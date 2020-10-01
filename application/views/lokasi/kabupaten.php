<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExampl" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExampl">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-check-square"></i> Data Kabupaten</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse hide" id="collapseCardExampl">
        <div class="card-body">
            <h6 class="mb-2 font-weight-bold text-primary">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newKabupatenModal"><i class="fas fa-plus"></i> Tambah Kabupaten</a>
            </h6>
            <div class="table-responsive">
                <small>
                    <table class="table table-hover table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr align="center">
                                <th scope="col">#</th>
                                <th scope="col">Nama Kabupaten</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Flag</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($kabupaten as $kab) : ?>
                                <tr>
                                    <th><?= $i++; ?></th>
                                    <td><?= $kab['nm_kabupaten']; ?></td>
                                    <td><?= $kab['ket_kabupaten']; ?></td>
                                    <td><?= $kab['flag_kab']; ?></td>
                                    <td align="center">
                                        <a href="#" class="badge badge-info p-2 m-1 pr-3 pl-3" data-toggle="modal" data-target="#editModal<?= $kab['id_kabupaten']; ?>">Edit</a>
                                        <a href="<?= base_url('lokasi/kabDel/') . $kab['id_kabupaten']; ?>" class="badge badge-danger p-2" onclick="return confirm('Are you sure delete this Data?')">Delete</a>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal<?= $kab['id_kabupaten']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newRoleLabel">Edit Data Kabupaten <b><?= $kab['nm_kabupaten']; ?></b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="user" method="post" action="<?= base_url('lokasi/kabUpdate/') . $kab['id_kabupaten']; ?>">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kabupaten" value="<?= $kab['nm_kabupaten']; ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan" value="<?= $kab['ket_kabupaten']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="CheckBox" class="form-check form-check-inline">Aktif : </label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $kab['id_kabupaten']; ?>" value="0" <?= ($kab['flag_kab'] == 0) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="<?= $kab['id_kabupaten']; ?>">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $kab['id_kabupaten']; ?>a" value="1" <?= ($kab['flag_kab'] == 1) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="<?= $kab['id_kabupaten']; ?>a">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End edit Modal -->
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </small>
            </div>
        </div>
    </div>
</div>


<!-- Modal Add Kabupaten-->
<div class="modal fade" id="newKabupatenModal" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Data Kabupaten Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('lokasi'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kabupaten" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan">
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