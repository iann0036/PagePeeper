<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 19/7/2015
 * Time: 10:55 AM
 */

set_time_limit(3590);

defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASEPATH.'../application/third_party/twilio/Services/Twilio.php';

class Cron extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('Crawl');
        $this->load->model('Events_model');
        $this->load->helper('url');
        $this->load->database();
    }

    public function run() {
        if ($this->input->is_cli_request()) {
            $time_start = microtime(true);

            $this->_processOutstanding();
            $this->_updateStats();
            $this->_cleanup();

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;

            error_log('PagePeeper Total Execution Time: '.$execution_time.' mins');
        }
    }

    private function _cleanup() {
        $watches = $this->db->get('watches');
        foreach ($watches->result() as $watch) {
            $this->db->where('watch_id',$watch->id);
            $this->db->limit(999999,25);
            $this->db->order_by('time','DESC');
            $expired_watchdata = $this->db->get('watchdata');

            foreach ($expired_watchdata->result() as $row) {
                $image_id = $row->image;
                if ($image_id != null) {
                    @unlink("/var/www/my.pagepeeper.com/screenshots/" . $image_id . ".png");
                    @unlink("/var/www/my.pagepeeper.com/screenshots/" . $image_id . "_thumb.png");
                    @unlink("/var/www/my.pagepeeper.com/screenshots/" . $image_id . "_diff.png");
                }
                $this->db->where('id', $row->id);
                $this->db->delete('watchdata');
            }
        }
    }

    public function manual() {
        $time_start = microtime(true);

        $this->_processOutstanding();
        $this->_updateStats();
        $this->_cleanup();

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start)/60;

        echo '<b>Total Execution Time:</b> '.$execution_time.' mins';
    }

    private function _updateStats() {
        $checks_result = $this->db->query('SELECT SUM(checks_made) AS result FROM users');
        file_put_contents('/var/www/pagepeeper.com/checks.txt',$checks_result->row()->result);
        $changes_result = $this->db->query('SELECT SUM(changes_detected) AS result FROM users');
        file_put_contents('/var/www/pagepeeper.com/changes.txt',$changes_result->row()->result);

    }

    private function _processOutstanding() {
        $result = $this->db->get('watches');
        foreach ($result->result() as $watch) {
            $this->db->where('data IS NOT NULL', null, false);
            $this->db->where('watch_id',$watch->id);
            $this->db->order_by('time','DESC');
            $latest_watchdata = $this->db->get('watchdata');

            /* Check now */
            $timestamp = time();
            $crawl = new Crawl($watch->url);
            $data = $crawl->result();
            $title = $crawl->getTitle();
            $kb_downloaded = $crawl->getKBDownloaded();
            $code = $crawl->getResponseCode();
            $image = $crawl->getImage();
            $this->db->where('id',$watch->id);
            $this->db->update('watches',array(
                'title' => $title
            ));

            /* Check recent and see if triggered */
            $do_trigger_change = false;
            $insert_only = false;
            if ($latest_watchdata->num_rows()>0) {
                $last_watchdata = $latest_watchdata->row();
                $comparison = $crawl->compare($last_watchdata->data, $data);
                if ($comparison['trigger_change']) {
                    $do_trigger_change = true;
                }
                $comparison_image = $crawl->imagecompare($last_watchdata->image, $image);
                if ($comparison_image['trigger_change']) {
                    $do_trigger_change = true;
                } else {
                    $image = null;
                    $crawl->removeImage($image);
                }
            } else
                $insert_only = true;

            if ($do_trigger_change || $insert_only) {
                $insert_data = array(
                    'watch_id' => $watch->id,
                    'data' => $data,
                    'time' => date('Y-m-d H:i:s', $timestamp),
                    'http_code' => $code,
                    'image' => $image
                );
                if ($insert_only)
                    $insert_data['time'] = null;
                $this->db->insert('watchdata', $insert_data);
            }

            /* Send Updates and Update Stats */
            $this->db->where('watch_id', $watch->id);
            $userwatches = $this->db->get('userwatches');
            foreach ($userwatches->result() as $row) {
                $this->db->where('id', $row->user_id);
                $users = $this->db->get('users');
                $user = $users->row();

                $user_update_data = array(
                    'checks_made' => ($user->checks_made + 1),
                    'kb_downloaded' => ($user->kb_downloaded + $kb_downloaded)
                );

                if ($do_trigger_change)
                    $user_update_data['changes_detected'] = $user->changes_detected + 1;

                if ($do_trigger_change && $row->email) {
                    $this->_sendUpdateMail($user->email, $user->name, $watch->url, $row->id);
                    $user_update_data['emails_sent'] = $user->emails_sent + 1;
                }
                if ($do_trigger_change && $row->sms) {
                    $this->_sendUpdateSMS($user->phone, $user->name, $watch->url, $row->id);
                    $user_update_data['sms_sent'] = $user->sms_sent + 1;
                }

                $this->db->where('id', $row->user_id);
                $this->db->update('users',$user_update_data);

                if ($do_trigger_change) {
                    $events = new Events_model();
                    $events->insert("fa fa-share-square","Site updated","There was a change detected for the website ".htmlentities($watch->url),$user->id);
                }
            }
        }
    }

    private function _sendUpdateSMS($phone, $name, $url, $id) {
        mail("iann0036@gmail.com", "[PagePeeper Admin] SMS Sent", $phone." - ".$name." - ".$url." - ".$id); // DEBUG
        if ($phone==null || strlen($phone)<5)
            ; // do nothing
        else {
            $account_sid = 'AC1fb989168771d64191b305fbe87b0167';
            $auth_token = 'f5c1670a6cce0a0772b5d42a7e0770b2';
            $client = new Services_Twilio($account_sid, $auth_token);

            if (strlen($url)>103)
                $url = substr($url,0,100)."...";

            $client->account->messages->create(array(
                'To' => $phone,
                'From' => "Page Peeper",
                'Body' => "A page you are watching has just been updated!".PHP_EOL.PHP_EOL.$url
            ));
        }
    }

    private function _sendUpdateMail($to, $name, $url, $id) {
        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=iso-8859-1";
        $headers[] = "From: Page Peeper <support@pagepeeper.com>";
        $headers[] = "Bcc: Admin <iann0036@gmail.com>";
        $headers[] = "Subject: [PagePeeper] Page Update";
        $name_parts = explode(' ',$name);
        $firstname = ucfirst($name_parts[0]);
        $body = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="initial-scale=1.0"><meta name="format-detection" content="telephone=no">
	<title>Page Peeper</title>
	<style type="text/css">/* Resets: see reset.css for details */
        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
        .ExternalClass {width: 100%; background-color: #ebebeb;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        table {border-spacing:0;}
        table td {border-collapse:collapse;}
        .yshortcuts a {border-bottom: none !important;}


        /* Constrain email width for small screens */
        @media screen and (max-width: 600px) {
            table[class="container"] {
                width: 95% !important;
            }
        }

        /* Give content more room on mobile */
        @media screen and (max-width: 480px) {
            td[class="container-padding"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
         }
	</style>
</head>
<body bgcolor="#fff" leftmargin="0" marginheight="0" marginwidth="0" style="margin:0; padding:10px 0;" topmargin="0">
<div><br />
<div style="width :600px;margin-left: auto;margin-right: auto;margin-bottom:15px"><img alt="Logo" height="31" src="https://my.pagepeeper.com/assets/images/logo/logo-greyscale.png" style="width: 148px; height: 31px;" width="148" /></div>

<table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
	<tbody>
		<tr>
			<td align="center" bgcolor="#fff" style="background-color: #fff;" valign="top">
			<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" class="container" style="border: 1px solid #dddddd;padding-top:10px;padding-bottom:10px" width="600">
				<tbody>
					<tr>
						<td bgcolor="#ffffff" class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;">&nbsp;
						<div class="body-text center" style="font-family: Arial,Helvetica,sans-serif, sans-serif;font-size: 15px;line-height: 21px;color: #444444;padding: 0 0px;line-height: 26px">
						<div style="font-size: 18px; line-height: 24px; color: #444444;font-weight: bold">Page Peeper has detected a change on your <a href="${url}">tracked website!</a></div>
						<br />
						<br />
						Hi ${firstname},<br />
						<br />
						We detected a change on <b style="font-weight: 600">${url}</b> a few moments ago.<br />
						<br />You can manage and modify all of your jobs here:<br />
						<br />
						<br />
						<a href="https://my.pagepeeper.com/" style="font-size:13px;font-weight:700;font-family:Helvetica,Arial,sans-serif;text-transform:uppercase;text-align:center;letter-spacing:1px;text-decoration:none;line-height:52px;display:block;width:250px;height:48px;border-top-left-radius:6px;border-top-right-radius:6px;border-bottom-right-radius:6px;border-bottom-left-radius:6px;color:rgb(255,255,255);
                background: -webkit-linear-gradient(top,#008dfd 0,#0370ea 100%);
                background: -moz-linear-gradient(top,#008dfd 0,#0370ea 100%);
                background: -o-linear-gradient(top,#008dfd 0,#0370ea 100%);
                background: linear-gradient(top,#008dfd 0,#0370ea 100%);
                border: 1px solid #076bd2;
                margin:0px auto" target="_blank" title="PagePeeper-Dashboard">Page Peeper Dashboard</a><br />
						<br />
						- Page Peeper Team<br />
						<br />
						<span style="font-size: 12px">Stop alerting <a href="#">here</a> | Follow us on <a href="http://twitter.com/pagepeeper">Twitter</a> | Visit us on <a href="http://facebook.com/pagepeeper">Facebook</a> | Is this a <a href="#">false alarm</a>? </span><br />
						<br />
						<em style="font-style:italic; font-size: 12px; color: #aaa;">A service from www.pagepeeper.com</em><br />
						&nbsp;</div>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
</div>
</body>
</html>
EOT;
        mail($to, "[PagePeeper] Page Update", $body, implode("\r\n", $headers));
    }
}
