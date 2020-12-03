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

    public function loadKabupatenTS($pl)
    {
        $res = array();
        foreach ($this->db->get('dt_kabupaten')->result_array() as $r) {
            $cek = $this->anggota->getReportLokasiCountTS($r['id_kabupaten'], $pl);
            if ($cek['stokbibit'] > 0) {
                $res[] = $r;
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
        $data['lokasits'] = $this->loadKabupatenTS($pl);
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

    public function pengawasants($Id)
    {
        $IdRes = explode("-", $Id);
        $data['urlx'] = $Id;
        $data['IdRes'] = explode("-", $Id);
        $data['title'] = 'Data Anggota';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pl'] = $this->db->get_where('dt_user', ['id_user' => $IdRes[1]])->row_array();
        $data['lokasi'] = $this->anggota->loadPengawasanLokasiTS($IdRes);
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
        $this->load->view('anggota/pengawasants', $data);
        $this->load->view('templates/footer');
    }

    public function approve($aprvl, $id, $url)
    {
        if ($aprvl == "bahan") {
            $update = $this->db->update('harianbahan', ['status' => '1'], ['id_harianbahan' => $id]);
        } elseif ($aprvl == "bibit") {
            $update = $this->db->update('harianbibit', ['status' => '1'], ['id_harianbibit' => $id]);
        } elseif ($aprvl == "lapangan") {
            $update = $this->db->update('harianlapangan', ['status' => '1'], ['id_harianlapangan' => $id]);
        } elseif ($aprvl == "bibitpertama") {
            $update = $this->db->update('harianbibit_i', ['status' => '1'], ['id_harianbibit_i' => $id]);
        }
        if ($update) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),  'logs' => "Supervisor Approved data pengawasan " . $aprvl . " : " . $id . ", Url :" . $url, 'id_sub_menu' => 22, 'tgl' => $datetime, 'waktu' => $time
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
        if ($aprvl == "bibitpertama") {
            redirect('anggota/pengawasants/' . $url);
        } else {
            redirect('anggota/pengawasan/' . $url);
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
        } elseif ($aprvl == "bibitpertama") {
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
                'id_user' => $this->session->userdata('id_user_login'),  'logs' => "Supervisor Reject Approval data pengawasan"  . $aprvl . " : " . $id, 'id_sub_menu' => 22, 'tgl' => $datetime, 'waktu' => $time
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
        if ($aprvl == "bibitpertama") {
            redirect('anggota/pengawasants/' . $url);
        } else {
            redirect('anggota/pengawasan/' . $url);
        }
    }
}
