<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 19/7/2015
 * Time: 10:55 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->input->post('username') && $this->input->post('password') && $this->input->post('name')) {
            if ($this->User_model->register($this->input->post('username'),$this->input->post('password'),$this->input->post('name'),$this->input->post('email')))
                redirect('/');
            else
                $this->load->view('register',array(
                    'registererror' => true
                ));
        } else
            $this->load->view('register');
    }

    public function enthusiast() {
        $this->load->view('register');
    }

    public function stalker() {
        $this->load->view('register');
    }
}
