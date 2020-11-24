<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-capitalize font-weight-bold"><a href="<?= base_url('spk'); ?>"><?= $title; ?></a><small class="text-info">/SPK Lapangan</small></h1>
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
        <a href="#collapseSpklapangan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSpklapangan">
            <h6 class="m-0 font-weight-bold text-primary"><i class="far fa-fw fa-list-alt"></i> Data SPK Lapangan</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseSpklapangan">
            <div class="card-body">
                <a href="" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#newSpklapangan"><i class="fas fa-plus"></i> Tambah</a>
                <small>
                    <div class="table-responsive" id="tampildata">
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
                                        <td class="font-weight-bold">Kab. <?= $spkl['nm_kabupaten'] . ",<br>Kec. " . $spkl['nm_kecamatan'] . ", <br>Desa " . $spkl['nm_desa'] . ", <br> " . $spkl['nm_blok'] . " <b>|</b> " . $spkl['nm_petak']; ?></td>
                                        <td>
                                            <ol type="1" class="mb-1">
                                                <?php
                                                $kegiatn = $this->lapang->getLapanganspkPetak($spkl['id_petak']);
                                                foreach ($kegiatn as $kegl) {
                                                ?>
                                                    <li>
                                                        <div class="row petakHov m-0">
                                                            <div class="col-sm-5"><?= $kegl['nm_kegiatan']; ?></div>
                                                            <div class="col-sm-3 text-right m-0 pr-1">
                                                                <b class="<?php if ($kegl['satuan'] == "Ha") {
                                                                                echo ($kegl['nilai_spklapangan'] != $spkl['luas_petak']) ? "berkedip text-danger" : "";
                                                                            } ?>">
                                                                    <?= number_format($kegl['nilai_spklapangan'], 2, '.', ','); ?>
                                                                </b>
                                                            </div>
                                                            <div class="col-sm-1 m-0 p-0"><small>(<?= ($kegl['satuan'] == "Ha") ? $spkl['luas_petak'] : ""; ?><?= $kegl['satuan']; ?>)</small></div>
                                                            <div class="col-sm-3 text-center">
                                                                <a href="#" class="badge badge-info p-1 m-0 edit" data-idptk="<?= $spkl['id_petak']; ?>" data-idspk="<?= $kegl['id_spklapangan']; ?>">Edit</a>
                                                                <a href="<?= base_url('spk/delSpklapangan/') . $kegl['id_spklapangan']; ?>" class="badge badge-danger m-0 p-1" onclick="return confirm('Are you sure delete this data?')">Delete</a>
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
                        <div class="form-row align-items-center">
                            <div class="col-sm-12 mb-2">
                                <div class="input-group input-group-sm">
                                    <select name="petak" id="petaklap" onchange="getPetak()" class="form-control form-control-sm" required title="Pilih Petak">
                                        <option value=''>Pilih Petak</option>
                                    </select>
                                    <div class="input-group-prepend" id="luaspetak">
                                        <div class="input-group-text font-weight-bold"><b id="nilainya"></b> Ha</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-1">
                            <select name="kegiatan" id="kegiatan" class="form-control form-control-sm" required title="Pilih Desa">
                                <option value="">Pilih Kegiatan</option>
                                <?php foreach ($kegiatan as $kegi) : ?>
                                    <option value="<?= $kegi['id_kegiatan']; ?>"><?= ($kegi['satuan'] == "Ha") ? $kegi['satuan'] . " | " : ""; ?> <b><?= $kegi['nm_kegiatan']; ?></b></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="col-sm-12 my-2">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-weight-bold">Nilai Volume Pengawasan Lapangan</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="nilai" name="nilai" placeholder="0" title="Nilai Volume" required>
                                </div>
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    $("#luaspetak").hide();

    function getPetak() {
        var IdPetak = $("#petaklap").val();
        $.ajax({
            url: "<?= base_url('spk/bahanHarianAjax'); ?>",
            method: "POST",
            data: {
                id: IdPetak
            },
            async: true,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var html = data['luas_petak'] + "&nbsp;";
                $("#luaspetak").show();
                $('#nilainya').html(html);
            },
            error: function(er) {
                console.log(er);
                $("#er").html(er['responseText']);
            }
        });
    }

    //Memunculkan modal edit
    $("#cruddata").hide();
    $("#tampildata").on("click", ".edit", function() {
        var idPtk = $(this).data("idptk");
        var idSpk = $(this).data("idspk");
        // alert(idPtk + "-" + idSpk);
        $.ajax({
            url: '<?= base_url('spk/spklapanganedit'); ?> ',
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

    setInterval(function() {
        $(".berkedip").toggle();
    }, 500);
</script>