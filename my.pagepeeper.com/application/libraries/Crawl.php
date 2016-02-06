<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 28/7/2015
 * Time: 8:43 PM
 */

class Crawl {
    private $url;
    private $info;
    private $last_response;

    function __construct($url = null) {
        if ($url!=null)
            $this->url = $url;
    }

    public function setURL($url) {
        $this->url = $url;
    }

    public static function imagecompare($original_image, $new_image) {
        $image_changed = false;

        $im2 = imagecreatefrompng("/var/www/my.pagepeeper.com/screenshots/".$new_image.".png");
        if (strlen($original_image)<2)
            $im = imagecreatetruecolor(imagesx($im2),imagesy($im2));
        else
            $im = imagecreatefrompng("/var/www/my.pagepeeper.com/screenshots/".$original_image.".png");

        $width = imagesx($im);
        $height = imagesy($im);

        $pink = imagecolorallocatealpha($im2, 255, 105, 180, 60);

        for ($y=0; $y<$height; $y++) {
            for ($x=0; $x<$width; $x++) {
                $pixel_original = imagecolorat($im, $x, $y);
                $pixel_compare = imagecolorat($im2, $x, $y);

                $r1 = ($pixel_original >> 16) & 0xFF;
                $g1 = ($pixel_original >> 8) & 0xFF;
                $b1 = $pixel_original & 0xFF;
                $r2 = ($pixel_compare >> 16) & 0xFF;
                $g2 = ($pixel_compare >> 8) & 0xFF;
                $b2 = $pixel_compare & 0xFF;

                if (abs($r1-$r2)>30 || abs($g1-$g2)>30 || abs($b1-$b2)>30) {
                    // change detected
                    imagesetpixel($im2, $x, $y, $pink);
                    $image_changed = true;
                }
            }
        }

        if ($image_changed) {
            imagepng($im2, "/var/www/my.pagepeeper.com/screenshots/" . $new_image . "_diff.png");
        }
        imagedestroy($im);
        imagedestroy($im2);

        if ($image_changed) {
            return array(
                'trigger_change' => true
            );
        }

        return array(
            'trigger_change' => false
        );
    }

    public static function compare($original_data, $new_data) {
        if ($original_data==$new_data) {
            return array(
                'trigger_change' => false,
                'changes' => array()
            );
        }

        $changes = array();
        $diff = xdiff_string_diff($original_data, $new_data, 0);
        $parts = explode("@@", $diff);
        for ($i=1; $i<count($parts); $i+=2) {
            $change_metadata = trim($parts[$i]);
            $change_data = $parts[$i+1];
            $lines = explode("\n", str_replace("\r","\n",$change_data));

            $added = array();
            $removed = array();

            foreach ($lines as $line) {
                if (substr($line,0,1) == '+') {
                    $added[] = substr($line,1);
                }
                if (substr($line,0,1) == '-') {
                    $removed[] = substr($line,1);
                }
            }

            if (count($added)>0 && count($removed)>0) {
                $change_type = 'changed';
                $linecount = max(count($added),count($removed));
            } else if (count($added)>0) {
                $change_type = 'added';
                $linecount = count($added);
            } else if (count($removed)>0) {
                $change_type = 'removed';
                $linecount = count($removed);
            }

            $changes[] = array(
                'type' => $change_type,
                'linecount' => $linecount,
                'added' => $added,
                'removed' => $removed,
                'metadata' => $change_metadata,
                'friendlymetadata' => md5($change_metadata)
            );
        }

        $response = array(
            'trigger_change' => true,
            'changes' => $changes
        );

        return $response;
    }

    public function result() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_URL => $this->url,
            CURLOPT_USERAGENT => 'bot - admin@pagepeeper.com'
        ));
        $resp = curl_exec($curl);

        $this->info = curl_getinfo($curl);
        $this->last_response = $resp;

        if ($this->getResponseCode() != 200) {
            echo $this->url.": ".curl_errno($curl)."<br />";
        }

        curl_close($curl);

        return $resp;
    }

    public function removeImage($image_id) {
        @unlink("/var/www/my.pagepeeper.com/screenshots/".$image_id.".png");
        @unlink("/var/www/my.pagepeeper.com/screenshots/".$image_id."_thumb.png");
    }

    public function getImage() {
        $image = file_get_contents("http://screens.pagepeeper.com/run.py?url=".urlencode($this->url));
        $image_id = uniqid(md5($this->url));
        file_put_contents("/var/www/my.pagepeeper.com/screenshots/".$image_id.".png",$image);

        sleep(1);

        $this->_generateThumb($image_id);

        return $image_id;
    }

    private function _generateThumb($image_id) {
        $source_image = imagecreatefrompng("/var/www/my.pagepeeper.com/screenshots/".$image_id.".png");
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        $virtual_image = imagecreatetruecolor(min(480,$width), min(480,$height));

        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, min(480,$width), min(480,$height), min($width,$height), min($width,$height));

        imagepng($virtual_image, "/var/www/my.pagepeeper.com/screenshots/".$image_id."_thumb.png");

        imagedestroy($source_image);
        imagedestroy($virtual_image);
    }

    public function getInfo() {
        return $this->info;
    }

    public function getKBDownloaded() {
        return intval($this->info['size_download']/1024);
    }

    public function getTitle() {
        $html = $this->last_response;

        $startpos = strpos($html,'<title');
        $startpos = strpos($html,'>',$startpos);
        $endpos = strpos($html,'</title',$startpos);

        if ($startpos===false || $endpos===false)
            return null;

        return substr($html,$startpos+1,$endpos-$startpos-1);
    }

    public function getResponseCode() {
        return $this->info['http_code'];
    }
}