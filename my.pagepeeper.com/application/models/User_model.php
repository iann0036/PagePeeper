<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 19/7/2015
 * Time: 11:24 AM
 */

class User_model extends CI_Model {
    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->model('Events_model');
    }

    public function login($username, $password) {
        $this->db->where('username',$username);
        $this->db->where('password',$this->hash($password));
        $this->db->where('type','internal');
        $results = $this->db->get('users');
        if ($results->num_rows()!=1)
            return false;

        $user = $results->row();

        $userdata = array(
            'user_id'   => $user->id,
            'username'  => $user->username,
            'name'      => $user->name,
            'email'     => $user->email,
            'type'      => 'internal'
        );

        $this->session->set_userdata($userdata);

        return true;
    }

    public function register($username,$password,$name,$email) {
        // TODO check for existing here

        $insert_data = array(
            'username' => $username,
            'password' => $this->hash($password),
            'name'     => $name,
            'type'     => 'internal'
        );
        if ($email)
            $insert_data['email'] = $email;
        $this->db->insert('users',$insert_data);

        $userdata = array(
            'user_id'   => $this->db->insert_id(),
            'username'  => $username,
            'name'      => $name,
            'email'     => $email,
            'type'      => 'internal'
        );

        $this->session->set_userdata($userdata);

        $events = new Events_model();
        $events->insert("icon-rocket","Account Created","Your account has been created. Welcome to Page Peeper!",$this->db->insert_id());

        $this->_sendWelcomeMail($email, $name);

        return true;
    }

    private function hash($password) {
        return md5($password);
    }

    private function _sendWelcomeMail($to, $name) {
        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=iso-8859-1";
        $headers[] = "From: Page Peeper <support@pagepeeper.com>";
        $headers[] = "Bcc: Admin <iann0036@gmail.com>";
        $headers[] = "Subject: [PagePeeper] Welcome to Page Peeper";
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

						<div style="font-weight:bold;font-size:18px;line-height:24px;">Welcome to Page Peeper!</div>
                        <br />
                        Thanks for registering your account. You can get started by using Page Peeper to:
                        <br /><br />
                        - <b>Be First:</b> Jobs, pricing, deals, availability, releases etc.
                        <br /><br />
                        - <b>Be Aware:</b> News, social media, google search rankings.
                        <br /><br />
                        - <b>Be Alert:</b> Keep an eye on competition, friends and foes.
                        <br /><br />
                        - <b>Be Smart:</b> Automate to a computer, shipping status, regulatory changes.
                        <br /><br />
                        As always, please reply to this email or write at support@pagepeeper.com if you need any help or have any questions.
						<br /><br />
						- Page Peeper Team<br />
						<br />
						<span style="font-size: 12px">Follow us on <a href="http://twitter.com/pagepeeper">Twitter</a> | Visit us on <a href="http://facebook.com/pagepeeper">Facebook</a></span><br />
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
        mail($to, "[PagePeeper] Welcome to Page Peeper", $body, implode("\r\n", $headers));
    }
}