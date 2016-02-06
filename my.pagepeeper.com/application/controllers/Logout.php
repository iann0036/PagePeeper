<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 19/7/2015
 * Time: 10:55 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $this->session->sess_destroy();
        redirect('/login/');
    }
}
