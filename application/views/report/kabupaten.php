<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report/mingguan'); ?>"><?= $title; ?></a><small class="text-info">/Kecamatan</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="<?= base_url('report/mingguan'); ?> " class="btn btn-sm btn-info" title="kembali"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
        <?php
        if (COUNT($kabupaten) > 0) {
            foreach ($kabupaten as $kab) {

        ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-200 ml-0">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-lg font-weight-bold text-info text-capitalize mb-1">Kab. <?= $kab['nm_kabupaten']; ?></div>
                                    <div class="h2 mb-0 font-weight-bold text-capitalize text-gray-800">Kec. <?= $kab['nm_kecamatan']; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-3x  text-info"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer  btn-info btn-icon-split btn-sm text-lg" title="Lihat Detail Semua data">
                            <a href="<?= base_url('report/kecamatan/') . $kab['id_kabupaten'] . "-" . $kab['id_kecamatan']; ?>">
                                <span class="text font-weight-bold"><i class="fas fa-fw fa-arrow-right"></i> Lihat Data</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="col-xl-12 mb-3">
                <div class="card border-left-warning shadow h-200 ml-0">
                    <div class="card-header">
                        <strong>Report Pengawasan dan Penilaian Mingguan <b>Kabupaten <?= $kab['nm_kabupaten']; ?> </b> ! </strong>
                        <p><strong> Konfirmasi Terlebih Dahulu! </strong> Masukkan atau pilih tanggal mulai untuk menampilkan laporan pengawasan di <b>Kabupaten <?= $kab['nm_kabupaten']; ?> </b>.
                            <?php
                            $tepilih = isset($_GET['tglmulai']) != "" ? $_GET['tglmulai'] : "";
                            $today = date('Y-m-d');
                            ?>
                        <form class="form-inline">
                            <table class="table-sm">
                                <tr>
                                    <td class="font-weight-bold">
                                        Pilih Tanggal Mulai
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name='tglmulai' id="tglmulai" max="<?= $today; ?>" value="<?= $tepilih; ?>" required>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Confirm Identity</button>
                                    </td>
                                    <?php
                                    if (isset($_GET['tglmulai']) != "") {
                                    ?>
                                        <td>
                                            <button data-toggle="tooltip" data-placement="top" title="Export to PDF" class="btn btn-warning mr-2" onclick="printContent('reportMingguanKab')"><i class="fas fa-print"></i> Pdf</button>
                                            <a data-toggle="tooltip" data-placement="top" title="Export to Excel" href="<?= base_url('report/detailExcelKab/') . $kab['id_kabupaten'] . "/" . $_GET['tglmulai']; ?>" target="_blank" class="btn btn-info"><i class="far fa-file-excel"></i> Excel</a>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="card-body" id="reportMingguanKab">

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
                        ?>
                            <div id="reportMingguanBlok">
                                <div class="row mb-5">
                                    <div class="col-sm-6">
                                        <img class="img" src="<?= base_url('assets/'); ?>img/logo-si.png" alt="" width="50%">
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <img class="img" src="<?= base_url('assets/'); ?>img/logo-vale.png" alt="" width="20%">
                                    </div>
                                </div>
                                <div class="row">
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
                                                <td><?= $kab['nm_kabupaten']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pelaksana</td>
                                                <td>:</td>
                                                <td>PTSI</td>
                                            </tr>
                                            <tr>
                                                <td>Luas</td>
                                                <td>:</td>
                                                <td>
                                                    <?= $this->report->luasKab($kab['id_kabupaten'])['luasnya']; ?>
                                                    Ha</td>
                                            </tr>
                                        </table>
                                        <table class="table-sm table-borderless" width="45%" align="left">
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
                                        </table>
                                    </div>
                                    <div class="col-lg-12 text-1x scrol mb-4" style="width: 100%; height:100%; font-size:12px;">
                                        <table class="mb-5 table-bordered table-hover table-sm" width="100%" style="min-width: 999px;">
                                            <thead>
                                                <tr class="text-uppercase text-center">
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Jenis Kegiatan</th>
                                                    <th rowspan="2">Satuan</th>
                                                    <th colspan="7">Progress Harian</th>
                                                    <th rowspan="2">Jumlah</th>
                                                    <th rowspan="2">Total</th>
                                                    <th rowspan="2">Realisasi<b> | </b> Target</th>
                                                    <th rowspan="2">Ket</th>
                                                </tr>
                                                <tr class="text-center">
                                                    <?php
                                                    foreach ($dates as $tgl) {
                                                        $pisah = explode("-", $tgl);
                                                        $tahuns = $pisah[0];
                                                        $bulans = $pisah[1];
                                                        $haris = $pisah[2];
                                                        $TglShow = $haris . "/" . $bulans . "/" . $tahuns;
                                                        echo "<th>" . $TglShow . "</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <small>
                                                    <!-- Tampilkan Bahan  -->
                                                    <tr>
                                                        <th>I</th>
                                                        <th colspan="13">BAHAN-BAHAN</th>
                                                    </tr>
                                                    <?php
                                                    $no = 1;
                                                    $Totalbahan = 0;
                                                    $kegiatanbahan = $this->report->LoadKegiatanBahanKab($kab['id_kabupaten']);
                                                    foreach ($kegiatanbahan as $key) {
                                                        $MguLalu = $this->report->LoadBahanMingguanLastBahan($key['id_kegiatan'], $tglmulai, $kab['id_kabupaten']);
                                                        $SpkBahan = $this->report->LoadBahanHarianSpkKab($kab['id_kabupaten'], $key['id_kegiatan']);
                                                        $realisasi = $this->report->LoadBahanMingguanKabAllReal($key['id_kegiatan'], $kab['id_kabupaten']);
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++ ?></td>
                                                            <td><?= $key['nm_kegiatan']; ?></td>
                                                            <td class="text-center"><?= $key['satuan']; ?></td>
                                                            <?php
                                                            foreach ($dates as $tgl) {
                                                                $tglreal = $this->report->LoadBahanMingguan($key['id_kegiatan'], $tgl, $kab['id_kabupaten']);
                                                                echo "<td class='text-center'>" . $tglreal . "</td>";
                                                                $Totalbahan = $Totalbahan + $tglreal;
                                                            }
                                                            if ($Totalbahan > 0) {
                                                                $ikonBahan = "<span class='badge badge-info'><i class='fas fa-fw fa-2x fa-arrow-alt-circle-up'></i><span class='align-top'>+" . $Totalbahan . "</span></span>";
                                                            } elseif ($realisasi['realisasi'] >= $SpkBahan['spk']) {
                                                                $ikonBahan = "<b class='text-success'><i class='fas fa-2x fa-check-square'></i></b>";
                                                            } else {
                                                                $ikonBahan = "<b class='text-danger'><i class='fas fa-2x fa-info-circle'></i></b>";
                                                            }
                                                            // $SpkBahan = $this->report->getSpkBahan($key['id_spkbahan']);
                                                            $SdMingguIni = $MguLalu + $Totalbahan;
                                                            $Ket = $realisasi['realisasi'] < $SpkBahan['spk'] ? "PROSES" : "<b>LENGKAP</b>";
                                                            // $Ket = $Totalbahan < $SpkBahan ? "PROSES" : "LENGKAP";
                                                            ?>
                                                            <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $Totalbahan ?> Dari <?= $SpkBahan['spk']; ?>"><?= number_format($Totalbahan, 2, ',', '.'); ?></td>
                                                            <td class="text-right" data-toggle="tooltip" data-placement="left" title="Total sampai dengan <?= $bulan; ?> Minggu <?= $minggu; ?>"><?= number_format($SdMingguIni, '2', '.', ','); ?></td>
                                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-html="true" data-placement="left" title="Total Realisasi Pengawasan | Target Yang Harus Terpenuhi <br><b> <?= number_format($realisasi['realisasi'], 0, ',', '.'); ?> | <?= $SpkBahan['spk']; ?> </b>">
                                                                <?= number_format($realisasi['realisasi'], '2', '.', ',') . " <b>|</b> " . number_format($SpkBahan['spk'], '2', ',', '.'); ?>
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
                                                        <th colspan="13">PENGADAAN BIBIT SULAMAN</th>
                                                    </tr>
                                                    <?php
                                                    $no = 1;
                                                    $TotalBibit = 0;
                                                    $kegiatanbibit = $this->report->LoadKegiatanBibitKab($kab['id_kabupaten']);
                                                    foreach ($kegiatanbibit as $keyb) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center font-weight-bold"><?= $no++ ?></td>
                                                            <td class="font-weight-bold"><?= $keyb['kategori']; ?></td>
                                                            <td class="text-center font-weight-bold"><?= $keyb['satuan_spkbibit']; ?></td>
                                                            <td colspan="9"></td>
                                                            <td class="text-center font-weight-bold" style="cursor:pointer" data-toggle="tooltip" data-placement="left" title="Total Realisasi Pengawasan | Target Yang Harus Terpenuhi ">
                                                                <?php
                                                                $totSpk = $this->report->LoadBibitKabSpkTotal($kab['id_kabupaten'], $keyb['kategori']);
                                                                echo number_format($totSpk['totReal'], 2, ',', '.') . "<b> | </b> " . number_format($totSpk['TotalSpk'], 2, ',', '.');
                                                                ?>
                                                            </td>
                                                            <td class="text-center font-weight-bold">
                                                                <?= $totSpk['totReal'] >= $totSpk['TotalSpk'] ? "<b class='text-success'><i class='fas fa-fw fa-2x fa-check-square'></i></b>" : "<b class='text-danger'><i class='fas fa-2x fa-info-circle'></i></b>"; ?>
                                                                <?= $totSpk['totReal'] < $totSpk['TotalSpk'] ? "PROSES" : "<b>LENGKAP<b>"; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $bibitnya = $this->report->loadBibitKategoriKab($kab['id_kabupaten'], $keyb['kategori']);
                                                        foreach ($bibitnya as $value) {
                                                            $MguLaluBibit = $this->report->LoadBahanHarianLastKab($kab['id_kabupaten'], $tglmulai, $value['id_bibit']);
                                                            $totRealBibit = $this->report->LoadBibitHarianKabAll($kab['id_kabupaten'], $value['id_bibit']);
                                                        ?>
                                                            <tr>
                                                                <td class="text-right">-</td>
                                                                <td><?= $value['nm_bibit']; ?></td>
                                                                <td class="text-center"><?= $value['satuan']; ?></td>
                                                                <?php
                                                                foreach ($dates as $tgl) {
                                                                    $realtgl = $this->report->LoadBibitHarianKab($kab['id_kabupaten'], $tgl, $value['id_bibit']);
                                                                    echo "<td class='text-center'>" . number_format($realtgl, 0, ',', '.') . "</td>";
                                                                    $TotalBibit = $TotalBibit + $realtgl;
                                                                }
                                                                $SdMingguIniBibit = $MguLaluBibit + $TotalBibit;
                                                                if ($TotalBibit > 0) {
                                                                    $ikonbibit = "<span class='badge badge-info'><i class='fas fa-fw fa-2x fa-arrow-alt-circle-up'></i><span class='align-top'>+" . $TotalBibit . "</span></span>";
                                                                } elseif ($totSpk['totReal'] >= $totSpk['TotalSpk']) {
                                                                    $ikonbibit = "<b class='text-success'><i class='fas fa-fw fa-2x fa-check-square'></i></b>";
                                                                } else {
                                                                    $ikonbibit = "<b class='text-danger'><i class='fas fa-fw fa-2x fa-info-circle'></i></b>";
                                                                }
                                                                ?>
                                                                <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="<?= $TotalBibit ?> Dari <?= $totSpk['TotalSpk']; ?>"><?= number_format($TotalBibit, 2, ',', '.'); ?></td>
                                                                <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="Total sampai dengan <?= $bulan; ?> Minggu <?= $minggu; ?> : <?= $SdMingguIniBibit ?> Dari <?= $totSpk['TotalSpk']; ?>"><?= number_format($SdMingguIniBibit, '2', '.', ',') ?></td>
                                                                <td class="text-center" data-toggle='tooltip' data-placement="left" title="Total Realisasi Hasil Pengawasan <?= $value['nm_bibit']; ?> :  <?= number_format($totRealBibit['tot'], 0, ',', '.') . " " . $value['satuan']; ?> ">
                                                                    <?php
                                                                    echo number_format($totRealBibit['tot'], 2, ',', '.');
                                                                    ?>
                                                                </td>
                                                                <td class="text-center"><?= $ikonbibit; ?><?= $totSpk['totReal'] < $totSpk['TotalSpk'] ? "PROSES" : "<b>LENGKAP<b>"; ?></td>
                                                            </tr>
                                                        <?php
                                                            $TotalBibit = 0;
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- tampilkan lapangan  -->
                                                    <tr>
                                                        <th>II</th>
                                                        <th colspan="13">KEGIATAN DI LAPANGAN</th>
                                                    </tr>
                                                    <?php
                                                    $no = 1;
                                                    $TotalLapangan = 0;
                                                    $kegiatanlapangan = $this->report->LoadKegiatanLapanganKab($kab['id_kabupaten']);
                                                    foreach ($kegiatanlapangan as $keyl) {
                                                        $MguLaluLapangan = $this->report->LoadLapanganMingguanLast($keyl['id_kegiatan'], $tglmulai, $kab['id_kabupaten']);
                                                        $SpkLapangan = $this->report->LoadLapanganHarianSpkKab($kab['id_kabupaten'], $keyl['id_kegiatan'])['spk'];
                                                        $realisasi = $this->report->LoadLapanganMingguanKabAllReal($keyl['id_kegiatan'], $kab['id_kabupaten']);
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++ ?></td>
                                                            <td><?= $keyl['nm_kegiatan']; ?></td>
                                                            <td class="text-center"><?= $keyl['satuan']; ?></td>
                                                            <?php
                                                            foreach ($dates as $tgl) {
                                                                $realtglLap = $this->report->LoadLapanganMingguan($keyl['id_kegiatan'], $tgl, $kab['id_kabupaten']);
                                                                echo "<td class='text-center'>" . $realtglLap . "</td>";
                                                                $TotalLapangan = $TotalLapangan + $realtglLap;
                                                            }
                                                            $SdMingguIni = $MguLaluLapangan + $TotalLapangan;
                                                            $Ket = $realisasi['realisasi'] < $SpkLapangan ? "PROSES" : "<b>LENGKAP</b>";
                                                            if ($TotalLapangan > 0) {
                                                                $ikon = "<span class='badge badge-info'><i class='fas fa-fw fa-2x fa-arrow-alt-circle-up'></i><span class='align-top'>+" . $TotalLapangan . "</span></span>";
                                                            } elseif ($realisasi['realisasi'] >= $SpkLapangan) {
                                                                $ikon = "<b class='text-success'><i class='fas fa-fw fa-2x fa-check-square'></i></b>";
                                                            } else {
                                                                $ikon = "<b class='text-danger'><i class='fas fa-fw fa-2x fa-info-circle'></i></b>";
                                                            }
                                                            ?>
                                                            <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="<?= $TotalLapangan ?> Dari <?= $SpkLapangan; ?>"><?= number_format($TotalLapangan, 2, ',', '.'); ?></td>
                                                            <td class="text-right" data-toggle="tooltip" data-placement="left" title="Total sampai dengan <?= $bulan; ?> Minggu <?= $minggu; ?>"><?= number_format($SdMingguIni, '2', '.', ','); ?></td>
                                                            <td class="text-center" style='cursor:pointer' data-toggle='tooltip' data-html="true" data-placement="left" title="Total Realisasi Pengawasan | Target Yang Harus Terpenuhi <br><b> <?= number_format($realisasi['realisasi'], 0, ',', '.'); ?> | <?= $SpkLapangan; ?> </b>">
                                                                <?= number_format($realisasi['realisasi'], '2', '.', ',') . " <b>|</b> " . number_format($SpkLapangan, '2', ',', '.'); ?>
                                                            </td>
                                                            <td class="text-center"><?= $ikon . " " . $Ket ?></td>
                                                        </tr>
                                                    <?php
                                                        $TotalLapangan = 0;
                                                    }
                                                    ?>
                                                </small>
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <?php include 'grafikmingguanKab.php'; ?>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
</div>