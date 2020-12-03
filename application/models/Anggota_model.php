<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    }
    // Tally Sheet
    public function getReportLokasiCountTS($kab, $idanggota)
    {
        $bahan = "SELECT COUNT(id_harianbibit_i) AS stokbibit FROM harianbibit_i WHERE id_kab='$kab' AND id_user='$idanggota' ";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }
    public function getBlokHarianTS($des, $pl)
    {
        $res = array();
        foreach ($this->db->get_where('tb_blok', ['id_desa' => $des])->result_array() as $r) {
            $cek = $this->getBlokCountTS($r['id_blok'], $pl);
            if ($cek['stokbibit'] > 0) {
                $res[] = $r;
            }
        }
        return $res;
    }
    public function getBlokCountTS($IdBlok, $pl)
    {
        $bahan = "SELECT COUNT(id_harianbibit_i) AS stokbibit FROM harianbibit_i WHERE id_user='$pl' AND id_blok = '$IdBlok'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }
    public function LoadPetakTS($blok, $pl)
    {
        $res = array();
        foreach ($this->db->get_where('tb_petak', ['id_blok' => $blok])->result_array() as $r) {
            $cek = $this->getPetakCountTS($r['id_petak'], $pl);
            if ($cek['stokbibit'] > 0) {
                $res[] = $r;
            }
        }
        return $res;
    }
    public function getPetakCountTS($IdPetak, $pl)
    {
        $bahan = "SELECT COUNT(id_harianbibit_i) AS stokbibit FROM harianbibit_i WHERE id_user='$pl' AND id_petak = '$IdPetak'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }
    // Pengawasan TS 
    public function loadPengawasanLokasiTS($id)
    {
        $kueri = "SELECT * FROM dt_kabupaten, harianbibit_i
                    WHERE dt_kabupaten.id_kabupaten = harianbibit_i.id_kab 
                    AND harianbibit_i.id_kab =  '$id[0]'
                    AND harianbibit_i.id_user =  '$id[1]'
                    GROUP BY  harianbibit_i.id_kab ORDER BY  harianbibit_i.id_kab ASC ";
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

    // controller anggota 
    public function getAnggota($idsupervisor)
    {
        $sql = "SELECT * FROM dt_user, user_anggota WHERE dt_user.id_user=user_anggota.id_anggota AND user_anggota.id_supervisor='$idsupervisor'";
        return $this->db->query($sql)->result_array();
    }

    public function loadLokasi()
    {
        $sql = "SELECT * FROM dt_kabupaten, dt_kecamatan, dt_desa WHERE dt_kabupaten.id_kabupaten=dt_kecamatan.id_kabupaten AND dt_kecamatan.id_kecamatan=dt_desa.id_kecamatan ";
        return $this->db->query($sql)->result_array();
    }

    public function getReportLokasiCount($kab, $kec, $des, $idanggota)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_kab='$kab' AND id_kec='$kec' AND id_desa='$des' AND id_user='$idanggota' ";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_kab='$kab' AND id_kec='$kec' AND id_desa='$des' AND id_user='$idanggota' ";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_kab='$kab' AND id_kec='$kec' AND id_desa='$des' AND id_user='$idanggota' ";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function getBlokHarian($des, $pl)
    {
        $res = array();
        foreach ($this->db->get_where('tb_blok', ['id_desa' => $des])->result_array() as $r) {
            $cek = $this->getBlokCount($r['id_blok'], $pl);
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

    public function getBlokCount($IdBlok, $pl)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_user='$pl' AND id_blok = '$IdBlok'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_user='$pl' AND id_blok = '$IdBlok'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_user='$pl' AND id_blok = '$IdBlok'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    public function LoadPetak($blok, $pl)
    {
        $res = array();
        foreach ($this->db->get_where('tb_petak', ['id_blok' => $blok])->result_array() as $r) {
            $cek = $this->getPetakCount($r['id_petak'], $pl);
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
    public function getPetakCount($IdPetak, $pl)
    {
        $bahan = "SELECT COUNT(id_harianbahan) AS stokbahan FROM harianbahan WHERE id_user='$pl' AND id_petak = '$IdPetak'";
        $data['stokbahan'] = $this->db->query($bahan)->row_array()['stokbahan'];
        $bahan = "SELECT COUNT(id_harianlapangan) AS stoklapangan FROM harianlapangan WHERE id_user='$pl' AND id_petak = '$IdPetak'";
        $data['stoklapangan'] = $this->db->query($bahan)->row_array()['stoklapangan'];
        $bahan = "SELECT COUNT(id_harianbibit) AS stokbibit FROM harianbibit WHERE id_user='$pl' AND id_petak = '$IdPetak'";
        $data['stokbibit'] = $this->db->query($bahan)->row_array()['stokbibit'];
        return $data;
    }

    // pengawasan.php 
    public function loadPengawasanLokasi($id)
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

    public function getPengawasanTotLuas($petak, $pl)
    {
        $sql = "SELECT SUM(luas) AS nilaibahan FROM harianbahan WHERE id_petak='$petak' AND id_user='$pl' ";
        $data['nilaibahan'] = $this->db->query($sql)->row_array()['nilaibahan'];
        $sql = "SELECT SUM(luas) AS nilailapangan FROM harianlapangan WHERE id_petak='$petak' AND id_user='$pl' ";
        $data['nilailapangan'] = $this->db->query($sql)->row_array()['nilailapangan'];
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit WHERE id_petak='$petak' AND id_user='$pl' ";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }

    public function getBahan($IdPetak)
    {
        $SQL = "SELECT * FROM spkbahan, jenis_kegiatan WHERE spkbahan.id_kegiatan=jenis_kegiatan.id_kegiatan AND spkbahan.id_petak='$IdPetak'";
        return $this->db->query($SQL)->result_array();
    }

    public function getBahanProgres($id_petak, $id_spkbahan, $pl)
    {
        $SQL = "SELECT SUM(nilai_harianbahan) AS totnilai FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak' AND id_user='$pl' ";
        return $this->db->query($SQL)->row_array();
    }

    public function getBahanKet($id_petak, $id_spkbahan, $pl)
    {
        $SQL = "SELECT keterangan FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak' AND id_user='$pl' ";
        return $this->db->query($SQL)->result_array();
    }

    public function getRealisasiBibitnya($idspk, $pl)
    {
        $sql = "SELECT SUM(nilai_harianbibit) AS nilaibibit FROM harianbibit WHERE id_spkbibit='$idspk' AND id_user='$pl' ";
        return $this->db->query($sql)->row_array();
    }

    public function getBibit($idSpkbibit)
    {
        $sql = "SELECT * FROM spkbibit_bantu, bibit WHERE spkbibit_bantu.id_bibit=bibit.id_bibit AND spkbibit_bantu.id_spkbibit='$idSpkbibit' ";
        return $this->db->query($sql)->result_array();
    }

    public function getBibitProgres($bibit, $petak, $pl)
    {
        $sql = "SELECT SUM(nilai_harianbibit) AS total FROM harianbibit WHERE id_petak='$petak' AND id_bibit='$bibit' AND id_user='$pl' ";
        return $this->db->query($sql)->row_array();
    }

    public function getLapangan($IdPetak)
    {
        $SQL = "SELECT * FROM spklapangan, jenis_kegiatan WHERE spklapangan.id_kegiatan=jenis_kegiatan.id_kegiatan AND spklapangan.id_petak='$IdPetak'";
        return $this->db->query($SQL)->result_array();
    }

    public function getLapanganProgres($id_petak, $id_spk, $pl)
    {
        $SQL = "SELECT SUM(nilai_harianlapangan) AS totnilai FROM harianlapangan WHERE id_spklapangan='$id_spk' AND id_petak='$id_petak' AND id_user='$pl' ";
        return $this->db->query($SQL)->row_array();
    }

    public function getPengawasanTotLuasTgl($petak, $tgl, $pl)
    {
        $sql = "SELECT SUM(luas) AS nilaibahan FROM harianbahan WHERE id_petak='$petak' AND tgl='$tgl' AND id_user='$pl' ";
        $data['nilaibahan'] = $this->db->query($sql)->row_array()['nilaibahan'];
        $sql = "SELECT SUM(luas) AS nilailapangan FROM harianlapangan WHERE id_petak='$petak' AND tgl='$tgl' AND id_user='$pl' ";
        $data['nilailapangan'] = $this->db->query($sql)->row_array()['nilailapangan'];
        $sql = "SELECT SUM(luas) AS nilaibibit FROM harianbibit WHERE id_petak='$petak' AND tgl='$tgl' AND id_user='$pl' ";
        $data['nilaibibit'] = $this->db->query($sql)->row_array()['nilaibibit'];
        return $data;
    }

    public function getBahanProgresTgl($id_petak, $id_spkbahan, $tgl, $pl)
    {
        $SQL = "SELECT SUM(nilai_harianbahan) AS totnilai FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak' AND tgl='$tgl' AND id_user='$pl' ";
        return $this->db->query($SQL)->row_array();
    }

    public function getBahanKetTgl($id_petak, $id_spkbahan, $tgl, $pl)
    {
        $SQL = "SELECT keterangan FROM harianbahan WHERE id_spkbahan='$id_spkbahan' AND id_petak='$id_petak' AND tgl='$tgl' AND id_user='$pl' ";
        return $this->db->query($SQL)->result_array();
    }

    public function getBibitProgresTgl($bibit, $petak, $tgl, $pl)
    {
        $sql = "SELECT SUM(nilai_harianbibit) AS total FROM harianbibit WHERE id_petak='$petak' AND id_bibit='$bibit' AND tgl='$tgl' AND id_user='$pl' ";
        return $this->db->query($sql)->row_array();
    }

    public function getLapanganProgresTgl($id_petak, $id_spk, $tgl, $pl)
    {
        $SQL = "SELECT SUM(nilai_harianlapangan) AS totnilai FROM harianlapangan WHERE id_spklapangan='$id_spk' AND id_petak='$id_petak' AND tgl='$tgl' AND id_user='$pl' ";
        return $this->db->query($SQL)->row_array();
    }
}
