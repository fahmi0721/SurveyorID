<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report/mingguan'); ?>"><?= $title; ?></a><small class="text-info">/Kecamatan</small><small class="text-success">/Desa</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="javascript:history.back()" class="btn btn-info btn-sm" title="kembali ke halaman sebelumnya"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
        <?php
        if (COUNT($kabupaten) > 0) {
            foreach ($kabupaten as $kab) {

        ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-200 ml-0">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-lg font-weight-bold text-success text-capitalize mb-1">Kab. <?= $kab['nm_kabupaten']; ?>, Kec. <?= $kab['nm_kecamatan']; ?></div>
                                    <div class="h2 mb-0 font-weight-bold text-capitalize text-gray-800">Desa <?= $kab['nm_desa']; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-3x  text-success"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer  btn-success btn-icon-split btn-sm text-lg" title="Lihat Detail Semua data">
                            <a href="<?= base_url('report/desa/') . $kab['id_kabupaten'] . "-" . $kab['id_kecamatan'] . "-" . $kab['id_desa']; ?>">
                                <span class="text font-weight-bold"></i> Lihat Data</span>
                            </a>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->