<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spk extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
    }

    public function index()
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

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('spk/index', $data);
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
        redirect('spk');
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
                'id_petak' => $this->input->post('petak', true),
                'nilai_spkbahan' => htmlspecialchars($this->input->post('nilai', true))
            ], ['id_spkbahan' => $id]);
            if ($data) {
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
        redirect('spk');
    }

    public function delSpkbahan($id)
    {
        $del = $this->db->delete('spkbahan', ['id_spkbahan' => $id]);
        if ($del) {
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
        redirect('spk');
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
            if ($simpan) {
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
        redirect('spk');
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
                'id_petak' => $this->input->post('petak', true),
                'nilai_spklapangan' => htmlspecialchars($this->input->post('nilai', true))
            ], ['id_spklapangan' => $id]);
            if ($data) {
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
        redirect('spk');
    }

    public function delSpklapangan($id)
    {
        $del = $this->db->delete('spklapangan', ['id_spklapangan' => $id]);
        if ($del) {
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
        redirect('spk');
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
                'kategori' => $this->input->post('kategori', true),
                'id_petak' => $this->input->post('petak', true),
                'nilai_spkbibit' => htmlspecialchars($this->input->post('nilai', true)),
                'satuan_spkbibit' => htmlspecialchars($this->input->post('satuan', true))
            ]);
            if ($data) {
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
        redirect('spk');
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
                'id_petak' => $this->input->post('petak', true),
                'nilai_spkbibit' => htmlspecialchars($this->input->post('nilai', true)),
                'satuan_spkbibit' => htmlspecialchars($this->input->post('satuan', true))
            ], ['id_spkbibit' => $id]);
            if ($data) {
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
        redirect('spk');
    }

    public function delSpkbibit($id)
    {
        $del = $this->db->delete('spkbibit', ['id_spkbibit' => $id]);
        if ($del) {
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
        redirect('spk');
    }
    public function addSpkbibitkat()
    {
        $data = $this->db->insert('spkbibit_bantu', [
            'id_spkbibit' => $this->input->post('kategori', true),
            'id_bibit' => $this->input->post('bibit', true),
        ]);
        if ($data) {
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
        redirect('spk');
    }
    public function delSpkbibitkat($id)
    {
        $del = $this->db->delete('spkbibit_bantu', ['id_bibitbantu' => $id]);
        if ($del) {
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
        redirect('spk');
    }
}
