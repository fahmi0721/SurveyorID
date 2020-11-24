<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-capitalize font-weight-bold"><a href="<?= base_url('spk'); ?>"><?= $title; ?></a><small class="text-info">/SPK Bahan</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('spk'); ?> " class="btn btn-warning" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left"></i> kembali</a>
        </div>
        <div class="col-sm-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div id="cruddata">
    </div>
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
                    <div class="table-responsive m-0" id="tampildata">
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
                                        <td>Kab. <?= $spk['nm_kabupaten'] . "<br> Kec. " . $spk['nm_kecamatan'] . ", </br>Desa. " . $spk['nm_desa'] . ", </br> " . $spk['nm_blok'] . " <b>|</b> " . $spk['nm_petak']; ?></td>
                                        <td>
                                            <ol type="1" class="m-0 mb-1">
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
                                                                <a href="#" class="badge badge-info p-1 m-0 edit" data-idptk="<?= $spk['id_petak']; ?> " data-idspk="<?= $keg['id_spkbahan']; ?>">Edit</a>
                                                                <a href="<?= base_url('spk/delSpkbahan/') . $keg['id_spkbahan']; ?>" class="badge badge-danger m-0 p-1" onclick="return confirm('Are you sure delete this data?')">Delete</a>
                                                            </div>
                                                        </div>
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
                        <select name="kegiatan" id="kegiatan" class="form-control form-control-sm" required title="Pilih Desa">
                            <option value="">Pilih Kegiatan</option>
                            <?php foreach ($kegiatan as $kegi) : ?>
                                <option value="<?= $kegi['id_kegiatan']; ?>"><b><?= $kegi['nm_kegiatan']; ?></b></option>
                            <?php endforeach; ?>
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
<script>
    //Memunculkan modal edit
    $("#cruddata").hide();
    $("#tampildata").on("click", ".edit", function() {
        var idPtk = $(this).data("idptk");
        var idSpk = $(this).data("idspk");
        // alert(idPtk + idSpk);
        $.ajax({
            url: '<?= base_url('spk/spkbahanedit'); ?> ',
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