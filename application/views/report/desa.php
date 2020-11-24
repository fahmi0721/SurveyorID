<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report/mingguan'); ?>"><?= $title; ?></a><small class="text-info">/Kecamatan</small><small class="text-success">/Desa</small><small class="text-warning">/Blok&Petak</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="javascript:history.back()" class="btn btn-info btn-sm" title="kembali ke halaman sebelumnya"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
        <?php
        if (COUNT($kabupaten) > 0) {
            foreach ($kabupaten as $kab) {

        ?>
                <div class="col-xl-6 mb-4">
                    <div class="card border-left-warning shadow h-200 ml-0">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-lg font-weight-bold text-success text-capitalize mb-1">Kab. <?= $kab['nm_kabupaten']; ?>, Kec. <?= $kab['nm_kecamatan'] ?>, Desa <?= $kab['nm_desa']; ?></div>
                                    <div class="h1 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $kab['nm_blok'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-3x  text-warning"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-lg">
                            <ul class="m-0">
                                <div class="row">
                                    <?php
                                    $petak = $this->report->LoadPetak($kab['id_kabupaten'], $kab['id_kecamatan'], $kab['id_desa'], $kab['id_blok']);
                                    foreach ($petak as $pet) {
                                    ?>
                                        <div class="col-sm-3">
                                            <a href="<?= base_url('report/details/') . $kab['id_kabupaten'] . "-" . $kab['id_kecamatan'] . "-" . $kab['id_desa'] . "-" . $kab['id_blok'] . "-" . $pet['id_petak']; ?>">
                                                <li><?= $pet['nm_petak']; ?></li>
                                            </a>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        <!-- /.container-fluid -->
    </div>

</div>
<!-- End of Main Content -->
</div>