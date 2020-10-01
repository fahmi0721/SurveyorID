<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardKec" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardKec">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-check-square"></i> Data Kecamatan</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse hide" id="collapseCardKec">
        <div class="card-body">
            <h6 class="mb-2 font-weight-bold text-primary">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newKecModal"><i class="fas fa-plus"></i> Tambah Kecamatan</a>
            </h6>
            <div class="table-responsive">
                <small>
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr align="center">
                                <th scope="col">#</th>
                                <th scope="col">Nama Kabupaten</th>
                                <th scope="col">Nama Kecamatan</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Flag</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($kecamatan as $kec) : ?>
                                <tr>
                                    <th><?= $i++; ?></th>
                                    <td><?= $kec['nm_kabupaten']; ?></td>
                                    <td><?= $kec['nm_kecamatan']; ?></td>
                                    <td><?= $kec['ket_kecamatan']; ?></td>
                                    <td><?= $kec['flag_kec']; ?></td>
                                    <td align="center">
                                        <a href="#" class="badge badge-info p-2 m-0 pr-3 pl-3" data-toggle="modal" data-target="#editModalKec<?= $kec['id_kecamatan']; ?>">Edit</a>
                                        <a href="<?= base_url('lokasi/kecDel/') . $kec['id_kecamatan']; ?>" class="badge badge-danger p-2" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModalKec<?= $kec['id_kecamatan']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newRoleLabel">Edit Data Kecamatan <b><?= $kec['nm_kecamatan']; ?></b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="user" method="post" action="<?= base_url('lokasi/kecUpdate/') . $kec['id_kecamatan']; ?>">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <select name="kab" id="kab" class="form-control" required>
                                                            <option value="">Pilih Kabupaten</option>
                                                            <?php foreach ($kabupaten as $ka) : ?>
                                                                <?php $pilih = ($ka['nm_kabupaten'] == $kec['nm_kabupaten']) ? "selected" : ""; ?>
                                                                <option value="<?= $ka['id_kabupaten']; ?>" <?= $pilih; ?>><b><?= $ka['nm_kabupaten']; ?></b></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="kec" name="kec" placeholder="Nama Kecamatan" value="<?= $kec['nm_kecamatan']; ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan" value="<?= $kec['ket_kecamatan']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="CheckBox" class="form-check form-check-inline">Aktif : </label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $kec['id_kecamatan']; ?>" value="0" <?= ($kec['flag_kec'] == 0) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="<?= $kec['id_kecamatan']; ?>">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $kec['id_kecamatan']; ?>a" value="1" <?= ($kec['flag_kec'] == 1) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="<?= $kec['id_kecamatan']; ?>a">Tidak</label>
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

<!-- Modal Add Kecamatan-->
<div class="modal fade" id="newKecModal" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Data Kecamatan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('lokasi/kecAdd'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="kab" id="kab" class="form-control" required>
                            <option value="">Pilih Kabupaten</option>
                            <?php foreach ($kabupaten as $ka) : ?>
                                <option value="<?= $ka['id_kabupaten']; ?>"><b><?= $ka['nm_kabupaten']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="kec" name="kec" placeholder="Nama Kecamatan" required title="Nama Kecamatan">
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