<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-8">
            <h1 class="h3 mb-4 font-weight-bold text-primary"><?= $title . " " . $user['nm_user']; ?>/<small class="text-info"><?= $pl['nm_user']; ?>/</small><small class="text-warning">Kab.<?= $lokasi['nm_kabupaten']; ?></small></h1>
        </div>
        <div class="col-sm-4 text-right">
            <button class="btn btn-sm btn-warning" onclick="printContent('reportHarian')"><i class="fas fa-print"></i> Print This Tally Sheet</button>
            <a href="javascript:history.back()" class="btn btn-info btn-sm" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
    </div>

    <?= $this->session->flashdata('message'); ?>
    <?php
    $aprvBibit = "bibitpertama";
    ?>
    <div class="card shadow mb-4">
        <a href="#reportHarian" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="reportHarian">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Detail Pengawasan Harian Bibit Tally Sheet (Tahap I) | Kab. <?= $lokasi['nm_kabupaten']; ?> | <?= $pl['nm_user']; ?></h6>
        </a>
        <div class="collapse show" id="reportHarian">
            <div class="card-body">
                <div class="row m-3">
                    <div class="col-sm-6">
                        <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                    </div>
                    <div class="col-sm-6 text-right">
                        <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center mb-4 font-weight-bold">
                        <h2 class="font-weight-bold">TALLY SHEET PERSEMAIAN</h2>
                        <hr>
                    </div>
                    <div class="col-lg-12 text-uppercase font-weight-bold mb-3 ml-3">
                        <table class="table-sm table-borderless" width="45%" align="left">
                            <tr>
                                <td>Propinsi</td>
                                <td>:</td>
                                <td>Sulawesi Selatan</td>
                            </tr>
                            <tr>
                                <td>Kabupaten</td>
                                <td>:</td>
                                <td><?= $lokasi['nm_kabupaten']; ?></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Desa</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>
                        <table class="table-sm table-borderless" width="45%" align="left">
                            <tr>
                                <td>Petak/Lokasi</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Das/Sub DAS</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Koordinat</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Luas</td>
                                <td>:</td>
                                <td><?php
                                    $totalluasharian = $this->report->getPengawasanTotLuasTallysheetPl($IdRes[0], $IdRes[1]);
                                    ?>
                                    <?= $totalluasharian['nilaibibit']; ?> Ha
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Bibit</td>
                                <td>:</td>
                                <td><?php
                                    $totalbibit = $this->report->getJumBibitTallysheetPl($IdRes[0], $IdRes[1]);
                                    $total = $totalbibit['pertama'] + $totalbibit['kedua'] + $totalbibit['ketiga'];
                                    ?>
                                    <?= number_format($total, 0, ',', '.'); ?> Batang
                                </td>
                            </tr>
                        </table>
                    </div><br>
                    <div class="col-lg-12 text-1x">
                        <small>
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr class="text-center text-uppercase">
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Jenis Bibit</th>
                                        <th colspan="3">Kondisi Tinggi Bibit</th>
                                        <th rowspan="2">Keterangan</th>
                                        <th rowspan="2">#</th>
                                    </tr>
                                    <tr class="text-center text-uppercase">
                                        <th>1 - 5 Cm</th>
                                        <th>6 - 10 Cm</th>
                                        <th>10 Cm Up</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $bibit = $this->report->getkabTallysheetBibit($IdRes[0], $IdRes[1]);
                                    foreach ($bibit as $value) {
                                        $nilai = $this->report->getBibitProgresTallysheetPl($IdRes[0], $value['id_bibit'], $IdRes[1]);
                                        $sql = $this->db->get_where('harianbibit_i', ['id_bibit' => $value['id_bibit'], 'id_kab' => $IdRes[0], 'id_user' => $IdRes[1]])->result_array();
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $value['nm_bibit']; ?></td>
                                            <td class="text-center"><?= number_format($nilai['pertama'], 0, ',', '.'); ?></td>
                                            <td class="text-center"><?= number_format($nilai['kedua'], 0, ',', '.'); ?></td>
                                            <td class="text-center"><?= number_format($nilai['ketiga'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?php
                                                foreach ($sql as $valueket) {
                                                    echo $valueket['keterangan'] . ". ";
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#Details<?= $value['id_bibit']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                </small>
                                                <!-- Modal -->
                                                <div class="modal fade text-left" id="Details<?= $value['id_bibit']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="newRoleLabel">Detail Tally Sheet <b><?= $value['nm_bibit']; ?></b></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body scrol">
                                                                <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                    <table class="table-sm table-striped table-hover" width="100%">
                                                                        <tr class="text-center">
                                                                            <th>*</th>
                                                                            <th>Tgl Pengawasan/Input</th>
                                                                            <th>Petugas</th>
                                                                            <th>Koordinat</th>
                                                                            <th>Bibit</th>
                                                                            <th>1-5 Cm</th>
                                                                            <th>6-10 Cm</th>
                                                                            <th>10 Cm Up</th>
                                                                            <th>Luas</th>
                                                                            <th>Keterangan</th>
                                                                            <th>Foto</th>
                                                                            <th>Approvals</th>
                                                                        </tr>
                                                                        <?php
                                                                        $ni = 1;
                                                                        foreach ($sql as $val) {
                                                                            $pl = $this->db->get_where('dt_user', ['id_user' => $val['id_user']])->row_array();
                                                                        ?>
                                                                            <tr>
                                                                                <td><?= $ni++; ?></td>
                                                                                <td class="text-center"><?= $val['tgl'] . "<br>" . date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                <td><?= $val['petugas_lap']; ?></td>
                                                                                <td><?= $val['koordinat']; ?></td>
                                                                                <td><?= $value['nm_bibit']; ?></td>
                                                                                <td class="text-center"><?= $val['nilai_pertama']; ?></td>
                                                                                <td class="text-center"><?= $val['nilai_kedua']; ?></td>
                                                                                <td class="text-center"><?= $val['nilai_ketiga']; ?></td>
                                                                                <td class="text-center"><?= $val['luas']; ?> Ha</td>
                                                                                <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                <td>
                                                                                    <center data-toggle="tooltip" data-placement="left" title="Klik untuk memperbesar.">
                                                                                        <?php
                                                                                        if (file_exists("assets/img/peng-bibit-pertama/" . $val['foto'])) { ?>
                                                                                            <button type="button" class="btn btn-info " data-toggle="modal" data-target="#fotoViewibit<?= $val['id_harianbibit_i'] ?>" style="cursor:zoom-in">
                                                                                                <i class="fas fa-seedling fa-fa-3x"></i>
                                                                                            </button>
                                                                                        <?php
                                                                                        } else { ?>
                                                                                            <button type="button" class="btn btn-info text-sm">
                                                                                                Image not <br> found..
                                                                                            </button>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </center>
                                                                                    <!-- Modal Foto View -->
                                                                                    <div class="modal fade" id="fotoViewibit<?= $val['id_harianbibit_i'] ?>" tabindex="-1" aria-labelledby="fotoViewibit<?= $val['id_harianbibit_i'] ?>Label" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-body modal-open text-center m-0 p-0" style="background-color: transparent;">
                                                                                                    <?php
                                                                                                    $BahanimageURL = base_url("assets/img/peng-bibit-pertama/" . $val['foto']);
                                                                                                    $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                    ?>
                                                                                                    <a href="<?= $BahanimageURL; ?>" target="_blank"><img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit-pertama/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>"></a>
                                                                                                    <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                    <?php
                                                                                                    if (!empty($BahanUrlMap)) {
                                                                                                    ?>
                                                                                                        <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                            <button class="btn btn-info btn-outline-primary m-1 pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i> Klik untuk melihat titik lokasi pengambilan gambar di google maps</button>
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                    <hr>
                                                                                                    <?php
                                                                                                    $BahanimageURL = base_url("assets/img/peng-bibit-pertama/" . $val['foto_2']);
                                                                                                    $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                    ?>
                                                                                                    <a href="<?= $BahanimageURL; ?>" target="_blank"><img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit-pertama/<?= $val['foto_2']; ?>" alt="" width="100%" title="<?= $val['foto_2']; ?>"></a>
                                                                                                    <h3 class="badge-dark badge-lg m-0"><?= $val['foto_2']; ?></h3>
                                                                                                    <?php
                                                                                                    if (!empty($BahanUrlMap)) {
                                                                                                    ?>
                                                                                                        <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                            <button class="btn btn-info btn-outline-primary m-1 pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i> Klik untuk melihat titik lokasi pengambilan gambar di google maps</button>
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                    <hr>
                                                                                                    <?php
                                                                                                    $BahanimageURL = base_url("assets/img/peng-bibit-pertama/" . $val['foto_3']);
                                                                                                    $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                    ?>
                                                                                                    <a href="<?= $BahanimageURL; ?>" target="_blank"><img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit-pertama/<?= $val['foto_3']; ?>" alt="" width="100%" title="<?= $val['foto_3']; ?>"></a>
                                                                                                    <h3 class="badge-dark badge-lg m-0"><?= $val['foto_3']; ?></h3>
                                                                                                    <?php
                                                                                                    if (!empty($BahanUrlMap)) {
                                                                                                    ?>
                                                                                                        <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                            <button class="btn btn-info btn-outline-primary m-1 pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i> Klik untuk melihat titik lokasi pengambilan gambar di google maps</button>
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                    <hr>
                                                                                                    <?php
                                                                                                    $BahanimageURL = base_url("assets/img/peng-bibit-pertama/" . $val['foto_4']);
                                                                                                    $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                    ?>
                                                                                                    <a href="<?= $BahanimageURL; ?>" target="_blank"><img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit-pertama/<?= $val['foto_4']; ?>" alt="" width="100%" title="<?= $val['foto_4']; ?>"></a>
                                                                                                    <h3 class="badge-dark badge-lg m-0"><?= $val['foto_4']; ?></h3>
                                                                                                    <?php
                                                                                                    if (!empty($BahanUrlMap)) {
                                                                                                    ?>
                                                                                                        <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                            <button class="btn btn-info btn-outline-primary m-1 pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i> Klik untuk melihat titik lokasi pengambilan gambar di google maps</button>
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                    <hr>
                                                                                                    <?php
                                                                                                    $BahanimageURL = base_url("assets/img/peng-bibit-pertama/" . $val['foto_5']);
                                                                                                    $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                    ?>
                                                                                                    <a href="<?= $BahanimageURL; ?>" target="_blank"><img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit-pertama/<?= $val['foto_5']; ?>" alt="" width="100%" title="<?= $val['foto_5']; ?>"></a>
                                                                                                    <h3 class="badge-dark badge-lg m-0"><?= $val['foto_5']; ?></h3>
                                                                                                    <?php
                                                                                                    if (!empty($BahanUrlMap)) {
                                                                                                    ?>
                                                                                                        <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                            <button class="btn btn-info btn-outline-primary m-1 pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i> Klik untuk melihat titik lokasi pengambilan gambar di google maps</button>
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <?php
                                                                                    if ($val['status'] == 1) {
                                                                                    ?>
                                                                                        <div class="btn btn-success btn-icon-split">
                                                                                            <span class="icon text-white-50">
                                                                                                <i class="fas fa-check"></i>
                                                                                            </span>
                                                                                            <span class="text"> Approved</span>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else if ($val['status'] == 2) {
                                                                                    ?>
                                                                                        <div class="btn btn-warning btn-icon-split">
                                                                                            <span class="icon text-white-50">
                                                                                                &times;
                                                                                            </span>
                                                                                            <span class="text"> Rejected</span>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <a class="btn btn-sm btn-info font-weight-bold" onclick="return confirm('Proses Approval pengawasan?')" href="<?= base_url('anggota/approve/') . $aprvBibit . "/" . $val['id_harianbibit_i'] . "/" . $urlx; ?>">
                                                                                            Approve
                                                                                        </a>
                                                                                        <hr class="m-1">
                                                                                        <a class="btn btn-sm btn-danger font-weight-bold" onclick="return confirm('Yakin akan me Reject Pengawasan ini? Reject akan menghapus dari daftar pengawasan harian.')" href="<?= base_url('anggota/reject/') . $aprvBibit . "/" . $val['id_harianbibit_i'] . "/"  . $urlx; ?>">
                                                                                            Reject
                                                                                        </a>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                        ?>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
function get_image_location($image = '')
{
    error_reporting(0);
    $exif = exif_read_data($image, 0, true);
    if ($exif && isset($exif['GPS'])) {
        $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
        $GPSLatitude    = $exif['GPS']['GPSLatitude'];
        $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
        $GPSLongitude   = $exif['GPS']['GPSLongitude'];

        $lat_degrees = count($GPSLatitude) > 0 ? gps2Num($GPSLatitude[0]) : 0;
        $lat_minutes = count($GPSLatitude) > 1 ? gps2Num($GPSLatitude[1]) : 0;
        $lat_seconds = count($GPSLatitude) > 2 ? gps2Num($GPSLatitude[2]) : 0;

        $lon_degrees = count($GPSLongitude) > 0 ? gps2Num($GPSLongitude[0]) : 0;
        $lon_minutes = count($GPSLongitude) > 1 ? gps2Num($GPSLongitude[1]) : 0;
        $lon_seconds = count($GPSLongitude) > 2 ? gps2Num($GPSLongitude[2]) : 0;

        $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
        $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

        $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
        $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

        return $latitude . "," . $longitude;
    } else {
        return false;
    }
}
function gps2Num($coordPart)
{
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0)
        return 0;
    if (count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}
?>