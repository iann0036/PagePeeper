<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 28/7/2015
 * Time: 8:43 PM
 */

class Events_model extends CI_Model {
    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('pagepeeper_helper');
        $this->load->library('session');
    }

    public function get() {
        $events = array();

        $this->db->where('user_id',$this->session->userdata('user_id'));
        $results = $this->db->get('events');
        foreach ($results->result() as $row) {
            $row->readable_time = convert_datetime($row->time);
            $events[] = $row;
        }

        return array_reverse($events);
    }

    public function insert($icon, $event, $desc, $user_id = null) {
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
        }

        $insert_data = array(
            'user_id' => $user_id,
            'icon' => $icon,
            'event' => $event,
            'desc' => $desc
        );
        $this->db->insert('events', $insert_data);
    }
}