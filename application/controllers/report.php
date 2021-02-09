<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

$Spreadsheet = new Spreadsheet();
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
        $data['tallysheet'] = $this->report->tallySheet();
        $this->load->model('Report_model', 'loask');
        // untuk grafik 
        $data['tgltallysheet'] = $this->report->LoadTallysheet();
        $data['bibitsheet'] = $this->report->LoadTallysheetBibitx();

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
        $this->load->model('Report_model', 'report');
        $data['kabupaten'] = $this->loadKecamatan($Id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/kabupaten', $data);
        $this->load->view('templates/footer');
    }
    public function detailExcelKab($Id, $tgl)
    {
        $data['tglmulai'] = $tgl;
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->model('Report_model', 'report');
        $data['lokasi'] = $this->db->get_where('dt_kabupaten', ['id_kabupaten' => $Id])->row_array();
        $this->load->view('report/excelKab', $data);
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
        $data['urlx'] = $Id;
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
    public function detailExcelBlok($Id, $tgl, $blok)
    {
        $IdRes = explode("-", $Id);
        $data['tglmulai'] = $tgl;
        $data['blok'] = $blok;
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['kabupaten'] = $this->loadBlok($IdRes);
        $this->load->model('Report_model', 'report');
        $this->load->view('report/excelBlok', $data);
    }

    public function details($Id)
    {
        $IdRes = explode("-", $Id);
        $data['urlx'] = $Id;
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
    public function detailsExcel($Id, $tgl)
    {
        $IdRes = explode("-", $Id);
        $data['tglmulai'] = $tgl;
        $data['title'] = 'Report Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['lokasi'] = $this->report->LoadPetaks($IdRes);
        $this->load->model('Report_model', 'report');
        $this->load->view('report/excel', $data);
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

    public function tallysheet($Id)
    {
        $data['urlx'] = $Id;
        $data['title'] = 'Report Peng Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['lokasi'] = $this->report->LoadHarianLokasiTallysheet($Id);
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
        $this->load->view('report/tallysheetbibit', $data);
        $this->load->view('templates/footer');
    }

    // PROSES APPROVE & REJECT

    public function approve($aprvl, $id, $url)
    {
        if ($aprvl == "bahan") {
            $update = $this->db->update('harianbahan', ['status' => '1'], ['id_harianbahan' => $id]);
        } elseif ($aprvl == "bibit") {
            $update = $this->db->update('harianbibit', ['status' => '1'], ['id_harianbibit' => $id]);
        } elseif ($aprvl == "lapangan") {
            $update = $this->db->update('harianlapangan', ['status' => '1'], ['id_harianlapangan' => $id]);
        } elseif ($aprvl == "bibit_I") {
            $update = $this->db->update('harianbibit_i', ['status' => '1'], ['id_harianbibit_i' => $id]);
        }
        if ($update) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),  'logs' => " Approved data pengawasan " . $aprvl . " : " . $id . ", Url :" . $url, 'id_sub_menu' => 11, 'tgl' => $datetime, 'waktu' => $time
            ]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Approved successfully!</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Approved gagal.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        if ($aprvl == "bibit_I") {
            redirect('report/tallysheet/' . $url);
        } else {
            redirect('report/harian/' . $url);
        }
    }

    public function reject($aprvl, $id, $url)
    {
        if ($aprvl == "bahan") {
            $sql = $this->db->get_where('harianbahan', ['id_harianbahan' => $id])->row_array();
            if (file_exists('assets/img/peng-bahan/' . $sql['foto']) || file_exists('assets/img/peng-bahan/' . $sql['foto_2']) || file_exists('assets/img/peng-bahan/' . $sql['foto_3']) || file_exists('assets/img/peng-bahan/' . $sql['foto_4']) || file_exists('assets/img/peng-bahan/' . $sql['foto_5'])) { //jika fotonya ada maka hapus
                unlink('assets/img/peng-bahan/' . $sql['foto']);
                unlink('assets/img/peng-bahan/' . $sql['foto_2']);
                unlink('assets/img/peng-bahan/' . $sql['foto_3']);
                unlink('assets/img/peng-bahan/' . $sql['foto_4']);
                unlink('assets/img/peng-bahan/' . $sql['foto_5']);
            }
            $delete = $this->db->delete('harianbahan', ['id_harianbahan' => $id]);
        } elseif ($aprvl == "bibit") {
            $sql = $this->db->get_where('harianbibit', ['id_harianbibit' => $id])->row_array();
            if (file_exists('assets/img/peng-bibit/' . $sql['foto']) || file_exists('assets/img/peng-bibit/' . $sql['foto_2']) || file_exists('assets/img/peng-bibit/' . $sql['foto_3']) || file_exists('assets/img/peng-bibit/' . $sql['foto_4']) || file_exists('assets/img/peng-bibit/' . $sql['foto_5'])) {
                unlink('assets/img/peng-bibit/' . $sql['foto']);
                unlink('assets/img/peng-bibit/' . $sql['foto_2']);
                unlink('assets/img/peng-bibit/' . $sql['foto_3']);
                unlink('assets/img/peng-bibit/' . $sql['foto_4']);
                unlink('assets/img/peng-bibit/' . $sql['foto_5']);
            }
            $delete = $this->db->delete('harianbibit', ['id_harianbibit' => $id]);
        } elseif ($aprvl == "lapangan") {
            $sql = $this->db->get_where('harianlapangan', ['id_harianlapangan' => $id])->row_array();
            if (file_exists('assets/img/peng-lapangan/' . $sql['foto']) || file_exists('assets/img/peng-lapangan/' . $sql['foto_2']) || file_exists('assets/img/peng-lapangan/' . $sql['foto_3']) || file_exists('assets/img/peng-lapangan/' . $sql['foto_4']) || file_exists('assets/img/peng-lapangan/' . $sql['foto_5'])) {
                unlink('assets/img/peng-lapangan/' . $sql['foto']);
                unlink('assets/img/peng-lapangan/' . $sql['foto_2']);
                unlink('assets/img/peng-lapangan/' . $sql['foto_3']);
                unlink('assets/img/peng-lapangan/' . $sql['foto_4']);
                unlink('assets/img/peng-lapangan/' . $sql['foto_5']);
            }
            if (file_exists('assets/img/peng-video/' . $sql['video'])) {
                unlink('assets/img/peng-video/' . $sql['video']);
            }
            $delete = $this->db->delete('harianlapangan', ['id_harianlapangan' => $id]);
        } elseif ($aprvl == "bibit_I") {
            $sql = $this->db->get_where('harianbibit_i', ['id_harianbibit_i' => $id])->row_array();
            if (file_exists('assets/img/peng-bibit-pertama/' . $sql['foto']) || file_exists('assets/img/peng-bibit-pertama/' . $sql['foto_2']) || file_exists('assets/img/peng-bibit-pertama/' . $sql['foto_3']) || file_exists('assets/img/peng-bibit-pertama/' . $sql['foto_4']) || file_exists('assets/img/peng-bibit-pertama/' . $sql['foto_5'])) {
                unlink('assets/img/peng-bibit-pertama/' . $sql['foto']);
                unlink('assets/img/peng-bibit-pertama/' . $sql['foto_2']);
                unlink('assets/img/peng-bibit-pertama/' . $sql['foto_3']);
                unlink('assets/img/peng-bibit-pertama/' . $sql['foto_4']);
                unlink('assets/img/peng-bibit-pertama/' . $sql['foto_5']);
            }
            $delete = $this->db->delete('harianbibit_i', ['id_harianbibit_i' => $id]);
        }
        if ($delete) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),  'logs' => "Reject Approval data pengawasan" . $aprvl . "  : " . $id, 'id_sub_menu' => 11, 'tgl' => $datetime, 'waktu' => $time
            ]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Reject successfully!</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Reject Approval gagal.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        if ($aprvl == "bibit_I") {
            redirect('report/tallysheet/' . $url);
        } else {
            redirect('report/harian/' . $url);
        }
    }

    public function coba()
    {
        echo "<pre>";
        $data = $this->report->getJumlah(13);
    }
}
