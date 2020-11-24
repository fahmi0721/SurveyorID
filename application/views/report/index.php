<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 font-weight-bold text-primary"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive table-head-fixed">
                <table class="table table-hover table-bordered scrol" id="dataTables">
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->