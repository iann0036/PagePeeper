<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 16/7/2015
 * Time: 8:16 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');
        if (is_null($this->session->userdata('user_id')))
            redirect('/login/');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('support');
        $this->load->view('footer');
    }
}
