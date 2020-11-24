<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
        $this->load->model('Report_model', 'report');
        date_default_timezone_set('Asia/Makassar');
    }

    public function loadHarian()
    {
        $res = array();
        foreach ($this->report->LoadLokasi() as $key => $r) {
            $cek = $this->report->getReportDesaCount($r['id_kabupaten'], $r['id_kecamatan'], $r['id_desa']);
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

    public function index()
    {
        $data['title'] = 'Report Peng Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['lokasi'] = $this->loadHarian();
        $this->load->model('Report_model', 'loask');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/index', $data);
        $this->load->view('templates/footer');
    }

    public function loadKabupaten()
    {
        $res = array();
        foreach ($this->report->LoadKabupaten() as $key => $r) {
            $cek = $this->report->getReportKabupatenCount($r['id_kabupaten']);
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

    public function loadKecamatan($Id)
    {
        $res = array();
        foreach ($this->report->LoadKecamatan($Id) as $key => $r) {
            $cek = $this->report->getReportKecamatanCount($Id, $r['id_kecamatan']);
            $r['id_kabupaten'] = $Id;
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

    public function loadDesa($Id)
    {
        $IdKabupaten = $Id[0];
        $IdKecamatan = $Id[1];
        $res = array();
        foreach ($this->report->LoadDesa($IdKecamatan) as $key => $r) {
            $cek = $this->report->getReportDesaCount($IdKabupaten, $IdKecamatan, $r['id_desa']);
            $r['id_kabupaten'] = $IdKabupaten;
            $r['id_kecamatan'] = $IdKecamatan;
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

    public function loadBlok($Id)
    {
        $IdKabupaten = $Id[0];
        $IdKecamatan = $Id[1];
        $IdDesa = $Id[2];
        $res = array();
        foreach ($this->report->LoadBlok($IdDesa) as $key => $r) {
            $cek = $this->report->getReportBlokCount($IdKabupaten, $IdKecamatan, $IdDesa, $r['id_blok']);
            $r['id_kabupaten'] = $IdKabupaten;
            $r['id_kecamatan'] = $IdKecamatan;
            $r['id_desa'] = $IdDesa;
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



    public function mingguan()
    {
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['kabupaten'] = $this->loadKabupaten();

        // query Grafik pengawasan 
        $this->load->model('Report_model', 'report');
        $data['tglbahan'] = $this->report->LoadBahan();
        $data['tglbibit'] = $this->report->LoadBibit();
        $data['tglap'] = $this->report->LoadLapangan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/mingguan', $data);
        $this->load->view('templates/footer');
    }

    public function kabupaten($Id)
    {
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['kabupaten'] = $this->loadKecamatan($Id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/kabupaten', $data);
        $this->load->view('templates/footer');
    }

    public function kecamatan($Id)
    {
        $IdRes = explode("-", $Id);
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['kabupaten'] = $this->loadDesa($IdRes);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/kecamatan', $data);
        $this->load->view('templates/footer');
    }

    public function desa($Id)
    {
        $IdRes = explode("-", $Id);
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['kabupaten'] = $this->loadBlok($IdRes);
        $this->load->model('Report_model', 'report');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/desa', $data);
        $this->load->view('templates/footer');
    }

    public function details($Id)
    {
        $IdRes = explode("-", $Id);
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['lokasi'] = $this->report->LoadPetaks($IdRes);
        $this->load->model('Report_model', 'report');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/pengawasan', $data);
        $this->load->view('templates/footer');
    }

    public function harian($Id)
    {
        $IdRes = explode("-", $Id);
        $data['urlx'] = $Id;
        $data['IdRes'] = explode("-", $Id);
        $data['title'] = 'Report Peng Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['lokasi'] = $this->report->LoadHarianLokasi($IdRes);
        $this->load->model('Report_model', 'report');
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses Report Pengawasan Harian : " . $Id,
            'id_sub_menu' => 13,
            'tgl' => $datetime,
            'waktu' => $time
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/harian', $data);
        $this->load->view('templates/footer');
    }

    public function coba()
    {
        echo "<pre>";
        $data = $this->report->getJumlah(13);
    }
}
