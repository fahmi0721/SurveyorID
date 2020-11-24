<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Log / <?= $title; ?></h1>
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-bottom-info shadow h-200 ml-0">
                <div class="card-header text-info font-weight-bold">Aktivitas</div>
                <div class="card-body text-sm">
                    <small>
                        <div class="table-responsive table-head-fixed">
                            <table class="table table-sm table-striped text-sm" width="100%" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Aktivitas</th>
                                        <th>Menu</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($log as $value) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $value['nm_user']; ?></td>
                                            <td><?= $value['role']; ?></td>
                                            <td><?= $value['logs']; ?></td>
                                            <td><?= $value['title']; ?></td>
                                            <td><?= (date('Y-m-d') == $value['tgl']) ? "Hari ini" : $value['tgl']; ?> | <?= $value['waktu']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trafik Log / Aktivitas</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
include 'chart-log.php';
?>