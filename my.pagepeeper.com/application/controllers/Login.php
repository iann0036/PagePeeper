<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 19/7/2015
 * Time: 10:55 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../third_party/facebook/facebook-sdk/autoload.php';

class Login extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->input->post('username') && $this->input->post('password')) {
            if ($this->User_model->login($this->input->post('username'),$this->input->post('password')))
                redirect('/');
            else
                $this->load->view('login',array(
                    'loginerror' => true
                ));
        } else {
            $this->load->view('login',array(
                'facebookurl' => $this->_getFacebookLoginURL()
            ));
        }
    }

    private function _getFacebookLoginURL() {
        $fb = new Facebook\Facebook(array(
            'app_id' => '902142706501154',
            'app_secret' => '942a2bee082cb4baf80f0c9f7bc16a0b',
            'default_graph_version' => 'v2.4',
        ));

        $helper = $fb->getRedirectLoginHelper();

        $permissions = array('email'); // Optional permissions
        return htmlspecialchars($helper->getLoginUrl('https://my.pagepeeper.com/login/facebook/', $permissions));
    }

    public function facebook() {
        die();

        $fb = new Facebook\Facebook([
            'app_id' => '902142706501154',
            'app_secret' => '942a2bee082cb4baf80f0c9f7bc16a0b',
            'default_graph_version' => 'v2.4',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('902142706501154');
        // If you know the user ID this access token belongs to, you can validate it here
        // $tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>";
                exit;
            }
            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        // User is logged in with a long-lived access token.
        // You can redirect them to a members-only page.
        //redirect('/');
    }
}
