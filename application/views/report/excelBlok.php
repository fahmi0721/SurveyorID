<?php
if (isset($tglmulai) != "") {
    $lokasi = $this->report->LoadReportBlok($blok);
    $dates = array();
    $tglmulai = $tglmulai;
    $dates[] = $tglmulai;
    for ($i = 1; $i < 7; $i++) {
        $date = strtotime($tglmulai);
        $date = strtotime("+" . $i . " day", $date);
        $dates[] = date("Y-m-d", $date);
    }
    $tglx = date('d', strtotime($tglmulai));
    $bulan = date('F Y', strtotime($tglmulai));
    if ($tglx <= 28 && $tglx >= 22) {
        $minggu = "IV (Keempat)";
    } elseif ($tglx <= 21 && $tglx >= 15) {
        $minggu = "III (Ketiga)";
    } elseif ($tglx <= 14 && $tglx >= 8) {
        $minggu = "II (Kedua)";
    } else {
        $minggu = "I (Pertama)";
    }
}

require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$Spreadsheet = new Spreadsheet();
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Rehabdas - rehabdas.ptsi.co.id')
    ->setLastModifiedBy('AlimalHaq - rehabdas.ptsi.co.id')
    ->setTitle('Office 2007 XLSX Report Document')
    ->setSubject('Office 2007 XLSX Report Document')
    ->setDescription('Report document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Report result file');

// konfigurasi gambar 
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setWorksheet($spreadsheet->getActiveSheet());
$drawing->setName('logo-si');
$drawing->setDescription('logo-si');
$drawing->setPath('assets/img/logo-si.png');
$drawing->setCoordinates('B1');
$drawing->setHeight(190);
$drawing->setWidth(310);

$drawings = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawings->setWorksheet($spreadsheet->getActiveSheet());
$drawings->setName('logo-vale');
$drawings->setDescription('logo-vale');
$drawings->setPath('assets/img/logo-vale.png');
$drawings->setCoordinates('O1');
$drawings->setHeight(136);
$drawings->setWidth(90);
// style tittle /Format cell Judul
$spreadsheet->getActiveSheet()->mergeCells('A5:P5');
$spreadsheet->getActiveSheet()->mergeCells('A6:P6');
$spreadsheet->getActiveSheet()->mergeCells('A8:B8');
$spreadsheet->getActiveSheet()->mergeCells('A9:B9');
$spreadsheet->getActiveSheet()->mergeCells('A10:B10');
$spreadsheet->getActiveSheet()->mergeCells('A11:B11');
$styleArray = [
    'font' => [
        'bold' => true,
        'size' => 16,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
];
$spreadsheet->getActiveSheet()->getStyle('A5:A7')->applyFromArray($styleArray);
$spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

// Table Head style 
$spreadsheet->getActiveSheet()->mergeCells('A13:A14'); // No
$spreadsheet->getActiveSheet()->mergeCells('B13:D14'); // Jenis Kegiatan
$spreadsheet->getActiveSheet()->mergeCells('E13:E14'); // Rencana
$spreadsheet->getActiveSheet()->mergeCells('F13:L13'); // Progress Mingguan
$spreadsheet->getActiveSheet()->mergeCells('M13:M14'); // Jumlah
$spreadsheet->getActiveSheet()->mergeCells('N13:N14'); // Total
$spreadsheet->getActiveSheet()->mergeCells('O13:O14'); // Realisasi | Target
$spreadsheet->getActiveSheet()->mergeCells('P13:P14'); // KET
$spreadsheet->getActiveSheet()->mergeCells('B15:P15'); // BAHAN BAHAN
$styleTableHead = [
    'font' => [
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$styleBorderLeft = [
    'font' => [
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'borders' => [
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'Right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$styleTableHeadSub = [
    'font' => [
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$styleNoKategori = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$styleJenisKegiatan = [
    'font' => [
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders' => [
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$styleTextCenter = [
    'font' => [
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$spreadsheet->getActiveSheet()->getStyle('E14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('F14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('G14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('H14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('I14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('J14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('K14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('L14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('A13:A14')->applyFromArray($styleTableHead); // BORDER No
$spreadsheet->getActiveSheet()->getStyle('B13:D14')->applyFromArray($styleTableHead); // BORDER Jenis Kegiatan
$spreadsheet->getActiveSheet()->getStyle('E13:E14')->applyFromArray($styleTableHead); // BORDER SATUAN
$spreadsheet->getActiveSheet()->getStyle('F13:L13')->applyFromArray($styleTableHead); // BORDER Progress Mingguan
$spreadsheet->getActiveSheet()->getStyle('M13:M14')->applyFromArray($styleTableHead); // Jumlah
$spreadsheet->getActiveSheet()->getStyle('N13:N14')->applyFromArray($styleTableHead); // Total
$spreadsheet->getActiveSheet()->getStyle('O13:O14')->applyFromArray($styleTableHead); // Realisasi |Target KETERANGAN
$spreadsheet->getActiveSheet()->getStyle('P13:P14')->applyFromArray($styleTableHead); // Ket
$spreadsheet->getActiveSheet()->getStyle('A15')->applyFromArray($styleTableHeadSub); // BORDER I
$spreadsheet->getActiveSheet()->getStyle('B15:P15')->applyFromArray($styleTableHeadSub); // BORDER BAHAN BAHAN

// Lebar Kolom 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(16.30);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16.57);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16.30);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

// Page setup 
$spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.5);
$spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.25);
$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.5);

// Add some data Title
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A5', 'REKAPITULASI HASIL PENGAWASAN DAN PENILAIAN MINGGUAN')
    ->setCellValue('A6', 'PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK');
// Add some data
$styleHeader = [
    'font' => [
        'bold' => true,
        'size' => 14,
    ],
];
$styleRataTengah = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
$spreadsheet->getActiveSheet()->getStyle('A1:Q60')->applyFromArray($styleRataTengah);
$spreadsheet->getActiveSheet()->getStyle('A13:P14')->applyFromArray($styleHeader);

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A8', 'KABUPATEN')
    ->setCellValue('A9', 'KECAMATAN')
    ->setCellValue('A10', 'DESA')
    ->setCellValue('A11', 'PELAKSANA')
    ->setCellValue('C8', ':')->setCellValue('C9', ':')->setCellValue('C10', ':')->setCellValue('C11', ':')
    ->setCellValue('D8', $lokasi['nm_kabupaten'])
    ->setCellValue('D9', $lokasi['nm_kecamatan'])
    ->setCellValue('D10', $lokasi['nm_desa'])
    ->setCellValue('D11', 'PTSI')
    ->setCellValue('F8', 'BLOK')
    ->setCellValue('F9', 'LUAS')
    ->setCellValue('F10', 'MINGGU KE')
    ->setCellValue('F11', 'BULAN / TAHUN')
    ->setCellValue('G8', ':')->setCellValue('G9', ':')->setCellValue('G10', ':')->setCellValue('G11', ':')
    ->setCellValue('H8', $lokasi['nm_blok'])
    ->setCellValue('H9', $lokasi['luas'] . ' HA')
    ->setCellValue('H10', "$minggu")
    ->setCellValue('H11', "$bulan")
    // Table Head 
    ->setCellValue('A13', 'NO')
    ->setCellValue('B13', 'JENIS KEGIATAN')
    ->setCellValue('E13', 'SATUAN')
    ->setCellValue('F13', 'PROGRESS HARIAN');

$arraybaris = array('F', 'G', 'H', 'I', 'J', 'K', 'L');
$urutArray = 0;
foreach ($dates as $tgl) {
    $pisah = explode("-", $tgl);
    $tahuns = $pisah[0];
    $bulans = $pisah[1];
    $haris = $pisah[2];
    $TglShow = $haris . "/" . $bulans . "/" . $tahuns;
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue($arraybaris[$urutArray] . '14', "$TglShow");
    $urutArray = $urutArray + 1;
}
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('M13', 'JUMLAH')
    ->setCellValue('N13', 'TOTAL')
    ->setCellValue('O13', 'Realisasi | Target')
    ->setCellValue('P13', 'KET')
    ->setCellValue('A15', 'I')
    ->setCellValue('B15', 'BAHAN BAHAN');

// LOAD DATA BAHAN
$no = 16;
$urut = 1;
$Totalbahan = 0;
$kegiatanbahan = $this->report->LoadKegiatanBahanBlok($lokasi['id_blok']);
foreach ($kegiatanbahan as $key) {
    $MguLalu = $this->report->LoadBahanHarianLastBahan($key['id_spkbahan'], $tglmulai);
    $SpkBahan = $this->report->LoadBahanHarianspkBlok($lokasi['id_blok'], $key['id_kegiatan']);
    $realisasi = $this->report->LoadBahanMingguanBlokAllReal($key['id_spkbahan']);
    $spreadsheet->getActiveSheet()->mergeCells('B' . $no . ':D' . $no); //buat marge cell Jenis Kegiatan BAHAN BAHAN
    $spreadsheet->getActiveSheet()->getStyle('A' . $no)->applyFromArray($styleBorderLeft); // BORDER nomor
    $spreadsheet->getActiveSheet()->getStyle('B' . $no . ':D' . $no)->applyFromArray($styleJenisKegiatan); // BORDER Jenis Kegiatan
    $spreadsheet->getActiveSheet()->getStyle('E' . $no)->applyFromArray($styleTextCenter); // BORDER satuan
    $spreadsheet->getActiveSheet()->getStyle('F' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('G' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('H' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('I' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('J' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('K' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('L' . $no)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('M' . $no)->applyFromArray($styleTextCenter); // JUM
    $spreadsheet->getActiveSheet()->getStyle('N' . $no)->applyFromArray($styleTextCenter); // , TOTAL
    $spreadsheet->getActiveSheet()->getStyle('O' . $no)->applyFromArray($styleTextCenter); // , REALISASI
    $spreadsheet->getActiveSheet()->getStyle('P' . $no)->applyFromArray($styleTextCenter); // , KET

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $no,  $urut++)
        ->setCellValue('B' . $no, $key['nm_kegiatan'])
        ->setCellValue('E' . $no, $key['satuan']);
    $arraybaris = array('F', 'G', 'H', 'I', 'J', 'K', 'L');
    $urutArray = 0;
    foreach ($dates as $tgl) {
        $tglreal = $this->report->LoadBahanHarianBlok($key['id_spkbahan'], $tgl, $lokasi['id_blok']);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue($arraybaris[$urutArray] . $no,  "$tglreal");
        $urutArray = $urutArray + 1;
        $Totalbahan = $Totalbahan + $this->report->LoadBahanHarianBlok($key['id_spkbahan'], $tgl, $lokasi['id_blok']);
    }
    $SdMingguIni = $MguLalu + $Totalbahan;
    $Ket = $realisasi['realisasi'] < $SpkBahan['spk'] ? "PROSES" : "<b>LENGKAP</b>";
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('M' . $no,  number_format($Totalbahan, 2, '.', ','))
        ->setCellValue('N' . $no,  number_format($SdMingguIni, 2, '.', ','))
        ->setCellValue('O' . $no,  number_format($realisasi['realisasi'], '2', '.', ',') . " | " . number_format($SpkBahan['spk'], '2', ',', '.'))
        ->setCellValue('P' . $no,  $Ket);
    $Totalbahan = 0;
    $NoAkhirBahan = $no++;
}

// MargeCell Bibit 
$noPengadaanBibit = $NoAkhirBahan + 1; // Ambil No.baris terahir bahan + 1
$spreadsheet->getActiveSheet()->mergeCells('B' . $noPengadaanBibit . ':P' . $noPengadaanBibit); // BAHAN BAHAN
$spreadsheet->getActiveSheet()->getStyle('A' . $noPengadaanBibit)->applyFromArray($styleTableHeadSub); // BORDER I
$spreadsheet->getActiveSheet()->getStyle('B' . $noPengadaanBibit . ':P' . $noPengadaanBibit)->applyFromArray($styleTableHeadSub); // BORDER BAHAN BAHAN
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . $noPengadaanBibit, 'II')
    ->setCellValue('B' . $noPengadaanBibit, 'PENGADAAN BIBIT SULAMAN');
// LOAD DATA BIBIT
$noBi = $noPengadaanBibit + 1; // Tambahkan nilai 1 dari nilai akhir sebelumnya
$urut = 1;
$TotalBibit = 0;
$kegiatanbibit = $this->report->LoadKegiatanBibitBlok($lokasi['id_blok']);
foreach ($kegiatanbibit as $keyb) {
    $spreadsheet->getActiveSheet()->mergeCells('B' . $noBi . ':D' . $noBi); //buat marge cell Jenis Kegiatan BAHAN BAHAN
    $spreadsheet->getActiveSheet()->mergeCells('F' . $noBi . ':N' . $noBi); //buat marge  baris kosong
    $spreadsheet->getActiveSheet()->getStyle('F' . $noBi . ':N' . $noBi)->applyFromArray($styleTableHeadSub); // BORDER baris kosong
    $spreadsheet->getActiveSheet()->getStyle('A' . $noBi)->applyFromArray($styleNoKategori); // BORDER nomor
    $spreadsheet->getActiveSheet()->getStyle('B' . $noBi . ':D' . $noBi)->applyFromArray($styleTableHeadSub); // BORDER nomor
    $spreadsheet->getActiveSheet()->getStyle('E' . $noBi)->applyFromArray($styleTableHeadSub); // BORDER satuan
    $spreadsheet->getActiveSheet()->getStyle('O' . $noBi)->applyFromArray($styleTableHeadSub); // KET
    $spreadsheet->getActiveSheet()->getStyle('P' . $noBi)->applyFromArray($styleTableHeadSub); // KET

    $totSpk = $this->report->LoadBibitBlokSpkTotal($lokasi['id_blok'], $keyb['kategori']);
    $proses = $totSpk['totReal'] < $totSpk['TotalSpk'] ? "PROSES" : "<b>LENGKAP<b>";
    // isi kategori 
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $noBi,  $urut++)
        ->setCellValue('B' . $noBi, $keyb['kategori'])
        ->setCellValue('E' . $noBi, $keyb['satuan_spkbibit'])
        ->setCellValue('O' . $noBi, number_format($totSpk['totReal'], 2, ',', '.') . " | " . number_format($totSpk['TotalSpk'], 2, ',', '.'))
        ->setCellValue('P' . $noBi, "$proses");

    // isi bibitnya 
    $noIsiBibit = $noBi + 1;
    $bibitnya = $this->report->loadBibitKategoriBlok($lokasi['id_blok'], $keyb['kategori']);
    foreach ($bibitnya as $value) {
        $spreadsheet->getActiveSheet()->getStyle('A' . $noIsiBibit)->applyFromArray($styleBorderLeft); // BORDER nomor
        $spreadsheet->getActiveSheet()->mergeCells('B' . $noIsiBibit . ':D' . $noIsiBibit); //buat marge cell Jenis Kegiatan BAHAN BAHAN
        $spreadsheet->getActiveSheet()->getStyle('B' . $noIsiBibit . ':D' . $noIsiBibit)->applyFromArray($styleJenisKegiatan); // BORDER Jenis Kegiatan
        $spreadsheet->getActiveSheet()->getStyle('E' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('F' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('G' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('H' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('I' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('J' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('K' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('L' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('M' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('N' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('O' . $noIsiBibit)->applyFromArray($styleTextCenter);
        $spreadsheet->getActiveSheet()->getStyle('P' . $noIsiBibit)->applyFromArray($styleTextCenter);

        $MguLaluBibit = $this->report->LoadBahanHarianLastBibit($keyb['id_spkbibit'], $tglmulai, $value['id_bibit']);
        $MguLaluBibit = $this->report->LoadBahanHarianLastBibit($keyb['id_spkbibit'], $tglmulai, $value['id_bibit']);
        $totRealBibit = $this->report->LoadBibitHarianBlokAll($lokasi['id_blok'], $value['id_bibit']);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $noIsiBibit, ' ')
            ->setCellValue('B' . $noIsiBibit, '- ' . $value['nm_bibit'])
            ->setCellValue('E' . $noIsiBibit, $value['satuan']);
        $arraybaris = array('F', 'G', 'H', 'I', 'J', 'K', 'L'); //isi tabel bibit
        $urutArray = 0;
        foreach ($dates as $tgl) {
            $bibittotal = $this->report->LoadBibitHarianBlok($lokasi['id_blok'], $tgl, $value['id_bibit']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($arraybaris[$urutArray] . $noIsiBibit,  "$bibittotal");
            $urutArray = $urutArray + 1;
            $TotalBibit = $TotalBibit + $this->report->LoadBibitHarianBlok($lokasi['id_blok'], $tgl, $value['id_bibit']);
        }
        $SdMingguIniBibit = $MguLaluBibit + $TotalBibit;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('M' . $noIsiBibit,  number_format($TotalBibit, 2, ',', '.'))
            ->setCellValue('N' . $noIsiBibit,  number_format($SdMingguIniBibit, 2, '.', ','))
            ->setCellValue('O' . $noIsiBibit,  number_format($totRealBibit['tot'], 2, '.', ','))
            ->setCellValue('P' . $noIsiBibit,  $proses);
        $TotalBibit = 0;
        $noIsiBibitLast = $noIsiBibit++;
    }
    $noBi = $noIsiBibitLast + 1;
}

// MargeCell Lapangan
$noPengadaanLap = $noBi; // Ambil No.baris terahir Bibit & + 1
$spreadsheet->getActiveSheet()->mergeCells('B' . $noPengadaanLap . ':P' . $noPengadaanLap); // Mergecell LAPANGAN
$spreadsheet->getActiveSheet()->getStyle('A' . $noPengadaanLap)->applyFromArray($styleTableHeadSub); // BORDER I
$spreadsheet->getActiveSheet()->getStyle('B' . $noPengadaanLap . ':P' . $noPengadaanLap)->applyFromArray($styleTableHeadSub); // BORDER LAPANGAN
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . $noPengadaanLap, 'III')
    ->setCellValue('B' . $noPengadaanLap, 'KEGIATAN DI LAPANGAN');
$noLa = $noPengadaanLap + 1; // Tambahkan nilai 1 dari nilai akhir sebelumnya
$nol = 1;
$TotalLapangan = 0;
$kegiatanlapangan = $this->report->LoadKegiatanLapanganBlok($lokasi['id_blok']);
foreach ($kegiatanlapangan as $keyl) {
    $MguLaluLapangan = $this->report->LoadLapanganHarianLast($keyl['id_spklapangan'], $tglmulai);
    $realisasi = $this->report->LoadLapanganMingguanBlokAllReal($keyl['id_spklapangan']);

    $spreadsheet->getActiveSheet()->getStyle('A' . $noLa)->applyFromArray($styleBorderLeft); // BORDER nomor
    $spreadsheet->getActiveSheet()->mergeCells('B' . $noLa . ':D' . $noLa); //buat marge cell Jenis Kegiatan BAHAN BAHAN
    $spreadsheet->getActiveSheet()->getStyle('B' . $noLa . ':D' . $noLa)->applyFromArray($styleJenisKegiatan); // BORDER Jenis Kegiatan
    $spreadsheet->getActiveSheet()->getStyle('E' . $noLa)->applyFromArray($styleTextCenter); // BORDER satuan
    $spreadsheet->getActiveSheet()->getStyle('F' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('G' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('H' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('I' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('J' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('K' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('L' . $noLa)->applyFromArray($styleTextCenter); // tgl progress
    $spreadsheet->getActiveSheet()->getStyle('M' . $noLa)->applyFromArray($styleTextCenter); // JUM
    $spreadsheet->getActiveSheet()->getStyle('N' . $noLa)->applyFromArray($styleTextCenter); // , TOTAL
    $spreadsheet->getActiveSheet()->getStyle('O' . $noLa)->applyFromArray($styleTextCenter); // , REALISASI
    $spreadsheet->getActiveSheet()->getStyle('P' . $noLa)->applyFromArray($styleTextCenter); // , KET

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $noLa,  $nol++)
        ->setCellValue('B' . $noLa, $keyl['nm_kegiatan'])
        ->setCellValue('E' . $noLa, $keyl['satuan']);
    $arraybaris = array('F', 'G', 'H', 'I', 'J', 'K', 'L'); //isi tabel bibit
    $urutArray = 0;
    foreach ($dates as $tgl) {
        $laptotal = $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue($arraybaris[$urutArray] . $noLa,  "$laptotal");
        $urutArray = $urutArray + 1;
        $TotalLapangan = $TotalLapangan + $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl);
    }
    $SpkLapangan = $this->report->getSpkLapangan($keyl['id_spklapangan']);
    $SdMingguIni = $MguLaluLapangan + $TotalLapangan;
    $Ket = $realisasi['realisasi'] < $SpkLapangan ? " PROSES " : " LENGKAP ";

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('M' . $noLa,  number_format($TotalLapangan, 2, '.', ','))
        ->setCellValue('N' . $noLa,  number_format($SdMingguIni, 2, '.', ','))
        ->setCellValue('O' . $noLa,  number_format($realisasi['realisasi'], '2', '.', ',') . " | " . number_format($SpkLapangan, '2', ',', '.'))
        ->setCellValue('P' . $noLa,  $Ket);
    $TotalLapangan = 0;
    $EndNo = $noLa++;
}

$EndLine = $EndNo + 1;
$spreadsheet->getActiveSheet()->getStyle('A' . $EndLine . ':P' . $EndLine)->applyFromArray($styleTableHeadSub); // BORDER LAPANGAN
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . $EndLine,  '');


// Rename Worksheet
$Spreadsheet->getActiveSheet()->setTitle('Report Mingguan');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Report Mingguan" ' . $lokasi['nm_kabupaten'] . "_"  . $lokasi['nm_kecamatan'] . "_"  . $lokasi['nm_desa'] . "_" . $lokasi['nm_blok'] . "_" . date('d-m-Y-His') . '".xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
