<?php
/**
 * Created by PhpStorm.
 * User: iann0036
 * Date: 16/7/2015
 * Time: 8:16 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('Crawl');
        $this->load->helper('pagepeeper');
        $this->load->database();
        $this->load->helper('url');
        if (is_null($this->session->userdata('user_id')) && $this->uri->segment(2) != "bookmarklet")
            redirect('/login/');
    }

    public function quickadd() {
        if ($this->input->post('url'))
            $this->session->set_flashdata('addurl',$this->input->post('url'));
        redirect('/sites/add/');
    }

    public function ignorechange($userwatch_id, $change) {
        $insert_data = array(
            'userwatch_id' => $userwatch_id,
            'change' => $change
        );
        $this->db->insert('ignoredchanges',$insert_data);

        redirect('/sites/');
    }

    public function index() {
        $watches = array();

        $this->db->select('userwatches.id,watches.title,watches.url,max(watchdata.time) as last_change');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->join('userwatches', 'userwatches.watch_id = watches.id');
        $this->db->join('watchdata', 'watchdata.watch_id = watches.id', 'left');
        $this->db->group_by(array('userwatches.id','watches.title','watches.url'));

        $result = $this->db->get('watches');

        foreach ($result->result() as $row) {
            if ($row->last_change==null)
                $row->last_change = "Never";

            if (strlen($row->title)>83) {
                $row->title = substr($row->title,0,80)."...";
            }
            $row->display_url = $row->url;
            if (strlen($row->url)>53) {
                $row->display_url = substr($row->url,0,50)."...";
            }

            $watches[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'url' => $row->url,
                'display_url' => $row->display_url,
                'last_change' => $row->last_change,
                'last_change_readable' => convert_datetime($row->last_change)
            );
        }

        $this->load->view('header',array(
            'bar_message' => $this->session->flashdata('bar_message')
        ));
        $this->load->view('sites',array(
            'watches' => $watches
        ));
        $this->load->view('footer');
    }

    public function add() {
        $url = $this->input->post('url');

        if ($url) {
            $email_notify = 0;
            if ($this->input->post('email_notify')) {
                $email_notify = 1;
            }
            $sms_notify = 0;
            if ($this->input->post('sms_notify')) {
                $sms_notify = 1;
            }

            $this->db->where('url', $url);
            $result = $this->db->get('watches');
            if ($result->num_rows()==1) {
                $watch = $result->row();
                $watch_id = $watch->id;
            } else {
                $insert_data = array(
                    'url' => $url
                );
                $this->db->insert('watches',$insert_data);
                $watch_id = $this->db->insert_id();
            }


            $insert_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'watch_id' => $watch_id,
                'email' => $email_notify,
                'sms' => $sms_notify
            );
            $this->db->insert('userwatches',$insert_data);

            $this->session->set_flashdata('bar_message', array(
                'type' => 'success',
                'message' => "<strong>Success:</strong> ".str_replace("&amp;","&",htmlspecialchars($url))." was successfully added."
            ));

            redirect('/sites/');
        }

        $this->load->view('header');
        $this->load->view('sites_add',array(
            'addurl' => $this->session->flashdata('addurl')
        ));
        $this->load->view('footer');
    }

    public function delete($id) {
        $this->db->where('userwatches.id',$id);
        $this->db->join('watches','userwatches.watch_id = watches.id');
        $result = $this->db->get('userwatches');

        if ($result->num_rows()!=1)
            die();

        $row = $result->row();
        $watch_id = $row->watch_id;

        $this->session->set_flashdata('bar_message', array(
            'type' => 'success',
            'message' => "<strong>Success:</strong> ".str_replace("&amp;","&",htmlspecialchars($row->url))." was successfully removed."
        ));

        $this->db->where('id',$id);
        $this->db->delete('userwatches');

        $this->db->where('watch_id',$watch_id);
        $result = $this->db->get('userwatches');
        if ($result->num_rows()>0)
            redirect('/sites/');
        $watch = $result->row();

        $crawl = new Crawl();
        $crawl->removeImage($watch->image);

        $this->db->where('id',$watch_id);
        $this->db->delete('watches');

        redirect('/sites/');
    }

    public function edit($id) {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('userwatches.id', $id);
        $this->db->join('userwatches', 'userwatches.watch_id = watches.id');
        $watches = $this->db->get('watches');

        if ($watches->num_rows()!=1) {
            die(); // bad id
        }
        $watch = $watches->row();

        $update_id = $this->input->post('id');

        if ($update_id==$id) {
            $email_notify = 0;
            if ($this->input->post('email_notify')) {
                $email_notify = 1;
            }
            $sms_notify = 0;
            if ($this->input->post('sms_notify')) {
                $sms_notify = 1;
            }

            $update_data = array(
                'email' => $email_notify,
                'sms' => $sms_notify
            );
            $this->db->where('id', $id);
            $this->db->update('userwatches', $update_data);

            $this->session->set_flashdata('bar_message', array(
                'type' => 'success',
                'message' => "<strong>Success:</strong> ".str_replace("&amp;","&",htmlspecialchars($watch->url))." was successfully updated."
            ));

            redirect('/sites/');
        }

        $this->load->view('header');
        $this->load->view('sites_edit',array(
            'id' => $id,
            'url' => $watch->url,
            'email_check' => $watch->email,
            'sms_check' => $watch->sms
        ));
        $this->load->view('footer');
    }
    /*
    public function viewchange($id) {
        $this->db->where('watchdata.id', $id);
        $this->db->join('watchdata', 'watchdata.watch_id = watches.id');
        $watches = $this->db->get('watches');

        if ($watches->num_rows() != 1) {
            die(); // bad id
        }
        $update = $watches->row();

        $this->db->where('watch_id', $update->watch_id);
        $this->db->where('time <', $update->time);
        $this->db->order_by('time','DESC');
        $previous_watchdata = $this->db->get('watchdata');
        if ($previous_watchdata->num_rows() < 1) {
            $last_watchdata = null;
        } else {
            $row = $previous_watchdata->row();
            $last_watchdata = $row->data;
        }

        if ($last_watchdata == null)
            $diff = null;
        else {
            $compare = Crawl::compare($last_watchdata, $update->data);
            $diff = $compare['changes'];
        }

        $this->load->view('header');
        $this->load->view('sites_viewchange', array(
            'updatedata' => $update,
            'diffdata' => $diff,
            'view_id' => $id
        ));
        $this->load->view('footer');
    }
    */

    public function view($id) {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('userwatches.id', $id);
        $this->db->join('userwatches', 'userwatches.watch_id = watches.id');
        $watches = $this->db->get('watches');

        if ($watches->num_rows() != 1) {
            die(); // bad id
        }
        $watch = $watches->row();

        $ignored_changes = array();
        $this->db->where('userwatch_id',$id);
        $result = $this->db->get('ignoredchanges');
        foreach ($result->result() as $row) {
            $ignored_changes[] = $row->change;
        }

        $this->db->where('id', $id);
        $userwatches = $this->db->get('userwatches');
        $userwatch = $userwatches->row();

        $this->db->where('watch_id', $userwatch->watch_id);
        $this->db->order_by('time', 'ASC');
        $watchdata = $this->db->get('watchdata');
        $data = array();

        $last_watchdata = null;
        foreach ($watchdata->result() as $row) {
            if ($last_watchdata == null)
                $row->diff = null;
            else {
                $compare = Crawl::compare($last_watchdata, $row->data);
                $row->diff = $compare['changes'];
            }

            $row->readable_time = convert_datetime($row->time);
            $data[] = $row;

            $last_watchdata = $row->data;
        }

        $data = array_reverse($data); // latest first

        $this->load->view('header');
        $this->load->view('sites_view', array(
            'url' => $watch->url,
            'data' => $data,
            'ignored_changes' => $ignored_changes,
            'userwatch_id' => $id
        ));
        $this->load->view('footer');
    }
    /*
    public function bookmarklet() {
        if (!$this->input->get('key') || !$this->input->get('url'))
            die(); // key or url missing

        $this->db->where('key',$this->input->get('key'));
        $users = $this->db->get('users');
        if ($users->num_rows() < 1)
            die(); // bad key

        $user = $users->row();

        $this->db->where('url',$this->input->get('url'));
        $watches = $this->db->get('watches');
        if ($watches->num_rows()>0) {
            $row = $watches->row();
            $watch_id = $row->id;
        } else {
            $this->db->insert('watches',array('url' => $this->input->get('url')));
            $watch_id = $this->db->insert_id();

            $crawl = new Crawl($this->input->get('url'));
            $data = $crawl->result();
            $insert_data = array(
                'watch_id' => $watch_id,
                'data' => $data
            );
            $this->db->insert('watchdata',$insert_data);
        }

        $this->db->where('watch_id',$watch_id);
        $this->db->where('user_id',$user->id);
        $userwatches = $this->db->get('userwatches');
        if ($userwatches->num_rows()>0)
            die(); // already exists

        $insert_data = array(
            'user_id' => $user->id,
            'watch_id' => $watch_id
        );
        $this->db->insert('userwatches',$insert_data);
    }
    */
}
