<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardDesa" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardDesa">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-check-square"></i> Data Desa</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse hide" id="collapseCardDesa">
        <div class="card-body">
            <h6 class="mb-2 font-weight-bold text-primary">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newDesaModal"><i class="fas fa-plus"></i> Tambah Desa</a>
            </h6>
            <small>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTableDes" width="100%" cellspacing="0">
                        <thead class="table-active">
                            <tr align="center">
                                <th scope="col">#</th>
                                <th scope="col">Kabupaten</th>
                                <th scope="col">Kecamatan/Desa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $qkab = $this->db->get('dt_kabupaten')->result_array();
                            $no = 1; //Tampilkan data Kabupaten
                            foreach ($qkab as $kab) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $kab['nm_kabupaten']; ?></td>
                                    <td>
                                        <ol type="1">
                                            <?php //Tampilkan Data kecamatan Berdasarkan Kabupatennya
                                            $qkec = $this->db->get_where('dt_kecamatan', ['id_kabupaten' => $kab['id_kabupaten']])->result_array();
                                            foreach ($qkec as $kec) { ?>
                                                <li>
                                                    <b>Kec </b> <?= $kec['nm_kecamatan']; ?> :
                                                    <ul type="arrow">
                                                        <table class="table table-borderless table-hover table-sm">
                                                            <?php //Tampilkan Desa berdasarkan kecamatan
                                                            $qdes = $this->db->get_where('dt_desa', ['id_kecamatan' => $kec['id_kecamatan']])->result_array();
                                                            foreach ($qdes as $des) { ?>
                                                                <tr>
                                                                    <td width="70%">
                                                                        <li title="<?= $des['ket_desa']; ?>" <?= ($des['flag_des'] == 0) ? "class='text-success'" : "class='text-danger'"; ?>>
                                                                            <b>Desa </b><?= $des['nm_desa']; ?>
                                                                        </li>
                                                                    </td>
                                                                    <td width="30%" class="text-center">
                                                                        <a href="#" class="badge badge-info p-1 m-0 pr-2 pl-2" data-toggle="modal" data-target="#editModalDes<?= $des['id_desa']; ?>">Edit</a>
                                                                        <a href="<?= base_url('lokasi/desDel/') . $des['id_desa']; ?>" class="badge badge-danger  m-0 p-1" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                                                    </td>
                                                                </tr>

                                                                <!-- Modal Edit -->
                                                                <div class="modal fade" id="editModalDes<?= $des['id_desa']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="newRoleLabel">Edit Data Desa <b><?= $des['nm_desa']; ?></b></h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form method="post" action="<?= base_url('lokasi/desEdit/') . $des['id_desa']; ?>">
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <select name="kabuE" id="kabuE" class="form-control" required disabled>
                                                                                            <?php foreach ($kabupaten as $ka) : ?>
                                                                                                <?php $pilih = ($ka['nm_kabupaten'] == $kab['nm_kabupaten']) ? "selected" : ""; ?>
                                                                                                <option value="<?= $ka['id_kabupaten']; ?>" <?= $pilih; ?>><b><?= $ka['nm_kabupaten']; ?></b></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <select name="kecaE" id="kecaE" class="form-control" required title="Pilih Kecamatan">
                                                                                            <option value=''>Pilih Kecamatan</option>
                                                                                            <?php
                                                                                            // Query Kecamatan berdasarkan apa $ka['id_kabupaten'] nya di array ini
                                                                                            $where = [
                                                                                                'id_kabupaten' => $kab['id_kabupaten']
                                                                                            ];
                                                                                            $dataKec = $this->db->get_where('dt_kecamatan', $where)->result_array();
                                                                                            ?>
                                                                                            <?php foreach ($dataKec as $kac) : ?>
                                                                                                <?php $pilih = ($kac['nm_kecamatan'] == $kec['nm_kecamatan']) ? "selected" : ""; ?>
                                                                                                <option value="<?= $kac['id_kecamatan']; ?>" <?= $pilih; ?>><b><?= $kac['nm_kecamatan']; ?></b></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="desa" name="desa" placeholder="Nama Desa" value="<?= $des['nm_desa']; ?>" required title="Nama Desa">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan" title="Keterangan" value="<?= $des['ket_desa']; ?>">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="CheckBox" class="form-check form-check-inline">Aktif : </label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $des['id_desa']; ?>" value="0" <?= ($des['flag_des'] == 0) ? "checked" : ""; ?>>
                                                                                            <label class="form-check-label" for="<?= $des['id_desa']; ?>">Ya</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="flag" id="<?= $des['id_desa']; ?>a" value="1" <?= ($des['flag_des'] == 1) ? "checked" : ""; ?>>
                                                                                            <label class="form-check-label" for="<?= $des['id_desa']; ?>a">Tidak</label>
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
                                                        </table>
                                                    </ul>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ol>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot class="table-active">
                            <tr>
                                <th colspan="2" class="text-right text-bold">Flag Desa :</th>
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

<!-- Modal Add Desa-->
<div class="modal fade" id="newDesaModal" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Data Desa Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('lokasi/desAdd'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="kabu" id="kabu" class="form-control" required title="Pilih Kabupaten">
                            <option value="">Pilih Kabupaten</option>
                            <?php foreach ($kabupaten as $ka) : ?>
                                <option value="<?= $ka['id_kabupaten']; ?>"><b><?= $ka['nm_kabupaten']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="keca" id="keca" class="form-control" required title="Pilih Kecamatan">
                            <option value=''>Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="desa" name="desa" placeholder="Nama Desa" required title="Nama Kecamatan">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan" title="Keterangan">
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