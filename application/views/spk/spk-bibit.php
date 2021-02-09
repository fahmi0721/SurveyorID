<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-capitalize font-weight-bold"><a href="<?= base_url('spk'); ?>"><?= $title; ?></a><small class="text-info">/SPK Bibit</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('spk'); ?> " class="btn btn-warning" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left"></i> kembali</a>
        </div>
        <div class="col-sm-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div id="cruddata"></div>
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
                    <div class="table-responsive m-0" id="tampildata">
                        <table class="table table-hover table-sm table-bordered m-0" id="dataTab">
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
                                        <td>Kabupaten <?= $spkbi['nm_kabupaten'] . ", </br>Kec. " . $spkbi['nm_kecamatan'] . ", </br>Desa. " . $spkbi['nm_desa'] . ", </br> " . $spkbi['nm_blok'] . " <b>|</b> " . $spkbi['nm_petak']; ?></td>
                                        <td colspan="2">
                                            <div class="row m-0 p-0">
                                                <?php
                                                $kategori = $this->bibitkat->getBibitkatspk($spkbi['id_petak']);
                                                foreach ($kategori as $kat) {
                                                ?>
                                                    <div class="col-lg-6 petakHov">
                                                        <ul style="list-style-type:square" class="m-0 mb-1">
                                                            <li>
                                                                <div class="row col-lg-12 m-0 font-weight-bold border-bottom-success">
                                                                    <div class="col-sm-5"><?= $kat['kategori']; ?></div>
                                                                    <div class="col-sm-5 text-right pr-2"><?= number_format($kat['nilai_spkbibit'], 2, '.', ','); ?> <small> <?= $kat['satuan_spkbibit']; ?></small></div>
                                                                    <div class="col-sm-2">
                                                                        <a title="Edit Kategori" href="#" class="badge badge-info p-1 pr-2 pl-2 edit" data-idptk="<?= $spkbi['id_petak']; ?>" data-idspk="<?= $kat['id_spkbibit']; ?>"><i class="fas fa-edit"></i></a>
                                                                        <a title="hapus Kategori" href="<?= base_url('spk/delSpkbibit/') . $kat['id_spkbibit']; ?>" class="badge badge-danger p-1 pr-2 pl-2" onclick="return confirm('Anda yakin akan menghapus kategori bibit?')"><i class="fas fa-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                                <ul class="mt-0">
                                                                    <?php
                                                                    $bibitampil = $this->bibitshow->getBibitshow($kat['id_spkbibit']);
                                                                    foreach ($bibitampil as $bit) {
                                                                    ?>
                                                                        <li>
                                                                            <div class="row hovbg m-0">
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
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>

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
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
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
                        <input type="text" class="form-control form-control-sm" id="kategori" name="kategori" placeholder="Kategori Bibit" title="Kategori Bibit" required>
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
<script>
    //Memunculkan modal edit
    $("#cruddata").hide();
    $("#tampildata").on("click", ".edit", function() {
        var idPtk = $(this).data("idptk");
        var idSpk = $(this).data("idspk");
        // alert(idPtk + "-" + idSpk);
        $.ajax({
            url: '<?= base_url('spk/spkbibitedit'); ?> ',
            type: 'post',
            data: {
                idPtk: idPtk,
                idSpk: idSpk
            },
            success: function(msg) {
                $("#cruddata").hide().fadeIn(2000).html(msg);
            }
        });
    });

    $("#cruddata").on("click", "#batal", function() {
        $("#cruddata").fadeOut(500);
    });

    $(document).ready(function() {

    })
</script>