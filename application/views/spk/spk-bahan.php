<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseSpkBahan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSpkBahan">
        <h6 class="m-0 font-weight-bold text-primary"><i class="far fa-fw fa-list-alt"></i> Data SPK Bahan</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseSpkBahan">
        <div class="card-body">
            <a href="" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#newSpkbahan"><i class="fas fa-plus"></i> Tambah</a>
            <small>
                <div class="table-responsive m-0">
                    <table class="table table-hover table-sm table-bordered m-0" id="dataTable">
                        <thead>
                            <tr align="center" class="table-active">
                                <th>No</th>
                                <th>Lokasi/Petak</th>
                                <th>Nama Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($spkbahan as $spk) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $spk['nm_kecamatan'] . ", </br> " . $spk['nm_desa'] . ", </br> " . $spk['nm_blok'] . " <b>|</b> " . $spk['nm_petak']; ?></td>
                                    <td>
                                        <ol type="1" class="m-0 mb-1 scroll">
                                            <?php
                                            $kegia = $this->bahana->getBahanspkPetak($spk['id_petak']);
                                            foreach ($kegia as $keg) {
                                            ?>
                                                <li>
                                                    <div class="row petakHov m-0">
                                                        <div class="col-sm-5"><?= $keg['nm_kegiatan']; ?></div>
                                                        <div class="col-sm-3 text-right m-0 pr-1"><?= number_format($keg['nilai_spkbahan'], 2, '.', ','); ?></div>
                                                        <div class="col-sm-1 m-0 p-0"><small>(<?= $keg['satuan']; ?>)</small></div>
                                                        <div class="col-sm-3 text-center">
                                                            <a href="#" class="badge badge-info p-1 m-0 " data-toggle="modal" data-target="#editModalSpkbahan<?= $keg['id_spkbahan']; ?>">Edit</a>
                                                            <a href="<?= base_url('spk/delSpkbahan/') . $keg['id_spkbahan']; ?>" class="badge badge-danger m-0 p-1" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <!-- Modal Edit SPK Bahan-->
                                                <div class="modal fade" id="editModalSpkbahan<?= $keg['id_spkbahan']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="newRoleLabel">Edit SPK BAHAN</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form class="user" method="post" action="<?= base_url('spk/updateSpkbahan/') . $keg['id_spkbahan']; ?>">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <select name="kegiatan" id="kegiatan" class="form-control form-control-sm" required title="Pilih Desa">
                                                                            <option value="">Pilih Kegiatan</option>
                                                                            <?php foreach ($kegiatan as $kegi) : ?>
                                                                                <option value="<?= $kegi['id_kegiatan']; ?>" <?= ($kegi['id_kegiatan'] == $keg['id_kegiatan']) ? "selected" : ""; ?>><b><?= $kegi['nm_kegiatan']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="desa" id="desa" class="form-control form-control-sm" required title="Pilih Desa" disabled>
                                                                            <option value="">Pilih Desa</option>
                                                                            <?php foreach ($datadesa as $de) : ?>
                                                                                <option value="<?= $de['id_desa']; ?>" <?= ($de['id_desa'] == $keg['id_desa']) ? "selected" : ""; ?>><b><?= $de['nm_desa']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="blok" class="form-control form-control-sm" required disabled title="Blok">
                                                                            <?php foreach ($blok as $bl) : ?>
                                                                                <option value="<?= $bl['id_blok']; ?>" <?= ($bl['id_blok'] == $keg['id_blok']) ? "selected" : ""; ?>><b><?= $bl['nm_blok']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="petak" class="form-control form-control-sm" required title="Pilih Petak" readonly>
                                                                            <?php foreach ($petak as $ptk) : ?>
                                                                                <option value="<?= $ptk['id_petak']; ?>" <?= ($ptk['id_petak'] == $keg['id_petak']) ? "selected" : ""; ?>><b><?= $ptk['nm_petak']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control form-control-sm" value="<?= $keg['nilai_spkbahan'] ?>" id="nilai" name="nilai" placeholder="Nilai" title="Nilai Volume" required>
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
                    </table>
                </div>
            </small>
        </div>
    </div>
</div>
<!-- Modal Add SPK Bahan-->
<div class="modal fade" id="newSpkbahan" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah SPK BAHAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('spk/addSpkbahan'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="kegiatan" id="kegiatan" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value="">Pilih Kegiatan</option>
                            <?php foreach ($kegiatan as $kegi) : ?>
                                <option value="<?= $kegi['id_kegiatan']; ?>"><b><?= $kegi['nm_kegiatan']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="desa" id="deselect" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value="">Pilih Desa</option>
                            <?php foreach ($datadesa as $de) : ?>
                                <option value="<?= $de['id_desa']; ?>"><b><?= $de['nm_desa']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="blok" id="blok" class="form-control form-control-sm" required title="Pilih Blok">
                            <option value=''>Pilih Desa terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="petak" id="petak" class="form-control form-control-sm" required title="Pilih Petak">
                            <option value=''>Pilih Petak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="nilai" name="nilai" placeholder="0" title="Nilai Volume" required>
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