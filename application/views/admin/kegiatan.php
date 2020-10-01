<?php
function KonDecRomawi($angka)
{
    $hsl = "";
    if ($angka < 1 || $angka > 5000) {
        // Statement di atas buat nentuin angka ngga boleh dibawah 1 atau di atas 5000
        $hsl = "Batas Angka 1 s/d 5000";
    } else {
        while ($angka >= 1000) {
            // While itu termasuk kedalam statement perulangan
            // Jadi misal variable angka lebih dari sama dengan 1000
            // Kondisi ini akan di jalankan
            $hsl .= "M";
            // jadi pas di jalanin , kondisi ini akan menambahkan M ke dalam
            // Varible hsl
            $angka -= 1000;
            // Lalu setelah itu varible angka di kurangi 1000 ,
            // Kenapa di kurangi
            // Karena statment ini mengambil 1000 untuk di konversi menjadi M
        }
    }


    if ($angka >= 500) {
        // statement di atas akan bernilai true / benar
        // Jika var angka lebih dari sama dengan 500
        if ($angka > 500) {
            if ($angka >= 900) {
                $hsl .= "CM";
                $angka -= 900;
            } else {
                $hsl .= "D";
                $angka -= 500;
            }
        }
    }
    while ($angka >= 100) {
        if ($angka >= 400) {
            $hsl .= "CD";
            $angka -= 400;
        } else {
            $angka -= 100;
        }
    }
    if ($angka >= 50) {
        if ($angka >= 90) {
            $hsl .= "XC";
            $angka -= 90;
        } else {
            $hsl .= "L";
            $angka -= 50;
        }
    }
    while ($angka >= 10) {
        if ($angka >= 40) {
            $hsl .= "XL";
            $angka -= 40;
        } else {
            $hsl .= "X";
            $angka -= 10;
        }
    }
    if ($angka >= 5) {
        if ($angka == 9) {
            $hsl .= "IX";
            $angka -= 9;
        } else {
            $hsl .= "V";
            $angka -= 5;
        }
    }
    while ($angka >= 1) {
        if ($angka == 4) {
            $hsl .= "IV";
            $angka -= 4;
        } else {
            $hsl .= "I";
            $angka -= 1;
        }
    }

    return ($hsl);
}
// KonDecRomawi($no++);
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?> Pengawasan</h1>
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseKegiatan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseKegiatan">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-check-square"></i> Data Jenis <?= $title; ?></h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseKegiatan">
            <div class="card-body">
                <h6 class="mb-2 font-weight-bold text-primary">
                    <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newIsi"><i class="fas fa-plus"></i> Tambah</a>
                </h6>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-sm" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr align="center" class="table-active">
                                <th scope="col">#</th>
                                <th scope="col">Jenis Kegiatan</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">flag</th>
                                <th scope="col">aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($kegiatan as $keg) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class=""><?= $keg['nm_kegiatan']; ?></td>
                                    <td class="text-center"><?= $keg['satuan']; ?></td>
                                    <td class="text-center"><?= $keg['flag_keg']; ?></td>
                                    <td class="text-center">
                                        <a href="#" class="badge badge-info p-1 m-0 pr-3 pl-3" data-toggle="modal" data-target="#editModalKeg<?= $keg['id_kegiatan']; ?>">Edit</a>
                                        <a href="<?= base_url('admin/kegiatanDel/') . $keg['id_kegiatan']; ?>" class="badge badge-danger  m-0 p-1" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModalKeg<?= $keg['id_kegiatan']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newRoleLabel">Edit Data Kegiatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="<?= base_url('admin/kegiatanUpdate/') . $keg['id_kegiatan']; ?>">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="nama" value="<?= $keg['nm_kegiatan']; ?>" name="nama" placeholder="Nama Kegiatan" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="<?= $keg['satuan']; ?>" id="satuan" name="satuan" placeholder="Satuan" title="Satuan (Ha/Patok/Batang/Unit/Paket/Buah)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="CheckBox" class="form-check form-check-inline">Aktif : </label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $keg['id_kegiatan']; ?>" value="0" <?= ($keg['flag_keg'] == 0) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="<?= $keg['id_kegiatan']; ?>">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $keg['id_kegiatan']; ?>a" value="1" <?= ($keg['flag_keg'] == 1) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="<?= $keg['id_kegiatan']; ?>a">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Perbaharui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End edit Modal -->
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Add Jenis Isi-->
        <div class="modal fade" id="newIsi" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newRoleLabel">Tambah Isi Jenis <?= $title; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('admin/kegiatanAdd'); ?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" title="Satuan (Ha/Patok/Batang/Unit/Paket/Buah)">
                            </div>
                        </div>
                        <div class=" modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'bibit.php';
    ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->