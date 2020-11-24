<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-shadow text-gray-800"><?= $title; ?></h1>
    <div class="row">

        <div class="col-sm-12 mb-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newAnggota"><i class="fas fa-plus"></i> Add Anggota</a>
            </h6>
        </div>
        <div class="col-sm-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
        <?php foreach ($userVisor as $sup) : ?>
            <div class="col-sm-12">
                <!-- Circle Buttons -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Anggota <?= $sup['nm_user'] . " | " . $sup['id_user']; ?></h6>
                    </div>
                    <div class="card-body">
                        <?php
                        // Select  usernya Supervisor berdasarkan siapa supervisornya
                        $this->load->model('Menu_model', 'supervisor');
                        $users = $this->supervisor->getSprAnggota($sup['id_user']);
                        if (empty($users)) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>User anggota supervisor tidak ada!</strong>
                            </div>
                        <?php
                        } else {
                            $no = 1;
                        ?>
                            <div class="table-responsive text-sm">
                                <table class="table table-sm table-hover " id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Foto</th>
                                            <th>Keterangan</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $usr) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $usr['nm_user']; ?></td>
                                                <td><?= $usr['email']; ?></td>
                                                <td><img src="<?= base_url('assets/img/profile/') . $usr['image']; ?>" width="30px" height="35px"></td>
                                                <td><?= $usr['ket_user_anggota']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/anggotaDel/') . $usr['id_user_anggota']; ?>" data-toggle="tooltip" data-placement="left" title="Hapus Anggota" class="badge badge-danger p-2" onclick="return confirm('Yakin akan menghapus anggota ini?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="newAnggota" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Add New Supervisor Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('admin/supervisoradd'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="id_supervisor" id="id_supervisor" class="form-control" required>
                            <option value="" selected>Select Supervisor</option>
                            <?php foreach ($userVisor as $sr) : ?>
                                <option value="<?= $sr['id_user']; ?>"> <?= $sr['nm_user']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="id_anggota" id="id_anggota" class="form-control" required>
                            <option value="" selected>Select User</option>
                            <?php foreach ($nonvis as $nonsr) : ?>
                                <?php
                                $SqlAnggota = $this->db->get_where('user_anggota', ['id_anggota' => $nonsr['id_user']])->row_array();
                                if (empty($SqlAnggota)) {
                                ?>
                                    <option value="<?= $nonsr['id_user']; ?>"> <?= $nonsr['nm_user']; ?> </option>
                                <?php
                                }
                                ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="ket" name="ket" placeholder="Note">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>