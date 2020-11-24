<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="newRoleLabel">EDIT SPK BAHAN | Desa <?= $isi['nm_desa'] . " / " . $isi['nm_blok'] . " / " . $isi['nm_petak']; ?> </h5>
    </div>
    <form class="user" method="post" action="<?= base_url('spk/updateSpkbahan/') . $isi['id_spkbahan']; ?>">
        <div class="modal-body">
            <div class="form-group">
                <select name="kegiatan" id="kegiatan" class="form-control" required title="Pilih Desa">
                    <option value="">Pilih Kegiatan</option>
                    <?php foreach ($kegiatan as $kegi) : ?>
                        <option value="<?= $kegi['id_kegiatan']; ?>" <?= ($kegi['id_kegiatan'] == $isi['id_kegiatan']) ? "selected" : ""; ?>><b><?= $kegi['nm_kegiatan']; ?></b></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?= $isi['nilai_spkbahan'] ?>" id="nilai" name="nilai" placeholder="Nilai" title="Nilai Volume" required>
            </div>
        </div>
        <div class=" modal-footer">
            <button type="button" class="btn btn-secondary" id="batal" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
<hr>