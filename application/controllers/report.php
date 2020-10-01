<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
    }

    public function index()
    {
        $data['title'] = 'Report Peng Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        // cek user yang login 
        $id_users = $data['user']['id_user'];
        $users = $data['user']['role_id'];
        if ($users == 1) { //admin
            // Load Model
            $this->load->model('Report_model', 'report');
            $data['report'] = $this->report->getReportAdmin();
            $this->load->view('report/index', $data);
        } elseif ($users == 8) { //penginput
            $this->load->model('Report_model', 'report');
            $data['report'] = $this->report->getReport($id_users);
            $this->load->view('report/penginput', $data);
        } elseif ($users == 9) { //supervisor
            $this->load->model('Report_model', 'report');
            $data['report'] = $this->report->getReportDetailAnggota($id_users);
            $this->load->view('report/supervisor', $data);
        } else {
            redirect('auth/notfound');
        }
        $this->load->view('templates/footer');
    }
    public function detail($id)
    {
        $data['title'] = 'Report Peng Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('Report_model', 'detail');
        $data['details'] = $this->detail->getReportDetail($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/details', $data);
        $this->load->view('templates/footer');
    }

    public function print($id)
    {
        $data['title'] = 'Report Peng Harian';

        $this->load->model('Report_model', 'detail');
        $data['details'] = $this->detail->getReportDetail($id);

        $this->load->view('report/print', $data);
    }

    public function mingguan()
    {
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/mingguan', $data);
        $this->load->view('templates/footer');
    }
}
