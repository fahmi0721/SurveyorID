<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
        date_default_timezone_set('Asia/Makassar');
    }

    public function LapSatuanAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getSatuanKegiatan($idnya);
        echo json_encode($data);
    }

    public function BahanSatuanAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getSatuanBahan($idnya);
        echo json_encode($data);
    }

    public function bibitSatuanAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getSatuanBibit($idnya);
        echo json_encode($data);
    }

    public function index()
    {
        $this->load->model('Log_model', 'lognya');
        $data['title'] = 'Pengawasan Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/index', $data);
        $this->load->view('templates/footer');
    }
    public function lapanganHarianAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'lap');
        $data = $this->lap->getLapanganKegiatnModel($idnya);
        $data = $this->lap->getLapanganKegiatnModel($idnya);
        echo json_encode($data);
    }

    public function bahanHarianAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getBahanKegiatnModel($idnya);
        echo json_encode($data);
    }

    public function bibitjenisAjax()
    {
        $idnya = ['id_petak' => $this->input->post('id', TRUE)];
        $data = $this->db->get_where('spkbibit', $idnya)->result_array();
        $rs = array();
        foreach ($data as $row) {
            if ($this->getRealisasiBibit($row['id_spkbibit']) < $row['nilai_spkbibit']) {
                $rs[] = $row;
            }
        }
        echo json_encode($rs);
    }

    public function bibitAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'bibit');
        $data = $this->bibit->getBibitModel($idnya);
        echo json_encode($data);
    }

    public function bibitnyaAjax()
    {
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'bibit');
        $data = $this->bibit->getBibitnya($idnya);
        echo json_encode($data);
    }

    public function harianbahan()
    {
        $data['title'] = 'Pengawasan Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/harian-bahan', $data);
        $this->load->view('templates/footer');
    }

    public function harianbibitpertama()
    {
        $data['title'] = 'Pengawasan Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/harian-bibit-pertama', $data);
        $this->load->view('templates/footer');
    }

    public function harianbibit()
    {
        $data['title'] = 'Pengawasan Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/harian-bibit', $data);
        $this->load->view('templates/footer');
    }

    public function harianlapangan()
    {
        $data['title'] = 'Pengawasan Harian';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/harian-lapangan', $data);
        $this->load->view('templates/footer');
    }

    public function kecAjax()
    {
        // Query Kecamatan ajax
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kecam');
        $data = $this->kecam->getDesajax($idnya)->result();
        echo json_encode($data);
    }

    public function desaAjax()
    {
        // Query Desa ajax
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kedesa');
        $data = $this->kedesa->getDesaAjax($idnya)->result();
        echo json_encode($data);
    }
    public function desblAjax()
    {
        // Query desa ke blok ajax
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kedes');
        $data = $this->kedes->getDesblokajax($idnya)->result();
        echo json_encode($data);
    }
    public function blpetAjax()
    {
        // Query blok ke petak ajax
        $idnya = $this->input->post('id', TRUE);
        $this->load->model('Menu_model', 'kepet');
        $data = $this->kepet->getBlokPetajax($idnya)->result();
        // print_r($data);

        echo json_encode($data);
    }

    public function getJumlahSpkBahan($IdSpkBahan)
    {
        $query = $this->db->get_where('spkbahan', array('id_spkbahan' => $IdSpkBahan))->result_array();
        return $query[0]['nilai_spkbahan'];
    }

    public function getRealisasiBahan($IdSpkBahan)
    {
        $sql = "SELECT SUM(nilai_harianbahan) as tot FROM harianbahan WHERE id_spkbahan = '$IdSpkBahan'";
        $data = $this->db->query($sql)->result_array();
        return $data[0]['tot'];
    }

    public function getRealisasiLapangan($IdSpkLapangan)
    {
        $sql = "SELECT SUM(nilai_harianlapangan) as tot FROM harianlapangan WHERE id_spklapangan = '$IdSpkLapangan'";
        $data = $this->db->query($sql)->result_array();
        return $data[0]['tot'];
    }

    public function getJumlahSpkLapangan($IdLapangan)
    {
        $query = $this->db->get_where('spklapangan', array('id_spklapangan' => $IdLapangan))->result_array();
        return $query[0]['nilai_spklapangan'];
    }

    public function getJumlahSpkBibit($IdSpkBibit)
    {
        $query = $this->db->get_where('spkbibit', array('id_spkbibit' => $IdSpkBibit))->result_array();
        return $query[0]['nilai_spkbibit'];
    }

    public function getRealisasiBibit($IdSpkBibit)
    {
        $sql = "SELECT SUM(nilai_harianbibit) as tot FROM harianbibit WHERE id_spkbibit = '$IdSpkBibit'";
        $data = $this->db->query($sql)->result_array();
        return $data[0]['tot'];
    }

    public function harianbibitinputpertama()
    {
        $adname = time();
        $data = [
            'nilai_pertama' => $this->input->post('pertama', true),
            'nilai_kedua' => $this->input->post('kedua', true),
            'nilai_ketiga' => $this->input->post('ketiga', true),
            'tgl' => $this->input->post('tgl_pengawasan', true),
            'foto' => '1-' . $adname . '-' . $_FILES["foto"]["name"],
            'foto_2' => '2-' . $adname . '-' . $_FILES["foto2"]["name"],
            'foto_3' => '3-' . $adname . '-' . $_FILES["foto3"]["name"],
            'foto_4' => '4-' . $adname . '-' . $_FILES["foto4"]["name"],
            'foto_5' => '5-' . $adname . '-' . $_FILES["foto5"]["name"],
            'id_kab' => $this->input->post('kabupat', true),
            'id_kec' => $this->input->post('kecamat', true),
            'id_desa' => $this->input->post('deselect', true),
            'id_blok' => $this->input->post('blok', true),
            'id_petak' => $this->input->post('petak', true),
            'id_bibit' => $this->input->post('bibit', true),
            'koordinat' => $this->input->post('koordinat', true),
            'luas' => $this->input->post('luas', true),
            'petugas_lap' => $this->input->post('petugas', true),
            'keterangan' => $this->input->post('ket', true),
            'id_user' => $this->input->post('id_user', true),
            'tgl_create' => time(),
            'status' => 0
        ];
        $input = $this->db->insert('harianbibit_i', $data);
        if ($input) {
            // Lokasi path untuk upload
            $uploadPath = "assets/img/peng-bibit-pertama/";
            // Syarat format yang diperbolehkan
            $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
            if (!empty($_FILES["foto"]["name"])) {
                // File info
                $fileName = basename('1-' . $adname . '-' . $_FILES["foto"]["name"]);
                $imageUploadPath = $uploadPath . $fileName;
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    $imageTemp = $_FILES["foto"]["tmp_name"];
                    copy($imageTemp, $imageUploadPath);
                } else {
                    $this->session->set_flashdata(
                        'messagegmbr',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            }
            if (!empty($_FILES["foto2"]["name"])) {
                // File info
                $fileName = basename('2-' . $adname . '-' . $_FILES["foto2"]["name"]);
                $imageUploadPath = $uploadPath . $fileName;
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    $imageTemp = $_FILES["foto2"]["tmp_name"];
                    copy($imageTemp, $imageUploadPath);
                } else {
                    $this->session->set_flashdata(
                        'messagegmbr',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            }
            if (!empty($_FILES["foto3"]["name"])) {
                // File info
                $fileName = basename('3-' . $adname . '-' . $_FILES["foto3"]["name"]);
                $imageUploadPath = $uploadPath . $fileName;
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    $imageTemp = $_FILES["foto3"]["tmp_name"];
                    copy($imageTemp, $imageUploadPath);
                } else {
                    $this->session->set_flashdata(
                        'messagegmbr',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            }
            if (!empty($_FILES["foto4"]["name"])) {
                // File info
                $fileName = basename('4-' . $adname . '-' . $_FILES["foto4"]["name"]);
                $imageUploadPath = $uploadPath . $fileName;
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    $imageTemp = $_FILES["foto4"]["tmp_name"];
                    copy($imageTemp, $imageUploadPath);
                } else {
                    $this->session->set_flashdata(
                        'messagegmbr',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            }
            if (!empty($_FILES["foto5"]["name"])) {
                // File info
                $fileName = basename('5-' . $adname . '-' . $_FILES["foto5"]["name"]);
                $imageUploadPath = $uploadPath . $fileName;
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    $imageTemp = $_FILES["foto5"]["tmp_name"];
                    copy($imageTemp, $imageUploadPath);
                } else {
                    $this->session->set_flashdata(
                        'messagegmbr',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            }
            $datetime = date("Y-m-d");
            $waktu = date("H:i:s");
            // kirim Ke Log 
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Input Sukses Data Pengawasan Harian Bibit (Tahap I) : " . $data['petugas_lap'],
                'id_sub_menu' => 7,
                'tgl' => $datetime,
                'waktu' => $waktu
            ]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> Pengawasan Harian Bibit Tahap I Berhasil di Kirim.
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
        redirect('input/harianbibitpertama');
    }

    public function harianbibitinput()
    {
        $adname = time();
        $data = [
            'id_spkbibit' => $this->input->post('jenisbibit', true),
            'nilai_harianbibit' => $this->input->post('volume', true),
            'tgl' => $this->input->post('tgl_pengawasan', true),
            'foto' => '1-' . $adname . '-' . $_FILES["foto"]["name"],
            'foto_2' => '2-' . $adname . '-' . $_FILES["foto2"]["name"],
            'foto_3' => '3-' . $adname . '-' . $_FILES["foto3"]["name"],
            'foto_4' => '4-' . $adname . '-' . $_FILES["foto4"]["name"],
            'foto_5' => '5-' . $adname . '-' . $_FILES["foto5"]["name"],
            'id_kab' => $this->input->post('kabupat', true),
            'id_kec' => $this->input->post('kecamat', true),
            'id_desa' => $this->input->post('deselect', true),
            'id_blok' => $this->input->post('blok', true),
            'id_petak' => $this->input->post('petak', true),
            'id_bibit' => $this->input->post('bibit', true),
            'koordinat' => $this->input->post('koordinat', true),
            'luas' => $this->input->post('luas', true),
            'petugas_lap' => $this->input->post('petugas', true),
            'keterangan' => $this->input->post('ket', true),
            'id_user' => $this->input->post('id_user', true),
            'tgl_create' => time(),
            'status' => 0
        ];
        $JumlahSpkBibit = $this->getJumlahSpkBibit($data['id_spkbibit']);
        $JumlahBibitYangRealisasi = $this->getRealisasiBibit($data['id_spkbibit']);
        $Total = $JumlahBibitYangRealisasi + $data['nilai_harianbibit'];
        if ($Total > $JumlahSpkBibit) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Volume bahan melebihi SPK yang telah disepakati.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $input = $this->db->insert('harianbibit', $data);
            if ($input) {
                // ketika melakukan submit file foto dikompres dan upload
                // Lokasi path untuk upload
                $uploadPath = FCPATH . "assets/img/peng-bibit/";
                // Syarat format yang diperbolehkan
                $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
                if (!empty($_FILES["foto"]["name"])) {
                    // File info
                    $fileName = basename('1-' . $adname . '-' . $_FILES["foto"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto2"]["name"])) {
                    // File info
                    $fileName = basename('2-' . $adname . '-' . $_FILES["foto2"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto2"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto3"]["name"])) {
                    // File info
                    $fileName = basename('3-' . $adname . '-' . $_FILES["foto3"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto3"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto4"]["name"])) {
                    // File info
                    $fileName = basename('4-' . $adname . '-' . $_FILES["foto4"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto4"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto5"]["name"])) {
                    // File info
                    $fileName = basename('5-' . $adname . '-' . $_FILES["foto5"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto5"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                } // end script upload 
                $datetime = date("Y-m-d");
                $waktu = date("H:i:s");
                // kirim Ke Log 
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "Input Data Harian Bibit : " . $data['petugas_lap'],
                    'id_sub_menu' => 7,
                    'tgl' => $datetime,
                    'waktu' => $waktu
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> Pengawasan Harian Bibit Berhasil di Kirim.
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
        }
        redirect('input/harianbibit');
    }

    public function harianbahaninput()
    {
        $adname = time();
        $data = [
            'id_spkbahan' => $this->input->post('kegbahan', true),
            'nilai_harianbahan' => $this->input->post('volume', true),
            'tgl' => $this->input->post('tgl_pengawasan', true),
            'foto' => '1-' . $adname . '-' . $_FILES["foto"]["name"],
            'foto_2' => '2-' . $adname . '-' . $_FILES["foto2"]["name"],
            'foto_3' => '3-' . $adname . '-' . $_FILES["foto3"]["name"],
            'foto_4' => '4-' . $adname . '-' . $_FILES["foto4"]["name"],
            'foto_5' => '5-' . $adname . '-' . $_FILES["foto5"]["name"],
            'id_kab' => $this->input->post('kabupat', true),
            'id_kec' => $this->input->post('kecamat', true),
            'id_desa' => $this->input->post('deselect', true),
            'id_blok' => $this->input->post('blok', true),
            'id_petak' => $this->input->post('petak', true),
            'koordinat' => $this->input->post('koordinat', true),
            'luas' => $this->input->post('luas', true),
            'petugas_lap' => $this->input->post('petugas', true),
            'keterangan' => $this->input->post('ket', true),
            'id_user' => $this->input->post('id_user', true),
            'tgl_create' => time(),
            'status' => 0
        ];

        $JumlahSpkBahan = $this->getJumlahSpkBahan($data['id_spkbahan']);
        $JumlahBahanYangRealisasi = $this->getRealisasiBahan($data['id_spkbahan']);
        $Total = $JumlahBahanYangRealisasi + $data['nilai_harianbahan'];
        if ($Total > $JumlahSpkBahan) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Volume bahan melebihi SPK yang telah disepakati.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $input = $this->db->insert('harianbahan', $data);
            if ($input) {
                // ketika melakukan submit file foto dikompres dan upload
                // Lokasi path untuk upload
                $uploadPath = FCPATH . "assets/img/peng-bahan/";
                // Syarat format yang diperbolehkan
                $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
                if (!empty($_FILES["foto"]["name"])) {
                    // File info
                    $fileName = basename('1-' . $adname . '-' . $_FILES["foto"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto2"]["name"])) {
                    // File info
                    $fileName = basename('2-' . $adname . '-' . $_FILES["foto2"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto2"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto3"]["name"])) {
                    // File info
                    $fileName = basename('3-' . $adname . '-' . $_FILES["foto3"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto3"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto4"]["name"])) {
                    // File info
                    $fileName = basename('4-' . $adname . '-' . $_FILES["foto4"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto4"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto5"]["name"])) {
                    // File info
                    $fileName = basename('5-' . $adname . '-' . $_FILES["foto5"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto5"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                } // end script upload 
                $datetime = date("Y-m-d");
                $waktu = date("H:i:s");
                // kirim Ke Log 
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "Input Data Harian Bahan : " . $data['petugas_lap'],
                    'id_sub_menu' => 7,
                    'tgl' => $datetime,
                    'waktu' => $waktu
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> Pengawawsan Harian Bahan Berhasil di Kirim.
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
        }
        redirect('input/harianbahan');
    }

    public function harianlapanganinput()
    {
        $adname = time();
        // upload video 
        //ini_set('post_max_size', '64M');
        //ini_set('upload_max_filesize', '64M');
        if (!empty($_FILES['video']['name'])) {
            $config['upload_path'] =  './assets/img/peng-video/';
            $config['allowed_types'] = 'mp4|3gp|flv|ts';
            $config['max_size'] = '20480';
            $config['file_name'] = $adname . '-' . $_FILES['video']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($config) {
                if ($this->upload->do_upload('video')) {
                    $new_image = $this->upload->data('file_name');
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata(
                        'msgVideo',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> Upload Video Sukses! </strong>' . $error . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                    );
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata(
                        'msgVideo',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Upload Video Gagal! </strong> Cek tipe file dan ukuran max 20Mb.<br> ' . $error . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata(
                    'msgVideo',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> Upload Video Gagal! </strong> Cek tipe file dan ukuran max 20Mb.<br> ' . $error . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
        } else {
            $new_image = '';
        }

        $data = [
            'id_spklapangan' => $this->input->post('keglapangan', true),
            'nilai_harianlapangan' => $this->input->post('volume', true),
            'tgl' => $this->input->post('tgl_pengawasan', true),
            'foto' => '1-' . $adname . '-' . $_FILES["foto"]["name"],
            'foto_2' => '2-' . $adname . '-' . $_FILES["foto2"]["name"],
            'foto_3' => '3-' . $adname . '-' . $_FILES["foto3"]["name"],
            'foto_4' => '4-' . $adname . '-' . $_FILES["foto4"]["name"],
            'foto_5' => '5-' . $adname . '-' . $_FILES["foto5"]["name"],
            'video' => $new_image,
            'id_kab' => $this->input->post('kabupat', true),
            'id_kec' => $this->input->post('kecamat', true),
            'id_desa' => $this->input->post('deselect', true),
            'id_blok' => $this->input->post('blok', true),
            'id_petak' => $this->input->post('petak', true),
            'koordinat' => $this->input->post('koordinat', true),
            'luas' => $this->input->post('luas', true),
            'petugas_lap' => $this->input->post('petugas', true),
            'keterangan' => $this->input->post('ket', true),
            'id_user' => $this->input->post('id_user', true),
            'tgl_create' => time(),
            'status' => 0
        ];

        $JumlahSpkLapangan = $this->getJumlahSpkLapangan($data['id_spklapangan']);
        $JumlahLapanganYangRealisasi = $this->getRealisasiLapangan($data['id_spklapangan']);
        $Total = $JumlahLapanganYangRealisasi + $data['nilai_harianlapangan'];
        if ($Total > $JumlahSpkLapangan) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Ops! </strong> Volume bahan melebihi SPK yang telah disepakati.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $input = $this->db->insert('harianlapangan', $data);
            if ($input) {
                // ketika melakukan submit file foto dikompres dan upload
                // Lokasi path untuk upload
                $uploadPath = FCPATH . "assets/img/peng-lapangan/";
                // Syarat format yang diperbolehkan
                $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
                if (!empty($_FILES["foto"]["name"])) {
                    // File info
                    $fileName = basename('1-' . $adname . '-' . $_FILES["foto"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto2"]["name"])) {
                    // File info
                    $fileName = basename('2-' . $adname . '-' . $_FILES["foto2"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto2"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto3"]["name"])) {
                    // File info
                    $fileName = basename('3-' . $adname . '-' . $_FILES["foto3"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto3"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto4"]["name"])) {
                    // File info
                    $fileName = basename('4-' . $adname . '-' . $_FILES["foto4"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto4"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                if (!empty($_FILES["foto5"]["name"])) {
                    // File info
                    $fileName = basename('5-' . $adname . '-' . $_FILES["foto5"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        $imageTemp = $_FILES["foto5"]["tmp_name"];
                        copy($imageTemp, $imageUploadPath);
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }

                $datetime = date("Y-m-d");
                $waktu = date("H:i:s");
                // kirim Ke Log 
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "Input Data Harian Lapangan : " . $data['petugas_lap'],
                    'id_sub_menu' => 7,
                    'tgl' => $datetime,
                    'waktu' => $waktu
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> Pengawasan Harian Lapangan Berhasil di Kirim.
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
        }
        redirect('input/harianlapangan');
    }

    public function view()
    {
        $data['title'] = 'View Pengawasan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();
        // Query Lokasi berdasarkan user login
        $this->load->model('Report_model', 'loask');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/view', $data);
        $this->load->view('templates/footer');
    }
    public function viewdetailpengawasan($id_petak)
    {
        $data['title'] = 'View Pengawasan';
        $data['urlx'] = $id_petak;
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Lokasi berdasarkan user login
        $this->load->model('Report_model', 'det');
        $data['details'] = $this->det->getDetPengawasanBahan($id_petak, $data['user']['id_user']);
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $waktu = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses Detail Pengawasan Bahan : idpetak(" . $id_petak . ")",
            'id_sub_menu' => 9,
            'tgl' => $datetime,
            'waktu' => $waktu
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/view-pengawasandetail', $data);
        $this->load->view('templates/footer');
    }
    public function viewdetailpengawasanlap($id_petak)
    {
        $data['title'] = 'View Pengawasan';
        $data['urlx'] = $id_petak;
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Lokasi berdasarkan user login
        $this->load->model('Report_model', 'det');
        $data['details'] = $this->det->getDetPengawasanLap($id_petak, $data['user']['id_user']);
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $waktu = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses Detail Pengawasan Lapangan : idpetak(" . $id_petak . ")",
            'id_sub_menu' => 9,
            'tgl' => $datetime,
            'waktu' => $waktu
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/view-pengawasandetaillap', $data);
        $this->load->view('templates/footer');
    }
    public function viewdetailpengawasanbibit($id_petak)
    {
        $data['urlx'] = $id_petak;
        $data['title'] = 'View Pengawasan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Lokasi berdasarkan user login
        $this->load->model('Report_model', 'det');
        $data['details'] = $this->det->getDetPengawasanBibit($id_petak, $data['user']['id_user']);
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $waktu = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses Detail Pengawasan Bibit : idpetak(" . $id_petak . ")",
            'id_sub_menu' => 9,
            'tgl' => $datetime,
            'waktu' => $waktu
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/view-pengawasandetailbibit', $data);
        $this->load->view('templates/footer');
    }
    public function viewdetailpengawasanbibitpertama($idkab)
    {
        $data['title'] = 'View Pengawasan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Lokasi berdasarkan user login
        $this->load->model('Report_model', 'report');
        $data['lokasi'] = $this->report->getDetPengawasanBibitPl($idkab, $data['user']['id_user']);
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $waktu = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "Akses Detail Pengawasan Bibit : idkabupaten(" . $idkab . ")",
            'id_sub_menu' => 9,
            'tgl' => $datetime,
            'waktu' => $waktu
        ]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/view-pengawasandetailbibitpertama', $data);
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
        } elseif ($aprvl == "bibitpertama") {
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
        if ($aprvl == "bibitpertama") {
            redirect('input/viewdetailpengawasanbibitpertama/' . $url);
        } elseif ($aprvl == "bahan") {
            redirect('input/viewdetailpengawasan/' . $url);
        } elseif ($aprvl == "bibit") {
            redirect('input/viewdetailpengawasanbibit/' . $url);
        } elseif ($aprvl == "lapangan") {
            redirect('input/viewdetailpengawasanlap/' . $url);
        } else {
            redirect('input/viewdetailpengawasanbibitpertama/' . $url);
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
        if ($aprvl == "bibitpertama") {
            redirect('input/viewdetailpengawasanbibitpertama/' . $url);
        } elseif ($aprvl == "bahan") {
            redirect('input/viewdetailpengawasan/' . $url);
        } elseif ($aprvl == "bibit") {
            redirect('input/viewdetailpengawasanbibit/' . $url);
        } elseif ($aprvl == "lapangan") {
            redirect('input/viewdetailpengawasanlap/' . $url);
        } else {
            redirect('input/viewdetailpengawasanbibitpertama/' . $url);
        }
    }
}
