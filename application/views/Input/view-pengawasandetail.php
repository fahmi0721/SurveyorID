<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('input/view'); ?>"><?= $title; ?></a> <small class="text-info">/Detail Bahan-bahan</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('input/view'); ?> " class="badge badge-info" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <a href="#collapseSpkbibit" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSpkbibit">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Detail Pengawasan Harian Bahan</h6>
        </a>
        <div class="collapse show" id="collapseSpkbibit">
            <div class="card-body">
                <div class="row">
                    <div class="row m-3">
                        <div class="col-sm-6">
                            <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                        </div>
                        <div class="col-sm-6 text-right">
                            <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                        </div>
                    </div>
                    <div class="col-lg-12 text-center mb-4 font-weight-bold">
                        <h5 class="font-weight-bold">HASIL PENGAWASAN DAN PENILAIAN HARIAN</h5>
                        <h5 class="font-weight-bold">PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK</h5>
                        <hr>
                    </div>
                    <div class="col-lg-6 text-uppercase font-weight-bold">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Kabupaten</td>
                                <td>:</td>
                                <td><?= $details['nm_kabupaten']; ?></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>:</td>
                                <td><?= $details['nm_kecamatan']; ?></td>
                            </tr>
                            <tr>
                                <td>Desa</td>
                                <td>:</td>
                                <td><?= $details['nm_desa']; ?></td>
                            </tr>
                            <tr>
                                <td>Pelaksana</td>
                                <td>:</td>
                                <td>PTSI</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6 text-uppercase font-weight-bold">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Nama Petugas</td>
                                <td>:</td>
                                <td><?= $details['petugas_lap']; ?></td>
                            </tr>
                            <tr>
                                <td>Blok</td>
                                <td>:</td>
                                <td><?= $details['nm_blok']; ?></td>
                            </tr>
                            <tr>
                                <td>Petak</td>
                                <td>:</td>
                                <td><?= $details['nm_petak']; ?></td>
                            </tr>
                            <tr>
                                <td>Luas</td>
                                <td>:</td>
                                <td><?php
                                    $totalluasharian = $this->det->getDataPengawasanTotLuas($details['id_petak'], $details['id_user']);
                                    ?>
                                    <?= $totalluasharian['totluas']; ?> Ha
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12 text-1x"><small>
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
                                    <?php
                                    $no = 1;
                                    $datanx = $this->det->getDataPengawasanBahan($details['id_petak']);
                                    foreach ($datanx as $dat) {
                                        $totalnilaiharian = $this->det->getDataPengawasanTotNilai($dat['id_spkbahan'], $dat['id_petak']);
                                        $sql = $this->db->get_where('harianbahan', ['id_spkbahan' => $dat['id_spkbahan'], 'id_petak' => $details['id_petak'], 'id_user' => $details['id_user'],])->result_array();

                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $dat['nm_kegiatan']; ?></td>
                                            <td class="text-center"><?= $dat['satuan']; ?></td>
                                            <td class="text-center <?= ($dat['nilai_spkbahan'] < $totalnilaiharian['totnilai']) ? "text-warning" : ""; ?> <?= ($dat['nilai_spkbahan'] > $totalnilaiharian['totnilai']) ? "text-danger" : "text-success"; ?>" data-toggle="tooltip" data-placement="top" title="<?= number_format($totalnilaiharian['totnilai'], 2, '.', ','); ?> dari <?= number_format($dat['nilai_spkbahan'], 2, '.', ','); ?>"><?= number_format($totalnilaiharian['totnilai'], 2, '.', ','); ?></td>
                                            <td><?php
                                                foreach ($sql as $value) {
                                                    echo "- " . $value['keterangan'] . ".<br> ";
                                                } ?>
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    <a href="" class="badge badge-info p-2" data-toggle="modal" data-target="#Details<?= $dat['id_spkbahan']; ?>" title="Detail"><i class="fas fa-fw fa-info fa-1x"></i></a>
                                                </small>
                                                <!-- Modal Add SPK Kategori bibit-->
                                                <div class="modal fade" id="Details<?= $dat['id_spkbahan']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="newRoleLabel">Detail Kegiatan <b><?= $dat['nm_kegiatan']; ?></b></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body scrol">
                                                                <table class="table table-sm">
                                                                    <tr class="table-active">
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
                                                                    foreach ($sql as $val) { ?>
                                                                        <tr>
                                                                            <td><?= $ni++; ?></td>
                                                                            <td><?= $val['tgl']; ?></td>
                                                                            <td><?= date('m d Y', $val['tgl_create']); ?></td>
                                                                            <td><?= $val['petugas_lap']; ?></td>
                                                                            <td><?= $val['koordinat']; ?></td>
                                                                            <td><?= $val['nilai_harianbahan']; ?></td>
                                                                            <td><?= $val['luas']; ?></td>
                                                                            <td class="text-left"><?= $val['keterangan']; ?></td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-info p-0" data-toggle="modal" data-target="#fotoView<?= $val['id_harianbahan'] ?>">
                                                                                    <img class="img" src="<?= base_url('assets/'); ?>img/peng-bahan/<?= $val['foto']; ?>" alt="" width="40px" height="40px" title="<?= $val['foto']; ?>">
                                                                                </button>
                                                                                <!-- Modal Foto View -->
                                                                                <div class="modal" id="fotoView<?= $val['id_harianbahan'] ?>" tabindex="-1" aria-labelledby="fotoView<?= $val['id_harianbahan'] ?>Label" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-xl" style="width: 100%;">
                                                                                        <div class="modal-body modal-open text-center m-0 p-0">
                                                                                            <img class="img" src="<?= base_url('assets/'); ?>img/peng-bahan/<?= $val['foto']; ?>" alt="" width="100%" title="<?= $val['foto']; ?>">
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
