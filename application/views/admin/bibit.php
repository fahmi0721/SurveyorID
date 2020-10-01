<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapsebibit" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapsebibit">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list-alt"></i> Data BIBIT</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapsebibit">
        <div class="card-body">
            <h6 class="mb-2 font-weight-bold text-primary">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newBibit"><i class="fas fa-plus"></i> Tambah</a>
            </h6>
            <div class="table-responsive">
                <table class="table table-hover table-bordered " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center" class="table-active">
                            <th scope="col">#</th>
                            <th scope="col">Nama Bibit</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">flag</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($bibit as $bit) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class=""><?= $bit['nm_bibit']; ?></td>
                                <td class="text-center"><?= $bit['satuan']; ?></td>
                                <td class="text-center"><?= $bit['flag_bibit']; ?></td>
                                <td class="text-center">
                                    <a href="#" class="badge badge-info p-2 m-0 pr-3 pl-3" data-toggle="modal" data-target="#editModalKeg<?= $bit['id_bibit']; ?>">Edit</a>
                                    <a href="<?= base_url('admin/bibitDel/') . $bit['id_bibit']; ?>" class="badge badge-danger  m-0 p-2" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModalKeg<?= $bit['id_bibit']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="newRoleLabel">Edit Data Bibit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="<?= base_url('admin/bibitEdit/') . $bit['id_bibit']; ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nama" value="<?= $bit['nm_bibit']; ?>" name="nama" placeholder="Nama Bibit" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" value="<?= $bit['satuan']; ?>" id="satuan" name="satuan" placeholder="Satuan" title="Satuan (Ha/Patok/Batang/Unit/Paket/Buah)">
                                                </div>
                                                <div class="form-group">
                                                    <label for="CheckBox" class="form-check form-check-inline">Aktif : </label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="flag" id="<?= $bit['id_bibit']; ?>" value="0" <?= ($bit['flag_bibit'] == 0) ? "checked" : ""; ?>>
                                                        <label class="form-check-label" for="<?= $bit['id_bibit']; ?>">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="flag" id="<?= $bit['id_bibit']; ?>a" value="1" <?= ($bit['flag_bibit'] == 1) ? "checked" : ""; ?>>
                                                        <label class="form-check-label" for="<?= $bit['id_bibit']; ?>a">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Perbaharui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End edit Modal -->
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Add Jenis Isi-->
    <div class="modal fade" id="newBibit" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newRoleLabel">Tambah Data BIBIT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('admin/bibitAdd'); ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Bibit" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" title="Satuan (Ha/Patok/Batang/Unit/Paket/Buah)">
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>