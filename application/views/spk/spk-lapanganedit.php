<!-- Modal Edit SPK lapangan-->
<form class="user" method="post" action="<?= base_url('spk/updateSpklapangan/') . $isi['id_spklapangan']; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="newRoleLabel">EDIT SPK LAPANGAN | Desa <?= $isi['nm_desa'] . " / " . $isi['nm_blok'] . " / " . $isi['nm_petak'] . " (" . $isi['luas_petak'] . "Ha)"; ?> </h5>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-1"></div>
                <label for="kegiatan" class="col-sm-2 col-form-label">Pilih Kegiatan</label>
                <div class="col-sm-8">
                    <select name="kegiatan" id="kegiatan" class="form-control" required title="Pilih Desa">
                        <?php foreach ($kegiatan as $kegi) : ?>
                            <option value="<?= $kegi['id_kegiatan']; ?>" <?= ($kegi['id_kegiatan'] == $isi['id_kegiatan']) ? "selected" : ""; ?>><b><?= $kegi['nm_kegiatan']; ?></b></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-1"></div>
                <label for="kegiatan" class="col-sm-2 col-form-label">Nilai Volume</label>
                <div class="col-sm-8">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" value="<?= $isi['nilai_spklapangan'] ?>" id="nilai" name="nilai" placeholder="Nilai" title="Nilai Volume" required>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?= $isi['satuan'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pr-5">
            <button type="button" class="btn btn-secondary" id="batal" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
<hr>