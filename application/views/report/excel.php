<?php
if (isset($tglmulai) != "") {
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

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$Spreadsheet = new Spreadsheet();
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Rehabdas - rehabdas.ptsi.co.id')
    ->setLastModifiedBy('Alimal - rehabdas.ptsi.co.id')
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
$drawing->setCoordinates('A1');
$drawing->setHeight(190);
$drawing->setWidth(310);

$drawings = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawings->setWorksheet($spreadsheet->getActiveSheet());
$drawings->setName('logo-vale');
$drawings->setDescription('logo-vale');
$drawings->setPath('assets/img/logo-vale.png');
$drawings->setCoordinates('J1');
$drawings->setHeight(136);
$drawings->setWidth(90);
// style tittle /Format cell Judul

$spreadsheet->getActiveSheet()->mergeCells('A5:K5');
$spreadsheet->getActiveSheet()->mergeCells('A6:K6');
$spreadsheet->getActiveSheet()->mergeCells('A7:K7');
$spreadsheet->getActiveSheet()->mergeCells('A9:B9');
$spreadsheet->getActiveSheet()->mergeCells('A10:B10');
$spreadsheet->getActiveSheet()->mergeCells('A11:B11');
$styleArray = [
    'font' => [
        'bold' => true,
        'size' => 12,
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
$spreadsheet->getActiveSheet()->mergeCells('E13:F13'); // Rencana
$spreadsheet->getActiveSheet()->mergeCells('G13:I13'); // Progress Mingguan
$spreadsheet->getActiveSheet()->mergeCells('J13:J14'); // Realisasi
$spreadsheet->getActiveSheet()->mergeCells('K13:K14'); // KETERANGAN
$spreadsheet->getActiveSheet()->mergeCells('B15:K15'); // BAHAN BAHAN
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
$styleRataTengah = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
$spreadsheet->getActiveSheet()->getStyle('A1:L60')->applyFromArray($styleRataTengah);

$spreadsheet->getActiveSheet()->getStyle('E14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('F14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('G14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('H14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('I14')->applyFromArray($styleTableHead);
$spreadsheet->getActiveSheet()->getStyle('A13:A14')->applyFromArray($styleTableHead); // BORDER No
$spreadsheet->getActiveSheet()->getStyle('B13:D14')->applyFromArray($styleTableHead); // BORDER Jenis Kegiatan
$spreadsheet->getActiveSheet()->getStyle('E13:F13')->applyFromArray($styleTableHead); // BORDER Rencana
$spreadsheet->getActiveSheet()->getStyle('G13:I13')->applyFromArray($styleTableHead); // BORDER Progress Mingguan
$spreadsheet->getActiveSheet()->getStyle('J13:J14')->applyFromArray($styleTableHead); // BORDER Realisasi
$spreadsheet->getActiveSheet()->getStyle('K13:K14')->applyFromArray($styleTableHead); // BORDER KETERANGAN
$spreadsheet->getActiveSheet()->getStyle('A15')->applyFromArray($styleTableHeadSub); // BORDER I
$spreadsheet->getActiveSheet()->getStyle('B15:K15')->applyFromArray($styleTableHeadSub); // BORDER BAHAN BAHAN

// Lebar Kolom 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(16.30);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16.57);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16.30);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(14.14);

// Page setup 
$spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.5);
$spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.25);
$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.5);

// Add some data Title
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A5', 'LAPORAN KEMAJUAN PEKERJAAN')
    ->setCellValue('A6', 'PEMBUATAN TANAMAN (P0) REHABILITASI DAS PT VALE INDONESIA,TBK')
    ->setCellValue('A7', 'Periode : Minggu ' . $minggu . ' Bulan  ' . $bulan);
// Add some data
// LUAS
$totalluasharian = $this->report->getPengawasanTotLuas($lokasi['id_petak']);
$total = $totalluasharian['nilaibahan'] + $totalluasharian['nilailapangan'] + $totalluasharian['nilaibibit'];

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A9', 'KABUPATEN')
    ->setCellValue('A10', 'KECAMATAN')
    ->setCellValue('A11', 'DESA')
    ->setCellValue('C9', ':')->setCellValue('C10', ':')->setCellValue('C11', ':')
    ->setCellValue('D9', $lokasi['nm_kabupaten'])
    ->setCellValue('D10', $lokasi['nm_kecamatan'])
    ->setCellValue('D11', $lokasi['nm_desa'])
    ->setCellValue('F9', 'BLOK')
    ->setCellValue('F10', 'PETAK')
    ->setCellValue('F11', 'LUAS')
    ->setCellValue('G9', ':')->setCellValue('G10', ':')->setCellValue('G11', ':')
    ->setCellValue('H9', $lokasi['nm_blok'])
    ->setCellValue('H10', $lokasi['nm_petak'])
    ->setCellValue('H11', $total . ' HA')
    // Table Head 
    ->setCellValue('A13', 'NO')
    ->setCellValue('B13', 'JENIS KEGIATAN')
    ->setCellValue('E13', 'RENCANA')
    ->setCellValue('E14', 'SATUAN')
    ->setCellValue('F14', 'VOLUME')
    ->setCellValue('G13', 'PROGRESS MINGGUAN')
    ->setCellValue('G14', 'S/D MINGGU LALU')
    ->setCellValue('H14', 'MINGGU INI')
    ->setCellValue('I14', 'S/D MINGGU INI')
    ->setCellValue('J13', 'REALISASI')
    ->setCellValue('K13', 'KETERANGAN')
    ->setCellValue('A15', 'I')
    ->setCellValue('B15', 'BAHAN BAHAN');

// LOAD DATA BAHAN
$no = 16;
$urut = 1;
$Totalbahan = 0;
$kegiatanbahan = $this->report->LoadKegiatanBahan($lokasi['id_petak']);
foreach ($kegiatanbahan as $key) {
    $MguLalu = $this->report->LoadBahanHarianLastBahan($key['id_spkbahan'], $tglmulai);
    $realisasi = $this->report->LoadBahanMingguanRealisasi($key['id_spkbahan'], $lokasi['id_petak'])['total'];
    $spreadsheet->getActiveSheet()->mergeCells('B' . $no . ':D' . $no); //buat marge cell Jenis Kegiatan BAHAN BAHAN
    $spreadsheet->getActiveSheet()->getStyle('A' . $no)->applyFromArray($styleBorderLeft); // BORDER nomor
    $spreadsheet->getActiveSheet()->getStyle('B' . $no . ':D' . $no)->applyFromArray($styleJenisKegiatan); // BORDER Jenis Kegiatan
    $spreadsheet->getActiveSheet()->getStyle('E' . $no)->applyFromArray($styleTextCenter); // BORDER satuan
    $spreadsheet->getActiveSheet()->getStyle('F' . $no)->applyFromArray($styleTextCenter); // BORDER Volume
    $spreadsheet->getActiveSheet()->getStyle('G' . $no)->applyFromArray($styleTextCenter); // BORDER s.d minggu lalu
    $spreadsheet->getActiveSheet()->getStyle('H' . $no)->applyFromArray($styleTextCenter); // BORDER minggu ini
    $spreadsheet->getActiveSheet()->getStyle('I' . $no)->applyFromArray($styleTextCenter); // BORDER S/d minggu ini
    $spreadsheet->getActiveSheet()->getStyle('J' . $no)->applyFromArray($styleTextCenter); // Realisasi
    $spreadsheet->getActiveSheet()->getStyle('K' . $no)->applyFromArray($styleTextCenter); // KET
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $no,  $urut++)
        ->setCellValue('B' . $no, $key['nm_kegiatan'])
        ->setCellValue('E' . $no, $key['satuan'])
        ->setCellValue('F' . $no, number_format($key['nilai_spkbahan'], 2, '.', ','));
    foreach ($dates as $tgl) {
        $Totalbahan = $Totalbahan + $this->report->LoadBahanHarian($key['id_spkbahan'], $tgl);
    }
    $SpkBahan = $this->report->getSpkBahan($key['id_spkbahan']);
    $SdMingguIni = $MguLalu + $Totalbahan;
    $Ket = $realisasi < $SpkBahan ? "PROSES" : "LENGKAP";
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('G' . $no,  number_format($MguLalu, 2, '.', ','))
        ->setCellValue('H' . $no,  number_format($Totalbahan, 2, '.', ','))
        ->setCellValue('I' . $no,  number_format($SdMingguIni, 2, '.', ','))
        ->setCellValue('J' . $no,  number_format($realisasi, 2, ',', '.'))
        ->setCellValue('K' . $no,  $Ket);
    $Totalbahan = 0;
    $NoAkhirBahan = $no++;
}
$noPengadaanBibit = $NoAkhirBahan + 1; // Ambil No.baris terahir bahan + 1
// MargeCell Bibit 
$spreadsheet->getActiveSheet()->mergeCells('B' . $noPengadaanBibit . ':K' . $noPengadaanBibit); // BAHAN BAHAN
$spreadsheet->getActiveSheet()->getStyle('A' . $noPengadaanBibit)->applyFromArray($styleTableHeadSub); // BORDER I
$spreadsheet->getActiveSheet()->getStyle('B' . $noPengadaanBibit . ':K' . $noPengadaanBibit)->applyFromArray($styleTableHeadSub); // BORDER BAHAN BAHAN
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . $noPengadaanBibit, 'II')
    ->setCellValue('B' . $noPengadaanBibit, 'PENGADAAN BIBIT SULAMAN');
// LOAD DATA BIBIT
$noBi = $noPengadaanBibit + 1; // Tambahkan nilai 1 dari nilai akhir sebelumnya
$urut = 1;
$TotalBibit = 0;
$kegiatanbibit = $this->report->LoadKegiatanBibit($lokasi['id_petak']);
$ResalisasiBibir = $this->report->ReaisasiSphBibit();
foreach ($kegiatanbibit as $keyb) {
    $MguLaluBibit = $this->report->LoadBahanHarianLastBibit($keyb['id_spkbibit'], $tglmulai, $keyb['id_bibit']);
    $realbibit = $this->report->loadRealBibit($keyb['id_bibit'], $lokasi['id_petak'])['total'];
    $spreadsheet->getActiveSheet()->mergeCells('B' . $noBi . ':D' . $noBi); //buat marge cell Jenis Kegiatan BAHAN BAHAN
    $spreadsheet->getActiveSheet()->getStyle('A' . $noBi)->applyFromArray($styleBorderLeft); // BORDER nomor
    $spreadsheet->getActiveSheet()->getStyle('B' . $noBi . ':D' . $noBi)->applyFromArray($styleJenisKegiatan); // BORDER Jenis Kegiatan
    $spreadsheet->getActiveSheet()->getStyle('E' . $noBi)->applyFromArray($styleTextCenter); // BORDER satuan
    $spreadsheet->getActiveSheet()->getStyle('F' . $noBi)->applyFromArray($styleTextCenter); // BORDER Volume
    $spreadsheet->getActiveSheet()->getStyle('G' . $noBi)->applyFromArray($styleTextCenter); // BORDER s.d minggu lalu
    $spreadsheet->getActiveSheet()->getStyle('H' . $noBi)->applyFromArray($styleTextCenter); // BORDER minggu ini
    $spreadsheet->getActiveSheet()->getStyle('I' . $noBi)->applyFromArray($styleTextCenter); // BORDER S/d minggu ini
    $spreadsheet->getActiveSheet()->getStyle('J' . $noBi)->applyFromArray($styleTextCenter); // KET
    $spreadsheet->getActiveSheet()->getStyle('K' . $noBi)->applyFromArray($styleTextCenter); // KET
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $noBi,  $urut++)
        ->setCellValue('B' . $noBi, $keyb['nm_bibit'])
        ->setCellValue('E' . $noBi, $keyb['satuan'])
        ->setCellValue('F' . $noBi, number_format($keyb['nilai_spkbibit'], 2, '.', ','));
    foreach ($dates as $tgl) {
        $TotalBibit = $TotalBibit + $this->report->LoadBibitHarian($keyb['id_spkbibit'], $tgl, $keyb['id_bibit']);
    }
    $SpkBibit = $this->report->getSpkBibit($keyb['id_spkbibit']);
    $SdMingguIniBibit = $MguLaluBibit + $TotalBibit;
    $SdMingguIniBib = $this->report->ReaisasiSphBibitReport($keyb['id_spkbibit'], $lokasi['id_petak']);
    $ket = $realbibit < $SpkBibit ? "PROSES" : "LENGKAP";

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('G' . $noBi,  number_format($MguLaluBibit, 2, '.', ','))
        ->setCellValue('H' . $noBi,  number_format($TotalBibit, 2, '.', ','))
        ->setCellValue('I' . $noBi,  number_format($SdMingguIniBibit, 2, '.', ','))
        ->setCellValue('J' . $noBi,  number_format($realbibit, 2, ',', '.'))
        ->setCellValue('K' . $noBi,  $ket);
    $TotalBibit = 0;
    $noAkhirBibit = $noBi++;
}
// MargeCell Lapangan
$noPengadaanLap = $noAkhirBibit + 1; // Ambil No.baris terahir Bibit & + 1
$spreadsheet->getActiveSheet()->mergeCells('B' . $noPengadaanLap . ':K' . $noPengadaanLap); // Mergecell LAPANGAN
$spreadsheet->getActiveSheet()->getStyle('A' . $noPengadaanLap)->applyFromArray($styleTableHeadSub); // BORDER I
$spreadsheet->getActiveSheet()->getStyle('B' . $noPengadaanLap . ':K' . $noPengadaanLap)->applyFromArray($styleTableHeadSub); // BORDER LAPANGAN
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . $noPengadaanLap, 'III')
    ->setCellValue('B' . $noPengadaanLap, 'KEGIATAN DI LAPANGAN');
$noLa = $noPengadaanLap + 1; // Tambahkan nilai 1 dari nilai akhir sebelumnya
$nol = 1;
$TotalLapangan = 0;
$kegiatanlapangan = $this->report->LoadKegiatanLapangan($lokasi['id_petak']);;
foreach ($kegiatanlapangan as $keyl) {
    $MguLaluLapangan = $this->report->LoadLapanganHarianLast($keyl['id_spklapangan'], $tglmulai);
    $realisasi = $this->report->loadRealMingguanLap($keyl['id_spklapangan'], $lokasi['id_petak'])['tot'];
    $spreadsheet->getActiveSheet()->mergeCells('B' . $noLa . ':D' . $noLa); //buat marge cell Jenis Kegiatan BAHAN BAHAN
    $spreadsheet->getActiveSheet()->getStyle('A' . $noLa)->applyFromArray($styleBorderLeft); // BORDER nomor
    $spreadsheet->getActiveSheet()->getStyle('B' . $noLa . ':D' . $noLa)->applyFromArray($styleJenisKegiatan); // BORDER Jenis Kegiatan
    $spreadsheet->getActiveSheet()->getStyle('E' . $noLa)->applyFromArray($styleTextCenter); // BORDER satuan
    $spreadsheet->getActiveSheet()->getStyle('F' . $noLa)->applyFromArray($styleTextCenter); // BORDER Volume
    $spreadsheet->getActiveSheet()->getStyle('G' . $noLa)->applyFromArray($styleTextCenter); // BORDER s.d minggu lalu
    $spreadsheet->getActiveSheet()->getStyle('H' . $noLa)->applyFromArray($styleTextCenter); // BORDER minggu ini
    $spreadsheet->getActiveSheet()->getStyle('I' . $noLa)->applyFromArray($styleTextCenter); // BORDER S/d minggu ini
    $spreadsheet->getActiveSheet()->getStyle('J' . $noLa)->applyFromArray($styleTextCenter); // KET
    $spreadsheet->getActiveSheet()->getStyle('K' . $noLa)->applyFromArray($styleTextCenter); // KET
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $noLa,  $nol++)
        ->setCellValue('B' . $noLa, $keyl['nm_kegiatan'])
        ->setCellValue('E' . $noLa, $keyl['satuan'])
        ->setCellValue('F' . $noLa, number_format($keyl['nilai_spklapangan'], 2, '.', ','));
    foreach ($dates as $tgl) {
        $TotalLapangan = $TotalLapangan + $this->report->LoadLapanganHarian($keyl['id_spklapangan'], $tgl);
    }
    $SpkLapangan = $this->report->getSpkLapangan($keyl['id_spklapangan']);
    $SdMingguIni = $MguLaluLapangan + $TotalLapangan;
    $Ket = $realisasi < $SpkLapangan ? "PROSES" : "LENGKAP";
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('G' . $noLa,  number_format($MguLaluLapangan, 2, '.', ','))
        ->setCellValue('H' . $noLa,  number_format($TotalLapangan, 2, '.', ','))
        ->setCellValue('I' . $noLa,  number_format($SdMingguIni, 2, '.', ','))
        ->setCellValue('J' . $noLa,  number_format($realisasi, 2, ',', '.'))
        ->setCellValue('K' . $noLa,  $Ket);
    $TotalLapangan = 0;
    $EndNo = $noLa++;
}

$EndLine = $EndNo + 1;
$spreadsheet->getActiveSheet()->getStyle('A' . $EndLine . ':K' . $EndLine)->applyFromArray($styleTableHeadSub); // BORDER LAPANGAN
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . $EndLine,  '');


// Rename Worksheet
$Spreadsheet->getActiveSheet()->setTitle('Report Mingguan');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Report Mingguan "' . date('d-m-Y H') . '".xlsx"');
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
