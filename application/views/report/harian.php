<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report'); ?>"><?= $title; ?></a></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('report'); ?>" class="btn btn-info btn-sm" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-body p-2">
            <?php
            $tepilih = isset($_GET['tgl']) != "" ? $_GET['tgl'] : "";
            ?>
            <form class="form-inline">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="font-weight-bold">
                            Berdasarkan Tanggal Pengawasan :
                            <?php $today = date('Y-m-d'); ?>
                            <input type="date" class="form-control" name='tgl' id="tgl" max="<?= $today; ?>" required value="<?= $tepilih; ?>">
                            <input type="submit" class="btn btn-primary" value="Confirm identity">
                            <a href="<?= base_url('report/harian/') . $urlx; ?>" class="btn btn-danger"> Reset</a>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="printContent('reportHarian')"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>

    <?php
    if (!empty(isset($_GET['tgl']))) {
        $tgl = $_GET['tgl'];
    ?>
        <div class="card shadow mb-4">
            <a href="#reportHarian" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="reportHarian">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Detail Pengawasan Harian <b><?= $tgl; ?> </b> | Kab. <?= $lokasi['nm_kabupaten']; ?> | Kec. <?= $lokasi['nm_kecamatan']; ?> | Desa <?= $lokasi['nm_desa']; ?> | <?= $lokasi['nm_blok']; ?> | <?= $lokasi['nm_petak']; ?></h6>
            </a>
            <div class="collapse show scrol p-2" id="reportHarian">
                <div class="card-body" style="min-width: 999px;">
                    <div class="row m-4">
                        <div class="col-sm-6">
                            <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                        </div>
                        <div class="col-sm-6 text-right">
                            <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center mb-2 font-weight-bold">
                            <h5 class="font-weight-bold">RHASIL PENGAWASAN DAN PENILAIAN HARIAN</h5>
                            <h5 class="font-weight-bold">PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK</h5>
                        </div>
                        <div class="col-lg-12 text-uppercase font-weight-bold mb-3 ml-3">
                            <table class="table-sm table-borderless" width="45%" align="left">
                                <tr>
                                    <td>Kabupaten</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_kabupaten']; ?></td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_kecamatan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Desa</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_desa']; ?></td>
                                </tr>
                                <tr>
                                    <td>Pelaksana</td>
                                    <td>:</td>
                                    <td>PTSI</td>
                                </tr>
                            </table>
                            <table class="table-sm table-borderless" width="45%" align="left">
                                <tr>
                                    <td>Blok</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_blok']; ?></td>
                                </tr>
                                <tr>
                                    <td>Petak</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_petak']; ?></td>
                                </tr>
                                <tr>
                                    <td>Luas</td>
                                    <td>:</td>
                                    <td><?php
                                        $totalluasharian = $this->report->getPengawasanTotLuasTgl($lokasi['id_petak'], $tgl);
                                        $total = $totalluasharian['nilaibahan'] + $totalluasharian['nilailapangan'] + $totalluasharian['nilaibibit'];
                                        ?>
                                        <?= $total; ?> Ha
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hari/Tanggal</td>
                                    <td>:</td>
                                    <td><?= $_GET['tgl']; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-12 text-1x">
                            <small>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr class="text-center text-uppercase">
                                            <th>No</th>
                                            <th>Jenis Kegiatan</th>
                                            <th>Satuan</th>
                                            <th>Progress</th>
                                            <th>Kendala/Rekomendasi</th>
                                            <th colspan="2">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-left">I.</th>
                                            <th colspan="5">BAHAN-BAHAN</th>
                                        </tr>
                                        <?php
                                        $no = 1;
                                        $bahan = $this->report->getBahan($lokasi['id_petak'], $tgl);
                                        foreach ($bahan as $value) {
                                            $nilai = $this->report->getBahanProgresTgl($lokasi['id_petak'], $value['id_spkbahan'], $tgl);
                                            $ket = $this->report->getBahanKetTgl($lokasi['id_petak'], $value['id_spkbahan'], $tgl);
                                            // $progres = empty($nilai['totnilai']) ? "0" : $nilai['totnilai'];
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++ ?></td>
                                                <td><?= $value['nm_kegiatan']; ?></td>
                                                <td class="text-center"><?= $value['satuan']; ?></td>
                                                <td class="text-center <?= ($nilai['totnilai'] > $value['nilai_spkbahan']) ? "text-warning" : ""; ?>  <?= ($nilai['totnilai'] < $value['nilai_spkbahan']) ? "text-danger" : "text-success"; ?>" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= number_format($nilai['totnilai'], 2, ',', '.'); ?> Dari <?= number_format($value['nilai_spkbahan'], 2, ',', '.'); ?>"><?= number_format($nilai['totnilai'], 2, ',', '.'); ?></td>
                                                <td>
                                                    <?php
                                                    foreach ($ket as $valueket) {
                                                        echo $valueket['keterangan'] . ". ";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <small>
                                                        <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#DetailsTgl<?= $value['id_spkbahan']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                    </small>
                                                    <!-- Modal -->
                                                    <div class="modal fade text-left" id="DetailsTgl<?= $value['id_spkbahan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="newRoleLabel">Detail Kegiatan <b><?= $tgl . " | " . $value['nm_kegiatan']; ?></b></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body scrol">
                                                                    <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                        <table class="table-sm table-striped table-hover" width="100%">
                                                                            <tr class="text-center">
                                                                                <th>*</th>
                                                                                <th>Tgl Pengawasan</th>
                                                                                <th>Tgl Input</th>
                                                                                <th>Petugas</th>
                                                                                <th>Koordinat</th>
                                                                                <th>Progress</th>
                                                                                <th>Luas</th>
                                                                                <th>Keterangan</th>
                                                                                <th>Foto</th>
                                                                            </tr>
                                                                            <?php
                                                                            $ni = 1;
                                                                            $sql = $this->db->get_where('harianbahan', ['id_spkbahan' => $value['id_spkbahan'], 'id_petak' => $value['id_petak'], 'tgl' => $tgl])->result_array();
                                                                            foreach ($sql as $val) { ?>
                                                                                <tr>
                                                                                    <td><?= $ni++; ?></td>
                                                                                    <td><?= $val['tgl']; ?></td>
                                                                                    <td><?= date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                    <td><?= $val['petugas_lap']; ?></td>
                                                                                    <td><?= $val['koordinat']; ?></td>
                                                                                    <td><?= $val['nilai_harianbahan']; ?></td>
                                                                                    <td><?= $val['luas']; ?></td>
                                                                                    <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <?php
                                                                                            if (file_exists("assets/img/peng-bahan/" . $val['foto'])) { ?>
                                                                                                <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoViewBahan<?= $val['id_harianbahan'] ?>">
                                                                                                    <img class="img" src="<?= base_url('assets/'); ?>img/peng-bahan/<?= $val['foto']; ?>" alt="" width="60px" height="60px" style="cursor:zoom-in" data-toggle="tooltip" data-placement="left" title="Klik untuk memperbesar.">
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
                                                                                        <div class="modal fade" id="fotoViewBahanTgl<?= $val['id_harianbahan'] ?>" tabindex="-1" aria-labelledby="fotoViewBahanTgl<?= $val['id_harianbahan'] ?>Label" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-body modal-open text-center m-0 p-0" style="background-color: transparent;">
                                                                                                        <img class="img" src="<?= base_url('assets/'); ?>img/peng-bahan/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>">
                                                                                                        <?php
                                                                                                        $BahanimageURL = "assets/img/peng-bahan/" . $val['foto'];
                                                                                                        $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                        ?>
                                                                                                        <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                        <?php
                                                                                                        if (!empty($BahanUrlMap)) {
                                                                                                        ?>
                                                                                                            <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                                <button class="btn btn-info btn-outline-primary pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i></button>
                                                                                                            </a>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
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
                                        <tr>
                                            <th class="text-left">II</th>
                                            <th colspan="5">PENGADAAN BIBIT</th>
                                        </tr>
                                        <?php
                                        $nom = 1;
                                        $kategori = $this->db->get_where('spkbibit', ['id_petak' => $lokasi['id_petak']])->result_array();
                                        foreach ($kategori as $kat) {
                                            $realisasi = $this->report->getRealisasiBibitnya($kat['id_spkbibit']);
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $nom++; ?></td>
                                                <td><?= $kat['kategori']; ?></td>
                                                <td></td>
                                                <td class="text-center"><b class="<?= ($realisasi['nilaibibit'] < $kat['nilai_spkbibit']) ? "text-danger" : ""; ?> <?= ($realisasi['nilaibibit'] > $kat['nilai_spkbibit']) ? "text-warning" : "text-success"; ?>"><?= number_format($realisasi['nilaibibit'], 0, ',', '.'); ?></b> dari <b class="text-success"><?= number_format($kat['nilai_spkbibit'], 0, ',', '.'); ?></b></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $bibit = $this->report->getBibit($kat['id_spkbibit']);
                                            foreach ($bibit as $valueBibit) {
                                                $progresbibit = $this->report->getBibitProgresTgl($valueBibit['id_bibit'], $lokasi['id_petak'], $tgl);
                                                $harianbibit = $this->db->get_where('harianbibit', ['id_bibit' => $valueBibit['id_bibit'], 'id_petak' => $lokasi['id_petak'], 'tgl' => $tgl])->result_array();
                                                // $progres = empty($progresbibit['total']) ? "0" : $progresbibit['total'];
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td> - <?= $valueBibit['nm_bibit']; ?></td>
                                                    <td class="text-center"><?= $valueBibit['satuan']; ?></td>
                                                    <td class="text-center <?= ($realisasi['nilaibibit'] < $kat['nilai_spkbibit']) ? "text-danger" : ""; ?> <?= ($realisasi['nilaibibit'] > $kat['nilai_spkbibit']) ? "text-warning" : "text-success"; ?>" data-toggle="tooltip" data-placement="left" title="<?= number_format($realisasi['nilaibibit'], 0, ',', '.'); ?> dari <?= number_format($kat['nilai_spkbibit'], 0, ',', '.'); ?>"><?= number_format($progresbibit['total'], 0, ',', '.'); ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($harianbibit as $harbit) {
                                                            echo $harbit['keterangan'] . ". ";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <small>
                                                            <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#DetailsBibitTgl<?= $valueBibit['id_bibit']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                        </small>
                                                        <!-- Modal Add SPK Kategori bibit-->
                                                        <div class="modal fade text-left" id="DetailsBibitTgl<?= $valueBibit['id_bibit']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="newRoleLabel">Detail <b><?= $tgl . " | " . $valueBibit['nm_bibit']; ?></b></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body scrol">
                                                                        <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                            <table class="table-sm table-striped table-hover" width="100%">
                                                                                <tr class="text-center">
                                                                                    <th>*</th>
                                                                                    <th>Tgl Pengawasan</th>
                                                                                    <th>Tgl Input</th>
                                                                                    <th>Petugas</th>
                                                                                    <th>Koordinat</th>
                                                                                    <th>Progress</th>
                                                                                    <th>Luas</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Foto</th>
                                                                                </tr>
                                                                                <?php
                                                                                $ni = 1;
                                                                                foreach ($harianbibit as $val) { ?>
                                                                                    <tr>
                                                                                        <td><?= $ni++; ?></td>
                                                                                        <td><?= $val['tgl']; ?></td>
                                                                                        <td><?= date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                        <td><?= $val['petugas_lap']; ?></td>
                                                                                        <td><?= $val['koordinat']; ?></td>
                                                                                        <td><?= $val['nilai_harianbibit']; ?></td>
                                                                                        <td><?= $val['luas']; ?></td>
                                                                                        <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                        <td>
                                                                                            <center>
                                                                                                <?php
                                                                                                if (file_exists(base_url('assets/') . "img/peng-bibit/" . $val['foto'])) { ?>
                                                                                                    <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoViewBibitTgl<?= $val['id_harianbibit'] ?>">
                                                                                                        <img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit/<?= $val['foto']; ?>" alt="" width="60px" height="60px" title="<?= $val['foto']; ?>">
                                                                                                    </button>
                                                                                                <?php
                                                                                                } else { ?>
                                                                                                    <button type="button" class="btn btn-info">
                                                                                                        Image not <br> found..
                                                                                                    </button>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                            </center>
                                                                                            <!-- Modal Foto View -->
                                                                                            <div class="modal fade" id="fotoViewBibitTgl<?= $val['id_harianbibit'] ?>" tabindex="-1" aria-labelledby="fotoViewBibitTgl<?= $val['id_harianbibit'] ?>Label" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                                    <div class="modal-content" style="background-color: transparent;">
                                                                                                        <div class="modal-body modal-open text-center m-0 p-0">
                                                                                                            <img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>">
                                                                                                            <?php
                                                                                                            $BibitimageURL = "assets/img/peng-bibit/" . $val['foto'];
                                                                                                            $BibitUrlMap = get_image_location($BibitimageURL);
                                                                                                            ?>
                                                                                                            <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                            <?php
                                                                                                            if (!empty($BibitUrlMap)) {
                                                                                                            ?>
                                                                                                                <a target="_blank" href="https://maps.google.com/maps?q=<?= $BibitUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                                    <button class="btn btn-info btn-outline-primary pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i></button>
                                                                                                                </a>
                                                                                                            <?php } ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                                        }
                                        ?>
                                        <tr>
                                            <th class="text-left">III</th>
                                            <th colspan="5">KEGIATAN DI LAPANGAN</th>
                                        </tr>
                                        <?php
                                        $nomr = 1;
                                        $lapangan = $this->report->getLapangan($lokasi['id_petak']);
                                        foreach ($lapangan as $valueLap) {
                                            $progreslapangan = $this->report->getLapanganProgresTgl($lokasi['id_petak'], $valueLap['id_spklapangan'], $tgl);
                                            $harianlapangan = $this->db->get_where('harianlapangan', ['id_spklapangan' => $valueLap['id_spklapangan'], 'id_petak' => $lokasi['id_petak'], 'tgl' => $tgl])->result_array();
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $nomr++; ?></td>
                                                <td><?= $valueLap['nm_kegiatan']; ?></td>
                                                <td class="text-center"><?= $valueLap['satuan']; ?></td>
                                                <td class="text-center font-weight-bold <?= ($valueLap['nilai_spklapangan'] < $progreslapangan['totnilai']) ? "text-warning" : ""; ?> <?= ($valueLap['nilai_spklapangan'] > $progreslapangan['totnilai']) ? "text-danger" : "text-success"; ?>" data-toggle="tooltip" data-placement="top" title="<?= number_format($progreslapangan['totnilai'], 2, '.', ','); ?> dari <?= number_format($valueLap['nilai_spklapangan'], 2, '.', ','); ?>"><?= number_format($progreslapangan['totnilai'], 2, '.', ','); ?></td>
                                                <td>
                                                    <?php
                                                    foreach ($harianlapangan as $ket) {
                                                        echo $ket['keterangan'] . ". ";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <small>
                                                        <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#DetailsLapTgl<?= $valueLap['id_spklapangan']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                    </small>
                                                    <!-- Modal -->
                                                    <div class="modal fade text-left" id="DetailsLapTgl<?= $valueLap['id_spklapangan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="newRoleLabel">Detail Kegiatan <b><?= $valueLap['nm_kegiatan']; ?></b></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body scrol">
                                                                    <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                        <table class="table-sm table-striped table-hover" width="100%">
                                                                            <tr class="text-center">
                                                                                <th>*</th>
                                                                                <th>Tgl Pengawasan</th>
                                                                                <th>Tgl Input</th>
                                                                                <th>Petugas</th>
                                                                                <th>Koordinat</th>
                                                                                <th>Progress</th>
                                                                                <th>Luas</th>
                                                                                <th>Keterangan</th>
                                                                                <th>Foto</th>
                                                                                <th>Video</th>
                                                                            </tr>
                                                                            <?php
                                                                            $nih = 1;
                                                                            foreach ($harianlapangan as $val) { ?>
                                                                                <tr>
                                                                                    <td><?= $nih++; ?></td>
                                                                                    <td><?= $val['tgl']; ?></td>
                                                                                    <td><?= date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                    <td><?= $val['petugas_lap']; ?></td>
                                                                                    <td><?= $val['koordinat']; ?></td>
                                                                                    <td><?= $val['nilai_harianlapangan']; ?></td>
                                                                                    <td><?= $val['luas']; ?></td>
                                                                                    <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoViewLapanganTgl<?= $val['id_harianlapangan'] ?>">
                                                                                                <img class="img" src="<?= base_url('assets/'); ?>img/peng-lapangan/<?= $val['foto']; ?>" alt="" width="60px" height="60px" title="<?= $val['foto']; ?>">
                                                                                            </button>
                                                                                        </center>
                                                                                        <!-- Modal Foto View -->
                                                                                        <div class="modal" id="fotoViewLapanganTgl<?= $val['id_harianlapangan'] ?>" tabindex="-1" aria-labelledby="fotoViewLapanganTgl<?= $val['id_harianlapangan'] ?>Label" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                                <div class="modal-content" style="background-color: transparent;">
                                                                                                    <div class="modal-body modal-open text-center m-0 p-0">
                                                                                                        <img class="img" src="<?= base_url('assets/'); ?>img/peng-lapangan/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>"><br>
                                                                                                        <?php
                                                                                                        $LapimageURL = "assets/img/peng-lapangan/" . $val['foto'];
                                                                                                        $LapUrlMap = get_image_location($LapimageURL);
                                                                                                        ?>
                                                                                                        <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                        <?php
                                                                                                        if (!empty($LapUrlMap)) {
                                                                                                        ?>
                                                                                                            <a target="_blank" href="https://maps.google.com/maps?q=<?= $LapUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                                <button class="btn btn-info btn-outline-primary pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i></button>
                                                                                                            </a>
                                                                                                        <?php
                                                                                                        } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#videoView<?= $val['id_harianlapangan'] ?>">
                                                                                            <i class="fas fa-file-video"></i>
                                                                                        </button>
                                                                                        <div class="modal" id="videoView<?= $val['id_harianlapangan'] ?>" tabindex="-1" aria-labelledby="videoView<?= $val['id_harianlapangan'] ?>Label" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg" style="width: 100%;">
                                                                                                <div class="modal-content" style=" background-color: black;">
                                                                                                    <div class="modal-body modal-open text-center m-0 p-0">
                                                                                                        <video height="100%" controls>
                                                                                                            <source src="<?= base_url('assets/'); ?>img/peng-video/<?= $val['video']; ?>" type="video/mp4">
                                                                                                            Your browser does not support the video tag.
                                                                                                        </video>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
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
                    <h5 class="font-weight-bold">KENDALA ATAU REKOMENDASI :</h5>
                    <hr class="m-0 pb-2">
                    <p>
                        <span class="text-danger">* Realisasi progress pengawasan <b>belum terpenuhi</b> dari SPK yang telah ditentukan.</span><br>
                        <span class="text-success">* Realisasi progress pengawasan <b>telah terpenuhi</b> dari SPK yang telah ditentukan.</span><br>
                        <span class="text-warning">* Realisasi progress pengawasan <b>melebihi</b> dari SPK yang telah ditentukan.</span>
                    </p>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="card shadow mb-4">
            <a href="#reportHarian" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="reportHarian">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Detail Pengawasan Harian | Kab. <?= $lokasi['nm_kabupaten']; ?> | Kec. <?= $lokasi['nm_kecamatan']; ?> | Desa <?= $lokasi['nm_desa']; ?> | <?= $lokasi['nm_blok']; ?> | <?= $lokasi['nm_petak']; ?></h6>
            </a>
            <div class="collapse show p-2 scrol" id="reportHarian">
                <div class="col-sm-12" style="min-width: 999px;">
                    <div class="card-body">
                        <div class="row m-4">
                            <div class="col-sm-6">
                                <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                            </div>
                            <div class="col-sm-6 text-right">
                                <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center mb-2 font-weight-bold">
                                <h5 class="font-weight-bold">RHASIL PENGAWASAN DAN PENILAIAN HARIAN</h5>
                                <h5 class="font-weight-bold">PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK</h5>
                            </div>
                            <div class="col-lg-12 text-uppercase font-weight-bold mb-3 ml-3">
                                <table class="table-sm table-borderless" width="45%" align="left">
                                    <tr>
                                        <td>Kabupaten</td>
                                        <td>:</td>
                                        <td><?= $lokasi['nm_kabupaten']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>:</td>
                                        <td><?= $lokasi['nm_kecamatan']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Desa</td>
                                        <td>:</td>
                                        <td><?= $lokasi['nm_desa']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pelaksana</td>
                                        <td>:</td>
                                        <td>PTSI</td>
                                    </tr>
                                </table>
                                <table class="table-sm table-borderless" width="45%" align="left">
                                    <tr>
                                        <td>Blok</td>
                                        <td>:</td>
                                        <td><?= $lokasi['nm_blok']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Petak</td>
                                        <td>:</td>
                                        <td><?= $lokasi['nm_petak']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Luas</td>
                                        <td>:</td>
                                        <td><?php
                                            $totalluasharian = $this->report->getPengawasanTotLuas($lokasi['id_petak']);
                                            $total = $totalluasharian['nilaibahan'] + $totalluasharian['nilailapangan'] + $totalluasharian['nilaibibit'];
                                            ?>
                                            <?= $total; ?> Ha
                                        </td>
                                    </tr>
                                </table>
                            </div><br>
                            <div class="col-lg-12 text-1x">
                                <small>
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr class="text-center text-uppercase">
                                                <th>No</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Satuan</th>
                                                <th>Progress</th>
                                                <th>Kendala/Rekomendasi</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="text-left">I.</th>
                                                <th colspan="5">BAHAN-BAHAN</th>
                                            </tr>
                                            <?php
                                            $no = 1;
                                            $bahan = $this->report->getBahan($lokasi['id_petak']);
                                            foreach ($bahan as $value) {
                                                $nilai = $this->report->getBahanProgres($lokasi['id_petak'], $value['id_spkbahan']);
                                                $ket = $this->report->getBahanKet($lokasi['id_petak'], $value['id_spkbahan']);
                                                // $progres = empty($nilai['totnilai']) ? "0" : $nilai['totnilai'];
                                            ?>
                                                <tr>
                                                    <td class="text-right"><?= $no++ ?></td>
                                                    <td><?= $value['nm_kegiatan']; ?></td>
                                                    <td class="text-center"><?= $value['satuan']; ?></td>
                                                    <td class="text-center font-weight-bold <?= ($nilai['totnilai'] > $value['nilai_spkbahan']) ? "text-warning" : ""; ?>  <?= ($nilai['totnilai'] < $value['nilai_spkbahan']) ? "text-danger" : "text-success"; ?>" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= number_format($nilai['totnilai'], 2, ',', '.'); ?> Dari <?= number_format($value['nilai_spkbahan'], 2, ',', '.'); ?>"><?= number_format($nilai['totnilai'], 2, ',', '.'); ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($ket as $valueket) {
                                                            echo $valueket['keterangan'] . ". ";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <small>
                                                            <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#Details<?= $value['id_spkbahan']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                        </small>
                                                        <!-- Modal -->
                                                        <div class="modal fade text-left" id="Details<?= $value['id_spkbahan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="newRoleLabel">Detail Kegiatan <b><?= $value['nm_kegiatan']; ?></b></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body scrol">
                                                                        <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                            <table class="table-sm table-striped table-hover" width="100%">
                                                                                <tr class="text-center">
                                                                                    <th>*</th>
                                                                                    <th>Tgl Pengawasan</th>
                                                                                    <th>Tgl Input</th>
                                                                                    <th>Petugas Lapangan</th>
                                                                                    <th>Petugas</th>
                                                                                    <th>Koordinat</th>
                                                                                    <th>Progress</th>
                                                                                    <th>Luas</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Foto</th>
                                                                                </tr>
                                                                                <?php
                                                                                $ni = 1;
                                                                                $sql = $this->db->get_where('harianbahan', ['id_spkbahan' => $value['id_spkbahan'], 'id_petak' => $value['id_petak']])->result_array();
                                                                                foreach ($sql as $val) {
                                                                                    $pl = $this->db->get_where('dt_user', ['id_user' => $val['id_user']])->row_array();
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?= $ni++; ?></td>
                                                                                        <td><?= $val['tgl']; ?></td>
                                                                                        <td><?= date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                        <td><?= $pl['nm_user']; ?></td>
                                                                                        <td><?= $val['petugas_lap']; ?></td>
                                                                                        <td><?= $val['koordinat']; ?></td>
                                                                                        <td><?= $val['nilai_harianbahan']; ?></td>
                                                                                        <td><?= $val['luas']; ?></td>
                                                                                        <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                        <td>
                                                                                            <center>
                                                                                                <?php
                                                                                                if (file_exists("assets/img/peng-bahan/" . $val['foto'])) { ?>
                                                                                                    <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoViewBahan<?= $val['id_harianbahan'] ?>">
                                                                                                        <img class="img" src="<?= base_url('assets/'); ?>img/peng-bahan/<?= $val['foto']; ?>" alt="" width="60px" height="60px" style="cursor:zoom-in" data-toggle="tooltip" data-placement="left" title="Klik untuk memperbesar.">
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
                                                                                            <div class="modal fade" id="fotoViewBahan<?= $val['id_harianbahan'] ?>" tabindex="-1" aria-labelledby="fotoViewBahan<?= $val['id_harianbahan'] ?>Label" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-body modal-open text-center m-0 p-0" style="background-color: transparent;">
                                                                                                            <img class="img" src="<?= base_url('assets/'); ?>img/peng-bahan/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>">
                                                                                                            <?php
                                                                                                            $BahanimageURL = "assets/img/peng-bahan/" . $val['foto'];
                                                                                                            $BahanUrlMap = get_image_location($BahanimageURL);
                                                                                                            ?>
                                                                                                            <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                            <?php
                                                                                                            if (!empty($BahanUrlMap)) {
                                                                                                            ?>
                                                                                                                <a target="_blank" href="https://maps.google.com/maps?q=<?= $BahanUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                                    <button class="btn btn-info btn-outline-primary pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i></button>
                                                                                                                </a>
                                                                                                            <?php } ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                                            <tr>
                                                <th class="text-left">II</th>
                                                <th colspan="5">PENGADAAN BIBIT</th>
                                            </tr>
                                            <?php
                                            $nom = 1;
                                            $kategori = $this->db->get_where('spkbibit', ['id_petak' => $lokasi['id_petak']])->result_array();
                                            foreach ($kategori as $kat) {
                                                $realisasi = $this->report->getRealisasiBibitnya($kat['id_spkbibit']);
                                            ?>
                                                <tr>
                                                    <td class="text-right"><?= $nom++; ?></td>
                                                    <td><?= $kat['kategori']; ?></td>
                                                    <td></td>
                                                    <td class="text-center"><b class="<?= ($realisasi['nilaibibit'] < $kat['nilai_spkbibit']) ? "text-danger" : ""; ?> <?= ($realisasi['nilaibibit'] > $kat['nilai_spkbibit']) ? "text-warning" : "text-success"; ?>"><?= number_format($realisasi['nilaibibit'], 0, ',', '.'); ?></b> dari <b class="text-success"><?= number_format($kat['nilai_spkbibit'], 0, ',', '.'); ?></b></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                                $bibit = $this->report->getBibit($kat['id_spkbibit']);
                                                foreach ($bibit as $valueBibit) {
                                                    $progresbibit = $this->report->getBibitProgres($valueBibit['id_bibit'], $lokasi['id_petak']);
                                                    $harianbibit = $this->db->get_where('harianbibit', ['id_bibit' => $valueBibit['id_bibit'], 'id_petak' => $lokasi['id_petak']])->result_array();
                                                    // $progres = empty($progresbibit['total']) ? "0" : $progresbibit['total'];
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td> - <?= $valueBibit['nm_bibit']; ?></td>
                                                        <td class="text-center"><?= $valueBibit['satuan']; ?></td>
                                                        <td class="text-center font-weight-bold <?= ($realisasi['nilaibibit'] < $kat['nilai_spkbibit']) ? "text-danger" : ""; ?> <?= ($realisasi['nilaibibit'] > $kat['nilai_spkbibit']) ? "text-warning" : "text-success"; ?>" data-toggle="tooltip" data-placement="left" title="<?= number_format($realisasi['nilaibibit'], 0, ',', '.'); ?> dari <?= number_format($kat['nilai_spkbibit'], 0, ',', '.'); ?>"><?= number_format($progresbibit['total'], 0, ',', '.'); ?></td>
                                                        <td>
                                                            <?php
                                                            foreach ($harianbibit as $harbit) {
                                                                echo $harbit['keterangan'] . ". ";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <small>
                                                                <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#DetailsBibit<?= $valueBibit['id_bibit']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                            </small>
                                                            <!-- Modal Add SPK Kategori bibit-->
                                                            <div class="modal fade text-left" id="DetailsBibit<?= $valueBibit['id_bibit']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="newRoleLabel">Detail <b><?= $valueBibit['nm_bibit']; ?></b></h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body scrol">
                                                                            <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                                <table class="table-sm table-striped table-hover" width="100%">
                                                                                    <tr class="text-center">
                                                                                        <th>*</th>
                                                                                        <th>Tgl Pengawasan</th>
                                                                                        <th>Tgl Input</th>
                                                                                        <th>Petugas Lapangan</th>
                                                                                        <th>Petugas</th>
                                                                                        <th>Koordinat</th>
                                                                                        <th>Progress</th>
                                                                                        <th>Luas</th>
                                                                                        <th>Keterangan</th>
                                                                                        <th>Foto</th>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $ni = 1;
                                                                                    $sql = $this->db->get_where('harianbibit', ['id_bibit' => $valueBibit['id_bibit'], 'id_petak' => $lokasi['id_petak']])->result_array();
                                                                                    foreach ($sql as $val) {
                                                                                        $pl = $this->db->get_where('dt_user', ['id_user' => $val['id_user']])->row_array();
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?= $ni++; ?></td>
                                                                                            <td><?= $val['tgl']; ?></td>
                                                                                            <td><?= date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                            <td><?= $pl['nm_user']; ?></td>
                                                                                            <td><?= $val['petugas_lap']; ?></td>
                                                                                            <td><?= $val['koordinat']; ?></td>
                                                                                            <td><?= $val['nilai_harianbibit']; ?></td>
                                                                                            <td><?= $val['luas']; ?></td>
                                                                                            <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                            <td>
                                                                                                <center>
                                                                                                    <?php
                                                                                                    if (file_exists("assets/img/peng-bibit/" . $val['foto'])) {
                                                                                                    ?>
                                                                                                        <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoViewBibit<?= $val['id_harianbibit'] ?>">
                                                                                                            <img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit/<?= $val['foto']; ?>" alt="" width="60px" height="60px" style="cursor:zoom-in" data-toggle="tooltip" data-placement="left" title="Klik untuk memperbesar.">
                                                                                                        </button>
                                                                                                    <?php
                                                                                                    } else {
                                                                                                    ?>
                                                                                                        <button type="button" class="btn btn-info">
                                                                                                            Image not <br> found..
                                                                                                        </button>
                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </center>
                                                                                                <!-- Modal Foto View -->
                                                                                                <div class="modal fade" id="fotoViewBibit<?= $val['id_harianbibit'] ?>" tabindex="-1" aria-labelledby="fotoViewBibit<?= $val['id_harianbibit'] ?>Label" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                                        <div class="modal-content" style="background-color: transparent;">
                                                                                                            <div class="modal-body modal-open text-center m-0 p-0">
                                                                                                                <img class="img" src="<?= base_url('assets/'); ?>img/peng-bibit/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>">
                                                                                                                <?php
                                                                                                                $BibitimageURL = "assets/img/peng-bibit/" . $val['foto'];
                                                                                                                $BibitUrlMap = get_image_location($BibitimageURL);
                                                                                                                ?>
                                                                                                                <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                                <?php
                                                                                                                if (!empty($BibitUrlMap)) {
                                                                                                                ?>
                                                                                                                    <a target="_blank" href="https://maps.google.com/maps?q=<?= $BibitUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                                        <button class="btn btn-info btn-outline-primary pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i></button>
                                                                                                                    </a>
                                                                                                                <?php } ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
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
                                            }
                                            ?>
                                            <tr>
                                                <th class="text-left">III</th>
                                                <th colspan="5">KEGIATAN DI LAPANGAN</th>
                                            </tr>
                                            <?php
                                            $nomr = 1;
                                            $lapangan = $this->report->getLapangan($lokasi['id_petak']);
                                            foreach ($lapangan as $valueLap) {
                                                $progreslapangan = $this->report->getLapanganProgres($lokasi['id_petak'], $valueLap['id_spklapangan']);
                                                $harianlapangan = $this->db->get_where('harianlapangan', ['id_spklapangan' => $valueLap['id_spklapangan'], 'id_petak' => $lokasi['id_petak']])->result_array();
                                                // $progres = empty($progreslapangan['totnilai']) ? "0" : $progreslapangan['totnilai'];
                                            ?>
                                                <tr>
                                                    <td class="text-right"><?= $nomr++; ?></td>
                                                    <td><?= $valueLap['nm_kegiatan']; ?></td>
                                                    <td class="text-center"><?= $valueLap['satuan']; ?></td>
                                                    <td class="text-center font-weight-bold <?= ($valueLap['nilai_spklapangan'] < $progreslapangan['totnilai']) ? "text-warning" : ""; ?> <?= ($valueLap['nilai_spklapangan'] > $progreslapangan['totnilai']) ? "text-danger" : "text-success"; ?>" data-toggle="tooltip" data-placement="top" title="<?= number_format($progreslapangan['totnilai'], 2, '.', ','); ?> dari <?= number_format($valueLap['nilai_spklapangan'], 2, '.', ','); ?>"><?= number_format($progreslapangan['totnilai'], 2, '.', ','); ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($harianlapangan as $ket) {
                                                            echo $ket['keterangan'] . ". ";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <small>
                                                            <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#DetailsLap<?= $valueLap['id_spklapangan']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                        </small>
                                                        <!-- Modal -->
                                                        <div class="modal fade text-left" id="DetailsLap<?= $valueLap['id_spklapangan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="newRoleLabel">Detail Kegiatan <b><?= $valueLap['nm_kegiatan']; ?></b></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body scrol">
                                                                        <div class="col-sm-12 m-0 p-0" style="min-width: 999px;">
                                                                            <table class="table-sm table-striped table-hover" width="100%">
                                                                                <tr class="text-center">
                                                                                    <th>*</th>
                                                                                    <th>Tgl Pengawasan</th>
                                                                                    <th>Tgl Input</th>
                                                                                    <th>Petugas Lapangan</th>
                                                                                    <th>Petugas</th>
                                                                                    <th>Koordinat</th>
                                                                                    <th>Progress</th>
                                                                                    <th>Luas</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Foto</th>
                                                                                    <th>Video</th>
                                                                                </tr>
                                                                                <?php
                                                                                $nih = 1;
                                                                                foreach ($harianlapangan as $val) {
                                                                                    $pl = $this->db->get_where('dt_user', ['id_user' => $val['id_user']])->row_array();
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?= $nih++; ?></td>
                                                                                        <td><?= $val['tgl']; ?></td>
                                                                                        <td><?= date('Y-m-d', $val['tgl_create']); ?></td>
                                                                                        <td><?= $pl['nm_user']; ?></td>
                                                                                        <td><?= $val['petugas_lap']; ?></td>
                                                                                        <td><?= $val['koordinat']; ?></td>
                                                                                        <td><?= $val['nilai_harianlapangan']; ?></td>
                                                                                        <td><?= $val['luas']; ?></td>
                                                                                        <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                                        <td>
                                                                                            <center>
                                                                                                <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoViewLapangan<?= $val['id_harianlapangan'] ?>">
                                                                                                    <img class="img" src="<?= base_url('assets/'); ?>img/peng-lapangan/<?= $val['foto']; ?>" alt="" width="50px" height="50px" style="cursor:zoom-in" data-toggle="tooltip" data-placement="left" title="Klik untuk memperbesar.">
                                                                                                </button>
                                                                                            </center>
                                                                                            <!-- Modal Foto View -->
                                                                                            <div class="modal" id="fotoViewLapangan<?= $val['id_harianlapangan'] ?>" tabindex="-1" aria-labelledby="fotoViewLapangan<?= $val['id_harianlapangan'] ?>Label" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                                    <div class="modal-content" style="background-color: transparent;">
                                                                                                        <div class="modal-body modal-open text-center m-0 p-0">
                                                                                                            <img class="img" src="<?= base_url('assets/'); ?>img/peng-lapangan/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>"><br>
                                                                                                            <?php
                                                                                                            $LapimageURL = "assets/img/peng-lapangan/" . $val['foto'];
                                                                                                            $LapUrlMap = get_image_location($LapimageURL);
                                                                                                            ?>
                                                                                                            <h3 class="badge-dark badge-lg m-0"><?= $val['foto']; ?></h3>
                                                                                                            <?php
                                                                                                            if (!empty($LapUrlMap)) {
                                                                                                            ?>
                                                                                                                <a target="_blank" href="https://maps.google.com/maps?q=<?= $LapUrlMap; ?>" data-toggle="tooltip" data-placement="top" title="Klik untuk melihat Lokasi di google maps.">
                                                                                                                    <button class="btn btn-info btn-outline-primary pl-5 pr-5"> <i class="fas fa-map-marked-alt"></i></button>
                                                                                                                </a>
                                                                                                            <?php
                                                                                                            } ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#videoView<?= $val['id_harianlapangan'] ?>">
                                                                                                <i class="fas fa-file-video"></i>
                                                                                            </button>
                                                                                            <div class="modal" id="videoView<?= $val['id_harianlapangan'] ?>" tabindex="-1" aria-labelledby="videoView<?= $val['id_harianlapangan'] ?>Label" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-lg" style="width: 100%;">
                                                                                                    <div class="modal-content" style=" background-color: black;">
                                                                                                        <div class="modal-body modal-open text-center m-0 p-0">
                                                                                                            <video height="100%" controls>
                                                                                                                <source src="<?= base_url('assets/'); ?>img/peng-video/<?= $val['video']; ?>" type="video/mp4">
                                                                                                                Your browser does not support the video tag.
                                                                                                            </video>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                        <h5 class="font-weight-bold">KENDALA ATAU REKOMENDASI :</h5>
                        <hr class="m-0 pb-2">
                        <p>
                            <span class="text-danger">* Realisasi progress pengawasan <b>belum terpenuhi</b> dari SPK yang telah ditentukan.</span><br>
                            <span class="text-success">* Realisasi progress pengawasan <b>telah terpenuhi</b> dari SPK yang telah ditentukan.</span><br>
                            <span class="text-warning">* Realisasi progress pengawasan <b>melebihi</b> dari SPK yang telah ditentukan.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
function get_image_location($image = '')
{
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