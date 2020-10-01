<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseSpkbibit" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSpkbibit">
        <h6 class="m-0 font-weight-bold text-primary"><i class="far fa-fw fa-list-alt"></i> Data SPK BIBIT</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseSpkbibit">
        <div class="card-body">
            <a href="" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#newSpkbibitkat" title="Tambah kategori SPK Bibit"><i class="fas fa-fw fa-plus"></i> Kategori</a>
            <a href="" class="btn btn-primary btn-sm mb-2 pl-2 pr-2" data-toggle="modal" data-target="#newSpkbibit" title="Tambah SPK Bibit"><i class="fas fa-fw fa-plus"></i> Bibit</a>
            <small>
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-bordered" id="dataTab">
                        <thead>
                            <tr align="center" class="table-active">
                                <th>No</th>
                                <th>Lokasi / Petak</th>
                                <th>Kategori Bibit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($spkbibit as $spkbi) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $spkbi['nm_kecamatan'] . ", </br> " . $spkbi['nm_desa'] . ", </br> " . $spkbi['nm_blok'] . " <b>|</b> " . $spkbi['nm_petak']; ?></td>
                                    <td colspan="2">
                                        <?php
                                        $kategori = $this->bibitkat->getBibitkatspk($spkbi['id_petak']);
                                        foreach ($kategori as $kat) {
                                        ?>
                                            <ul style="list-style-type:square" class="mb-0 scroll">
                                                <li>
                                                    <div class="row petakHov mr-0 font-weight-bold border-bottom-dark">
                                                        <div class="col-sm-5"><?= $kat['kategori']; ?></div>
                                                        <div class="col-sm-5 text-right pr-2"><?= number_format($kat['nilai_spkbibit'], 2, '.', ','); ?> <small> <?= $kat['satuan_spkbibit']; ?></small></div>
                                                        <div class="col-sm-2">
                                                            <a title="Edit Kategori" href="#" class="badge badge-info p-1 pr-2 pl-2" data-toggle="modal" data-target="#editModalSpkbibit<?= $kat['id_spkbibit']; ?>"><i class="fas fa-edit"></i></a>
                                                            <a title="hapus Kategori" href="<?= base_url('spk/delSpkbibit/') . $kat['id_spkbibit']; ?>" class="badge badge-danger p-1 pr-2 pl-2" onclick="return confirm('Anda yakin akan menghapus kategori bibit?')"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                    <ul class="mt-0">
                                                        <?php
                                                        $bibitampil = $this->bibitshow->getBibitshow($kat['id_spkbibit']);
                                                        foreach ($bibitampil as $bit) {
                                                        ?>
                                                            <li>
                                                                <div class="row petakHov mr-0">
                                                                    <div class="col-sm-7"><?= $bit['nm_bibit']; ?> </div>
                                                                    <div class="col-sm-5">
                                                                        <a title="hapus Bibit" href="<?= base_url('spk/delSpkbibitkat/') . $bit['id_bibitbantu']; ?>" class="badge badge-warning" onclick="return confirm('Anda yakin akan menghapus bibit?')">hapus</a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <!-- Modal Add Kategori SPK bibit-->
                                            <div class="modal fade" id="editModalSpkbibit<?= $kat['id_spkbibit']; ?>" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="newRoleLabel">Edit SPK bibit</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form class="user" method="post" action="<?= base_url('spk/updateSpkbibit/') . $kat['id_spkbibit']; ?>">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control form-control-sm" value="<?= $kat['kategori'] ?>" id="kategori" name="kategori" placeholder="Kategori Bibit" title="Kategori Bibit" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <select name="desa" id="desa" class="form-control form-control-sm" required title="Pilih Desa">
                                                                        <option value="">Pilih Desa</option>
                                                                        <?php foreach ($datadesa as $de) : ?>
                                                                            <option value="<?= $de['id_desa']; ?>" <?= ($de['id_desa'] == $kat['id_desa']) ? "selected" : ""; ?>><b><?= $de['nm_desa']; ?></b></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <select name="blok" class="form-control form-control-sm" required disabled title="Blok">
                                                                        <?php foreach ($blok as $bl) : ?>
                                                                            <option value="<?= $bl['id_blok']; ?>" <?= ($bl['id_blok'] == $kat['id_blok']) ? "selected" : ""; ?>><b><?= $bl['nm_blok']; ?></b></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <select name="petak" class="form-control form-control-sm" required readonly>
                                                                        <?php foreach ($petak as $ptk) : ?>
                                                                            <option value="<?= $ptk['id_petak']; ?>" <?= ($ptk['id_petak'] == $kat['id_petak']) ? "selected" : ""; ?>><b><?= $ptk['nm_petak']; ?></b></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control form-control-sm" value="<?= $kat['nilai_spkbibit'] ?>" id="nilai" name="nilai" placeholder="Nilai" title="Nilai Volume" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control form-control-sm" value="<?= $kat['satuan_spkbibit'] ?>" id="satuan" name="satuan" placeholder="Satuan" title="Satuan  Kategori" required>
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
<!-- Modal Add SPK Kategori bibit-->
<div class="modal fade" id="newSpkbibitkat" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Kategori SPK bibit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('spk/addSpkbibit'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="kategori" name="kategori" placeholder="Kategori Bibit" title="Kategori Bibit" required>
                    </div>
                    <div class="form-group">
                        <select name="desa" id="desbibit" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value="">Pilih Desa</option>
                            <?php foreach ($datadesa as $de) : ?>
                                <option value="<?= $de['id_desa']; ?>"><b><?= $de['nm_desa']; ?></b></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="blok" id="blokbibit" class="form-control form-control-sm" required title="Pilih Blok">
                            <option value=''>Pilih Desa terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="petak" id="petakbibit" class="form-control form-control-sm" required title="Pilih Petak">
                            <option value=''>Pilih Petak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="nilai" name="nilai" placeholder="0" title="Nilai Volume" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="satuan" name="satuan" placeholder="satuan" title="Satuan Kategori" required>
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

<!-- Modal Add SPK bibit-->
<div class="modal fade" id="newSpkbibit" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Bibit Berdasarkan Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="post" action="<?= base_url('spk/addSpkbibitkat'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="kategori" class="form-control form-control-sm" required title="Pilih Kategori Berdasarkan Lokasi">
                            <option value="">Pilih Kategori Berdasarkan Lokasi</option>
                            <?php foreach ($spkbibitkat as $kat) : ?>
                                <option value="<?= $kat['id_spkbibit']; ?>"><?= $kat['nm_desa'] . " <b>|</b> " . $kat['nm_blok'] . " <b>|</b> " . $kat['nm_petak'] . " <b>|</b> " . $kat['kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="bibit" class="form-control form-control-sm" required title="Pilih Kategori Berdasarkan Lokasi">
                            <option value="">Pilih Bibit</option>
                            <?php
                            foreach ($bibitnya as $bibit) : ?>
                                <option value="<?= $bibit['id_bibit']; ?>"><?= $bibit['nm_bibit']; ?></option>
                            <?php endforeach; ?>
                        </select>
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