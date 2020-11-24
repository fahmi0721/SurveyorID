<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    }
    public function getTotalRealisasiLapangan($IdSpkLapangan)
    {
        $sql = "SELECT SUM(nilai_harianlapangan) as tot FROM harianlapangan WHERE id_spklapangan = '$IdSpkLapangan'";
        $r = $this->db->query($sql)->result_array();
        $rs = empty($r[0]['tot']) ? 0 : $r[0]['tot'];
        return $rs;
    }
    public function getLapanganKegiatnModel($IdPetak)
    {
        $query = "SELECT spklapangan.id_spklapangan,spklapangan.nilai_spklapangan, jenis_kegiatan.nm_kegiatan FROM spklapangan  INNER JOIN jenis_kegiatan  ON spklapangan.id_kegiatan = jenis_kegiatan.id_kegiatan WHERE spklapangan.id_petak = '$IdPetak'";
        $r = $this->db->query($query);
        $result = array();
        foreach ($r->result_array() as $row) {
            $JumlahRealisai = $this->getTotalRealisasiLapangan($row['id_spklapangan']);
            if ($JumlahRealisai < $row['nilai_spklapangan']) {
                $result[] = $row;
            }
        }
        return $result;
    }
    public function getTotalRealisasi($IdSpkBahan)
    {
        $sql = "SELECT SUM(nilai_harianbahan) as tot FROM harianbahan WHERE id_spkbahan = '$IdSpkBahan'";
        $r = $this->db->query($sql)->result_array();
        $rs = $r[0]['tot'];
        return $rs;
    }

    public function getBahanKegiatnModel($IdPetak)
    {
        $query = "SELECT spkbahan.id_spkbahan,spkbahan.nilai_spkbahan, jenis_kegiatan.nm_kegiatan FROM spkbahan  INNER JOIN jenis_kegiatan  ON spkbahan.id_kegiatan = jenis_kegiatan.id_kegiatan WHERE spkbahan.id_petak = '$IdPetak'";
        $r = $this->db->query($query);
        $result = array();
        foreach ($r->result_array() as $row) {
            $JumlahRealisai = $this->getTotalRealisasi($row['id_spkbahan']);
            if ($JumlahRealisai < $row['nilai_spkbahan']) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getSatuanKegiatan($idnya)
    {
        $sql = "SELECT jenis_kegiatan.satuan FROM jenis_kegiatan, spklapangan 
            WHERE jenis_kegiatan.id_kegiatan=spklapangan.id_kegiatan
            AND spklapangan.id_spklapangan = '$idnya'";
        return $this->db->query($sql)->row_array();
    }

    public function getSatuanBahan($idnya)
    {
        $sql = "SELECT jenis_kegiatan.satuan FROM jenis_kegiatan, spkbahan 
            WHERE jenis_kegiatan.id_kegiatan=spkbahan.id_kegiatan
            AND spkbahan.id_spkbahan = '$idnya'";
        return $this->db->query($sql)->row_array();
    }

    public function getSatuanBibit($idnya)
    {
        $sql = "SELECT satuan FROM bibit 
            WHERE id_bibit = '$idnya'";
        return $this->db->query($sql)->row_array();
    }

    public function getLuasPetak($idpetak)
    {
        $sql = "SELECT luas_petak FROM tb_petak WHERE id_petak='$idpetak'";
        return $this->db->query($sql)->row_array();
    }
    public function getBibitModel($idnya)
    {
        $queri = "SELECT * FROM spkbibit_bantu, bibit WHERE spkbibit_bantu.id_bibit=bibit.id_bibit AND spkbibit_bantu.id_spkbibit='$idnya'";
        return $this->db->query($queri)->result_array();
    }

    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id` ";
        return $this->db->query($query)->result_array();
    }
    public function getUserRole()
    {
        $query = "SELECT `dt_user`.*, `user_role`.`role`
                    FROM `dt_user` JOIN `user_role`
                    ON `dt_user`.`role_id` = `user_role`.`id` ";
        return $this->db->query($query)->result_array();
    }
    public function getKec()
    {
        $query = "SELECT `dt_kecamatan`.*, `dt_kabupaten`.`nm_kabupaten`
                    FROM `dt_kecamatan` JOIN `dt_kabupaten`
                    ON `dt_kecamatan`.`id_kabupaten` = `dt_kabupaten`.`id_kabupaten`
                    ORDER BY `dt_kecamatan`.`nm_kecamatan` ASC ";
        return $this->db->query($query)->result_array();
    }
    public function getDesa()
    {
        $query = "SELECT `dt_desa`.*, `dt_kecamatan`.`nm_kecamatan`, `dt_kabupaten`.`nm_kabupaten`, `dt_kabupaten`.`id_kabupaten`
                    FROM `dt_desa`, `dt_kecamatan`, `dt_kabupaten`
                    WHERE `dt_desa`.`id_kecamatan` = `dt_kecamatan`.`id_kecamatan`
                    AND `dt_kecamatan`.`id_kabupaten` = `dt_kabupaten`.`id_kabupaten` ";
        return $this->db->query($query)->result_array();
    }
    public function getDesajax($idnya)
    {
        $query = $this->db->get_where('dt_kecamatan', array('id_kabupaten' => $idnya));
        return $query;
    }
    public function getDesaAjax($idnya)
    {
        $query = $this->db->get_where('dt_desa', array('id_kecamatan' => $idnya));
        return $query;
    }
    // public function getIdform($id_user)
    // {
    //     // mengambil data id dengan kode paling besar
    //     $query = "SELECT max(SUBSTRING(`id_pengawasan`, 1, 12)) AS `kodeTerbesar` FROM `peng_penanaman` ORDER BY `id_pengawasan` DESC";
    //     $data = $this->db->query($query)->row_array();
    //     $kodeID = $data['kodeTerbesar'];
    //     // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    //     // dan diubah ke integer dengan (int)
    //     $urutan = (int) substr($kodeID, 7, 5);
    //     // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    //     $urutan++;
    //     // membentuk kode barang baru
    //     // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    //     // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    //     // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    //     $huruf = "FRM-PPH";
    //     $kodeID = $huruf . sprintf("%05s", $urutan) . $id_user;
    //     return $kodeID;
    // }
    public function getSupervisor()
    {
        $query = "SELECT * FROM `dt_user`, `user_role`
                WHERE `dt_user`.`role_id`=`user_role`.`id`
                AND `role_id`=9 ";
        return $this->db->query($query)->result_array();
    }
    public function getSprAnggota($id)
    {
        $query = "SELECT * FROM `dt_user`, `user_anggota`
        WHERE `dt_user`.`id_user`=`user_anggota`.`id_anggota`
        AND `user_anggota`.`id_supervisor`=$id ";
        return $this->db->query($query)->result_array();
    }
    public function getNonSupervisor()
    {
        $query = "SELECT id_user, nm_user FROM dt_user, user_role
            WHERE dt_user.role_id=user_role.id
            AND user_role.id=8 ";
        return $this->db->query($query)->result_array();
    }
    public function getBlok($id)
    {
        $query = "SELECT * FROM `tb_blok`, `dt_desa`, `dt_kecamatan`, `dt_kabupaten`
                WHERE `tb_blok`.`id_desa`= `dt_desa`.`id_desa`
                AND `dt_desa`.`id_kecamatan`= `dt_kecamatan`.`id_kecamatan`
                AND `dt_kecamatan`.`id_kabupaten`= `dt_kabupaten`.`id_kabupaten`
                AND `tb_blok`.`id_blok` = '$id' ";
        return $this->db->query($query)->row_array();
    }
    public function getCekBlok($id, $id_desa, $nm_blok)
    {
        $query = "SELECT * FROM `tb_blok` 
                WHERE `id_desa` = '$id_desa' AND `nm_blok` = '$nm_blok' AND `id_blok` != '$id' ";
        return $this->db->query($query)->row_array();
    }
    public function getDesblokajax($idnya)
    {
        $query = $this->db->get_where('tb_blok', array('id_desa' => $idnya));
        return $query;
    }
    public function getBlokPetajax($idnya)
    {
        $where = [
            'id_blok' => $idnya,
            'flag_petak' => '0'
        ];
        $query = $this->db->get_where('tb_petak', $where);
        return $query;
    }

    public function getBahanspkPetakEdit($idPtk, $idSpk)
    {
        $queri = "SELECT * FROM  `spkbahan`, `jenis_kegiatan`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spkbahan`.`id_kegiatan` = `jenis_kegiatan`.`id_kegiatan`
                    AND `spkbahan`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `spkbahan`.`id_petak` = '$idPtk'
                    AND `spkbahan`.`id_spkbahan` = '$idSpk'";
        return $this->db->query($queri)->row_array();
    }

    public function getBahanspkPetak($idpetak)
    {
        $queri = "SELECT * FROM  `spkbahan`, `jenis_kegiatan`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spkbahan`.`id_kegiatan` = `jenis_kegiatan`.`id_kegiatan`
                    AND `spkbahan`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `spkbahan`.`id_petak` = '$idpetak'
                    ORDER BY spkbahan.id_spkbahan ASC ";
        return $this->db->query($queri)->result_array();
    }
    public function getBahanspk()
    {
        $queri = "SELECT * FROM  `spkbahan`, `tb_petak`, `tb_blok`, `dt_desa`, `dt_kecamatan`, `dt_kabupaten`
                    WHERE `spkbahan`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa`
                    AND `dt_desa`.`id_kecamatan` = `dt_kecamatan`.`id_kecamatan`
                    AND `dt_kecamatan`.`id_kabupaten` = `dt_kabupaten`.`id_kabupaten`
                    GROUP BY `tb_petak`.`id_petak` ORDER BY `tb_petak`.`id_petak` ASC";
        return $this->db->query($queri)->result_array();
    }
    public function getLapanganspk()
    {
        $queri = "SELECT * FROM `jenis_kegiatan`, `spklapangan`, `tb_petak`, `tb_blok`, `dt_desa`, `dt_kecamatan`, `dt_kabupaten`
                    WHERE `jenis_kegiatan`.`id_kegiatan` = `spklapangan`.`id_kegiatan`
                    AND `spklapangan`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa`
                    AND `dt_desa`.`id_kecamatan` = `dt_kecamatan`.`id_kecamatan`
                    AND `dt_kecamatan`.`id_kabupaten` = `dt_kabupaten`.`id_kabupaten`
                    GROUP BY `tb_petak`.`id_petak`  ORDER BY `tb_petak`.`id_petak` ASC";
        return $this->db->query($queri)->result_array();
    }

    public function getLapanganspkPetakEdit($idPtk, $idSpk)
    {
        $queri = "SELECT * FROM  `spklapangan`, `jenis_kegiatan`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spklapangan`.`id_kegiatan` = `jenis_kegiatan`.`id_kegiatan`
                    AND `spklapangan`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `spklapangan`.`id_petak` = '$idPtk'
                    AND `spklapangan`.`id_spklapangan` = '$idSpk'";
        return $this->db->query($queri)->row_array();
    }

    public function getLapanganspkPetak($idpetak)
    {
        $queri = "SELECT * FROM  `spklapangan`, `jenis_kegiatan`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spklapangan`.`id_kegiatan` = `jenis_kegiatan`.`id_kegiatan`
                    AND `spklapangan`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `spklapangan`.`id_petak` = '$idpetak' 
                    ORDER BY spklapangan.id_spklapangan ASC";
        return $this->db->query($queri)->result_array();
    }

    // public function getStandarHa($id_kegiatan)
    // {
    //     $sql = "SELECT standar_ha FROM jenis_kegiatan WHERE id_kegiatan = '$id_kegiatan' ";
    //     return $this->db->query($sql)->row_array();
    // }

    // public function getPengadaanAjir($id_petak)
    // {
    //     $sql = "SELECT spkbahan.nilai_spkbahan FROM spkbahan, jenis_kegiatan
    //             WHERE jenis_kegiatan.id_kegiatan = spkbahan.id_kegiatan
    //             AND jenis_kegiatan.nm_kegiatan='Pengadaan Ajir'
    //             AND spkbahan.id_petak='$id_petak'";
    //     return $this->db->query($sql)->row_array();
    // }

    public function getCekbahan($id, $id_kegiatan, $id_petak)
    {
        $query = "SELECT * FROM `spkbahan` 
                WHERE `id_kegiatan` = '$id_kegiatan' AND `id_petak` = '$id_petak' AND `id_spkbahan` != '$id' ";
        return $this->db->query($query)->row_array();
    }
    public function getCeklapangan($id, $id_kegiatan, $id_petak)
    {
        $query = "SELECT * FROM `spklapangan` 
                WHERE `id_kegiatan` = '$id_kegiatan' AND `id_petak` = '$id_petak' AND `id_spklapangan` != '$id' ";
        return $this->db->query($query)->row_array();
    }
    public function getBibitspk()
    {
        $queri = "SELECT * FROM  `spkbibit`, `tb_petak`, `tb_blok`, `dt_desa`, `dt_kecamatan`
                    WHERE `spkbibit`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa`
                    AND `dt_desa`.`id_kecamatan` = `dt_kecamatan`.`id_kecamatan`
                    GROUP BY `spkbibit`.`id_petak` ORDER BY `spkbibit`.`id_petak` ASC";
        return $this->db->query($queri)->result_array();
    }
    public function getCekbibit($id, $kategori, $id_petak)
    {
        $query = "SELECT * FROM `spkbibit` 
                WHERE `kategori` = '$kategori' AND `id_petak` = '$id_petak' AND `id_spkbibit` != '$id' ";
        return $this->db->query($query)->row_array();
    }

    public function getBibitkatspkEdit($idPtk, $idSpk)
    {
        $queri = "SELECT * FROM  `spkbibit`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spkbibit`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa`
                    AND `spkbibit`.`id_petak` = '$idPtk'
                    AND `spkbibit`.`id_spkbibit` = '$idSpk' ";
        return $this->db->query($queri)->row_array();
    }

    public function getBibitkatspk($id_petak)
    {
        $queri = "SELECT * FROM  `spkbibit`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spkbibit`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa`
                    AND `spkbibit`.`id_petak` = '$id_petak' ";
        return $this->db->query($queri)->result_array();
    }
    public function getBibitspkat()
    {
        $queri = "SELECT * FROM  `spkbibit`, `tb_petak`, `tb_blok`, `dt_desa`
                    WHERE `spkbibit`.`id_petak` = `tb_petak`.`id_petak`
                    AND `tb_petak`.`id_blok` = `tb_blok`.`id_blok`
                    AND `tb_blok`.`id_desa` = `dt_desa`.`id_desa`
                    ORDER BY `spkbibit`.`id_petak` ASC";
        return $this->db->query($queri)->result_array();
    }
    public function getBibitshow($id)
    {
        $kuery = "SELECT * FROM `spkbibit_bantu`, `bibit`
                    WHERE `spkbibit_bantu`.`id_bibit` = `bibit`.`id_bibit`
                    AND `spkbibit_bantu`.`id_spkbibit` = '$id' ";
        return $this->db->query($kuery)->result_array();
    }

    // controller anggota 
    public function getAnggota($idsupervisor)
    {
        $sql = "SELECT * FROM dt_user, user_anggota WHERE dt_user.id_user=user_anggota.id_anggota AND user_anggota.id_supervisor='$idsupervisor'";
        return $this->db->query($sql)->result_array();
    }
}
