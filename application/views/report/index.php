<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 font-weight-bold text-primary"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive table-head-fixed">
                <table class="table table-hover table-bordered table-sm scrol" id="dataTables">
                    <thead>
                        <tr class="text-center text-lg">
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Blok/Petak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($lokasi as $value) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="font-weight-bold">Kab. <?= $value['nm_kabupaten'] . " | Kec. " . $value['nm_kecamatan'] . "<br> Desa " . $value['nm_desa']; ?></td>
                                <td>
                                    <div class="row scroll">
                                        <?php
                                        $diblok = 0;
                                        $desblok = $this->loask->getBlokHarian($value['id_kabupaten'], $value['id_kecamatan'], $value['id_desa']);
                                        foreach ($desblok as $blok) {
                                            $blokpetak = $this->loask->LoadPetak($value['id_kabupaten'], $value['id_kecamatan'], $value['id_desa'], $blok['id_blok']);
                                        ?>
                                            <div class="col-sm-6">
                                                <ul style="list-style-type:circle;" class="pl-4 m-0 mb-1 border-bottom-info">
                                                    <li class="">
                                                        <b class="text-info"><?= $blok['nm_blok']; ?></b>
                                                        <ul style="list-style-type:disc">
                                                            <div class="row font-weight-bold">
                                                                <?php
                                                                foreach ($blokpetak as $petak) {
                                                                ?>
                                                                    <div class="col-sm-4">
                                                                        <a href="<?= base_url('report/harian/') . $blok['id_kabupaten'] . "-" . $blok['id_kecamatan'] . "-" . $blok['id_desa'] . "-" . $blok['id_blok'] . "-" . $petak['id_petak']; ?>" class="" title="Lihat Laporan Harian">
                                                                            <li>
                                                                                <?= $petak['nm_petak']; ?>
                                                                            </li>
                                                                        </a>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <b>TALLY SHEET BIBIT</b>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($tallysheet as $value) { ?>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-200 ml-0">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Kabupaten</div>
                                        <div class="h1 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $value['nm_kabupaten'] ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-map-marker-alt fa-3x  text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            <a class="text card-footer btn-icon-split btn-sm text-lg" href="<?= base_url('report/tallysheet/') . $value['id_kabupaten']; ?>" title="Lihat Detail Pengawasan ">
                                <span class="text font-weight-bold"> Lihat Data</span>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer">
            <?php include 'grafikpengawasantallysheet.php'; ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->