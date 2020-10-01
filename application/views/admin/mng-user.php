<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newUserModal"><i class="fas fa-plus"></i> Add User Account</a>
            </h6>
        </div>
        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <?= form_error('email', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama User</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Is Active</th>
                            <th scope="col">Date Create</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($userRole as $u) : ?>
                            <tr>
                                <th><?= $i++; ?></th>
                                <td><?= $u['nm_user']; ?></td>
                                <td><?= $u['email']; ?></td>
                                <td><?= $u['role']; ?></td>
                                <?php $aktive = ($u['is_active'] == 1) ? "<b class='text-primary'>yes</b>" : "<b class='text-danger'>no</b>"; ?>
                                <td align="center" class=""><?= $aktive; ?></td>
                                <td><?= date('d F Y', $u['date_created']); ?></td>
                                <td align="center">
                                    <img src="<?= base_url('assets/img/profile/') . $u['image']; ?>" width="40px" height="50px">
                                </td>
                                <td align="center">
                                    <?php $blok = ($u['role_id'] == 1) ? "hidden" : ""; ?>
                                    <a href="#" class="badge badge-info p-2 m-1 pr-3 pl-3" data-toggle="modal" data-target="#editModal<?= $u['id_user']; ?>">Edit</a><br>
                                    <a href="<?= base_url('admin/userDel/') . $u['id_user']; ?>" class="badge badge-danger p-2" <?= $blok; ?> onclick="return confirm('Are you sure delete this user?')">Delete</a>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal<?= $u['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="newRoleLabel">Edit User <b><?= $u['nm_user']; ?></b></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="user" method="post" action="<?= base_url('admin/userUpdate/') . $u['id_user']; ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="<?= $u['nm_user']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?= $u['email']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <select name="role_id" id="role_id" class="form-control" required>
                                                        <option value="" selected>Select Role</option>
                                                        <?php foreach ($role as $r) : ?>
                                                            <?php $pilih = ($r['id'] == $u['role_id']) ? "selected" : ""; ?>
                                                            <option value="<?= $r['id']; ?>" <?= $pilih; ?>> <?= $r['role']; ?> </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group row">
                                                    <small class="col-sm-12 text-info pl-3">fill if you want to change the password</small>
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="password" class="form-control" id="pasword2" name="password2" placeholder="Repeat Password">
                                                    </div>
                                                </div>
                                                <div class="form-grop row">
                                                    <div class="form-check">
                                                        <?php $check = ($u['is_active'] == 1) ? "checked" : ""; ?>
                                                        <input type="checkbox" class="form-check-inputs" value="1" name="is_active" id="is_active" <?= $check; ?>>
                                                        <label class="form-check-label" for="is_active">
                                                            Active?
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End edit Modal -->
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Modal Add -->
<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="<?= set_value('name'); ?>" required>
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>" required>
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="" selected>Select Role</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id']; ?>"> <?= $r['role']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control" id="password1" name="password1" placeholder="Password" required>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="pasword2" name="password2" placeholder="Repeat Password" required>
                        </div>
                    </div>
                    <div class="form-grop">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-inputs" value="1" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
                        </div>
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