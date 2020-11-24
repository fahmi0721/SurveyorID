<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
        date_default_timezone_set('Asia/Makassar');
    }
    public function index()
    {
        $data['title'] = 'Manage Lokasi';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();
        // Query Kecamatan 
        $this->load->model('Menu_model', 'kec');
        $data['kecamatan'] = $this->kec->getKec();
        // Query Desa
        $this->load->model('Menu_model', 'desa');
        $data['datadesa'] = $this->desa->getDesa();
        // Query Blok
        $this->load->model('Menu_model', 'blok');

        // form Menu validasi
        $this->form_validation->set_rules('name', 'Nama Kabupaten', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('lokasi/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nm_kabupaten' => htmlspecialchars($this->input->post('name', true)),
                'ket_kabupaten' => htmlspecialchars($this->input->post('ket', true))
            ];
            $this->db->insert('dt_kabupaten', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data Kabupaten Ditambahkan!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        }
    }
    public function kabUpdate($id)
    {
        $this->db->update('dt_kabupaten', [
            'nm_kabupaten' => htmlspecialchars($this->input->post('name', true)),
            'ket_kabupaten' => htmlspecialchars($this->input->post('ket', true)),
            'flag_kab' => $this->input->post('flag', true)
        ], ['id_kabupaten' => $id]);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data Kabupaten Diperbaharui!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('lokasi');
    }

    public function kabDel($id)
    {
        $where = ['id_kabupaten' => $id];
        $hapus = $this->db->delete('dt_kabupaten', $where);
        if ($hapus) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data kabupaten dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data gagal dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        }
    }

    public function kecAdd()
    {
        $data = [
            'id_kabupaten' => $this->input->post('kab', true),
            'nm_kecamatan' => htmlspecialchars($this->input->post('kec', true)),
            'ket_kecamatan' => htmlspecialchars($this->input->post('ket', true))
        ];
        $this->db->insert('dt_kecamatan', $data);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data Kecamatan berhasil Ditambahkan!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('lokasi');
    }

    public function kecUpdate($id)
    {
        $this->db->update('dt_kecamatan', [
            'id_kabupaten' => $this->input->post('kab', true),
            'nm_kecamatan' => htmlspecialchars($this->input->post('kec', true)),
            'ket_kecamatan' => htmlspecialchars($this->input->post('ket', true)),
            'flag_kec' => $this->input->post('flag', true)
        ], ['id_kecamatan' => $id]);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data Kecamatan Diperbaharui!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('lokasi');
    }
    public function kecDel($id)
    {
        $where = ['id_kecamatan' => $id];
        $hapus = $this->db->delete('dt_kecamatan', $where);
        if ($hapus) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data kecamatan dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data kecamatan gagal dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        }
    }
    public function kecAjax()
    {
        // Query Kecamatan ajax
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getDesajax($idnya)->result();
        echo json_encode($data);
    }
    public function desAdd()
    {
        $data = [
            'id_kecamatan' => $this->input->post('keca', true),
            'nm_desa' => htmlspecialchars($this->input->post('desa', true)),
            'ket_desa' => htmlspecialchars($this->input->post('ket', true))
        ];
        $this->db->insert('dt_desa', $data);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data desa berhasil ditambahkan!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('lokasi');
    }
    public function desEdit($id)
    {
        $this->db->update('dt_desa', [
            'id_kecamatan' => $this->input->post('kecaE', true),
            'nm_desa' => htmlspecialchars($this->input->post('desa', true)),
            'ket_desa' => htmlspecialchars($this->input->post('ket', true)),
            'flag_des' => $this->input->post('flag', true),
        ], ['id_desa' => $id]);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data Desa Diperbaharui!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('lokasi');
    }
    public function desDel($id)
    {
        $where = ['id_desa' => $id];
        $hapus = $this->db->delete('dt_desa', $where);
        if ($hapus) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data desa telah dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data desa gagal dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        }
    }
    public function addBlok()
    {
        $blok = htmlspecialchars($this->input->post('blok', true));
        $data = [
            'id_desa' => $this->input->post('deselect', true),
            'nm_blok' => htmlspecialchars($this->input->post('blok', true)),
            'luas' => htmlspecialchars($this->input->post('luas', true)),
            'ket_blok' => htmlspecialchars($this->input->post('ket', true))
        ];
        // filter jika blok di desa itu sudah ada
        $desaWhere = [
            'id_desa' => $this->input->post('deselect', true)
        ];
        $where = [
            'id_desa' => $this->input->post('deselect', true),
            'nm_blok' => htmlspecialchars($this->input->post('blok', true))
        ];
        $filter = $this->db->get_where('tb_blok', $where)->row_array();
        if (empty($filter)) {
            // jika belum ada, insert data baru
            $sukses = $this->db->insert('tb_blok', $data);
            if ($sukses) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Blok berhasil ditambahkan!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Blok gagal ditambahkan!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            // jika blok di desa itu sudah ada maka tampilkan pesan error
            // ambil nama desanya
            $desax['nmdesanya'] = $this->db->get_where('dt_desa', $desaWhere)->row_array();
            $des = $desax['nmdesanya']['nm_desa'];
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal! </strong> Data <b>' . $blok . '</b> di desa <b>' . $des . '  </b> sudah ada.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('lokasi');
    }
    public function blokUpdate($id)
    {
        $id_desa = $this->input->post('deselect', true);
        $nm_blok = htmlspecialchars($this->input->post('blok', true));
        // filter jika blok di desa itu sudah ada
        // Query cek blok selain id blok ini
        $this->load->model('Menu_model', 'blokCek');
        $cekData = $this->blokCek->getCekBlok($id, $id_desa, $nm_blok);
        if (empty($cekData)) {
            // jalankan Update data blok
            $update = $this->db->update('tb_blok', [
                'id_desa' => $this->input->post('deselect', true),
                'nm_blok' => htmlspecialchars($this->input->post('blok', true)),
                'luas' => htmlspecialchars($this->input->post('luas', true)),
                'ket_blok' => htmlspecialchars($this->input->post('ket', true)),
                'flag_blok' => $this->input->post('flag', true)
            ], ['id_blok' => $id]);
            if ($update) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Blok berhasil di update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kesalahan!</strong> Blok gagal di update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            // jika blok di desa itu sudah ada maka tampilkan pesan error
            // ambil nama desanya
            $desax['nmdesanya'] = $this->db->get_where('dt_desa', ['id_desa' => $this->input->post('deselect', true)])->row_array();
            $des = $desax['nmdesanya']['nm_desa'];
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal! </strong> Data <b>' . $nm_blok . '</b> di desa <b>' . $des . '  </b> sudah ada.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('lokasi');
    }

    public function blokDel($id)
    {
        $hapus = $this->db->delete('tb_blok', ['id_blok' => $id]);
        if ($hapus) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses! </strong> Data telah dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan! </strong> Data gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        }
    }

    public function desblAjax()
    {
        // Query desa ke blok ajax
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kedes');
        $data = $this->kedes->getDesblokajax($idnya)->result();
        echo json_encode($data);
    }

    public function addPetak()
    {
        $data = [
            'id_blok' => $this->input->post('blok', true),
            'nm_petak' => htmlspecialchars($this->input->post('petak', true)),
            'ket_petak' => htmlspecialchars($this->input->post('ket', true))
        ];
        $insert = $this->db->insert('tb_petak', $data);
        if ($insert) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses! </strong> Petak berhasil ditambahkan
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan! </strong> Petak gagal ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('lokasi');
    }

    public function petakDel($id)
    {
        $hapus = $this->db->delete('tb_petak', ['id_petak' => $id]);
        if ($hapus) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses! </strong> Petak telah dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan! </strong> Petak gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('lokasi');
        }
    }
}
