<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Pengawasan Harian <?= $details['id_penanaman']; ?> </title>

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .zoom {
            transition: transform .2s;
            width: 100%;
            max-width: 90px;
            max-height: 20px;
            margin: 0 auto;
        }

        .table-bordered td,
        .table-bordered th {
            padding: 3px;
            border: 1px solid black;
            font-size: 12px;
        }

        .table .text-center {
            text-align: center;
        }

        .table .titel {
            font-weight: bold;
        }

        .table-sm {
            text-transform: uppercase;
            font-size: 12px;
        }

        p {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- <body onload=""> -->

    <p class="">HASIL PENGAWASAN PEKERJAAN HARIAN<br>PEMBUATAN TANAMAN REHAB DAS PT.VALE ......</p>
    <table class="table table-sm table-borderless">
        <tr>
            <td>Desa/Kecamatan</td>
            <td>:</td>
            <td><?= $details['nm_desa'] . '/' . $details['nm_kecamatan']; ?></td>

            <td>Nama Petugas</td>
            <td>:</td>
            <td><?= $details['nm_user']; ?></td>
        </tr>
        <tr>
            <td>Kabupaten</td>
            <td>:</td>
            <td><?= $details['nm_kabupaten']; ?></td>

            <td>Petak/Lokasi</td>
            <td>:</td>
            <td><?= $details['nm_petak']; ?></td>
        </tr>
        <tr>
            <td>Pelaksana</td>
            <td>:</td>
            <td>PTSI</td>

            <td>Koordinat</td>
            <td>:</td>
            <td><?= $details['koordinat']; ?></td>
        </tr>
        <tr>
            <td>Tanggal Input/Pengawasan</td>
            <td>:</td>
            <td><?= date('Y-m-d', $details['hari_tanggal']) . "/" . $details['tgl_pengawasan']; ?></td>

            <td>Luas</td>
            <td>:</td>
            <td><?= $details['luas']; ?></td>
        </tr>
    </table>
    <table class="table table-bordered">
        <tr class="text-center">
            <th scope="col">NO</th>
            <th scope="col">JENIS KEGIATAN</th>
            <th scope="col">SATUAN</th>
            <th scope="col">PROGRESS</th>
            <th scope="col">KETERANGAN</th>
            <th scope="col">FOTO</th>
        </tr>
        <tr>
            <td class="titel" colspan="6"> I. BAHAN BAHAN </td>
        </tr>
        <tbody class="">

            <tr class="borderles">
                <td class="text-center">1</td>
                <td>Pengadaan Patok Arah Larikan</td>
                <td class="text-center">Patok</td>
                <td class="text-center"> <?= ($details['prog_i_1'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_1']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_1'])) {
                    ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_1']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_1']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Pengadaan Patok Batas Petak</td>
                <td class="text-center">Patok</td>
                <td class="text-center"> <?= ($details['prog_i_2'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_2']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_2'])) {
                    ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_2']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_2']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Pengadaan Ajir</td>
                <td class="text-center">Batang</td>
                <td class="text-center"> <?= ($details['prog_i_3'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_3']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_3'])) {
                    ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_3']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_3']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Pengadaan Bahan Pembuatan Papan Nama</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_i_4'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_4']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_4'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_4']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_4']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Pengadaan Gubuk Kerja</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_i_5'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_5']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_5'])) {
                    ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_5']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_5']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Pengadaan Bahan Pondok Kerja</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_i_6'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_6']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_6'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_6']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_6']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Pengadaan Pupuk Kandang dan Kompos</td>
                <td class="text-center">Kg</td>
                <td class="text-center"> <?= ($details['prog_i_7'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_7']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_7'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_7']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_7']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">8</td>
                <td>Pengadaan Obat-obatan / Herbisida</td>
                <td class="text-center">Paket</td>
                <td class="text-center"> <?= ($details['prog_i_8'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_8']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_8'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_8']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_8']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">9</td>
                <td>Pengadaan Bahan atau Peralatan Kerja</td>
                <td class="text-center">paket</td>
                <td class="text-center"> <?= ($details['prog_i_9'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_i_9']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_9'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_9']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_9']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="titel" colspan="6"> II. PERSIAPAN LAPANGAN </td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td>Pembuatan Jalan Pemeriksaan</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_1'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_1']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_10'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_10']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_10']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Pembuatan Batas Lokasi</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_2'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_2']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_11'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_11']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_11']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Pemotongan Semak dan Alang-Alang</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_3'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_3']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_12'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_12']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_12']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Pembuatan Arah</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_4'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_4']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_13'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_13']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_13']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Pemasangan Ajir</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_5'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_5']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_14'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_14']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_14']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Pembuatan Piringan dan Lubang Tanam</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_6'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_6']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_15'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_15']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_15']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Pembuatan Papan Nama</td>
                <td class="text-center">Paket</td>
                <td class="text-center"> <?= ($details['prog_ii_7'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_7']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_16'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_16']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_16']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">8</td>
                <td>Pembuatan Gubuk Kerja</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_ii_8'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_8']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_17'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_17']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_17']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">9</td>
                <td>Pembuatan Pondok Kerja</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_ii_9'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_9']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_18'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_18']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_18']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">10</td>
                <td>Penanaman dan Pemupukan</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_ii_10'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_10']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_19'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_19']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_19']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">11</td>
                <td>Distribusi Bibit dan Pupuk ke Lubang Tanaman</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_11'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_11']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_20'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_20']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_20']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">12</td>
                <td>Penyulaman</td>
                <td class="text-center">Ha</td>
                <td class="text-center"> <?= ($details['prog_ii_12'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_12']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_21'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_21']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_21']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">13</td>
                <td>Penyiangan, Pendangiran, Pemb. Hama Penyakit</td>
                <td class="text-center">Unit</td>
                <td class="text-center"> <?= ($details['prog_ii_13'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_13']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_22'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_22']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_22']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">14</td>
                <td>Pengawasan / Mandor</td>
                <td class="text-center">OB</td>
                <td class="text-center"> <?= ($details['prog_ii_14'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_14']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_23'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_23']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_23']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">15</td>
                <td>Pengamanan / Pemeliharaan Bibit Sementara</td>
                <td class="text-center">OB</td>
                <td class="text-center"> <?= ($details['prog_ii_15'] > 0) ? "Ada" : "Tidak ada"; ?> </td>
                <td> <?= $details['ket_ii_15']; ?> </td>
                <td class="action text-center text-danger">
                    <?php
                    if (file_exists('assets/img/peng-penanaman/' . $details['fot_i_24'])) { ?>
                        <a href="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_24']; ?>" target="_blank">
                            <img src="<?= base_url('assets/img/peng-penanaman/') . $details['fot_i_24']; ?>" class="zoom"></a>
                    <?php } else {
                        echo "<i class='small m-0'>No Image</i>";
                    } ?>
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>