<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    public function getReport($id_users)
    {
        $query = "SELECT * FROM 
                    `dt_kabupaten`, `dt_kecamatan`, `dt_desa`, `peng_penanaman`, `progres_penan`, `keterangan_penan`, `foto_penan`, `dt_user`
                    WHERE `dt_kabupaten`.`id_kabupaten` = `dt_kecamatan`.`id_kabupaten` 
                    AND `dt_kecamatan`.`id_kecamatan` = `dt_desa`.`id_kecamatan` 
                    AND `peng_penanaman`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `peng_penanaman`.`id_penanaman` = `progres_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `keterangan_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `foto_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_user` = `dt_user`.`id_user`
                    AND `peng_penanaman`.`id_user` = $id_users
                    ORDER BY `peng_penanaman`.`id_penanaman` DESC";
        return $this->db->query($query)->result_array();
    }
    public function getReportAdmin()
    {
        $query = "SELECT * FROM 
                    `dt_kabupaten`, `dt_kecamatan`, `dt_desa`, `peng_penanaman`, `progres_penan`, `keterangan_penan`, `foto_penan`, `dt_user`
                    WHERE `dt_kabupaten`.`id_kabupaten` = `dt_kecamatan`.`id_kabupaten` 
                    AND `dt_kecamatan`.`id_kecamatan` = `dt_desa`.`id_kecamatan` 
                    AND `peng_penanaman`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `peng_penanaman`.`id_penanaman` = `progres_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `keterangan_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `foto_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_user` = `dt_user`.`id_user`";
        return $this->db->query($query)->result_array();
    }
    public function getReportDetail($id)
    {
        $query = "SELECT * FROM 
                    `dt_kabupaten`, `dt_kecamatan`, `dt_desa`, `peng_penanaman`, `progres_penan`, `keterangan_penan`, `foto_penan`, `dt_user`
                    WHERE `dt_kabupaten`.`id_kabupaten` = `dt_kecamatan`.`id_kabupaten` 
                    AND `dt_kecamatan`.`id_kecamatan` = `dt_desa`.`id_kecamatan` 
                    AND `peng_penanaman`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `peng_penanaman`.`id_penanaman` = `progres_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `keterangan_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `foto_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_user` = `dt_user`.`id_user`
                    AND `peng_penanaman`.`id_penanaman` = '$id'";
        return $this->db->query($query)->row_array();
    }
    public function getReportDetailAnggota($id)
    {
        $query = "SELECT * FROM 
                    `dt_kabupaten`, `dt_kecamatan`, `dt_desa`, `peng_penanaman`, `progres_penan`, `keterangan_penan`, `foto_penan`, `dt_user`, `user_anggota`
                    WHERE `dt_kabupaten`.`id_kabupaten` = `dt_kecamatan`.`id_kabupaten` 
                    AND `dt_kecamatan`.`id_kecamatan` = `dt_desa`.`id_kecamatan` 
                    AND `peng_penanaman`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `peng_penanaman`.`id_penanaman` = `progres_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `keterangan_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `foto_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_user` = `dt_user`.`id_user`
                    AND `dt_user`.`id_user` = `user_anggota`.`id_anggota`
                    AND `user_anggota`.`id_supervisor` = $id";
        return $this->db->query($query)->result_array();
    }

    public function getMingguan($id)
    {
        $iduser = $id['user']['id_user'];
        $desa = $id['desa'];
        $query = "SELECT * FROM 
                    `dt_kabupaten`, `dt_kecamatan`, `dt_desa`, `peng_penanaman`, `progres_penan`, `keterangan_penan`, `foto_penan`, `dt_user`, `user_anggota`
                    WHERE `dt_kabupaten`.`id_kabupaten` = `dt_kecamatan`.`id_kabupaten` 
                    AND `dt_kecamatan`.`id_kecamatan` = `dt_desa`.`id_kecamatan` 
                    AND `peng_penanaman`.`id_desa` = `dt_desa`.`id_desa` 
                    AND `peng_penanaman`.`id_penanaman` = `progres_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `keterangan_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_penanaman` = `foto_penan`.`id_penanaman` 
                    AND `peng_penanaman`.`id_user` = `dt_user`.`id_user`
                    AND `dt_user`.`id_user` = `user_anggota`.`id_anggota`
                    AND `user_anggota`.`id_supervisor` = $iduser
                    AND `peng_penanaman`.`mingguan_cek` = '0'
                    AND `peng_penanaman`.`id_desa` = $desa ";
        return $this->db->query($query)->result_array();
    }
}
