<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardBlok" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardBlok">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-check-square"></i> Data Blok</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse hide" id="collapseCardBlok">
        <div class="card-body">
            <h6 class="mb-2 font-weight-bold text-primary">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newBlok"><i class="fas fa-plus"></i> Tambah Blok</a>
                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newPetak"><i class="fas fa-plus"></i> Tambah Petak</a>
            </h6>
            <small>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover" id="dataTableBlok">
                        <thead class="table-active">
                            <tr align="center">
                                <th scope="col">No</th>
                                <th scope="col">Desa</th>
                                <th scope="col">Nama Blok/Petak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $qdesa = $this->db->get('dt_desa')->result_array();
                            foreach ($qdesa as $desa) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $desa['nm_desa']; ?></td>
                                    <td>
                                        <ul style="list-style-type:square">
                                            <?php
                                            $qblok = $this->db->get_where('tb_blok', ['id_desa' => $desa['id_desa']])->result_array();
                                            foreach ($qblok as $blok) {
                                                $qpetak = $this->db->get_where('tb_petak', ['id_blok' => $blok['id_blok']])->result_array();
                                            ?>
                                                <li title="<?= $blok['ket_blok']; ?>">
                                                    <div class="row petakHov mb-1 mr-2 <?= ($blok['flag_blok'] == 0) ? "text-success border-bottom-success" : "text-danger border-bottom-danger"; ?>">
                                                        <div class="col-sm-8 mb-0">
                                                            <b><?= $blok['nm_blok']; ?> &nbsp; | &nbsp; <?= $blok['luas']; ?> Ha </b>
                                                        </div>
                                                        <div class="col-sm-4 text-right">
                                                            <div class="dropdown no-arrow">
                                                                <a href="#collapseCardPetak<?= $blok['id_blok']; ?>" class="badge badge-warning p-1 m-0 mb-1 mr-1" title="Lihat Petak" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardPetak<?= $blok['id_blok']; ?>">
                                                                    Lihat Petak
                                                                </a>
                                                                <a class="dropdown-toggle btn btn-sm btn-info p-0 m-0 mr-1" title="Aksi <?= $blok['nm_blok']; ?>!" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                                    <div class="dropdown-header mt-0 mb-0 pt-0 pt-0">Action <?= $blok['nm_blok']; ?> :</div>
                                                                    <div class="dropdown-divider mt-0 mb-0"></div>
                                                                    <a href="#" class="dropdown-item text-success" data-toggle="modal" title="Edit data <?= $blok['nm_blok']; ?>" data-target="#editModalBlok<?= $blok['id_blok']; ?>">Edit</a>
                                                                    <a href="<?= base_url('lokasi/blokDel/') . $blok['id_blok']; ?>" title="Hapus data <?= $blok['nm_blok']; ?>" class="dropdown-item text-danger" onclick="return confirm('Are you sure delete this Blok?')">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal Edit Blok-->
                                                    <?php
                                                    $detblok = $this->blok->getBlok($blok['id_blok']);
                                                    ?>
                                                    <div class="modal fade" id="editModalBlok<?= $blok['id_blok']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="newRoleLabel">Edit Blok</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form class="user" method="post" action="<?= base_url('lokasi/blokUpdate/') . $blok['id_blok']; ?>">
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <select name="kabupat" id="" class="form-control form-control-sm" required title="Pilih Kabupaten" disabled>
                                                                                <?php foreach ($kabupaten as $ka) : ?>
                                                                                    <?php $pilih = ($ka['nm_kabupaten'] == $detblok['nm_kabupaten']) ? "selected" : ""; ?>
                                                                                    <option value="<?= $ka['id_kabupaten']; ?>" <?= $pilih; ?>><b><?= $ka['nm_kabupaten']; ?></b></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <select name="kecamat" id="" class="form-control form-control-sm" required title="Pilih Kecamatan" disabled>
                                                                                <?php foreach ($kecamatan as $kec) : ?>
                                                                                    <?php $pilih = ($kec['nm_kecamatan'] == $detblok['nm_kecamatan']) ? "selected" : ""; ?>
                                                                                    <option value="<?= $kec['id_kecamatan']; ?>" <?= $pilih; ?>><b><?= $kec['nm_kecamatan']; ?></b></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <select name="deselect" id="" class="form-control form-control-sm" required title="Pilih Desa">
                                                                                <?php foreach ($datadesa as $des) : ?>
                                                                                    <?php $pilih = ($des['nm_desa'] == $detblok['nm_desa']) ? "selected" : ""; ?>
                                                                                    <option value="<?= $des['id_desa']; ?>" <?= $pilih; ?>><b><?= $des['nm_desa']; ?></b></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <select name="blok" id="blok" class="form-control form-control-sm" required title="Pilih Blok">
                                                                                <option value=''>Pilih Blok</option>
                                                                                <option value='Blok 1' <?= ($blok['nm_blok'] == "Blok 1") ? "selected" : ""; ?>> Blok 1</option>
                                                                                <option value='Blok 2' <?= ($blok['nm_blok'] == "Blok 2") ? "selected" : ""; ?>> Blok 2</option>
                                                                                <option value='Blok 3' <?= ($blok['nm_blok'] == "Blok 3") ? "selected" : ""; ?>> Blok 3</option>
                                                                                <option value='Blok 4' <?= ($blok['nm_blok'] == "Blok 4") ? "selected" : ""; ?>> Blok 4</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input type="number" class="form-control form-control-sm" value="<?= $blok['luas']; ?>" id="luas" name="luas" placeholder="Luas(Ha)" required title="Luas Area Blok">
                                                                                <div class="input-group-prepend input-group-sm input-sm">
                                                                                    <div class="input-group-text text-sm p-0 pl-3 pr-3">Ha</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control form-control-sm" id="ket" value="<?= $blok['ket_blok']; ?>" name="ket" placeholder="Keterangan" required title="Keterangan">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="CheckBox" class="form-check form-check-inline">Aktif : </label>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="flag" id="<?= $blok['id_blok']; ?>" value="0" <?= ($blok['flag_blok'] == 0) ? "checked" : ""; ?>>
                                                                                <label class="form-check-label" for="<?= $blok['id_blok']; ?>">Ya</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="flag" id="<?= $blok['id_blok']; ?>a" value="1" <?= ($blok['flag_blok'] == 1) ? "checked" : ""; ?>>
                                                                                <label class="form-check-label" for="<?= $blok['id_blok']; ?>a">Tidak</label>
                                                                            </div>
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
                                                    <!-- end modal edit Blok -->
                                                    <ul style="list-style-type:circle" class="collapse hide" id="collapseCardPetak<?= $blok['id_blok']; ?>">
                                                        <table class="table table-borderless table-hover p-0">
                                                            <?php
                                                            foreach ($qpetak as $petak) {
                                                            ?>
                                                                <tr <?= ($petak['flag_petak'] == 0) ? "class='text-success'" : "class='text-danger'"; ?> title="<?= $petak['ket_petak']; ?>">
                                                                    <td>
                                                                        <li><?= $petak['nm_petak']; ?></li>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a href="<?= base_url('lokasi/petakDel/') . $petak['id_petak']; ?>" class="badge mr-4" onclick="return confirm('Are you sure delete this Petak?')" title="Hapus <?= $petak['nm_petak']; ?>?">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </table>
                                                    </ul>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot class="table-active">
                            <tr>
                                <th colspan="2" class="text-right text-bold">Flag :</th>
                                <th>
                                    <ul>
                                        <li class="text-success">Enabled</li>
                                        <li class="text-danger">Disabled</li>
                                    </ul>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </small>
        </div>
    </div>
</div>


<!-- Modal Add Blok-->
<div class="modal fade" id="newBlok" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Blok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('lokasi/addBlok'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="kabupat" id="kabAjx" class="form-control form-control-sm" required title="Pilih Kabupaten">
                            <option value="">Pilih Kabupaten</option>
                            <?php foreach ($kabupaten as $ka) : ?>
                                <option value="<?= $ka['id_kabupaten']; ?>"><b><?= $ka['nm_kabupaten']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="kecamat" id="kecAjx" class="form-control form-control-sm" required title="Pilih Kecamatan">
                            <option value=''>Pilih Kabupaten terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="deselect" id="desAjax" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value=''>Pilih Kecamatan terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="blok" id="blok" class="form-control form-control-sm" required title="Pilih Tambah Blok">
                            <option value=''>Tambah Blok</option>
                            <option value='Blok 1'> Blok 1</option>
                            <option value='Blok 2'> Blok 2</option>
                            <option value='Blok 3'> Blok 3</option>
                            <option value='Blok 4'> Blok 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="luas" name="luas" placeholder="Luas(Ha)" required title="Luas Area Blok">
                            <div class="input-group-prepend input-group-sm input-sm">
                                <div class="input-group-text text-sm p-0 pl-3 pr-3">Ha</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="ket" name="ket" placeholder="Keterangan" required title="Keterangan">
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
<!-- Modal Add Petak-->
<div class="modal fade" id="newPetak" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Petak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('lokasi/addPetak'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="desa" id="desaBlokAjax" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value="">Pilih Desa</option>
                            <?php foreach ($datadesa as $de) : ?>
                                <option value="<?= $de['id_desa']; ?>"><b><?= $de['nm_desa']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="blok" id="blokAjax" class="form-control form-control-sm" required title="Pilih Blok">
                            <option value=''>Pilih Desa terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="petak" id="petak" class="form-control form-control-sm" required title="Pilih Petak">
                            <option value=''>Pilih Petak</option>
                            <option value='Petak 1'> Petak 1</option>
                            <option value='Petak 2'> Petak 2</option>
                            <option value='Petak 3'> Petak 3</option>
                            <option value='Petak 4'> Petak 4</option>
                            <option value='Petak 5'> Petak 5</option>
                            <option value='Petak 6'> Petak 6</option>
                            <option value='Petak 7'> Petak 7</option>
                            <option value='Petak 8'> Petak 8</option>
                            <option value='Petak 9'> Petak 9</option>
                            <option value='Petak 10'> Petak 10</option>
                            <option value='Petak 11'> Petak 11</option>
                            <option value='Petak 12'> Petak 12</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="ket" name="ket" placeholder="Keterangan" title="Keterangan">
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