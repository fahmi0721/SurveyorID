<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report/mingguan'); ?>"><?= $title; ?></a></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="javascript:history.back()" class="btn btn-info btn-sm" title="kembali ke halaman pengawasan harian"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-body p-2">
            <?php
            $tepilih = isset($_GET['tglmulai']) != "" ? $_GET['tglmulai'] : "";
            ?>
            <form class="form-inline">
                <table class=" table-sm">
                    <tr>
                        <td>
                            Tanggal Mulai
                        </td>
                        <td>
                            <?php $today = date('Y-m-d'); ?>
                            <input type="date" class="form-control" name='tglmulai' id="tglmulai" max="<?= $today; ?>" required value="<?= $tepilih; ?>">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Confirm identity</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="printContent('reportMingguan')"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php
    if (isset($_GET['tglmulai']) != "") {
        $dates = array();
        $tglmulai = $_GET['tglmulai'];
        $dates[] = $tglmulai;
        for ($i = 1; $i < 7; $i++) {
            $date = strtotime($tglmulai);
            $date = strtotime("+" . $i . " day", $date);
            $dates[] = date("Y-m-d", $date);
        }
        $tglx = date('d', strtotime($tglmulai));
        $bulan = date('F Y', strtotime($tglmulai));
        if ($tglx <= 28 && $tglx >= 22) {
            $minggu = "IV (KEEMPAT)";
        } elseif ($tglx <= 21 && $tglx >= 15) {
            $minggu = "III (KETIGA)";
        } elseif ($tglx <= 14 && $tglx >= 8) {
            $minggu = "II (KEDUA)";
        } else {
            $minggu = "I (PERTAMA)";
        }

        // echo "<pre>";
        // print_r($dates);
    ?>
        <div class="card shadow mb-4">
            <a href="#reportMingguan" title="Klik untuk memperkecil dan memperbesar" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="reportMingguan">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Detail Pengawasan Harian</h6>
            </a>
            <div class="collapse show">
                <div class="card-body" id="reportMingguan">
                    <div class="row">
                        <div class="col-sm-6">
                            <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                        </div>
                        <div class="col-sm-6 text-right">
                            <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                        </div>
                        <div class="col-lg-12 text-center mb-1 font-weight-bold">
                            <h5 class="font-weight-bold">REKAPITULASI HASIL PENGAWASAN DAN PENILAIAN MINGGUAN</h5>
                            <h5 class="font-weight-bold">PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK</h5>
                            <hr>
                        </div>
                        <div class="col-lg-12 text-uppercase font-weight-bold">
                            <table class="table-sm table-borderless" width="45%" align="left">
                                <tr>
                                    <td>Kabupaten</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_kabupaten']; ?></td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_kecamatan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Desa</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_desa']; ?></td>
                                </tr>
                                <tr>
                                    <td>Pelaksana</td>
                                    <td>:</td>
                                    <td>PTSI</td>
                                </tr>
                            </table>
                            <table class="table-sm table-borderless" width="45%" align="left">
                                <tr>
                                    <td>Blok / Petak</td>
                                    <td>:</td>
                                    <td><?= $lokasi['nm_blok'] . " / " . $lokasi['nm_petak']; ?></td>
                                </tr>
                                <tr>
                                    <td>Luas</td>
                                    <td>:</td>
                                    <td><?php
                                        $totalluasharian = $this->report->getPengawasanTotLuas($lokasi['id_petak']);
                                        $total = $totalluasharian['nilaibahan'] + $totalluasharian['nilailapangan'] + $totalluasharian['nilaibibit'];
                                        ?>
                                        <?= $total; ?> Ha</td>
                                </tr>
                                <tr>
                                    <td>Minggu Ke</td>
                                    <td>:</td>
                                    <td><?= $minggu; ?></td>
                                </tr>
                                <tr>
                                    <td>Bulan/Tahun</td>
                                    <td>:</td>
                                    <td><?= $bulan; ?></td>
                                </tr>
                            </table><br>
                        </div>
                        <div class="col-lg-12 text-1x scrol" style="width: 100%; height:100%; font-size:13px;">
                            <table class="table-bordered table-hover table-sm" width="100%" style="min-width: 999px;">
                                <thead>
                                    <tr class="text-uppercase text-center">
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Jenis Kegiatan</th>
                                        <th rowspan="2">Satuan</th>
                                        <th colspan="7">Progress Harian</th>
                                        <th rowspan="2">Jumlah</th>
                                        <th rowspan="2">Total | Realisasi | Rencana</th>
                                        <th rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr class="text-center">
                                        <?php
                                        foreach ($dates as $tgl) {
                                            $pisah = explode("-", $tgl);
                                            $tahuns = $pisah[0];
                                            $bulans = $pisah[1];
                                            $haris = $pisah[2];
                                            $TglShow = $haris . "/" . $bulans . "/" . $tahuns;
                                            echo "<td>" . $TglShow . "</td>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <small>
                                        <!-- Tampilkan Bahan  -->
                                        <tr>
                                            <th>I</th>
                                            <th colspan="11">BAHAN-BAHAN</th>
                                        </tr>
                                        <?php
                                        $no = 1;
                                        $Totalbahan = 0;
                                        $kegiatanbahan = $this->report->LoadKegiatanBahan($lokasi['id_petak']);
                                        foreach ($kegiatanbahan as $key) {
                                            $MguLalu = $this->report->LoadBahanHarianLastBahan($key['id_spkbahan'], $tglmulai);
                                            $realisasi = $this->report->LoadBahanMingguanRealisasi($key['id_spkbahan'], $lokasi['id_petak'])['total'];
                                            $SpkBahan = $this->report->getSpkBahan($key['id_spkbahan']);
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++ ?></td>
                                                <td><?= $key['nm_kegiatan']; ?></td>
                                                <td class="text-center"><?= $key['satuan']; ?></td>
                                                <?php
                                                foreach ($dates as $tgl) {
                                                    echo "<td class='text-center'>" . $this->report->LoadBahanHarian($key['id_spkbahan'], $tgl) . "</td>";
                                                    $Totalbahan = $Totalbahan + $this->report->LoadBahanHarian($key['id_spkbahan'], $tgl);
                                                }
                                                if ($Totalbahan > 0) {
                                                    $ikonBahan = "<span class='badge badge-info'><i class='fas fa-fw fa-2x fa-arrow-alt-circle-up'></i><span class='align-top'>+" . $Totalbahan . "</span></span>";
                                                } elseif ($realisasi >= $SpkBahan) {
                                                    $ikonBahan = "<b class='text-success'><i class='fas fa-2x fa-check-square'></i></b>";
                                                } else {
                                                    $ikonBahan = "<b class='text-danger'><i class='fas fa-2x fa-info-circle'></i></b>";
                                                }
                                                $SdMingguIni = $MguLalu + $Totalbahan;
                                                $Ket = $realisasi < $SpkBahan ? "PROSES" : "<b>LENGKAP</b>";
                                                // $Ket = $Totalbahan < $SpkBahan ? "PROSES" : "LENGKAP";
                                                ?>
                                                <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $Totalbahan ?> Dari <?= $SpkBahan; ?>"><?= number_format($Totalbahan, 2, ',', '.'); ?></td>
                                                <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="Total sampai dengan <?= $bulan . " Minggu " . $minggu . " : " . $SdMingguIni ?> | Realisasi : <?= $realisasi . " | Rencana :" . $SpkBahan; ?>">
                                                    <?= number_format($SdMingguIni, '2', '.', ',') . " <b> | </b> " . number_format($realisasi, 2, ',', '.') . "<b> | </b>" . number_format($key['nilai_spkbahan'], '2', ',', '.'); ?>
                                                </td>
                                                <td class="text-center"><?= $ikonBahan . " " . $Ket ?></td>
                                            </tr>
                                        <?php
                                            $Totalbahan = 0;
                                        }
                                        ?>
                                        <!-- Tampilkan Bibit  -->
                                        <tr>
                                            <th>II</th>
                                            <th colspan="11">PENGADAAN BIBIT SULAMAN</th>
                                        </tr>
                                        <?php
                                        $no = 1;
                                        $TotalBibit = 0;
                                        $kegiatanbibit = $this->report->LoadKegiatanBibit($lokasi['id_petak']);
                                        // echo "<pre>";
                                        // print_r($kegiatanbibit);
                                        $ResalisasiBibir = $this->report->ReaisasiSphBibit();
                                        foreach ($kegiatanbibit as $keyb) {
                                            $MguLaluBibit = $this->report->LoadBahanHarianLastBibit($keyb['id_spkbibit'], $tglmulai, $keyb['id_bibit']);
                                            $realbibit = $this->report->loadRealBibit($keyb['id_bibit'], $lokasi['id_petak'])['total'];
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++ ?></td>
                                                <td><?= $keyb['nm_bibit']; ?></td>
                                                <td class="text-center"><?= $keyb['satuan']; ?></td>
                                                <?php
                                                foreach ($dates as $tgl) {
                                                    echo "<td class='text-center'>" . $this->report->LoadBibitHarian($keyb['id_spkbibit'], $tgl, $keyb['id_bibit']) . "</td>";
                                                    $TotalBibit = $TotalBibit + $this->report->LoadBibitHarian($keyb['id_spkbibit'], $tgl, $keyb['id_bibit']);
                                                }
                                                $SpkBibit = $this->report->getSpkBibit($keyb['id_spkbibit']);
                                                $SdMingguIniBibit = $MguLaluBibit + $TotalBibit;
                                                $SdMingguIniBib = $this->report->ReaisasiSphBibitReport($keyb['id_spkbibit'], $lokasi['id_petak']);
                                                $ket = $SdMingguIniBib['tot'] < $SpkBibit ? "PROSES" : "<b>LENGKAP</b>";
                                                if ($TotalBibit > 0) {
                                                    $ikonBi = "<span class='badge badge-info'><i class='fas fa-2x fa-arrow-alt-circle-up'></i><span class='align-top'>+" . $TotalBibit . "</span></span>";
                                                } elseif ($realbibit >= $SpkBibit) {
                                                    $ikonBi = "<b class='text-success'><i class='fas fa-2x fa-check-square'></i></b>";
                                                } else {
                                                    $ikonBi = "<b class='text-danger'><i class='fas fa-2x fa-info-circle'></i></b>";
                                                }
                                                ?>
                                                <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $TotalBibit ?> Dari <?= $SpkBibit; ?>"><?= $TotalBibit ?></td>
                                                <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="Total sampai dengan <?= $bulan . " Minggu " . $minggu . " : " . number_format($realbibit, 0, ',', '.') ?> | Realisasi : <?= number_format($SdMingguIniBib['tot'], 0, ',', '.') . " | Rencana :" .  number_format($SpkBibit, 0, ',', '.'); ?>">
                                                    <?= number_format($SdMingguIniBibit, '2', '.', ',') . " <b> | </b>" . number_format($realbibit, 2, ',', '.') . " <b> | </b>" . number_format($keyb['nilai_spkbibit'], 2, ',', '.'); ?>
                                                </td>
                                                <td class="text-center"><?= $ikonBi . " " . $ket ?></td>
                                            </tr>
                                        <?php
                                            $TotalBibit = 0;
                                        }
                                        ?>
                                        <!-- tampilkan lapangan  -->

                                        <tr>
                                            <th>II</th>
                                            <th colspan="11">KEGIATAN DI LAPANGAN</th>
                                        </tr>
                                        <?php
                                        $no = 1;
                                        $TotalLapangan = 0;
                                        $kegiatanlapangan = $this->report->LoadKegiatanLapangan($lokasi['id_petak']);;
                                        foreach ($kegiatanlapangan as $keyl) {
                                            $MguLaluLapangan = $this->report->LoadLapanganHarianLast($keyl['id_spklapangan'], $tglmulai);
                                            $realisasi = $this->report->loadRealMingguanLap($keyl['id_spklapangan'], $lokasi['id_petak'])['tot'];
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++ ?></td>
                                                <td><?= $keyl['nm_kegiatan']; ?></td>
                                                <td class="text-center"><?= $keyl['satuan']; ?></td>
                                                <?php
                                                foreach ($dates as $tgl) {
                                                    echo "<td class='text-center'>" . $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl) . "</td>";
                                                    $TotalLapangan = $TotalLapangan + $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl);
                                                }
                                                $SpkLapangan = $this->report->getSpkLapangan($keyl['id_spklapangan']);
                                                $SdMingguIni = $MguLaluLapangan + $TotalLapangan;
                                                $Ket = $realisasi < $SpkLapangan ? "PROSES" : "<b>LENGKAP</b>";
                                                if ($TotalLapangan > 0) {
                                                    $ikonLapangan = "<span class='badge badge-info'><i class='fas fa-fw fa-2x fa-arrow-alt-circle-up'></i><span class='align-top'>+" . $TotalLapangan . "</span></span>";
                                                } elseif ($realisasi >= $SpkLapangan) {
                                                    $ikonLapangan = "<b class='text-success'><i class='fas fa-2x fa-check-square'></i></b>";
                                                } else {
                                                    $ikonLapangan = "<b class='text-danger'><i class='fas fa-2x fa-info-circle'></i></b>";
                                                }
                                                ?>
                                                <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $TotalLapangan ?> Dari <?= $SpkLapangan; ?>"><?= $TotalLapangan ?></td>
                                                <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="Total sampai dengan <?= $bulan . " Minggu " . $minggu . " : " . number_format($SdMingguIni, 0, ',', '.') ?> | Realisasi : <?= number_format($realisasi, 0, ',', '.') . " | Rencana :" . number_format($SpkLapangan, 0, ',', '.'); ?>">
                                                    <?= number_format($SdMingguIni, '2', '.', ',') . " <b> | </b> " . number_format($realisasi, 2, ',', '.')  . " <b> | </b> " . number_format($keyl['nilai_spklapangan'], 2, ',', '.'); ?>
                                                </td>
                                                <td class="text-center"><?= $ikonLapangan . " " . $Ket ?></td>
                                            </tr>
                                        <?php
                                            $TotalLapangan = 0;
                                        }
                                        ?>
                                    </small>
                                </tbody>
                            </table>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan kemajuan -->
        <div class="card shadow mb-2">
            <div class="row  m-0 card-header">
                <div class="col-sm-10">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Laporan Kemajuan</h5>
                </div>
                <div class="col-sm-1 text-right">
                    <button class="btn btn-sm btn-warning" onclick="printContent('reportMingguanKemajuan')"><i class="fas fa-print"></i> Print</button>
                </div>
                <div class="col-sm-1 text-left">
                    <a href="<?= base_url('report/detailsExcel/') . $urlx . "/" . $tglmulai; ?>" target="_blank" class="btn btn-sm btn-info"><i class="far fa-file-excel"></i> Export</a>
                </div>
            </div>
            <div class="card-body" id="reportMingguanKemajuan">
                <div class="row m-4">
                    <div class="col-sm-6">
                        <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                    </div>
                    <div class="col-sm-6 text-right">
                        <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center mb-4 font-weight-bold" style="text-transform: uppercase;">
                        <h3 class="font-weight-bold">LAPORAN KEMAJUAN PEKERJAAN </h3>
                        <h3 class="font-weight-bold">PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK</h3>
                        PERIODE : MINGGU <?= $minggu; ?> BULAN <?= $bulan; ?>
                        <hr>
                    </div>
                    <div class="col-lg-12 text-uppercase font-weight-bold">
                        <table class="table-sm table-borderless" width="45%" align="left">
                            <tr>
                                <td>Kabupaten</td>
                                <td>:</td>
                                <td><?= $lokasi['nm_kabupaten']; ?></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>:</td>
                                <td><?= $lokasi['nm_kecamatan']; ?></td>
                            </tr>
                            <tr>
                                <td>Desa</td>
                                <td>:</td>
                                <td><?= $lokasi['nm_desa']; ?></td>
                            </tr>
                        </table>
                        <table class="table-sm table-borderless" width="45%" align="left">
                            <tr>
                                <td>Blok</td>
                                <td>:</td>
                                <td><?= $lokasi['nm_blok']; ?></td>
                            </tr>
                            <tr>
                                <td>Petak</td>
                                <td>:</td>
                                <td><?= $lokasi['nm_petak']; ?></td>
                            </tr>
                            <tr>
                                <td>Luas</td>
                                <td>:</td>
                                <td><?php
                                    $totalluasharian = $this->report->getPengawasanTotLuas($lokasi['id_petak']);
                                    $total = $totalluasharian['nilaibahan'] + $totalluasharian['nilailapangan'] + $totalluasharian['nilaibibit'];
                                    ?>
                                    <?= $total; ?> Ha</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12 text-1x scrol" style="width: 100%; height:100%; font-size:14px;">
                        <table class="table-bordered table-hover table-sm" width="100%" style="min-width: 999px;" border="1">
                            <thead>
                                <tr class="text-uppercase text-center">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Jenis Kegiatan</th>
                                    <th colspan="2"">Rencana</th>
                                        <th colspan=" 3">Progress Mingguan</th>
                                    <th rowspan="2">Realisasi</th>
                                    <th rowspan="2">Keterangan</th>
                                </tr>
                                <tr class=" text-uppercase text-center">
                                    <th>Satuan</th>
                                    <th>volume</th>
                                    <th>S/D Minggu Lalu</th>
                                    <th>Minggu Ini</th>
                                    <th>S/D Minggu Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                <small>
                                    <!-- Tampilkan Bahan  -->
                                    <tr>
                                        <th>I</th>
                                        <th colspan="11">BAHAN-BAHAN</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    $Totalbahan = 0;
                                    $kegiatanbahan = $this->report->LoadKegiatanBahan($lokasi['id_petak']);
                                    foreach ($kegiatanbahan as $key) {
                                        $MguLalu = $this->report->LoadBahanHarianLastBahan($key['id_spkbahan'], $tglmulai);
                                        $realisasi = $this->report->LoadBahanMingguanRealisasi($key['id_spkbahan'], $lokasi['id_petak'])['total'];
                                    ?>
                                        <tr>
                                            <td class="text-right"><?= $no++ ?></td>
                                            <td><?= $key['nm_kegiatan']; ?></td>
                                            <td class="text-center"><?= $key['satuan']; ?></td>
                                            <td class="text-center"><?= number_format($key['nilai_spkbahan'], 2, '.', ','); ?></td>
                                            <?php
                                            foreach ($dates as $tgl) {
                                                $Totalbahan = $Totalbahan + $this->report->LoadBahanHarian($key['id_spkbahan'], $tgl);
                                            }
                                            $SpkBahan = $this->report->getSpkBahan($key['id_spkbahan']);
                                            $SdMingguIni = $MguLalu + $Totalbahan;
                                            $Ket = $realisasi < $SpkBahan ? "PROSES" : "<b>LENGKAP</b>";
                                            ?>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $MguLalu ?> Dari <?= $SpkBahan; ?>"><?= number_format($MguLalu, 2, '.', ','); ?></td>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $Totalbahan ?> Dari <?= $SpkBahan; ?>"><?= number_format($Totalbahan, '2', '.', ',') ?></td>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $SdMingguIni ?> Dari <?= $SpkBahan; ?>"><?= number_format($SdMingguIni, '2', '.', ',') ?></td>
                                            <td class="text-center"><?= number_format($realisasi, 2, ',', '.') ?></td>
                                            <td class="text-center"><?= $Ket ?></td>
                                        </tr>
                                    <?php
                                        $Totalbahan = 0;
                                    }
                                    ?>
                                    <!-- Tampilkan Bibit  -->
                                    <tr>
                                        <th>II</th>
                                        <th colspan="11">PENGADAAN BIBIT SULAMAN</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    $TotalBibit = 0;
                                    $kegiatanbibit = $this->report->LoadKegiatanBibit($lokasi['id_petak']);
                                    $ResalisasiBibir = $this->report->ReaisasiSphBibit();
                                    foreach ($kegiatanbibit as $keyb) {
                                        $MguLaluBibit = $this->report->LoadBahanHarianLastBibit($keyb['id_spkbibit'], $tglmulai, $keyb['id_bibit']);
                                        $realbibit = $this->report->loadRealBibit($keyb['id_bibit'], $lokasi['id_petak'])['total'];
                                    ?>
                                        <tr>
                                            <td class="text-right"><?= $no++ ?></td>
                                            <td><?= $keyb['nm_bibit']; ?></td>
                                            <td class="text-center"><?= $keyb['satuan']; ?></td>
                                            <td class="text-center"><?= number_format($keyb['nilai_spkbibit'], 2, '.', ','); ?></td>
                                            <?php
                                            foreach ($dates as $tgl) {
                                                $TotalBibit = $TotalBibit + $this->report->LoadBibitHarian($keyb['id_spkbibit'], $tgl, $keyb['id_bibit']);
                                            }
                                            $SpkBibit = $this->report->getSpkBibit($keyb['id_spkbibit']);
                                            $SdMingguIniBibit = $MguLaluBibit + $TotalBibit;
                                            $SdMingguIniBib = $this->report->ReaisasiSphBibitReport($keyb['id_spkbibit'], $lokasi['id_petak']);
                                            $ket = $realbibit < $SpkBibit ? "PROSES" : "<b>LENGKAP</b>";
                                            ?>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $MguLaluBibit ?> Dari <?= $SpkBibit; ?>"><?= number_format($MguLaluBibit, 2, '.', ','); ?></td>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $TotalBibit ?> Dari <?= $SpkBibit; ?>"><?= number_format($TotalBibit, '2', '.', ',') ?></td>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $SdMingguIniBibit ?> Dari <?= $SpkBibit; ?>"><?= number_format($SdMingguIniBibit, '2', '.', ',') ?></td>
                                            <td class="text-center"><?= number_format($realbibit, 2, ',', '.'); ?> (<?= number_format($SdMingguIniBib['tot'], 0, ',', '.') ?>)</td>
                                            <td class="text-center"><?= $ket; ?></td>
                                        </tr>
                                    <?php
                                        $TotalBibit = 0;
                                    }
                                    ?>
                                    <!-- tampilkan lapangan  -->
                                    <tr>
                                        <th>II</th>
                                        <th colspan="11">KEGIATAN DI LAPANGAN</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    $TotalLapangan = 0;
                                    $kegiatanlapangan = $this->report->LoadKegiatanLapangan($lokasi['id_petak']);;
                                    foreach ($kegiatanlapangan as $keyl) {
                                        $MguLaluLapangan = $this->report->LoadLapanganHarianLast($keyl['id_spklapangan'], $tglmulai);
                                        $realisasi = $this->report->loadRealMingguanLap($keyl['id_spklapangan'], $lokasi['id_petak'])['tot'];
                                    ?>
                                        <tr>
                                            <td class="text-right"><?= $no++ ?></td>
                                            <td><?= $keyl['nm_kegiatan']; ?></td>
                                            <td class="text-center"><?= $keyl['satuan']; ?></td>
                                            <td class="text-center"><?= number_format($keyl['nilai_spklapangan'], 2, '.', ','); ?></td>
                                            <?php
                                            foreach ($dates as $tgl) {
                                                $TotalLapangan = $TotalLapangan + $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl);
                                            }
                                            $SpkLapangan = $this->report->getSpkLapangan($keyl['id_spklapangan']);
                                            $SdMingguIni = $MguLaluLapangan + $TotalLapangan;
                                            $Ket = $realisasi < $SpkLapangan ? "PROSES" : "<b>LENGKAP</b>";
                                            ?>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $MguLaluLapangan ?> Dari <?= $SpkLapangan; ?>"><?= number_format($MguLaluLapangan, 2, '.', ','); ?></td>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $TotalLapangan ?> Dari <?= $SpkLapangan; ?>"><?= number_format($TotalLapangan, '2', '.', ',') ?></td>
                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $SdMingguIni ?> Dari <?= $SpkLapangan; ?>"><?= number_format($SdMingguIni, '2', '.', ',') ?></td>
                                            <td class="text-center"><?= number_format($realisasi, 2, ',', '.') ?></td>
                                            <td class="text-center"><?= $Ket ?></td>
                                        </tr>
                                    <?php
                                        $TotalLapangan = 0;
                                    }
                                    ?>
                                </small>
                            </tbody>
                        </table>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> Confirmasi Terlebih Dahulu! </strong> Masukkan atau pilih tanggal mulai untuk menampilkan report dalam seminggu.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
        </div>
    <?php } ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->