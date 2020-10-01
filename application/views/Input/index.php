<?php
// cek login jika bukan admin dan supervisor yang mengakses halaman ini
$sesi = $user['role_id'];
if ($sesi == 8 || $sesi == 1) {
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary text-capitalize font-weight-bold"><?= $title; ?></h1>
        <div class="row" style="font-family: Calibri;">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="<?= base_url('input/harianbahan'); ?>" title="Go">
                                    <div class="text-x font-weight-bold text-info text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Bahan-Bahan</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url('input/harianbahan'); ?>" title="Go"><i class="fas fa-chevron-circle-right fa-3x text-info"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="<?= base_url('input/harianbahan'); ?>" title="Go">
                                    <div class="text-x font-weight-bold text-success text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Pengadaan Bibit</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url('input/harianbibit'); ?>" title="Go"><i class="fas fa-chevron-circle-right fa-3x  text-success"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="<?= base_url('input/harianlapangan'); ?>" title="Go">
                                    <div class="text-x font-weight-bold text-danger text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Kegiatan di Lapangan</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url('input/harianlapangan'); ?>" title="Go"><i class="fas fa-chevron-circle-right fa-3x text-danger"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php
} else {
    redirect('auth/notfound');
}
?>