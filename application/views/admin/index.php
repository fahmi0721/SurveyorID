<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="border-bottom-info shadow h-200 ml-0 alert alert-info alert-dismissible fade show" role="alert">
                <strong>Selamat Datang <?= $user['nm_user']; ?>.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-200 ml-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">number of users</div>
                            <div class="h5 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $users; ?> data</div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/manageuser'); ?>" title="Lihat Detail Semua data">
                                <i class="fas fa-users fa-3x  text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer  btn-warning btn-icon-split btn-sm" title="Lihat Detail Semua data">
                    <a href="<?= base_url('admin/manageuser'); ?>">
                        <span class="text font-weight-bold"><i class="fas fa-fw fa-arrow-right"></i> Lihat Semua Data User</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-200 ml-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengawasan Harian</div>
                            <div class="h5 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $harian; ?> data</div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('report'); ?>" title="Lihat detail semua data report pengawasan harian">
                                <i class="fas fa-file-invoice fa-3x text-success"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer  btn-success btn-icon-split btn-sm" title="Lihat detail semua data report pengawasan harian">
                    <a href="<?= base_url('report'); ?>" class="">
                        <span class="text font-weight-bold"><i class="fas fa-fw fa-arrow-right"></i>Report Pengawasan Harian</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-200 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-1">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-200 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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