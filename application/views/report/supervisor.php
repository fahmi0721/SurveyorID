<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Report Pengawasan Harian Berdasarkan Anggota</h1>
    <?php
    if (empty($report)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Tidak ada data untuk ditampilkan!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>
    <?php } ?>
    <div class="table-responsive table-head-fixed" style="font-size: small; font-family: Calibri;">
        <table class="table table-hover table-sm table-light" id="dataTables">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Desa/Kecamatan</th>
                    <th scope="col">Kabupaten</th>
                    <th scope="col">Tgl Pengawasan</th>
                    <th scope="col">Anggota</th>
                    <th scope="col">Petak</th>
                    <th scope="col">Koordinat</th>
                    <th scope="col">Luas</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $l = 1;
                foreach ($report as $re) : ?>
                    <tr>
                        <th scope="row"><?= $re['id_penanaman']; ?></th>
                        <td><?= $re['nm_desa'] . "/" . $re['nm_kecamatan']; ?></td>
                        <td><?= $re['nm_kabupaten']; ?></td>
                        <td><?= $re['tgl_pengawasan']; ?></td>
                        <td><?= $re['nm_user']; ?></td>
                        <td><?= $re['nm_petak']; ?></td>
                        <td><?= $re['koordinat']; ?></td>
                        <td><?= $re['luas']; ?></td>
                        <td>
                            <a href="<?= base_url('report/detail/') . $re['id_penanaman']; ?>" class="btn btn-info btn-circle btn-sm tooltip-inner" data-toggle="tooltip" data-placement="left" title="Lihat Detail Lengkap"><i class="fas fa-fw fa-info"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->