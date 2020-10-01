<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- card tile -->
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['nm_user']; ?></h5>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text"><small class="text-muted">User created since <?= date('l, d F Y', $user['date_created']); ?> </small></p>
                </div>
            </div>
        </div>
        <a href="<?= base_url('user/edit') ?>" class="btn btn-google btn-block text-capitalize"><i class="fa fa-user-edit fa-fw"></i> Edit my profiles</a>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->