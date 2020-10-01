<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseSpklapangan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSpklapangan">
        <h6 class="m-0 font-weight-bold text-primary"><i class="far fa-fw fa-list-alt"></i> Data SPK Lapangan</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseSpklapangan">
        <div class="card-body">
            <a href="" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#newSpklapangan"><i class="fas fa-plus"></i> Tambah</a>
            <small>
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-bordered" id="dataTabl">
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
                            foreach ($spklapangan as $spkl) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $spkl['nm_kecamatan'] . ", <br> " . $spkl['nm_desa'] . ", <br> " . $spkl['nm_blok'] . " <b>|</b> " . $spkl['nm_petak']; ?></td>
                                    <td>
                                        <ol type="1" class="mb-1 scroll">
                                            <?php
                                            $kegiatn = $this->lapang->getLapanganspkPetak($spkl['id_petak']);
                                            foreach ($kegiatn as $kegl) {
                                            ?>
                                                <li>
                                                    <div class="row petakHov m-0">
                                                        <div class="col-sm-5"><?= $kegl['nm_kegiatan']; ?></div>
                                                        <div class="col-sm-3 text-right m-0 pr-1"><?= number_format($kegl['nilai_spklapangan'], 2, '.', ','); ?></div>
                                                        <div class="col-sm-1 m-0 p-0"><small>(<?= $kegl['satuan']; ?>)</small></div>
                                                        <div class="col-sm-3 text-center">
                                                            <a href="#" class="badge badge-info p-1 m-0 pr-1 pl-1" data-toggle="modal" data-target="#editModalSpklapangan<?= $kegl['id_spklapangan']; ?>">Edit</a>
                                                            <a href="<?= base_url('spk/delSpklapangan/') . $kegl['id_spklapangan']; ?>" class="badge badge-danger m-0 p-1" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <!-- Modal Edit SPK lapangan-->
                                                <div class="modal fade" id="editModalSpklapangan<?= $kegl['id_spklapangan']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="newRoleLabel">Edit SPK Lapangan</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form class="user" method="post" action="<?= base_url('spk/updateSpklapangan/') . $kegl['id_spklapangan']; ?>">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <select name="kegiatan" id="kegiatan" class="form-control form-control-sm" required title="Pilih Desa">
                                                                            <option value="">Pilih Kegiatan</option>
                                                                            <?php foreach ($kegiatan as $kegi) : ?>
                                                                                <option value="<?= $kegi['id_kegiatan']; ?>" <?= ($kegi['id_kegiatan'] == $kegl['id_kegiatan']) ? "selected" : ""; ?>><b><?= $kegi['nm_kegiatan']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="desa" id="desa" class="form-control form-control-sm" required disabled title="Pilih Desa">
                                                                            <option value="">Pilih Desa</option>
                                                                            <?php foreach ($datadesa as $de) : ?>
                                                                                <option value="<?= $de['id_desa']; ?>" <?= ($de['id_desa'] == $kegl['id_desa']) ? "selected" : ""; ?>><b><?= $de['nm_desa']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="blok" class="form-control form-control-sm" required disabled title="Blok">
                                                                            <?php foreach ($blok as $bl) : ?>
                                                                                <option value="<?= $bl['id_blok']; ?>" <?= ($bl['id_blok'] == $kegl['id_blok']) ? "selected" : ""; ?>><b><?= $bl['nm_blok']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="petak" class="form-control form-control-sm" required title="Pilih Petak" readonly>
                                                                            <?php foreach ($petak as $ptk) : ?>
                                                                                <option value="<?= $ptk['id_petak']; ?>" <?= ($ptk['id_petak'] == $kegl['id_petak']) ? "selected" : ""; ?>><b><?= $ptk['nm_petak']; ?></b></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control form-control-sm" value="<?= $kegl['nilai_spklapangan'] ?>" id="nilai" name="nilai" placeholder="Nilai" title="Nilai Volume" required>
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
<!-- Modal Add SPK lapangan-->
<div class="modal fade" id="newSpklapangan" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah SPK LAPANGAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('spk/addSpklapangan'); ?>">
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
                        <select name="desa" id="desalap" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value="">Pilih Desa</option>
                            <?php foreach ($datadesa as $de) : ?>
                                <option value="<?= $de['id_desa']; ?>"><b><?= $de['nm_desa']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="blok" id="bloklap" class="form-control form-control-sm" required title="Pilih Blok">
                            <option value=''>Pilih Desa terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="petak" id="petaklap" class="form-control form-control-sm" required title="Pilih Petak">
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