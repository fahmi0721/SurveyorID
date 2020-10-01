<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
            <?= $this->session->flashdata('message'); ?>

            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>
            <div class="table-responsive">
                <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Url</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Active</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($subMenu as $sm) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $sm['title']; ?></td>
                                <td><?= $sm['menu']; ?></td>
                                <td><?= $sm['url']; ?></td>
                                <td><?= $sm['icon']; ?></td>
                                <td><?= $sm['is_active']; ?></td>
                                <td>
                                    <a href="" class="badge badge-info" data-toggle="modal" data-target="#editModal<?= $sm['id']; ?>">Edit</a>
                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#delModal<?= $sm['id']; ?>">Delete</a>
                                </td>
                            </tr>
                            <!-- Edit Modal-->
                            <div class="modal fade" id="editModal<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editMenuModalLabel">Edit Sub Menu</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('menu/submenuUpdt/') . $sm['id']; ?>" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="title" value="<?= $sm['title'] ?>" name="title" placeholder="Sub Menu title">
                                                </div>
                                                <div class="form-group">
                                                    <select name="menu_id" id="menu_id" class="form-control">
                                                        <option value="">Select Menu</option>
                                                        <?php foreach ($menu as $m) : ?>
                                                            <?php $pilih = ($m['menu'] == $sm['menu']) ? "selected" : ""; ?>
                                                            <option value="<?= $m['id']; ?>" <?= $pilih; ?>><?= $m['menu']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="url" value="<?= $sm['url'] ?>" name="url" placeholder="Sub Menu url">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="icon" value="<?= $sm['icon'] ?>" name="icon" placeholder="Sub Menu icon">
                                                </div>
                                                <div class="form-grop">
                                                    <div class="form-check">
                                                        <?php $pilih = ($sm['is_active'] == 1) ? "checked" : ""; ?>
                                                        <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" <?= $pilih; ?>>
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
                            <!-- Delete Modal-->
                            <div class="modal fade" id="delModal<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">Are you sure want to delete this submenu "<?= $sm['title']; ?>" ?</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                                            <a class="btn btn-primary" href="<?= base_url('menu/submenuDelete/') . $sm['id']; ?>">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Sub Menu title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu icon">
                    </div>
                    <div class="form-grop">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
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