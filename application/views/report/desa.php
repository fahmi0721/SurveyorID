<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('report/mingguan'); ?>"><?= $title; ?></a><small class="text-info">/Kecamatan</small><small class="text-success">/Desa</small><small class="text-warning">/Blok/Petak</small></h1>
        </div>
        <div class="col-sm-2 text-right">
            <a href="javascript:history.back()" class="btn btn-info btn-sm" title="kembali ke halaman sebelumnya"><i class="fas fa-fw fa-chevron-circle-left fa-sm"></i> kembali</a>
        </div>
        <?php
        if (COUNT($kabupaten) > 0) {
            foreach ($kabupaten as $kab) {
        ?>
                <div class="col-xl-6 mb-4">
                    <div class="card border-left-warning shadow h-200 ml-0">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-lg font-weight-bold text-success text-capitalize mb-1">Kab. <?= $kab['nm_kabupaten']; ?>, Kec. <?= $kab['nm_kecamatan'] ?>, Desa <?= $kab['nm_desa']; ?></div>
                                    <div class="h1 mb-0 font-weight-bold text-capitalize text-gray-800"><?= $kab['nm_blok']; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-3x  text-warning"></i>
                                </div>
                                <div class="col-sm-12">
                                    <hr>
                                    <ul class="m-0">
                                        <div class="row">
                                            <?php
                                            $petak = $this->report->LoadPetak($kab['id_kabupaten'], $kab['id_kecamatan'], $kab['id_desa'], $kab['id_blok']);
                                            foreach ($petak as $pet) {
                                            ?>
                                                <div class="col-sm-3">
                                                    <a href="<?= base_url('report/details/') . $kab['id_kabupaten'] . "-" . $kab['id_kecamatan'] . "-" . $kab['id_desa'] . "-" . $kab['id_blok'] . "-" . $pet['id_petak']; ?>">
                                                        <li><?= $pet['nm_petak']; ?></li>
                                                    </a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-lg">
                            <strong> Konfirmasi Terlebih Dahulu! </strong>
                            <p><strong> Konfirmasi Terlebih Dahulu! </strong> Masukkan atau pilih tanggal mulai untuk menampilkan laporan pengawasan.
                                <?php
                                $tepilih = isset($_GET['tglmulai']) != "" ? $_GET['tglmulai'] : "";
                                $today = date('Y-m-d');
                                ?>
                                <hr>
                            <form class="form-inline">
                                <table class="table-sm">
                                    <tr>
                                        <td class="font-weight-bold">
                                            Pilih Tanggal Mulai
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name='tglmulai' id="tglmulai" max="<?= $today; ?>" value="<?= $tepilih; ?>" required>
                                            <input type="text" class="form-control" name='idblok' required value="<?= $kab['id_blok']; ?>" hidden>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Confirm identity</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
            <div class="col-sm-12">
                <?php
                if (isset($_GET['tglmulai']) != "") {
                    $blok = $_GET['idblok'];
                    $lokasi = $this->report->LoadReportBlok($blok);
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
                        <div class="row pt-3 m-0 card-header">
                            <div class="col-sm-10">
                                <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-list"></i> Laporan Kemajuan</h5>
                            </div>
                            <div class="col-sm-2 text-right">
                                <button class="btn btn-sm btn-warning mr-2" onclick="printContent('reportMingguanBlok')"><i class="fas fa-print"></i> Pdf</button>
                                <a href="<?= base_url('report/detailExcelBlok/') . $urlx . "/" . $tglmulai . "/" . $blok; ?>" target="_blank" class="btn btn-sm btn-info"><i class="far fa-file-excel"></i> Excel</a>
                            </div>
                        </div>
                        <div class="collapse show" id="collapse">
                            <div class="card-body">
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
                                                    <td>Blok</td>
                                                    <td>:</td>
                                                    <td><?= $lokasi['nm_blok']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Luas</td>
                                                    <td>:</td>
                                                    <td><?= $lokasi['luas']; ?> Ha</td>
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
                                            </table>
                                        </div>
                                        <div class="col-lg-12 text-1x scrol">
                                            <small class="">
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
                                                            $kegiatanbahan = $this->report->LoadKegiatanBahanBlok($lokasi['id_blok']);
                                                            foreach ($kegiatanbahan as $key) {
                                                                $MguLalu = $this->report->LoadBahanHarianLastBahan($key['id_spkbahan'], $tglmulai);
                                                                $SpkBahan = $this->report->LoadBahanHarianspkBlok($lokasi['id_blok'], $key['id_kegiatan']);
                                                                $realisasi = $this->report->LoadBahanMingguanBlokAllReal($key['id_spkbahan']);
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $no++ ?></td>
                                                                    <td><?= $key['nm_kegiatan']; ?></td>
                                                                    <td class="text-center"><?= $key['satuan']; ?></td>
                                                                    <?php
                                                                    foreach ($dates as $tgl) {
                                                                        echo "<td class='text-center'>" . $this->report->LoadBahanHarianBlok($key['id_spkbahan'], $tgl, $lokasi['id_blok']) . "</td>";
                                                                        $Totalbahan = $Totalbahan + $this->report->LoadBahanHarianBlok($key['id_spkbahan'], $tgl, $lokasi['id_blok']);
                                                                    }
                                                                    // $SpkBahan = $this->report->getSpkBahan($key['id_spkbahan']);
                                                                    $SdMingguIni = $MguLalu + $Totalbahan;
                                                                    $Ket = $realisasi['realisasi'] < $SpkBahan['spk'] ? "PROSES" : "<b>LENGKAP</b>";
                                                                    // $Ket = $Totalbahan < $SpkBahan ? "PROSES" : "LENGKAP";
                                                                    ?>
                                                                    <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="top" title="<?= $Totalbahan ?> Dari <?= $SpkBahan['spk']; ?>"><?= number_format($Totalbahan, 2, ',', '.'); ?></td>
                                                                    <td class="text-right" data-toggle="tooltip" data-placement="left" title="Total sampai dengan <?= $bulan; ?> Minggu <?= $minggu; ?>"><?= number_format($SdMingguIni, '2', '.', ','); ?></td>
                                                                    <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-html="true" data-placement="left" title="Total Realisasi Pengawasan | Target Yang Harus Terpenuhi <br><b> <?= number_format($realisasi['realisasi'], 0, ',', '.'); ?> | <?= $SpkBahan['spk']; ?> </b>">
                                                                        <?= number_format($realisasi['realisasi'], '2', '.', ',') . " <b>|</b> " . number_format($SpkBahan['spk'], '2', ',', '.'); ?>
                                                                    </td>
                                                                    <td class="text-center"><?= $Ket ?></td>
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
                                                            $kegiatanbibit = $this->report->LoadKegiatanBibitBlok($lokasi['id_blok']);
                                                            // echo "<pre>";
                                                            // print_r($kegiatanbibit);
                                                            foreach ($kegiatanbibit as $keyb) {
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center font-weight-bold"><?= $no++ ?></td>
                                                                    <td class="font-weight-bold"><?= $keyb['kategori']; ?></td>
                                                                    <td class="text-center font-weight-bold"><?= $keyb['satuan_spkbibit']; ?></td>
                                                                    <td colspan="9"></td>
                                                                    <td class="text-right font-weight-bold" style="cursor:pointer" data-toggle="tooltip" data-placement="left" title="Total Realisasi Pengawasan | Target Yang Harus Terpenuhi ">
                                                                        <?php
                                                                        $totSpk = $this->report->LoadBibitBlokSpkTotal($lokasi['id_blok'], $keyb['kategori']);
                                                                        echo number_format($totSpk['totReal'], 2, ',', '.') . "<b> | </b> " . number_format($totSpk['TotalSpk'], 2, ',', '.');
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center font-weight-bold"><?= $totSpk['totReal'] < $totSpk['TotalSpk'] ? "PROSES" : "<b>LENGKAP<b>"; ?></td>
                                                                </tr>
                                                                <?php
                                                                $bibitnya = $this->report->loadBibitKategoriBlok($lokasi['id_blok'], $keyb['kategori']);
                                                                foreach ($bibitnya as $value) {
                                                                    $MguLaluBibit = $this->report->LoadBahanHarianLastBibit($keyb['id_spkbibit'], $tglmulai, $value['id_bibit']);
                                                                    $totRealBibit = $this->report->LoadBibitHarianBlokAll($lokasi['id_blok'], $value['id_bibit']);
                                                                ?>
                                                                    <tr>
                                                                        <td class="text-right">-</td>
                                                                        <td><?= $value['nm_bibit']; ?></td>
                                                                        <td class="text-center"><?= $value['satuan']; ?></td>
                                                                        <?php
                                                                        foreach ($dates as $tgl) {
                                                                            echo "<td class='text-center'>" . number_format($this->report->LoadBibitHarianBlok($lokasi['id_blok'], $tgl, $value['id_bibit']), 0, ',', '.') . "</td>";
                                                                            $TotalBibit = $TotalBibit + $this->report->LoadBibitHarianBlok($lokasi['id_blok'], $tgl, $value['id_bibit']);
                                                                        }
                                                                        $SdMingguIniBibit = $MguLaluBibit + $TotalBibit;
                                                                        ?>
                                                                        <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="<?= $TotalBibit ?> Dari <?= $totSpk['TotalSpk']; ?>"><?= number_format($TotalBibit, 2, ',', '.'); ?></td>
                                                                        <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="Total sampai dengan <?= $bulan; ?> Minggu <?= $minggu; ?> : <?= $SdMingguIniBibit ?> Dari <?= $totSpk['TotalSpk']; ?>"><?= number_format($SdMingguIniBibit, '2', '.', ',') ?></td>
                                                                        <td class="text-right" data-toggle='tooltip' data-placement="left" title="Total Realisasi Hasil Pengawasan <?= $value['nm_bibit']; ?> :  <?= number_format($totRealBibit['tot'], 0, ',', '.') . " " . $value['satuan']; ?> ">
                                                                            <?php
                                                                            echo number_format($totRealBibit['tot'], 2, ',', '.');
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center"><?= $totSpk['totReal'] < $totSpk['TotalSpk'] ? "PROSES" : "<b>LENGKAP<b>"; ?></td>
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
                                                            $kegiatanlapangan = $this->report->LoadKegiatanLapanganBlok($lokasi['id_blok']);
                                                            foreach ($kegiatanlapangan as $keyl) {
                                                                $MguLaluLapangan = $this->report->LoadLapanganHarianLast($keyl['id_spklapangan'], $tglmulai);
                                                                $realisasi = $this->report->LoadLapanganMingguanBlokAllReal($keyl['id_spklapangan']);
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $no++ ?></td>
                                                                    <td><?= $keyl['nm_kegiatan']; ?></td>
                                                                    <td class="text-center"><?= $keyl['satuan']; ?></td>
                                                                    <?php
                                                                    foreach ($dates as $tgl) {
                                                                        echo "<td class='text-center'>" . $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl) . "</td>";
                                                                        $TotalLapangan = $TotalLapangan + $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl);
                                                                    }
                                                                    $SpkLapangan = $this->report->getSpkLapangan($keyl['id_spklapangan']);
                                                                    $SdMingguIni = $MguLaluLapangan + $TotalLapangan;
                                                                    $Ket = $realisasi['realisasi'] < $SpkLapangan ? "PROSES" : "<b>LENGKAP</b>";
                                                                    ?>
                                                                    <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-placement="left" title="<?= $TotalLapangan ?> Dari <?= $SpkLapangan; ?>"><?= number_format($TotalLapangan, 2, ',', '.'); ?></td>
                                                                    <td class="text-right" data-toggle="tooltip" data-placement="left" title="Total sampai dengan <?= $bulan; ?> Minggu <?= $minggu; ?>"><?= number_format($SdMingguIni, '2', '.', ','); ?></td>
                                                                    <td class="text-right" style='cursor:pointer' data-toggle='tooltip' data-html="true" data-placement="left" title="Total Realisasi Pengawasan | Target Yang Harus Terpenuhi <br><b> <?= number_format($realisasi['realisasi'], 0, ',', '.'); ?> | <?= $SpkLapangan; ?> </b>">
                                                                        <?= number_format($realisasi['realisasi'], '2', '.', ',') . " <b>|</b> " . number_format($SpkLapangan, '2', ',', '.'); ?>
                                                                    </td>
                                                                    <td class="text-center"><?= $Ket ?></td>
                                                                </tr>
                                                            <?php
                                                                $TotalLapangan = 0;
                                                            }
                                                            ?>
                                                        </small>
                                                    </tbody>
                                                </table>
                                            </small>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Lihat Hasil Laporan Blok Disini </strong> Masukkan atau pilih tanggal mulai untuk menampilkan laporan pengawasan.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
        ?>
        <!-- /.container-fluid -->
    </div>

</div>
<!-- End of Main Content -->
</div>