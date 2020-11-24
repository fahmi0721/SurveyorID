<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-capitalize font-weight-bold"><a href=""><?= $title . " " . $user['nm_user']; ?></a><small class="text-info"></small></h1>
    <?php
    if (empty($anggota)) { ?>
        <div class="card text-center">
            <div class="card-header text-danger">
                --------------
            </div>
            <div class="card-body text-danger">
                <h5 class="card-title">Anggota tidak ditemukan</h5>
                <p class="card-text">Anda tidak mempunyai anggota, jika anda mempunyai anggota silahkan hubungi admin.</p>
                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
            </div>
            <div class="card-footer text-danger">
                --------------
            </div>
        </div>
    <?php
    } else { ?>
        <div class="card shadow mb-4">
            <div class="card-header">
                Daftar Anggota
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    foreach ($anggota as $value) {
                    ?>
                        <div class="col-sm-3 mb-4">
                            <div class="card" style="width: 100%;">
                                <img src="<?= base_url('assets/img/profile/') . $value['image']; ?>" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <h5 class="card-title m-0 font-weight-bold"><?= $value['nm_user']; ?></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><?= $value['email']; ?></li>
                                </ul>
                                <div class="card-body text-center">
                                    <a href="<?= base_url('anggota/pl/') . $value['id_user']; ?>" class="card-link">Lihat Pengawasan</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</div>
<!-- /.container-fluid -->

</div>