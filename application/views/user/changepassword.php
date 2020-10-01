<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <form action="<?= base_url('user/changepassword'); ?>" method="post">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" class="form-control" name="current_password">
                    <?= form_error('current_password', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="new_password1">New Password</label>
                    <input type="password" id="new_password1" class="form-control" name="new_password1">
                    <?= form_error('new_password1', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="new_password2">Repeat Password</label>
                    <input type="password" id="new_password2" class="form-control" name="new_password2">
                    <?= form_error('new_password2', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
        <div class="col-lg-6" style="display: none;">
            <!-- Tesss -->
            <form method="post" enctype="multipart/form-data">
                <label>Select Image File:</label>
                <input type="file" name="image">
                <input type="submit" name="submit" value="Upload">
            </form>
            <?php

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
            // Lokasi path untuk upload
            $uploadPath = "upload/";
            // ketika melakukan submit file
            $status = $statusMsg = '';
            if (isset($_POST["submit"])) {
                $status = 'error';
                if (!empty($_FILES["image"]["name"])) {
                    // File info
                    $fileName = basename($_FILES["image"]["name"]);
                    $imageUploadPath = $uploadPath . $fileName;
                    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                    // Syarat format yang diperbolehkan
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        // array gambar sementara
                        $imageTemp = $_FILES["image"]["tmp_name"];
                        // Kompres dan upload data
                        $compressedImage = compressImage($imageTemp, $imageUploadPath, 20);
                        if ($compressedImage) {
                            $status = 'success';
                            $statusMsg = "Gambar Berhasil dikompres.";
                        } else {
                            $statusMsg = "Kompres gambar gagal!";
                        }
                    } else {
                        $statusMsg = 'Maaf, hanya JPG, JPEG, PNG, & GIF yang diperbolehkan.';
                    }
                } else {
                    $statusMsg = 'Pilih gambar untuk diupload.';
                }
            }

            // Mencetak pesan status
            echo $statusMsg;

            // $config['upload_path'] = './assets/img/peng-penanaman/'; //path folder
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
            // $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

            // $this->load->library('upload', $config);
            // $this->upload->initialize($config);

            // $number_of_file = sizeof($_FILES['files']['tmp_name']); // mengambil nilai max
            // $filex = $_FILES['files'];
            // for ($i = 0; $i < $number_of_file; $i++) {
            //     # code...
            //     if (!empty($filex['name'][$i])) {
            //         $_FILES['files']['name'] = $filex['name'][$i];
            //         $_FILES['files']['type'] = $filex['type'][$i];
            //         $_FILES['files']['tmp_name'] = $filex['tmp_name'][$i];
            //         $_FILES['files']['error'] = $filex['error'][$i];
            //         $_FILES['files']['size'] = $filex['size'][$i];
            //         // $_FILES['files']['file_name'] = $filex['file_name'][$i];

            //         if ($this->upload->do_upload('files')) {
            //             $gbr = $this->upload->data();
            //             //Compress Image
            //             $config['image_library'] = 'gd2';
            //             $config['source_image'] = './assets/img/peng-penanaman/' . $gbr['file_name'];
            //             $config['create_thumb'] = FALSE;
            //             $config['maintain_ratio'] = FALSE;
            //             $config['quality'] = '40%';
            //             $config['width'] = 750;
            //             $config['height'] = 500;
            //             $config['new_image'] = './assets/img/peng-penanaman/' . $gbr['file_name'];
            //             $this->load->library('image_lib', $config);
            //             $this->image_lib->resize();
            //             $gbrfot_i_1 = $gbr['file_name'];
            //             // $id_pen=$this->input->post('id_pen');
            //             // $this->m_upload->simpan_upload($id_pen,$gbrfot_i_1);
            //             echo "Image berhasil diupload </br>";
            //         }
            //     } else {
            //         echo "Image yang diupload kosong </br>";
            //     }
            // }
            ?>
            <!-- tes -->


        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- 

// $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
// $uploadPath = FCPATH . "assets/img/peng-penanaman/";
// $number_of_file = sizeof($_FILES['files']['tmp_name']); // mengambil nilai max
// $filex = $_FILES['files'];
// $allowTypes = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF');
// for ($i = 1; $i <= $number_of_file; $i++) {
//     if (!empty($filex['name'][$i])) {
//         $_FILES['files']['name'] = $filex['name'][$i];
//         $_FILES['files']['type'] = $filex['type'][$i];
//         $_FILES['files']['tmp_name'] = $filex['tmp_name'][$i];
//         $_FILES['files']['error'] = $filex['error'][$i];
//         $_FILES['files']['size'] = $filex['size'][$i];
//         // $_FILES['files']['file_name'] = $filex['file_name'][$i];
//         $fileName = basename($filex['name'][$i]);
//         $imageUploadPath = $uploadPath . $fileName;
//         $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

//         if (in_array($fileType, $allowTypes)) {
//             // array gambar sementara

//             $imageTemp = $_FILES['files']['tmp_name'] = $filex['tmp_name'][$i];
//             // Kompres dan upload data
//             $compressedImage = compressImage($imageTemp, $imageUploadPath, 20);
//             if ($compressedImage) {
//                 $where = $this->input->post('id_pen', true);
//                 $fot = 'fot_i_' . $i;
//                 // var_dump($imageName);
//                 echo "Image yang diupload Berhasil dikompres : " . $fot . " " . $where . " " . $fileName . "   </br>";

//                 $this->db->set($fot, $fileName);
//                 $this->db->where('id_penanaman',  $where);
//                 $this->db->update('foto_penan');
//             } else {
//                 echo "Kompres gambar gagal!</br>";
//                 // $statusMsg = "Kompres gambar gagal!";
//             }
//         } else {
//             echo "Maaf, hanya JPG, JPEG, PNG, & GIF yang diperbolehkan.!</br>";
//             // $statusMsg = 'Maaf, hanya JPG, JPEG, PNG, & GIF yang diperbolehkan.';
//         }
//     } else {
//         echo "Image yang diupload kosong :  </br>";
//     }
// } -->