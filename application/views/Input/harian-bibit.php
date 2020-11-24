<!-- Begin Page Content -->
<p id='er'></p>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row" style="font-family: Calibri;">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-capitalize font-weight-bold"><a href="<?= base_url('input'); ?>"><?= $title; ?></a><small class="text-info">/Pengadaan Bibit</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('input'); ?> " class="badge badge-info" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
        <div class="col-sm-12">
            <?= $this->session->flashdata('message'); ?>
            <?= $this->session->flashdata('messagegmbr'); ?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Pengawasan Pekerjaan Harian Bibit</h6>
                    </div>
                    <div class="card-body">
                        <!-- form  -->
                        <?= form_open_multipart('input/harianbibitinput'); ?>
                        <div class="form-group row ">
                            <div class="col-sm-6">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <div class="input-group my-1">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text col-form-label-sm font-weight-bold">User ID </div>
                                            </div>
                                            <input type="text" class="form-control col-md-2" id="id_user" name="id_user" value="<?= $user['id_user']; ?>" required data-toggle="tooltip" data-placement="left" title="User ID" readonly>
                                            <input type="text" class="form-control" id="" name="" value="<?= $user['nm_user']; ?>" required data-toggle="tooltip" data-placement="left" title="User ID" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Petugas Lapangan</div>
                                            </div>
                                            <input type="text" class="form-control" id="petugas" name="petugas" placeholder="Nama" required data-toggle="tooltip" data-placement="left" title="Nama  Petugas Lapangan">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Kabupaten</div>
                                            </div>
                                            <select name="kabupat" id="kabupat" class="form-control col-md-12" required data-toggle="tooltip" data-placement="left" title="Pilih Kabupaten">
                                                <option value="">Pilih Kabupaten</option>
                                                <?php foreach ($kabupaten as $ka) : ?>
                                                    <option value="<?= $ka['id_kabupaten']; ?>"><b><?= $ka['nm_kabupaten']; ?></b></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Kecamatan</div>
                                            </div>
                                            <select name="kecamat" id="kecamat" class="form-control" required data-toggle="tooltip" data-placement="left" title="Pilih Kecamatan">
                                                <option value=''>Pilih Kabupaten Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Desa</div>
                                            </div>
                                            <select name="deselect" id="deselect" class="form-control" required data-toggle="tooltip" data-placement="left" title="Pilih Desa">
                                                <option value=''>Pilih Kecamatan Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Blok</div>
                                            </div>
                                            <select name="blok" id="blok" class="form-control" required data-toggle="tooltip" data-placement="left" title="Pilih Blok">
                                                <option value=''>Pilih Desa Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Petak</div>
                                            </div>
                                            <select name="petak" id="petak" onchange="getJenisbibit()" class="form-control" required data-toggle="tooltip" data-placement="left" title="Pilih Petak">
                                                <option value=''>Pilih Blok Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-row align-items-center" data-toggle="tooltip" data-placement="left" title="Pilih Kategori Bibit">
                                    <div class="col-sm-12 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Jenis Bibit</div>
                                            </div>
                                            <select name="jenisbibit" id="jenisbibit" onchange="getBibit()" class="form-control" required>
                                                <option value=''>Pilih Petak Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center" data-toggle="tooltip" data-placement="left" title="Pilih Bibit">
                                    <div class="col-sm-12 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Nama Bibit</div>
                                            </div>
                                            <select name="bibit" id="bibit" onchange="getSatuan()" class="form-control" required>
                                                <option value=''>Pilih Jenis Bibit Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center" data-toggle="tooltip" data-placement="left" title="Nilai Volume Kegiatan Pengawasan">
                                    <div class="col-sm-12 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">Nilai Volume</div>
                                            </div>
                                            <input type="text" class="form-control" id="volume" name="volume" placeholder="0" required>
                                            <div class="input-group-prepend" id="satuan">
                                                <div class="input-group-text font-weight-bold" id="isisatuan"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-1">
                                    <input type="text" class="form-control" id="koordinat" name="koordinat" placeholder="koordinat" data-toggle="tooltip" data-placement="left" title="Koordinat">
                                </div>
                                <div class="form-group mb-1">
                                    <textarea name="ket" id="ket" class="form-control" data-toggle="tooltip" data-placement="left" title="Keterangan" placeholder="Keterangan"></textarea>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 mb-1">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="luas" name="luas" placeholder="luas" required data-toggle="tooltip" data-placement="left" title="Luas">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold">&nbsp; Ha</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center" data-toggle="tooltip" data-placement="left" title="Tanggal pelaksanaan pengawasan">
                                    <div class="col-auto">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-sm font-weight-bold">Tanggal Pengawasan </div>
                                            </div>
                                            <?php
                                            $today = date('Y-m-d');
                                            ?>
                                            <input type="date" max="<?= $today; ?>" class="form-control" id="tgl_pengawasan" name="tgl_pengawasan" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="video" class="col-sm-2 col-form-label">File Foto</label>
                                <div class="col-sm-10">
                                    <input onchange="ValidateSize(this)" type="file" class="custom-file-input form-control-sm " id="foto" name="foto" required data-toggle="tooltip" data-placement="left" title="Foto pengawasan">
                                    <label for="foto" class="custom-file-label form-control-sm">Choose File</label>
                                    <small class="text-danger ml-0">*ekstensi file .jpeg/.jpg/.png/.gif | maksimal ukuran 1Mb</small>
                                </div>
                            </div>
                        </div>
                        <div class=" modal-footer">
                            <button type="submit" class="btn btn-primary btn-lg pl-5 pr-5 font-weight-bold" onclick="return confirm('Pastikan semua data yang dimasukkan sudah benar?')">Kirim</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
    $(document).ready(function() {

    });

    function getJenisbibit() {
        var IdPetak = $("#petak").val();
        $.ajax({
            url: "<?= base_url('input/bibitjenisAjax'); ?>",
            method: "POST",
            data: {
                id: IdPetak
            },
            async: true,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var html = "<option value=''>Pilih Jenis Bibit</option>";
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].id_spkbibit + '>' + data[i].kategori + '</option>';
                }
                $('#jenisbibit').html(html);
            },
            error: function(er) {
                console.log(er);
                $("#er").html(er['responseText']);
            }
        });
    }

    function getBibit() {
        var IdPetak = $("#jenisbibit").val();
        $.ajax({
            url: "<?= base_url('input/bibitAjax'); ?>",
            method: "POST",
            data: {
                id: IdPetak
            },
            async: true,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var html = "<option value=''>Pilih Bibit</option>";
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].id_bibit + '>' + data[i].nm_bibit + '</option>';
                }
                $('#bibit').html(html);
            },
            error: function(er) {
                console.log(er);
                $("#er").html(er['responseText']);
            }
        });
    }

    $("#satuan").hide();

    function getSatuan() {
        var KegLap = $("#bibit").val();
        $.ajax({
            url: "<?= base_url('input/bibitSatuanAjax'); ?>",
            method: "POST",
            data: {
                id: KegLap
            },
            async: true,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var html = data['satuan'] + "&nbsp;";
                $("#satuan").show();
                $('#isisatuan').html(html);
            },
            error: function(er) {
                console.log(er);
                $("#er").html(er['responseText']);
            }
        });
    }
</script>