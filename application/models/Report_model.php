<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    }
    // pengawasan harian di index 
    public function totalBahan()
    {
        return $this->db->query("SELECT id_petak FROM harianbahan GROUP BY id_petak ORDER BY id_petak ASC")->num_rows();
    }
    public function totalBibit()
    {
        return $this->db->query("SELECT id_petak FROM harianbibit GROUP BY id_petak ORDER BY id_petak ASC")->num_rows();
    }
    public function totalLapangan()
    {
        return $this->db->query("SELECT id_petak FROM harianlapangan GROUP BY id_petak ORDER BY id_petak ASC")->num_rows();
    }
    public function totalBibitPertama()
    {
        return $this->db->query("SELECT id_kab FROM harianbibit_i GROUP BY id_kab ORDER BY id_kab ASC")->num_rows();
    }

    // Grafik Pengawasan
    public function LoadBahan()
    {
        return $this->db->query("SELECT tgl AS tglbahan FROM harianbahan GROUP BY tgl ORDER BY tgl ASC")->result_array();
    }
    public function LoadBibit()
    {
        return $this->db->query("SELECT tgl AS tglbibit FROM harianbibit  GROUP BY tgl ORDER BY tgl ASC")->result_array();
    }
    public function LoadLapangan()
    {
        return $this->db->query("SELECT tgl AS tglap FROM harianlapangan GROUP BY tgl ORDER BY tgl ASC")->result_array();
    }
    public function LoadTallysheet()
    {
        return $this->db->query("SELECT tgl AS tgltally FROM harianbibit_i GROUP BY tgl ORDER BY tgl ASC")->result_array();
    }
    public function LoadTallysheetBibitx()
    {
        return $this->db->query("SELECT bibit.id_bibit, bibit.nm_bibit FROM harianbibit_i, bibit WHERE harianbibit_i.id_bibit=bibit.id_bibit GROUP BY bibit.id_bibit ORDER BY bibit.id_bibit ASC")->result_array();
    }
    public function getBibitTotal($bibit)
    {
        return $this->db->query("select SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM harianbibit_i WHERE id_bibit='$bibit' ")->row_array();
    }

    public function getKegiatanBahan($tgl)
    {
        return $this->db->query("SELECT count(id_spkbahan) AS jum FROM harianbahan WHERE tgl = '$tgl' AND nilai_harianbahan != '0' ")->row_array();
    }
    public function getKegiatanBibit($tgl)
    {
        return $this->db->query("SELECT count(id_spkbibit) AS jum FROM harianbibit WHERE tgl = '$tgl' AND nilai_harianbibit != '0' ")->row_array();
    }
    public function getKegiatanLap($tgl)
    {
        return $this->db->query("SELECT count(id_spklapangan) AS jum FROM harianlapangan WHERE tgl = '$tgl' AND nilai_harianlapangan != '0' ")->row_array();
    }
    public function getKegiatanTallysheet($tgl)
    {
        return $this->db->query("SELECT count(id_bibit) AS jum FROM harianbibit_i WHERE tgl = '$tgl' ")->row_array();
    }

    // data logs 
    public function getLogs()
    {
        return $this->db->query("SELECT * FROM dt_user, dt_logs WHERE dt_user.id_user = dt_logs.id_user ORDER BY dt_logs.id_logs DESC")->result_array();
    }
    public function getLogsDetail()
    {
        return $this->db->query("SELECT * FROM dt_user, dt_logs, user_role, user_sub_menu WHERE dt_user.id_user = dt_logs.id_user AND dt_user.role_id=user_role.id AND dt_logs.id_sub_menu=user_sub_menu.id ORDER BY dt_logs.id_logs DESC")->result_array();
    }
    public function getTgl()
    {
        return $this->db->query("SELECT tgl FROM `dt_logs` GROUP BY tgl ORDER BY tgl ASC")->result_array();
    }
    public function getTglTot($tgl)
    {
        return $this->db->query("SELECT COUNT(id_user) AS jum FROM `dt_logs` WHERE tgl='$tgl' ")->row_array();
    }

    // Model Report Harian 
    public function getTglBahan()
    {
        $sql = "SELECT tgl FROM harianbahan GROUP BY tgl ORDER BY tgl ASC";
        return $this->db->query($sql)->result_array();
    }

    public function LoadLokasi()
    {
        $kueri = "SELECT * FROM dt_desa, dt_kecamatan, dt_kabupaten 
                WHERE dt_desa.id_kecamatan=dt_kecamatan.id_kecamatan
                AND dt_kecamatan.id_kabupaten=dt_kabupaten.id_kabupaten
                ORDER BY dt_desa.id_desa ASC";
        return $this->db->query($kueri)->result_array();
    }

    public function getBlokHarian($IdKab, $IdKec, $IdDes)
    {
        $res = array();
        foreach ($this->LoadBlok($IdDes) as $r) {
            $cek = $this->getReportBlokCount($IdKab, $IdKec, $IdDes, $r['id_blok']);
            $r['id_kabupaten'] = $IdKab;
            $r['id_kecamatan'] = $IdKec;
            $r['id_desa'] = $IdDes;
            if ($cek['stokbahan'] > 0) {
                $res[] = $r;
            } else {
                if ($cek['stoklapangan'] > 0) {
                    $res[] = $r;
                } else {
                    if ($cek['stokbibit'] > 0) {
                        $res[] = $r;
                    }
                }
            }
        }
        return $res;
    }

    public function getReportBlokCountTally($IdKab, $IdKec, $IdDesa, $IdBlok)
    {
        $bibit = "SELECT COUNT(id_harianbibit_i) AS stokbibit FROM harianbibit_i WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'";
        $data['stokbibit'] = $this->db->query($bibit)->row_array()['stokbibit'];
        return $data;
    }

    // public function getBlokTallysheet($IdKab, $IdKec, $IdDes)
    // {
    //     $res = array();
    //     foreach ($this->LoadBlok($IdDes) as $r) {
    //         $cek = $this->getReportBlokCountTally($IdKab, $IdKec, $IdDes, $r['id_blok']);
    //         $r['id_kabupaten'] = $IdKab;
    //         $r['id_kecamatan'] = $IdKec;
    //         $r['id_desa'] = $IdDes;
    //         if ($cek['stokbibit'] > 0) {
    //             $res[] = $r;
    //         }
    //     }
    //     return $res;
    // }

    public function LoadHarianLokasi($id)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak =  '$id[4]'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->row_array();
    }

    public function getBahan($IdPetak)
    {
        $SQL = "SELECT * FROM spkbahan, jenis_kegiatan WHERE spkbahan.id_kegiatan=jenis_kegiatan.id_kegiatan AND spkbahan.id_petak='$IdPetak'";
        return $this->db->query($SQL)->result_array();
    }

    public function getBahanProgres($id_petak, $id_spkbahan)
    {
        $SQL = "SELECT SUM(nilai_harianbahan) AS totnilai FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak'  ";
        return $this->db->query($SQL)->row_array();
    }

    public function getBahanKet($id_petak, $id_spkbahan)
    {
        $SQL = "SELECT keterangan FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak'  ";
        return $this->db->query($SQL)->result_array();
    }

    public function getBibit($idSpkbibit)
    {
        $sql = "SELECT * FROM spkbibit_bantu, bibit WHERE spkbibit_bantu.id_bibit=bibit.id_bibit AND spkbibit_bantu.id_spkbibit='$idSpkbibit' ";
        return $this->db->query($sql)->result_array();
    }

    public function getBibitProgres($bibit, $petak)
    {
        $sql = "SELECT SUM(nilai_harianbibit) AS total FROM harianbibit WHERE id_petak='$petak' AND id_bibit='$bibit' ";
        return $this->db->query($sql)->row_array();
    }

    public function getLapangan($IdPetak)
    {
        $SQL = "SELECT * FROM spklapangan, jenis_kegiatan WHERE spklapangan.id_kegiatan=jenis_kegiatan.id_kegiatan AND spklapangan.id_petak='$IdPetak'";
        return $this->db->query($SQL)->result_array();
    }

    public function getLapanganProgres($id_petak, $id_spk)
    {
        $SQL = "SELECT SUM(nilai_harianlapangan) AS totnilai FROM harianlapangan WHERE id_spklapangan='$id_spk' AND id_petak='$id_petak'  ";
        return $this->db->query($SQL)->row_array();
    }

    public function getBahanProgresTgl($id_petak, $id_spkbahan, $tgl)
    {
        $SQL = "SELECT SUM(nilai_harianbahan) AS totnilai FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak' AND tgl='$tgl' ";
        return $this->db->query($SQL)->row_array();
    }

    public function getBahanKetTgl($id_petak, $id_spkbahan, $tgl)
    {
        $SQL = "SELECT keterangan FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak' AND tgl='$tgl' ";
        return $this->db->query($SQL)->result_array();
    }

    public function getBibitProgresTgl($bibit, $petak, $tgl)
    {
        $sql = "SELECT SUM(nilai_harianbibit) AS total FROM harianbibit WHERE id_petak='$petak' AND id_bibit='$bibit' AND tgl='$tgl' ";
        return $this->db->query($sql)->row_array();
    }

    public function getLapanganProgresTgl($id_petak, $id_spk, $tgl)
    {
        $SQL = "SELECT SUM(nilai_harianlapangan) AS totnilai FROM harianlapangan WHERE id_spklapangan='$id_spk' AND id_petak='$id_petak' AND tgl='$tgl' ";
        return $this->db->query($SQL)->row_array();
    }

    // VIEW PENGAWASAN BIBIT PERTAMA
    public function getBibitUserPertama($id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, harianbibit_i
                    WHERE dt_kabupaten.id_kabupaten = harianbibit_i.id_kab
                    AND harianbibit_i.id_user = '$id_user'
                    GROUP BY dt_kabupaten.id_kabupaten ORDER BY dt_kabupaten.id_kabupaten DESC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getBibitUserBlokPertama($id_desa, $id_user)
    {
        $kueri = "SELECT * FROM tb_blok, tb_petak, harianbibit_i
                    WHERE tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbibit_i.id_petak
                    AND tb_blok.id_desa = '$id_desa'
                    AND harianbibit_i.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getBibitPertamaUserPetak($id_user, $id_blok)
    {
        $kueri = "SELECT * FROM tb_petak, harianbibit_i
                    WHERE tb_petak.id_petak = harianbibit_i.id_petak
                    AND tb_petak.id_blok = '$id_blok'
                    AND harianbibit_i.id_user = '$id_user'
                    GROUP BY tb_petak.id_petak ORDER BY tb_petak.id_petak ASC ";
        return $this->db->query($kueri)->result_array();
    }
    // VIEW PENGAWASAN BIBIT KEDUA
    public function getBibitUser($id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak, harianbibit
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbibit.id_petak
                    AND harianbibit.id_user = '$id_user'
                    GROUP BY dt_desa.id_desa  ORDER BY dt_desa.id_desa ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getBibitUserBlok($id_desa, $id_user)
    {
        $kueri = "SELECT * FROM tb_blok, tb_petak, harianbibit
                    WHERE tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbibit.id_petak
                    AND tb_blok.id_desa = '$id_desa'
                    AND harianbibit.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getBibitUserPetak($id_user, $id_blok)
    {
        $kueri = "SELECT * FROM tb_petak, harianbibit
                    WHERE tb_petak.id_petak = harianbibit.id_petak
                    AND tb_petak.id_blok = '$id_blok'
                    AND harianbibit.id_user = '$id_user'
                    GROUP BY tb_petak.id_petak ORDER BY tb_petak.id_petak ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getDetPengawasanBibit($idpetak, $id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak, harianbibit, dt_user
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbibit.id_petak
                    AND harianbibit.id_user = dt_user.id_user
                    AND harianbibit.id_petak = '$idpetak'
                    AND harianbibit.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanTotLuasBibit($id_petak, $id_user)
    {
        $kueri = "SELECT SUM(luas) AS totluas FROM harianbibit 
        WHERE id_petak='$id_petak' AND id_user='$id_user'";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanBibit($idpetak)
    {
        $kueri = "SELECT * FROM tb_petak, spkbibit
                    WHERE tb_petak.id_petak = spkbibit.id_petak
                    AND spkbibit.id_petak = '$idpetak' ";
        return $this->db->query($kueri)->result_array();
    }
    public function getDataPengawasanBibitnya($id_spkbibit)
    {
        $kueri = "SELECT * FROM bibit, spkbibit_bantu
                    WHERE bibit.id_bibit=spkbibit_bantu.id_bibit
                    AND spkbibit_bantu.id_spkbibit='$id_spkbibit'";
        return $this->db->query($kueri)->result_array();
    }
    public function getRealisasiBibitnya($idspk)
    {
        $sql = "SELECT SUM(nilai_harianbibit) AS nilaibibit FROM harianbibit WHERE id_spkbibit='$idspk' ";
        return $this->db->query($sql)->row_array();
    }

    // Input - View Detail pengawasan bibit Tahap 1 Page PL 
    public function getDetPengawasanBibitPl($idkab, $id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, harianbibit_i, dt_user
                    WHERE dt_kabupaten.id_kabupaten = harianbibit_i.id_kab 
                    AND harianbibit_i.id_user = dt_user.id_user
                    AND harianbibit_i.id_kab = '$idkab'
                    AND harianbibit_i.id_user = '$id_user'
                    GROUP BY harianbibit_i.id_kab ORDER BY harianbibit_i.id_kab DESC ";
        return $this->db->query($kueri)->row_array();
    }
    public function getPengawasanTotLuasTallysheetPl($kab, $id_user)
    {
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit_i WHERE id_kab='$kab' AND id_user='$id_user' ";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }
    public function getJumBibitTallysheetPl($kab, $user)
    {
        $sql = "SELECT SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM `harianbibit_i` WHERE id_kab='$kab' AND id_user='$user' ";
        return $this->db->query($sql)->row_array();
    }
    public function getkabTallysheetBibit($kab, $user)
    {
        $sql = "SELECT bibit.id_bibit, bibit.nm_bibit FROM bibit, harianbibit_i WHERE harianbibit_i.id_bibit=bibit.id_bibit AND harianbibit_i.id_kab='$kab' AND harianbibit_i.id_user='$user' GROUP BY bibit.id_bibit ORDER BY bibit.id_bibit ASC";
        return $this->db->query($sql)->result_array();
    }
    public function getBibitProgresTallysheetPl($kab, $bibit, $user)
    {
        $sql = "SELECT SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM `harianbibit_i` WHERE id_kab='$kab' AND id_bibit='$bibit' AND id_user='$user' ";
        return $this->db->query($sql)->row_array();
    }

    // VIEW PENGAWASAN LAPANGAN
    public function getLapanganUser($id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak, harianlapangan
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianlapangan.id_petak
                    AND harianlapangan.id_user = '$id_user'
                    GROUP BY dt_desa.id_desa ORDER BY dt_desa.id_desa ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getLapanganUserBlok($id_desa, $id_user)
    {
        $kueri = "SELECT * FROM tb_blok, tb_petak, harianlapangan
                    WHERE tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianlapangan.id_petak
                    AND tb_blok.id_desa = '$id_desa'
                    AND harianlapangan.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getLapanganUserPetak($id_user, $id_blok)
    {
        $kueri = "SELECT * FROM tb_petak, harianlapangan
                    WHERE tb_petak.id_petak = harianlapangan.id_petak
                    AND tb_petak.id_blok = '$id_blok'
                    AND harianlapangan.id_user = '$id_user'
                    GROUP BY tb_petak.id_petak ORDER BY tb_petak.id_petak  ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getDetPengawasanLap($idpetak, $id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak, harianlapangan, dt_user
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianlapangan.id_petak
                    AND harianlapangan.id_user = dt_user.id_user
                    AND harianlapangan.id_petak = '$idpetak'
                    AND harianlapangan.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanTotLuasLap($id_petak, $id_user)
    {
        $kueri = "SELECT SUM(luas) AS totluas FROM harianlapangan 
        WHERE id_petak='$id_petak' AND id_user='$id_user'";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanLap($idpetak)
    {
        $kueri = "SELECT * FROM spklapangan, jenis_kegiatan
                    WHERE spklapangan.id_kegiatan = jenis_kegiatan.id_kegiatan
                    AND spklapangan.id_petak = '$idpetak'";
        return $this->db->query($kueri)->result_array();
    }
    public function getDataPengawasanTotNilaiLap($id_spklapangan, $id_petak)
    {
        $kueri = "SELECT SUM(nilai_harianlapangan) AS totnilai FROM harianlapangan 
        WHERE id_spklapangan='$id_spklapangan' AND id_petak='$id_petak'";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanTotNilaiBibit($id_bibit, $id_petak)
    {
        $kueri = "SELECT SUM(nilai_harianbibit) AS totnilai FROM harianbibit 
        WHERE id_bibit='$id_bibit' AND id_petak='$id_petak'";
        return $this->db->query($kueri)->row_array();
    }

    // VIEW PENGAWASAN USER Bahan
    public function getBahanUser($id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak, harianbahan
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbahan.id_petak
                    AND harianbahan.id_user = '$id_user'
                    GROUP BY dt_desa.id_desa ORDER BY dt_desa.id_desa ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getBahanUserBlok($id_desa, $id_user)
    {
        $kueri = "SELECT * FROM tb_blok, tb_petak, harianbahan
                    WHERE tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbahan.id_petak
                    AND tb_blok.id_desa = '$id_desa'
                    AND harianbahan.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok  ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getBahanUserPetak($id_user, $id_blok)
    {
        $kueri = "SELECT * FROM tb_petak, harianbahan
                    WHERE tb_petak.id_petak = harianbahan.id_petak
                    AND tb_petak.id_blok = '$id_blok'
                    AND harianbahan.id_user = '$id_user'
                    GROUP BY tb_petak.id_petak ORDER BY tb_petak.id_petak ASC ";
        return $this->db->query($kueri)->result_array();
    }
    public function getDetPengawasanBahan($idpetak, $id_user)
    {
        $kueri = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak, harianbahan, dt_user
                    WHERE dt_kabupaten.id_kabupaten = dt_kecamatan.id_kabupaten 
                    AND dt_kecamatan.id_kecamatan = dt_desa.id_kecamatan
                    AND dt_desa.id_desa = tb_blok.id_desa
                    AND tb_blok.id_blok = tb_petak.id_blok
                    AND tb_petak.id_petak = harianbahan.id_petak
                    AND harianbahan.id_user = dt_user.id_user
                    AND harianbahan.id_petak = '$idpetak'
                    AND harianbahan.id_user = '$id_user'
                    GROUP BY tb_blok.id_blok ORDER BY tb_blok.id_blok ASC ";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanBahan($idpetak)
    {
        $kueri = "SELECT * FROM spkbahan, jenis_kegiatan
                    WHERE spkbahan.id_kegiatan = jenis_kegiatan.id_kegiatan
                    AND spkbahan.id_petak = '$idpetak'";
        return $this->db->query($kueri)->result_array();
    }
    public function getDataPengawasanTotNilai($id_spkbahan, $id_petak)
    {
        $kueri = "SELECT SUM(nilai_harianbahan) AS totnilai FROM harianbahan 
        WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak'";
        return $this->db->query($kueri)->row_array();
    }
    public function getDataPengawasanTotLuas($id_petak, $id_user)
    {
        $kueri = "SELECT SUM(luas) AS totluas FROM harianbahan 
        WHERE id_petak='$id_petak' AND id_user='$id_user'";
        return $this->db->query($kueri)->row_array();
    }

    // 

    // public function getReportKab()
    // {
    //     $kueri = "SELECT * FROM harianbahan, tb_petak, tb_blok, dt_desa, dt_kecamatan, dt_kabupaten
    //             WHERE tb_petak.id_blok=tb_blok.id_blok
    //             AND tb_blok.id_desa=dt_desa.id_desa
    //             AND dt_desa.id_kecamatan=dt_kecamatan.id_kecamatan
    //             AND dt_kecamatan.id_kabupaten=dt_kabupaten.id_kabupaten
    //             AND harianbahan.id_petak=tb_petak.id_petak";
    //     return $this->db->query($kueri)->result_array();
    // }
    public function getReportKabupatenCount($id)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_kab='$id'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_kab='$id'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_kab='$id'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function getReportKecamatanCount($IdKab, $IdKec)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_kab='$IdKab' AND id_kec = '$IdKec'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_kab='$IdKab' AND id_kec = '$IdKec'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_kab='$IdKab' AND id_kec = '$IdKec'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function getReportDesaCount($IdKab, $IdKec, $IdDesa)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }
    public function getReportbibitCount($IdKab, $IdKec, $IdDesa)
    {
        $bibit = "SELECT COUNT(id_harianbibit_i) AS stokbibit FROM harianbibit_i WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa'";
        $data['stokbibit'] = $this->db->query($bibit)->row_array()['stokbibit'];
        return $data;
    }

    public function getReportBlokCount($IdKab, $IdKec, $IdDesa, $IdBlok)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function getReportPetakCount($IdKab, $IdKec, $IdDesa, $IdBlok, $IdPetak)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'  AND id_petak = '$IdPetak'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'  AND id_petak = '$IdPetak'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'  AND id_petak = '$IdPetak'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function LoadKabupaten()
    {
        $kueri = "SELECT id_kabupaten, nm_kabupaten FROM dt_kabupaten ORDER BY nm_kabupaten ASC";
        return $this->db->query($kueri)->result_array();
    }

    public function LoadKecamatan($id_kab)
    {
        $kueri = "SELECT id_kecamatan, nm_kecamatan, nm_kabupaten FROM dt_kecamatan, dt_kabupaten 
                WHERE dt_kecamatan.id_kabupaten=dt_kabupaten.id_kabupaten
                AND dt_kecamatan.id_kabupaten = '$id_kab' ORDER BY nm_kecamatan ASC";
        return $this->db->query($kueri)->result_array();
    }

    public function LoadDesa($id_kec)
    {
        $kueri = "SELECT id_desa, nm_desa, nm_kecamatan, nm_kabupaten FROM dt_desa, dt_kecamatan, dt_kabupaten 
                WHERE dt_desa.id_kecamatan=dt_kecamatan.id_kecamatan
                AND dt_kecamatan.id_kabupaten=dt_kabupaten.id_kabupaten
                AND dt_desa.id_kecamatan = '$id_kec' 
                ORDER BY dt_desa.nm_desa ASC";
        return $this->db->query($kueri)->result_array();
    }

    public function LoadBlok($id_desa)
    {
        $kueri = "SELECT id_blok, nm_blok, nm_desa, nm_kecamatan, nm_kabupaten FROM tb_blok, dt_desa, dt_kecamatan, dt_kabupaten 
                WHERE tb_blok.id_desa=dt_desa.id_desa 
                AND dt_desa.id_kecamatan=dt_kecamatan.id_kecamatan 
                AND dt_kecamatan.id_kabupaten=dt_kabupaten.id_kabupaten 
                AND tb_blok.id_desa = '$id_desa' 
                ORDER BY tb_blok.nm_blok ASC";
        return $this->db->query($kueri)->result_array();
    }

    public function LoadPetakx($IdBlok)
    {
        $kueri = "SELECT * FROM tb_petak WHERE id_blok = '$IdBlok' ORDER BY nm_petak ASC";
        return $this->db->query($kueri)->result_array();
    }

    public function LoadPetaks($Id)
    {
        $id_petak = $Id[4];
        $sql = "SELECT nm_kabupaten, nm_kecamatan, nm_desa, nm_blok, tb_petak.* FROM dt_kabupaten, dt_kecamatan, dt_desa, tb_blok, tb_petak
                WHERE dt_kecamatan.id_kabupaten=dt_kabupaten.id_kabupaten
                AND dt_desa.id_kecamatan=dt_kecamatan.id_kecamatan
                AND tb_blok.id_desa=dt_desa.id_desa
                AND tb_petak.id_blok=tb_blok.id_blok
                AND tb_petak.id_petak='$id_petak'";
        return $this->db->query($sql)->row_array();
    }


    public function LoadPetak($IdKab, $IdKec, $IdDes, $IdBlok)
    {
        $res = array();
        foreach ($this->LoadPetakx($IdBlok) as $key => $r) {
            $cek = $this->getReportPetakCount($IdKab, $IdKec, $IdDes, $IdBlok, $r['id_petak']);
            $r['id_kabupaten'] = $IdKab;
            $r['id_kecamatan'] = $IdKec;
            $r['id_desa'] = $IdDes;
            $r['id_blok'] = $IdBlok;
            if ($cek['stokbahan'] > 0) {
                $res[] = $r;
            } else {
                if ($cek['stoklapangan'] > 0) {
                    $res[] = $r;
                } else {
                    if ($cek['stokbibit'] > 0) {
                        $res[] = $r;
                    }
                }
            }
        }
        return $res;
    }
    // tally sheet bibit - report 
    public function tallySheet()
    {
        $sql = "SELECT * FROM dt_kabupaten, harianbibit_i WHERE dt_kabupaten.id_kabupaten=harianbibit_i.id_kab GROUP BY dt_kabupaten.id_kabupaten ORDER BY dt_kabupaten.id_kabupaten ASC ";
        return $this->db->query($sql)->result_array();
    }
    public function getReportPetakCountTally($IdKab, $IdKec, $IdDesa, $IdBlok, $IdPetak)
    {
        $bahan = "SELECT COUNT(id_harianbibit_i) AS stokbibit FROM harianbibit_i WHERE id_kab='$IdKab' AND id_kec = '$IdKec' AND id_desa = '$IdDesa' AND id_blok = '$IdBlok'  AND id_petak = '$IdPetak'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function LoadHarianLokasiTallysheet($id)
    {
        $kueri = "SELECT * FROM dt_kabupaten, harianbibit_i
            WHERE dt_kabupaten.id_kabupaten = harianbibit_i.id_kab 
            AND harianbibit_i.id_kab =  '$id'
            GROUP BY  harianbibit_i.id_kab ORDER BY harianbibit_i.id_kab ASC ";
        return $this->db->query($kueri)->row_array();
    }
    public function getPengawasanTotLuasTallysheet($kab)
    {
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit_i WHERE id_kab='$kab'";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }
    public function getJumBibitTallysheet($kab)
    {
        $sql = "SELECT SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM `harianbibit_i` WHERE id_kab='$kab'";
        return $this->db->query($sql)->row_array();
    }
    public function getkabTallysheetBibitReport($kab)
    {
        $sql = "SELECT bibit.id_bibit, bibit.nm_bibit FROM bibit, harianbibit_i WHERE harianbibit_i.id_bibit=bibit.id_bibit AND harianbibit_i.id_kab='$kab' GROUP BY bibit.id_bibit ORDER BY bibit.id_bibit ASC";
        return $this->db->query($sql)->result_array();
    }
    public function getBibitProgresTallysheet($kab, $bibit)
    {
        $sql = "SELECT SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM `harianbibit_i` WHERE id_kab='$kab' AND id_bibit='$bibit' ";
        return $this->db->query($sql)->row_array();
    }

    // tallySheet report TGL
    public function getPengawasanTotLuasTallysheetTgl($kab, $tgl)
    {
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit_i WHERE id_kab='$kab' AND tgl='$tgl' ";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }
    public function getJumBibitTallysheetTgl($kab, $tgl)
    {
        $sql = "SELECT SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM `harianbibit_i` WHERE id_kab='$kab' AND tgl='$tgl' ";
        return $this->db->query($sql)->row_array();
    }
    public function getkabTallysheetBibitReportTgl($kab, $tgl)
    {
        $sql = "SELECT bibit.id_bibit, bibit.nm_bibit FROM bibit, harianbibit_i WHERE harianbibit_i.id_bibit=bibit.id_bibit AND harianbibit_i.id_kab='$kab' AND harianbibit_i.tgl='$tgl' GROUP BY bibit.id_bibit ORDER BY bibit.id_bibit ASC";
        return $this->db->query($sql)->result_array();
    }
    public function getBibitProgresTallysheetTgl($kab, $bibit, $tgl)
    {
        $sql = "SELECT SUM(nilai_pertama) AS pertama, SUM(nilai_kedua) AS kedua, SUM(nilai_ketiga) AS ketiga FROM `harianbibit_i` WHERE id_kab='$kab' AND id_bibit='$bibit' AND tgl='$tgl' ";
        return $this->db->query($sql)->row_array();
    }

    // public function LoadPetakTally($IdKab, $IdKec, $IdDes, $IdBlok)
    // {
    //     $res = array();
    //     foreach ($this->LoadPetakx($IdBlok) as $r) {
    //         $cek = $this->getReportPetakCountTally($IdKab, $IdKec, $IdDes, $IdBlok, $r['id_petak']);
    //         $r['id_kabupaten'] = $IdKab;
    //         $r['id_kecamatan'] = $IdKec;
    //         $r['id_desa'] = $IdDes;
    //         $r['id_blok'] = $IdBlok;
    //         if ($cek['stokbibit'] > 0) {
    //             $res[] = $r;
    //         }
    //     }
    //     return $res;
    // }

    public function getPengawasanTotLuasTgl($petak, $tgl)
    {
        $sql = "SELECT SUM(luas) AS nilaibahan FROM harianbahan WHERE id_petak='$petak' AND tgl='$tgl' ";
        $data['nilaibahan'] = $this->db->query($sql)->row_array()['nilaibahan'];
        $sql = "SELECT SUM(luas) AS nilailapangan FROM harianlapangan WHERE id_petak='$petak' AND tgl='$tgl' ";
        $data['nilailapangan'] = $this->db->query($sql)->row_array()['nilailapangan'];
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit WHERE id_petak='$petak' AND tgl='$tgl' ";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }
    public function getPengawasanTotLuas($petak)
    {
        $sql = "SELECT SUM(luas) AS nilaibahan FROM harianbahan WHERE id_petak='$petak'";
        $data['nilaibahan'] = $this->db->query($sql)->row_array()['nilaibahan'];
        $sql = "SELECT SUM(luas) AS nilailapangan FROM harianlapangan WHERE id_petak='$petak'";
        $data['nilailapangan'] = $this->db->query($sql)->row_array()['nilailapangan'];
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit WHERE id_petak='$petak'";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }

    public function LoadKegiatanBahan($idPetak)
    {
        $sql = "SELECT * FROM spkbahan, jenis_kegiatan
                WHERE spkbahan.id_kegiatan=jenis_kegiatan.id_kegiatan
                AND spkbahan.id_petak='$idPetak'";
        return $this->db->query($sql)->result_array();
    }

    public function LoadKegiatanBibit($idPetak)
    {
        $sql = "SELECT * FROM bibit, spkbibit_bantu, spkbibit
                WHERE bibit.id_bibit=spkbibit_bantu.id_bibit
                AND spkbibit_bantu.id_spkbibit=spkbibit.id_spkbibit
                AND spkbibit.id_petak='$idPetak'";
        return $this->db->query($sql)->result_array();
    }

    public function LoadKegiatanLapangan($idPetak)
    {
        $sql = "SELECT * FROM spklapangan, jenis_kegiatan
                WHERE spklapangan.id_kegiatan=jenis_kegiatan.id_kegiatan
                AND spklapangan.id_petak='$idPetak'";
        return $this->db->query($sql)->result_array();
    }

    public function LoadBahanHarian($IdSpk, $Tgl)
    {
        $sql = "SELECT SUM(nilai_harianbahan) as tot FROM harianbahan WHERE id_spkbahan = '$IdSpk' AND tgl = '$Tgl'";
        $r = $this->db->query($sql)->result_array();
        $res = !empty($r[0]['tot']) ? $r[0]['tot'] : 0;
        return $res;
    }

    public function LoadBibitHarian($IdSpk, $Tgl, $IdBibit)
    {
        $sql = "SELECT SUM(nilai_harianbibit) as tot FROM harianbibit WHERE id_spkbibit = '$IdSpk' AND tgl = '$Tgl' AND id_bibit = '$IdBibit'";
        $r = $this->db->query($sql)->result_array();
        $res = !empty($r[0]['tot']) ? $r[0]['tot'] : 0;
        return $res;
    }

    public function LoadLapanganHarian($IdSpk, $Tgl)
    {
        $sql = "SELECT SUM(nilai_harianlapangan) as tot FROM harianlapangan WHERE id_spklapangan = '$IdSpk' AND tgl = '$Tgl'";
        $r = $this->db->query($sql)->result_array();
        $res = !empty($r[0]['tot']) ? $r[0]['tot'] : 0;
        return $res;
    }

    public function getSpkBahan($id)
    {
        $sql = "SELECT nilai_spkbahan as tot FROM spkbahan WHERE id_spkbahan = '$id'";
        $r = $this->db->query($sql)->result_array();
        $res = !empty($r[0]['tot']) ? $r[0]['tot'] : 0;
        return $res;
    }

    public function getSpkBibit($id)
    {
        $sql = "SELECT nilai_spkbibit as tot FROM spkbibit WHERE id_spkbibit = '$id'";
        $r = $this->db->query($sql)->result_array();
        $res = !empty($r[0]['tot']) ? $r[0]['tot'] : 0;
        return $res;
    }

    public function getSpkLapangan($id)
    {
        $sql = "SELECT nilai_spklapangan as tot FROM spklapangan WHERE id_spklapangan = '$id'";
        $r = $this->db->query($sql)->result_array();
        $res = !empty($r[0]['tot']) ? $r[0]['tot'] : 0;
        return $res;
    }

    public function ReaisasiSphBibit()
    {
        $sql = "SELECT SUM(nilai_harianbibit) as tot , id_spkbibit FROM harianbibit";
        $r = $this->db->query($sql)->result_array();
        $res = array();
        foreach ($r as $rs) {
            $res[$rs['id_spkbibit']] = $rs['tot'];
        }
        return $res;
    }


    public function getJumlah($Id)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_petak = '$Id'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array();
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_petak = '$Id'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array();
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_petak = '$Id'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array();
        return $data;
    }
}
