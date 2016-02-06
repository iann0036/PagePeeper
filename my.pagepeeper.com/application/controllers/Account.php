<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 16/7/2015
 * Time: 8:16 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');
        if (is_null($this->session->userdata('user_id')))
            redirect('/login/');
    }

    public function index() {
        $this->db->where('id', $this->session->userdata('user_id'));
        $result = $this->db->get('users');
        $user = $result->row();

        $this->load->view('header');
        $this->load->view('account',array(
            'user' => $user
        ));
        $this->load->view('footer');
    }
}
