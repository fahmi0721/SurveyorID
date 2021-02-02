<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-12">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report/mingguan'); ?>"><?= $title; ?></a></h1>
        </div>
        <?php
        if (COUNT($kabupaten) > 0) {
            foreach ($kabupaten as $kab) {

        ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-200 ml-0">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Kabupaten</div>
                                    <div class="h1 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $kab['nm_kabupaten'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-3x  text-primary"></i>
                                </div>
                            </div>
                        </div>
                        <a class="text card-footer btn-icon-split btn-sm text-lg" href="<?= base_url('report/kabupaten/') . $kab['id_kabupaten']; ?>" title="Lihat Detail Semua data">
                            <span class="text font-weight-bold"> Lihat Data</span>
                        </a>
                    </div>
                </div>
        <?php
            }
        }
        ?>

        <?php
        // foreach ($kabupaten as $value) {
        //     $spkReal = $this->report->LoadRealisasi($value['id_kabupaten']);
        //     echo "<pre>";
        //     echo '"' . $spkReal['totalRealisasi'] . '",';
        // }

        include 'grafikbar.php';
        include 'grafikpengawasan.php';

        ?>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->