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
            <div class="card border-left-primary shadow h-200 ml-0 " style="color: blue;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">number of users</div>
                            <div class="h5 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $users; ?> data</div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/manageuser'); ?>" title="Lihat Detail Semua data">
                                <i class="fas fa-users fa-3x  text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/manageuser'); ?>" class="card-footer texthoverwhite btn-primary btn-icon-split btn-sm" title="Lihat Detail Semua data">
                    <span class="text font-weight-bold">Lihat Semua Data User</span>
                </a>
            </div>
        </div>
        <div class="col-xl-9 mb-4">
            <div class="card border-left-info shadow h-200 ml-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-capitalize text-success">
                                        Bibit (Tahap I) : <?= $totbibitpertama; ?> Kabupaten
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= base_url('report'); ?>" title="Lihat detail semua data report pengawasan harian">
                                        <i class="fas fa-file-invoice fa-3x text-success"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 border-left-primary">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-capitalize text-primary">
                                        Bahan : <?= $totbahan; ?> Petak
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= base_url('report'); ?>" title="Lihat detail semua data report pengawasan harian">
                                        <i class="fas fa-file-invoice fa-3x text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 border-left-info">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-capitalize text-success">
                                        Bibit : <?= $totbibit; ?> Petak
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= base_url('report'); ?>" title="Lihat detail semua data report pengawasan harian">
                                        <i class="fas fa-file-invoice fa-3x text-success"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 border-left-info">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pengawasan Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-capitalize text-warning">
                                        Lapangan : <?= $totlapangan; ?> Petak
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= base_url('report'); ?>" title="Lihat detail semua data report pengawasan harian">
                                        <i class="fas fa-file-invoice fa-3x text-warning"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('report'); ?>" class="reporthover card-footer btn-info btn-icon-split btn-sm font-weight-bold" title="Lihat detail semua data report pengawasan harian">
                    <span class="text font-weight-bold">Report Pengawasan Harian</span>
                </a>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-bottom-danger shadow h-200 ml-0">
                <div class="card-header text-danger font-weight-bold">Aktivitas</div>
                <div class="card-body scroll text-sm">
                    <small>
                        <table class="table-sm table-striped text-sm" width="100%">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Aktivitas</th>
                                <th>Tanggal/waktu</th>
                            </tr>
                            <?php
                            $total = $this->db->get('dt_logs')->num_rows();
                            $no = 1;
                            foreach ($log as $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['nm_user']; ?></td>
                                    <td><?= $value['logs']; ?></td>
                                    <td><?= $value['tgl'] . " " . $value['waktu']; ?></td>
                                </tr>
                            <?php
                                if ($no == 16) {
                                    echo "<tr><td colspan='4'> . . . <br>" . $total . "</td></tr>";
                                    break;
                                }
                            }
                            ?>
                        </table>
                    </small>
                </div>
                <div class="card-footer btn-icon-split btn-sm" title="Lihat Semua Aktivitas">
                    <a href="<?= base_url('admin/logs'); ?>">
                        <span class="text text-danger font-weight-bold">Lihat Aktivitas</span>
                    </a>
                </div>
            </div>
        </div>
        <?php include 'grafikpengawasantallysheet.php'; ?>
        <?php include 'grafikpengawasan.php'; ?>

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
// include 'chart-pengawasan.php';
?>