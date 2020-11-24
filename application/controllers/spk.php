<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spk extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
        $this->load->model('Menu_model', 'spk');
        date_default_timezone_set('Asia/Makassar');
    }

    public function spkbibitedit()
    {
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();

        $idPtk = $this->input->post('idPtk', TRUE);
        $idSpk = $this->input->post('idSpk', TRUE);
        $data['isi'] = $this->spk->getBibitkatspkEdit($idPtk, $idSpk);
        $da = $this->load->view('spk/spk-bibitedit', $data);
        echo json_encode($da);
    }

    public function spklapanganedit()
    {
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();

        $idPtk = $this->input->post('idPtk', TRUE);
        $idSpk = $this->input->post('idSpk', TRUE);
        $data['isi'] = $this->spk->getLapanganspkPetakEdit($idPtk, $idSpk);
        $da = $this->load->view('spk/spk-lapanganedit', $data);
        echo json_encode($da);
    }

    public function spkbahanedit()
    {
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();

        $idSpk = $this->input->post('idSpk', TRUE);
        $idPtk = $this->input->post('idPtk', TRUE);
        $data['isi'] = $this->spk->getBahanspkPetakEdit($idPtk, $idSpk);
        $da = $this->load->view('spk/spk-bahanedit', $data);
        echo json_encode($da);
    }

    public function index()
    {
        $data['title'] = 'SPK Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('spk/index', $data);
        $this->load->view('templates/footer');
    }

    public function spkbibit()
    {
        $data['title'] = 'SPK Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // tampilkan jenis kegiatan
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();
        $data['blok'] = $this->db->get('tb_blok')->result_array();
        $data['petak'] = $this->db->get('tb_petak')->result_array();
        // kueri spk bahan
        $this->load->model('Menu_model', 'bahan');
        $data['spkbahan'] = $this->bahan->getBahanspk();
        // kueri spk bahan berdasarkan id petak
        $this->load->model('Menu_model', 'bahana');
        // Query Desa
        $this->load->model('Menu_model', 'desa');
        $data['datadesa'] = $this->desa->getDesa();
        // kueri spk lapangan
        $this->load->model('Menu_model', 'lapangan');
        $data['spklapangan'] = $this->lapangan->getLapanganspk();
        // kueri spk lapangan berdasarkan id petak
        $this->load->model('Menu_model', 'lapang');
        //kueri spk bibit
        $this->load->model('Menu_model', 'bibit');
        $data['spkbibit'] = $this->bibit->getBibitspk();
        //kueri Katogori spk bibit
        $this->load->model('Menu_model', 'bibitkat');
        //kueri spk bibit form input bibit berdasarkan kategori
        $this->load->model('Menu_model', 'bibitx');
        $data['spkbibitkat'] = $this->bibitx->getBibitspkat();
        // Kueri Bibit 
        $data['bibitnya'] = $this->db->get('bibit')->result_array();
        // kueri tampilkan bibit berdasarkan kategori 
        $this->load->model('Menu_model', 'bibitshow');
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses SPK BIBIT ",
            'id_sub_menu' => 18,
            'tgl' => $datetime,
            'waktu' => $time
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('spk/spk-bibit', $data);
        $this->load->view('templates/footer');
    }


    public function bahanHarianAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getLuasPetak($idnya);
        echo json_encode($data);
    }

    public function spklapangan()
    {
        $data['title'] = 'SPK Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // tampilkan jenis kegiatan
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();
        $data['blok'] = $this->db->get('tb_blok')->result_array();
        $data['petak'] = $this->db->get('tb_petak')->result_array();
        // kueri spk bahan
        $this->load->model('Menu_model', 'bahan');
        $data['spkbahan'] = $this->bahan->getBahanspk();
        // kueri spk bahan berdasarkan id petak
        $this->load->model('Menu_model', 'bahana');
        // Query Desa
        $this->load->model('Menu_model', 'desa');
        $data['datadesa'] = $this->desa->getDesa();
        // kueri spk lapangan
        $this->load->model('Menu_model', 'lapangan');
        $data['spklapangan'] = $this->lapangan->getLapanganspk();
        // kueri spk lapangan berdasarkan id petak
        $this->load->model('Menu_model', 'lapang');
        //kueri spk bibit
        $this->load->model('Menu_model', 'bibit');
        $data['spkbibit'] = $this->bibit->getBibitspk();
        //kueri Katogori spk bibit
        $this->load->model('Menu_model', 'bibitkat');
        //kueri spk bibit form input bibit berdasarkan kategori
        $this->load->model('Menu_model', 'bibitx');
        $data['spkbibitkat'] = $this->bibitx->getBibitspkat();
        // Kueri Bibit 
        $data['bibitnya'] = $this->db->get('bibit')->result_array();
        // kueri tampilkan bibit berdasarkan kategori 
        $this->load->model('Menu_model', 'bibitshow');
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses SPK LAPANGAN ",
            'id_sub_menu' => 18,
            'tgl' => $datetime,
            'waktu' => $time
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('spk/spk-lapangan', $data);
        $this->load->view('templates/footer');
    }
    public function spkbahan()
    {
        $data['title'] = 'SPK Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // tampilkan jenis kegiatan
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();
        $data['blok'] = $this->db->get('tb_blok')->result_array();
        $data['petak'] = $this->db->get('tb_petak')->result_array();
        // kueri spk bahan
        $this->load->model('Menu_model', 'bahan');
        $data['spkbahan'] = $this->bahan->getBahanspk();
        // kueri spk bahan berdasarkan id petak
        $this->load->model('Menu_model', 'bahana');
        // Query Desa
        $this->load->model('Menu_model', 'desa');
        $data['datadesa'] = $this->desa->getDesa();
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses SPK BAHAN ",
            'id_sub_menu' => 18,
            'tgl' => $datetime,
            'waktu' => $time
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('spk/spk-bahan', $data);
        $this->load->view('templates/footer');
    }

    public function addSpkbahan()
    {
        // cek jika sudah ada
        $cek = $this->db->get_where('spkbahan', [
            'id_kegiatan' => $this->input->post('kegiatan', true),
            'id_petak' => $this->input->post('petak', true)
        ])->row_array();
        if (empty($cek)) {
            $data = $this->db->insert('spkbahan', [
                'id_kegiatan' => $this->input->post('kegiatan', true),
                'id_petak' => $this->input->post('petak', true),
                'nilai_spkbahan' => htmlspecialchars($this->input->post('nilai', true))
            ]);
            if ($data) {
                // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "SPK Bahan Ditambahkan : idkeg/idpetak/nilai(" . $this->input->post('kegiatan', true) . "/" . $this->input->post('petak', true) . "/" . $this->input->post('nilai', true) . ")",
                    'id_sub_menu' => 18,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Bahan Berhasil ditambahkan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Kesalahan! </strong> Gagal Memproses Data.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Data SPK yang di masukkan sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spkbahan');
    }

    public function updateSpkbahan($id)
    {
        // cek jika sudah ada
        $id_kegiatan = $this->input->post('kegiatan', true);
        $id_petak = $this->input->post('petak', true);
        $this->load->model('Menu_model', 'cekbah');
        $cek = $this->cekbah->getCekbahan($id, $id_kegiatan, $id_petak);
        if (empty($cek)) {
            $data = $this->db->update('spkbahan', [
                'id_kegiatan' => $this->input->post('kegiatan', true),
                'nilai_spkbahan' => htmlspecialchars($this->input->post('nilai', true))
            ], ['id_spkbahan' => $id]);
            if ($data) {
                // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "SPK Bahan Diupdate : idkeg/nilai(" . $this->input->post('kegiatan', true) . "/" . $this->input->post('nilai', true) . ")",
                    'id_sub_menu' => 18,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Bahan Berhasil Diedit.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Kesalahan! </strong> Gagal Memproses Data.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Data SPK yang di masukkan sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spkbahan');
    }

    public function delSpkbahan($id)
    {
        $del = $this->db->delete('spkbahan', ['id_spkbahan' => $id]);
        if ($del) { // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "SPK Bahan Dihapus : idspkbahan(" . $id . ")",
                'id_sub_menu' => 18,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Data gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/spkbahan');
    }

    public function addSpklapangan()
    {
        // cek jika sudah ada
        $cek = $this->db->get_where('spklapangan', [
            'id_kegiatan' => $this->input->post('kegiatan', true),
            'id_petak' => $this->input->post('petak', true)
        ])->row_array();
        if (empty($cek)) {
            // jika tidak ada data yang sama maka jalankan inser data baru
            $simpan = $this->db->insert('spklapangan', [
                'id_kegiatan' => $this->input->post('kegiatan', true),
                'id_petak' => $this->input->post('petak', true),
                'nilai_spklapangan' => htmlspecialchars($this->input->post('nilai', true))
            ]);
            if ($simpan) { // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "SPK Lapangan Ditambahkan : idkeg/idpetak/nilai(" . $this->input->post('kegiatan', true) . "/" . $this->input->post('petak', true) . "/" . $this->input->post('nilai', true) . ")",
                    'id_sub_menu' => 18,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Lapangan Berhasil ditambahkan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Kesalahan! </strong> Gagal Memproses Data.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Data SPK yang di masukkan sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spklapangan');
    }
    public function updateSpklapangan($id)
    {
        // cek jika sudah ada
        $id_kegiatan = $this->input->post('kegiatan', true);
        $id_petak = $this->input->post('petak', true);
        $this->load->model('Menu_model', 'ceklap');
        $cek = $this->ceklap->getCeklapangan($id, $id_kegiatan, $id_petak);
        if (empty($cek)) {
            $data = $this->db->update('spklapangan', [
                'id_kegiatan' => $this->input->post('kegiatan', true),
                'nilai_spklapangan' => htmlspecialchars($this->input->post('nilai', true))
            ], ['id_spklapangan' => $id]);
            if ($data) { // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "SPK Lapangan Di Update : idkeg/idpetak/nilai(" . $this->input->post('kegiatan', true) . "/" . $this->input->post('nilai', true) . ")",
                    'id_sub_menu' => 18,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Lapangan Berhasil Diedit.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Kesalahan! </strong> Gagal Memproses Data.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Data SPK yang di masukkan sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spklapangan');
    }

    public function delSpklapangan($id)
    {
        $del = $this->db->delete('spklapangan', ['id_spklapangan' => $id]);
        if ($del) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "SPK Lapangan Di Hapus : id(" . $id . ")",
                'id_sub_menu' => 18,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Data gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/spklapangan');
    }

    public function addSpkbibit()
    {
        // cek jika sudah ada
        $cek = $this->db->get_where('spkbibit', [
            'kategori' => $this->input->post('kategori', true),
            'id_petak' => $this->input->post('petak', true)
        ])->row_array();
        if (empty($cek)) {
            $data = $this->db->insert('spkbibit', [
                'kategori' => htmlspecialchars($this->input->post('kategori', true)),
                'id_petak' => $this->input->post('petak', true),
                'nilai_spkbibit' => htmlspecialchars($this->input->post('nilai', true)),
                'satuan_spkbibit' => htmlspecialchars($this->input->post('satuan', true))
            ]);
            if ($data) { // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "SPK Bibit Ditambahkan : Kategori|idpetak|nilai|satuan(" . $this->input->post('kategori', true) . "|" . $this->input->post('petak', true) . "|" . $this->input->post('nilai', true) . "|" . $this->input->post('satuan', true) . ")",
                    'id_sub_menu' => 18,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Bitit Berhasil ditambahkan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Kesalahan! </strong> Gagal Memproses Data.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Data SPK yang di masukkan sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spkbibit');
    }

    public function updateSpkbibit($id)
    {
        // cek jika sudah ada
        $kategori = htmlspecialchars($this->input->post('kategori', true));
        $id_petak = $this->input->post('petak', true);
        $this->load->model('Menu_model', 'cekbibit');
        $cek = $this->cekbibit->getCekbibit($id, $kategori, $id_petak);
        if (empty($cek)) {
            $data = $this->db->update('spkbibit', [
                'kategori' => htmlspecialchars($this->input->post('kategori', true)),
                'nilai_spkbibit' => htmlspecialchars($this->input->post('nilai', true)),
                'satuan_spkbibit' => htmlspecialchars($this->input->post('satuan', true))
            ], ['id_spkbibit' => $id]);
            if ($data) { // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "SPK Bibit Du ubah : Kategori|nilai|satuan(" . $this->input->post('kategori', true) . "|" . $this->input->post('nilai', true) . "|" . $this->input->post('satuan', true) . ")",
                    'id_sub_menu' => 18,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Bitit Berhasil diedit.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Kesalahan! </strong> Gagal Memproses Data Kategori
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! Edit gagal.</strong> Data SPK yang di masukkan sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spkbibit');
    }

    public function delSpkbibit($id)
    {
        $del = $this->db->delete('spkbibit', ['id_spkbibit' => $id]);
        if ($del) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "SPK Bibit Di Hapus : idspk(" . $id . ")",
                'id_sub_menu' => 18,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Data gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/spkbibit');
    }
    public function addSpkbibitkat()
    {
        $data = $this->db->insert('spkbibit_bantu', [
            'id_spkbibit' => $this->input->post('kategori', true),
            'id_bibit' => $this->input->post('bibit', true),
        ]);
        if ($data) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Bibit Ditambahkan : idspkbibit|idbibit(" . $this->input->post('kategori', true) . "|" . $this->input->post('bibit', true) . ")",
                'id_sub_menu' => 18,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> Sukses! </strong> Data Bitit Berhasil ditambahkan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Kesalahan! </strong> Gagal Memproses Data.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/spkbibit');
    }
    public function delSpkbibitkat($id)
    {
        $del = $this->db->delete('spkbibit_bantu', ['id_bibitbantu' => $id]);
        if ($del) { // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Bibit SPK Dihapus : id(" . $id . ")",
                'id_sub_menu' => 18,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data bibit di kategori telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Data gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/spkbibit');
    }


    // KEGIATAN 

    public function kegiatan()
    {
        $data['title'] = 'Kegiatan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // tampilkan jenis kegiatan
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();
        $data['bibit'] = $this->db->get('bibit')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('spk/kegiatan', $data);
        $this->load->view('templates/footer');
    }
    public function kegiatanAdd()
    {
        $data = $this->db->insert('jenis_kegiatan', [
            'nm_kegiatan' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true)),
        ]);
        if ($data) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Jenis Kegiatan Ditambahkan : " . $this->input->post('nama', true) . " | " . $this->input->post('satuan', true),
                'id_sub_menu' => 17,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show pb-1" role="alert">
                <strong> Sukses! </strong> Jenis Kegiatan Berhasil ditambahkan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show pb-1" role="alert">
                <strong> Kesalahan! </strong> Gagal Memproses Data.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('spk/kegiatan');
    }
    public function kegiatanDel($id)
    {
        $hapus = $this->db->delete('jenis_kegiatan', ['id_kegiatan' => $id]);
        if ($hapus) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Jenis Kegiatan Di Hapus : " . $id,
                'id_sub_menu' => 17,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data kegiatan  telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Data kegiatan gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/kegiatan');
    }
    public function kegiatanUpdate($id)
    {
        $where = [
            'id_kegiatan' => $id
        ];
        $update = $this->db->update('jenis_kegiatan', [
            'nm_kegiatan' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true)),
            'flag_keg' => $this->input->post('flag', true),
        ], $where);
        if ($update) { // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Jenis Kegiatan Di Ubah : " . $this->input->post('nama', true) . " | " . $this->input->post('satuan', true),
                'id_sub_menu' => 17,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Jenis kegiatan  telah diperbaharui.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Jenis Kegiatan gagal diperbaharui.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/kegiatan');
    }
    public function bibitAdd()
    {
        $insert = $this->db->insert('bibit', [
            'nm_bibit' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true))
        ]);
        if ($insert) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Data Bibit Ditambahkan : " . $this->input->post('nama', true) . " | " . $this->input->post('satuan', true),
                'id_sub_menu' => 17,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Bibit berhasil ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Gagal memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/kegiatan');
    }
    public function bibitEdit($id)
    {
        $edit = $this->db->update('bibit', [
            'nm_bibit' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true)),
            'flag_bibit' => $this->input->post('flag', true)
        ], ['id_bibit' => $id]);
        if ($edit) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Data Bibit di Ubah : " . $this->input->post('nama', true) . " | " . $this->input->post('satuan', true) . " | " . $this->input->post('flag', true),
                'id_sub_menu' => 17,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Bibit berhasil diedit.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Gagal memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/kegiatan');
    }
    public function bibitdel($id)
    {
        $edit = $this->db->delete('bibit', ['id_bibit' => $id]);
        if ($edit) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Data Bibit dihapus : " . $id,
                'id_sub_menu' => 17,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Bibit berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Gagal memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('spk/kegiatan');
    }
}
