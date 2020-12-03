<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('input/view'); ?>"><?= $title; ?></a> <small class="text-info"></small></h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- Pengawasan Harian Bibit Tahap I -->
    <div class="card shadow mb-4">
        <a href="#collapseBibitTS" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseBibitTS">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list-ol"></i> Pengawasan Harian Bibit (Tahap I)</h6>
        </a>
        <div class="collapse show" id="collapseBibitTS">
            <div class="card-body">
                <div class="row">
                    <?php
                    $i = 1;
                    $datalokBibit = $this->loask->getBibitUserPertama($user['id_user']);
                    foreach ($datalokBibit as $lokbibit) : ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-200 ml-0">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Kabupaten</div>
                                            <div class="h1 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $lokbibit['nm_kabupaten']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-3x  text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                                <a class="text card-footer btn-icon-split btn-sm text-lg" href="<?= base_url('input/viewdetailpengawasanbibitpertama/') . $lokbibit['id_kabupaten']; ?>" title="Lihat Detail Pengawasan ">
                                    <span class="text font-weight-bold"> Lihat Data</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengawasan Harian Bahan -->
    <div class="card shadow mb-4">
        <a href="#collapseBahan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseBahan">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list-ol"></i> Pengawasan Harian Bahan</h6>
        </a>
        <div class="collapse show" id="collapseBahan">
            <div class="card-body">
                <div class="table-responsive " style="font-family: Calibri;">
                    <table class="table table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr class="text-center table-active text-lg">
                                <th>No</th>
                                <th>Lokasi</th> <!-- Kab.Kec.Des -->
                                <th>Blok/Petak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $datalok = $this->loask->getBahanUser($user['id_user']);
                            foreach ($datalok as $lok) : ?>
                                <tr>
                                    <th class="text-center"><?= $i++; ?></th>
                                    <td class="font-weight-bold">Kab. <?= $lok['nm_kabupaten'] . " | Kec. " . $lok['nm_kecamatan'] . "<br> Desa " . $lok['nm_desa']; ?></td>
                                    <td style="min-width: 300px;">
                                        <div class="row scroll">
                                            <?php
                                            $desblok = $this->loask->getBahanUserBlok($lok['id_desa'], $user['id_user']);
                                            foreach ($desblok as $blok) {
                                                $blokpetak = $this->loask->getBahanUserPetak($user['id_user'], $blok['id_blok']);
                                            ?>
                                                <div class="col-sm-6">
                                                    <ul style="list-style-type:circle;" class="pl-4 m-0 mb-1 border-bottom-danger">
                                                        <li class="">
                                                            <b class="text-info"><?= $blok['nm_blok']; ?></b>
                                                            <ul style="list-style-type:disc">
                                                                <div class="row petakHov font-weight-bold">
                                                                    <?php foreach ($blokpetak as $petak) { ?>
                                                                        <div class="col-sm-3" data-toggle="tooltip" data-placement="left" title="Lihat Detail Lengkap">
                                                                            <a href="<?= base_url('input/viewdetailpengawasan/') . $petak['id_petak']; ?>" class="text">
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengawasan Harian Bibit Tahap II -->
    <div class="card shadow mb-4">
        <a href="#collapseBibit" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseBibit">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list-ol"></i> Pengawasan Harian Bibit (Tahap II)</h6>
        </a>
        <div class="collapse show" id="collapseBibit">
            <div class="card-body">
                <div class="table-responsive " style="font-family: Calibri;">
                    <table class="table table-bordered table-hover" id="dataTable">
                        <thead>
                            <tr class="text-center table-active text-lg">
                                <th>No</th>
                                <th>Lokasi</th> <!-- Kab.Kec.Des -->
                                <th>Blok/Petak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $datalokBibit = $this->loask->getBibitUser($user['id_user']);
                            foreach ($datalokBibit as $lokbibit) : ?>
                                <tr>
                                    <th class="text-center"><?= $i++; ?></th>
                                    <td class="font-weight-bold">Kab. <?= $lokbibit['nm_kabupaten'] . " | Kec. " . $lokbibit['nm_kecamatan'] . "<br> Desa " . $lokbibit['nm_desa']; ?></td>
                                    <td style="min-width: 300px;">
                                        <div class="row scroll">
                                            <?php
                                            $desblokpeng = $this->loask->getBibitUserBlok($lokbibit['id_desa'], $user['id_user']);
                                            foreach ($desblokpeng as $blokpeng) {
                                                $blokbibitetak = $this->loask->getBibitUserPetak($user['id_user'], $blokpeng['id_blok']);
                                            ?>
                                                <div class="col-sm-6">
                                                    <ul style="list-style-type:circle;" class="pl-4 m-0 mb-1 border-bottom-danger">
                                                        <li class="">
                                                            <b class="text-info"><?= $blokpeng['nm_blok']; ?></b>
                                                            <ul style="list-style-type:disc">
                                                                <div class="row petakHov font-weight-bold">
                                                                    <?php foreach ($blokbibitetak as $petakpeng) { ?>
                                                                        <div class="col-sm-3" data-toggle="tooltip" data-placement="left" title="Lihat Detail Lengkap">
                                                                            <a href="<?= base_url('input/viewdetailpengawasanbibit/') . $petakpeng['id_petak']; ?>" class="text">
                                                                                <li>
                                                                                    <?= $petakpeng['nm_petak']; ?>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengawasan Harian Lapangan -->
    <div class="card shadow mb-4">
        <a href="#collapseLapangan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseLapangan">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list-ol"></i> Pengawasan Harian Lapangan</h6>
        </a>
        <div class="collapse show" id="collapseLapangan">
            <div class="card-body">
                <div class="table-responsive " style="font-family: Calibri;">
                    <table class="table table-bordered table-hover" id="dataTab">
                        <thead>
                            <tr class="text-center table-active text-lg">
                                <th>No</th>
                                <th>Lokasi</th> <!-- Kab.Kec.Des -->
                                <th>Blok/Petak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $datalokpeng = $this->loask->getLapanganUser($user['id_user']);
                            foreach ($datalokpeng as $lokpeng) : ?>
                                <tr>
                                    <th class="text-center"><?= $i++; ?></th>
                                    <td class="font-weight-bold">Kab. <?= $lokpeng['nm_kabupaten'] . " | Kec. " . $lokpeng['nm_kecamatan'] . "<br> Desa " . $lokpeng['nm_desa']; ?></td>
                                    <td style="min-width: 300px;">
                                        <div class="row scroll">
                                            <?php
                                            $desblokpeng = $this->loask->getLapanganUserBlok($lokpeng['id_desa'], $user['id_user']);
                                            foreach ($desblokpeng as $blokpeng) {
                                                $blokpengpetak = $this->loask->getLapanganUserPetak($user['id_user'], $blokpeng['id_blok']);
                                            ?>
                                                <div class="col-sm-6">
                                                    <ul style="list-style-type:circle;" class="pl-4 m-0 mb-1 border-bottom-danger">
                                                        <li class="">
                                                            <b class="text-info"><?= $blokpeng['nm_blok']; ?></b>
                                                            <ul style="list-style-type:disc">
                                                                <div class="row petakHov font-weight-bold">
                                                                    <?php foreach ($blokpengpetak as $petakpeng) { ?>
                                                                        <div class="col-sm-3" data-toggle="tooltip" data-placement="left" title="Lihat Detail Lengkap">
                                                                            <a href="<?= base_url('input/viewdetailpengawasanlap/') . $petakpeng['id_petak']; ?>" class="text">
                                                                                <li>
                                                                                    <?= $petakpeng['nm_petak']; ?>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->