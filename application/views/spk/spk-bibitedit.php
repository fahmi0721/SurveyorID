<!-- Modal Add Kategori SPK bibit-->
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="newRoleLabel">EDIT SPK BIBIT | Desa <?= $isi['nm_desa'] . " / " . $isi['nm_blok'] . " / " . $isi['nm_petak']; ?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form class="user" method="post" action="<?= base_url('spk/updateSpkbibit/') . $isi['id_spkbibit']; ?>">
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-1"></div>
                <label for="kegiatan" class="col-sm-2 col-form-label">Kategori Tanaman</label>
                <input type="text" class="col-sm-8 form-control" value="<?= $isi['kategori'] ?>" id="kategori" name="kategori" placeholder="Kategori Bibit" title="Kategori Bibit" required>
            </div>
            <div class="form-group row">
                <div class="col-sm-1"></div>
                <label for="kegiatan" class="col-sm-2 col-form-label">Nilai Volume</label>
                <input type="text" class="col-sm-8 form-control" value="<?= $isi['nilai_spkbibit'] ?>" id="nilai" name="nilai" placeholder="Nilai" title="Nilai Volume" required>
            </div>
            <div class="form-group row">
                <div class="col-sm-1"></div>
                <label for="kegiatan" class="col-sm-2 col-form-label">Satuan</label>
                <input type="text" class="col-sm-8 form-control" value="<?= $isi['satuan_spkbibit'] ?>" id="satuan" name="satuan" placeholder="Satuan" title="Satuan  Kategori" required>
            </div>
        </div>
        <div class=" modal-footer pr-5">
            <button type="button" class="btn btn-secondary" id="batal" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
<hr>