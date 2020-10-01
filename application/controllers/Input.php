<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
    }

    public function index()
    {
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

    public function harianbibitinput()
    {
        $adname = time();
        // fungsi kompres file gambar
        function compressImageBibit($source, $destination, $quality)
        {
            // Mendapatkan info gambar
            $imgInfo = getimagesize($source);
            $mime = $imgInfo['mime'];
            // Membuat gambar baru dari file yang diupload
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($source);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }
            // simpan gambar
            imagejpeg($image, $destination, $quality);
            // Return gambar yang dikompres
            return $destination;
        }

        $data = [
            'id_spkbibit' => $this->input->post('jenisbibit', true),
            'nilai_harianbibit' => $this->input->post('volume', true),
            'tgl' => $this->input->post('tgl_pengawasan', true),
            'foto' => $adname . '-' . $_FILES["foto"]["name"],
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
            'tgl_create' => time()
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
                if (!empty($_FILES["foto"]["name"])) {
                    // Lokasi path untuk upload
                    $uploadPath = FCPATH . "assets/img/peng-bibit/";
                    // File info
                    $fileName = basename($adname . '-' . $_FILES["foto"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    // Syarat format yang diperbolehkan
                    $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
                    if (in_array($fileType, $allowTypes)) {
                        // array gambar sementara
                        $imageTemp = $_FILES["foto"]["tmp_name"];
                        // Kompres dan upload data
                        $compressedImage = compressImageBibit($imageTemp, $imageUploadPath, 35);
                        if ($compressedImage) {
                            echo " <script>alert('Gambar " . $fileName . " diupload')</script> ";
                        } else {
                            echo " <script>alert('Gambar " . $fileName . " gagal diupload')</script> ";
                        }
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>  Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> SPK Bibit Berhasil ditambahkan.
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
        // fungsi kompres file gambar
        function compressImage($source, $destination, $quality)
        {
            // Mendapatkan info gambar
            $imgInfo = getimagesize($source);
            $mime = $imgInfo['mime'];
            // Membuat gambar baru dari file yang diupload
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($source);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }
            // simpan gambar
            imagejpeg($image, $destination, $quality);
            // Return gambar yang dikompres
            return $destination;
        }

        $data = [
            'id_spkbahan' => $this->input->post('kegbahan', true),
            'nilai_harianbahan' => $this->input->post('volume', true),
            'tgl' => $this->input->post('tgl_pengawasan', true),
            'foto' => $adname . '-' . $_FILES["foto"]["name"],
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
            'tgl_create' => time()
        ];
        // $input = $this->db->insert('harianbahan', $data);
        // print_r($this->db->error());
        // echo "<pre>";
        // print_r($data);

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
                if (!empty($_FILES["foto"]["name"])) {
                    // Lokasi path untuk upload
                    $uploadPath = FCPATH . "assets/img/peng-bahan/";
                    // File info
                    $fileName = basename($adname . '-' . $_FILES["foto"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    // Syarat format yang diperbolehkan
                    $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
                    if (in_array($fileType, $allowTypes)) {
                        // array gambar sementara
                        $imageTemp = $_FILES["foto"]["tmp_name"];
                        // Kompres dan upload data
                        $compressedImage = compressImage($imageTemp, $imageUploadPath, 35);
                        if ($compressedImage) {
                            echo " <script>alert('Gambar " . $fileName . " ter upload')</script> ";
                        } else {
                            echo " <script>alert('Gambar " . $fileName . " tidak terupload')</script> ";
                        }
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>  Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
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
        }
        redirect('input/harianbahan');
    }

    public function harianlapanganinput()
    {
        $adname = time();
        // fungsi kompres file gambar
        function compressImageLap($source, $destination, $quality)
        {
            // Mendapatkan info gambar
            $imgInfo = getimagesize($source);
            $mime = $imgInfo['mime'];
            // Membuat gambar baru dari file yang diupload
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($source);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }
            // simpan gambar
            imagejpeg($image, $destination, $quality);
            // Return gambar yang dikompres
            return $destination;
        }
        // upload video 
        if (!empty($_FILES['video']['name'])) {
            $config['upload_path'] =  FCPATH . 'assets/img/peng-video/';
            $config['allowed_types'] = 'mp4|3gp|flv';
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
            'foto' => $adname . '-' . $_FILES["foto"]["name"],
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
            'tgl_create' => time()
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
                if (!empty($_FILES["foto"]["name"])) {
                    // Lokasi path untuk upload
                    $uploadPath = FCPATH . "assets/img/peng-lapangan/";
                    // File info
                    $fileName = basename($adname . '-' . $_FILES["foto"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    // Syarat format yang diperbolehkan
                    $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
                    if (in_array($fileType, $allowTypes)) {
                        // array gambar sementara
                        $imageTemp = $_FILES["foto"]["tmp_name"];
                        // Kompres dan upload data
                        $compressedImage = compressImageLap($imageTemp, $imageUploadPath, 35);
                        if ($compressedImage) {
                            echo " <script>alert('Gambar " . $fileName . " ter upload')</script> ";
                        } else {
                            echo " <script>alert('Gambar " . $fileName . " tidak terupload')</script> ";
                        }
                    } else {
                        $this->session->set_flashdata(
                            'messagegmbr',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>  Upload gambar Gagal! </strong> Cek tipe file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                }
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> Sukses! </strong> Pengawasan Harian Lapangan Berhasil ditambahkan.
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

    public function mingguan()
    {
        $data['title'] = 'Pengawasan Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Query Kabupaten 
        $data['kabupaten'] = $this->db->get('dt_kabupaten')->result_array();
        // Query Kecamatan 
        $this->load->model('Menu_model', 'kec');
        $data['kecamatan'] = $this->kec->getKec();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/mingguan', $data);
        $this->load->view('templates/footer');
    }
    public function bahan()
    {
        $data['title'] = 'Pengawasan Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['id'] = $this->input->post('id_form', true);
        $data['kabupat'] = $this->db->get_where('dt_kabupaten', ['id_kabupaten' => $this->input->post('kabupat', true)])->row_array();
        $data['kecamat'] = $this->db->get_where('dt_kecamatan', ['id_kecamatan' => $this->input->post('kecamat', true)])->row_array();
        $data['desa'] = $this->db->get_where('dt_desa', ['id_desa' => $this->input->post('deselect', true)])->row_array();
        $data['mingguke'] = $this->input->post('mingguke', true);
        $data['blnthn'] = $this->input->post('blnthn', true);
        $data['petak'] = htmlspecialchars($this->input->post('petak', true));
        $data['koordinat'] = htmlspecialchars($this->input->post('koordinat', true));
        $data['luas'] = htmlspecialchars($this->input->post('luas', true));
        //Load Anggota Supervisor per 7 hari
        $id_users = $data['user']['id_user'];
        $this->load->model('Report_model', 'report');
        $data['report'] = $this->report->getMingguan($data);

        $array = [
            'id_penanaman' => $this->input->post('id_form', true),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/mingguan-next', $data);
        $this->load->view('templates/footer');
    }
    public function persiapan()
    {
        $data['title'] = 'Pengawasan Mingguan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['id'] = $this->input->post('id_form', true);
        $data['kabupat'] = $this->db->get_where('dt_kabupaten', ['id_kabupaten' => $this->input->post('kabupat', true)])->row_array();
        $data['kecamat'] = $this->db->get_where('dt_kecamatan', ['id_kecamatan' => $this->input->post('kecamat', true)])->row_array();
        $data['desa'] = $this->db->get_where('dt_desa', ['id_desa' => $this->input->post('deselect', true)])->row_array();
        $data['mingguke'] = $this->input->post('mingguke', true);
        $data['blnthn'] = $this->input->post('blnthn', true);
        $data['petak'] = htmlspecialchars($this->input->post('petak', true));
        $data['koordinat'] = htmlspecialchars($this->input->post('koordinat', true));
        $data['luas'] = htmlspecialchars($this->input->post('luas', true));

        $array = [
            'id_penanaman' => $this->input->post('id_form', true),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('input/mingguan-next2', $data);
        $this->load->view('templates/footer');
    }
}
