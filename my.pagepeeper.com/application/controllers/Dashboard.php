<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 16/7/2015
 * Time: 8:16 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Events_model');
        $this->load->helper('url');
        if (is_null($this->session->userdata('user_id')))
            redirect('/login/');
    }

    public function index() {
        $this->db->where('user_id',$this->session->userdata('user_id'));
        $this->db->from('userwatches');
        $sites_monitored = $this->db->count_all_results();

        $events_obj = new Events_model();
        $events = $events_obj->get();

        $this->db->where('id',$this->session->userdata('user_id'));
        $result = $this->db->get('users');
        $user = $result->row();

        $this->load->view('header');
        $this->load->view('dashboard', array(
            'sites_monitored' => $sites_monitored,
            'checks_made' => $user->checks_made,
            'changes_detected' => $user->changes_detected,
            'kb_downloaded' => $user->kb_downloaded,
            'emails_sent' => $user->emails_sent,
            'sms_sent' => $user->sms_sent,
            'events' => $events
        ));
        $this->load->view('footer');
    }
}
