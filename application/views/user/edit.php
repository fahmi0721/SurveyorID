<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
            <?= $this->session->flashdata('msgUpload'); ?>
        </div>
    </div>
    <!-- /.container-fluid -->
    <div class="row">
        <div class="col-lg-8">

            <?= form_open_multipart('user/edit'); ?>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['nm_user']; ?>">
                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Picture</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="" class="img-thumbnail" width="100%">
                        </div>
                        <div class="col-sm-8">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambarx" name="gambarx">
                                <label for="gambarx" class="custom-file-label">Choose File</label>
                                <small class="text-info">*max size 200kb and file gif/jpg/png</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>

            </form>

        </div>
    </div>

</div>

</div>
<!-- End of Main Content -->