<!-- Begin Page Content -->
<p id='er'></p>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row" style="font-family: Calibri;">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-capitalize font-weight-bold"><a href="<?= base_url('input'); ?>"><?= $title; ?></a><small class="text-info">/Pengadaan Bibit (Tahap I)</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('input'); ?> " class="btn btn-sm btn-info" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
        <div class="col-sm-12">
            <?= $this->session->flashdata('message'); ?>
            <?= $this->session->flashdata('messagegmbr'); ?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Pengawasan Pekerjaan Harian Bibit (Tahap I)</h6>
                    </div>
                    <div class="card-body">
                        <!-- form  -->
                        <?= form_open_multipart('input/harianbibitinputpertama'); ?>
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
                                                <div class="input-group-text font-weight-bold"><span class="text-danger pr-1">*</span> Petugas Lapangan</div>
                                            </div>
                                            <input type="text" class="form-control" id="petugas" name="petugas" placeholder="Nama" required data-toggle="tooltip" data-placement="left" title="Nama  Petugas Lapangan">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold"><span class="text-danger pr-1">*</span> Kabupaten</div>
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
                                            <select name="kecamat" id="kecamat" class="form-control" data-toggle="tooltip" data-placement="left" title="Pilih Kecamatan">
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
                                            <select name="deselect" id="deselect" class="form-control" data-toggle="tooltip" data-placement="left" title="Pilih Desa">
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
                                            <select name="blok" id="blok" class="form-control" data-toggle="tooltip" data-placement="left" title="Pilih Blok">
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
                                            <select name="petak" id="petak" onchange="getbibit()" class="form-control" data-toggle="tooltip" data-placement="left" title="Pilih Petak">
                                                <option value=''>Pilih Blok Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-row align-items-center" data-toggle="tooltip" data-placement="left" title="Pilih Bibit">
                                    <div class="col-sm-12 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text font-weight-bold"><span class="text-danger pr-1">*</span> Nama/Jenis Bibit</div>
                                            </div>
                                            <select name="bibit" id="bibit" class="form-control" required>
                                                <option value=''>Pilih Jenis Bibit</option>
                                                <?php foreach ($this->db->get('bibit')->result_array() as $bibit) : ?>
                                                    <option value="<?= $bibit['id_bibit']; ?>"><b><?= $bibit['nm_bibit']; ?></b></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="col-form-label font-weight-bold"><span class="text-danger pr-1">*</span> Volume Tinggi :</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <label for="pertama" class="input-group-prepend ">
                                                    <div class="input-group-text font-weight-bold">0 - 5 Cm</div>
                                                </label>
                                                <input type="number" class="col-sm-8 form-control" id="pertama" min="0" name="pertama" value="0">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <label for="kedua" class="input-group-prepend ">
                                                    <div class="input-group-text font-weight-bold">6 - 10 Cm</div>
                                                </label>
                                                <input type="number" class="col-sm-8 form-control" id="kedua" name="kedua" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <label for="ketiga" class="input-group-prepend ">
                                                    <div class="input-group-text font-weight-bold">10 Cm Up</div>
                                                </label>
                                                <input type="number" class="col-sm-8 form-control" id="ketiga" name="ketiga" min="0" value="0">
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
                                            <input type="number" class="form-control" id="luas" name="luas" placeholder="luas" data-toggle="tooltip" data-placement="left" title="Luas">
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
                                                <div class="input-group-text font-sm font-weight-bold"><span class="text-danger pr-1">*</span> Tanggal Pengawasan </div>
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
                                <label for="foto" class="col-sm-2 col-form-label"><span class="text-danger pr-1">*</span> File Foto</label>
                                <div class="col-sm-10">
                                    <input onchange="ValidateSize(this)" type="file" class="custom-file-input form-control-sm " id="foto" name="foto" required data-toggle="tooltip" data-placement="left" title="Foto pengawasan">
                                    <label for="foto" class="custom-file-label form-control-sm">Choose File</label>
                                    <small class="text-info ml-0">ekstensi file .jpeg/.jpg/.png/.gif | maksimal ukuran 5Mb</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto2" class="col-sm-2 col-form-label"><span class="text-danger pr-1">*</span> File Foto</label>
                                <div class="col-sm-10">
                                    <input onchange="ValidateSize(this)" type="file" class="custom-file-input form-control-sm " id="foto2" name="foto2" required data-toggle="tooltip" data-placement="left" title="Foto pengawasan">
                                    <label for="foto" class="custom-file-label form-control-sm">Choose File</label>
                                    <small class="text-info ml-0">ekstensi file .jpeg/.jpg/.png/.gif | maksimal ukuran 5Mb</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto3" class="col-sm-2 col-form-label"><span class="text-danger pr-1">*</span> File Foto</label>
                                <div class="col-sm-10">
                                    <input onchange="ValidateSize(this)" type="file" class="custom-file-input form-control-sm " id="foto3" name="foto3" required data-toggle="tooltip" data-placement="left" title="Foto pengawasan">
                                    <label for="foto" class="custom-file-label form-control-sm">Choose File</label>
                                    <small class="text-info ml-0">ekstensi file .jpeg/.jpg/.png/.gif | maksimal ukuran 5Mb</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto4" class="col-sm-2 col-form-label"><span class="text-danger pr-1">*</span> File Foto</label>
                                <div class="col-sm-10">
                                    <input onchange="ValidateSize(this)" type="file" class="custom-file-input form-control-sm " id="foto4" name="foto4" required data-toggle="tooltip" data-placement="left" title="Foto pengawasan">
                                    <label for="foto" class="custom-file-label form-control-sm">Choose File</label>
                                    <small class="text-info ml-0">ekstensi file .jpeg/.jpg/.png/.gif | maksimal ukuran 5Mb</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto5" class="col-sm-2 col-form-label"><span class="text-danger pr-1">*</span> File Foto</label>
                                <div class="col-sm-10">
                                    <input onchange="ValidateSize(this)" type="file" class="custom-file-input form-control-sm " id="foto5" name="foto5" required data-toggle="tooltip" data-placement="left" title="Foto pengawasan">
                                    <label for="foto" class="custom-file-label form-control-sm">Choose File</label>
                                    <small class="text-info ml-0">ekstensi file .jpeg/.jpg/.png/.gif | maksimal ukuran 5Mb</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p><span class="text-danger pr-1">* Form isian harus di isi.</span></p>
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

    function getbibit() {
        var IdPetak = $("#petak").val();
        $.ajax({
            url: "<?= base_url('input/bibitnyaAjax'); ?>",
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
</script>