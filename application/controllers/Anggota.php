<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
        $this->load->model('Anggota_model', 'anggota');
        date_default_timezone_set('Asia/Makassar');
    }

    public function index()
    {
        $data['title'] = 'Data Anggota';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();
        // cari anggota berdasarkan supervisornya
        $data['anggota'] = $this->anggota->getAnggota($data['user']['id_user']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('anggota/index', $data);
        $this->load->view('templates/footer');
    }


    public function loadKabupaten($pl)
    {
        $res = array();
        foreach ($this->anggota->loadLokasi() as $r) {
            $cek = $this->anggota->getReportLokasiCount($r['id_kabupaten'], $r['id_kecamatan'], $r['id_desa'], $pl);
            if ($cek['stokbahan'] > 0) {
                $res[] = $r;
            } else {
                if ($cek['stoklapangan'] > 0) {
                    $res[] = $r;
                } else {
                    if ($cek['stokbibit'] > 0) {
                        $res[] = $r;
                    }
                }
            }
        }
        return $res;
    }

    public function pl($pl)
    {
        $data['title'] = 'Data Anggota';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pl'] = $this->db->get_where('dt_user', ['id_user' => $pl])->row_array();
        $data['lokasi'] = $this->loadKabupaten($pl);
        $this->load->model('Anggota_model', 'loask');
        // Kirim Ke Logs 
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Supervisor Akses Data Pengawasan Anggotanya : " . $data['pl']['email'],
            'id_sub_menu' => 22,
            'tgl' => $date,
            'waktu' => $time
        ]);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('anggota/pl', $data);
        $this->load->view('templates/footer');
    }

    public function pengawasan($Id)
    {
        $IdRes = explode("-", $Id);
        $data['urlx'] = $Id;
        $data['IdRes'] = explode("-", $Id);
        $data['title'] = 'Data Anggota';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pl'] = $this->db->get_where('dt_user', ['id_user' => $IdRes[5]])->row_array();
        $data['lokasi'] = $this->anggota->loadPengawasanLokasi($IdRes);
        $this->load->model('Anggota_model', 'report');
        // Kirim Ke Logs 
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Supervisor Akses Data Pengawasan Anggotanya : " . $data['pl']['email'] . "(anggota/pengawasan/" . $Id . ")",
            'id_sub_menu' => 22,
            'tgl' => $date,
            'waktu' => $time
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('anggota/pengawasan', $data);
        $this->load->view('templates/footer');
    }
}
