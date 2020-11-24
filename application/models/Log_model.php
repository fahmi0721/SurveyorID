<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    }
    // Model Report Harian 
    public function getAkses($user, $log, $menuid, $datetime)
    {
        $data = [
            'id_user' => $user,
            'logs' => $log,
            'id_sub_menu' => $menuid,
            'tgl' => $datetime
        ];
        $input = $this->db->insert('dt_logs', $data);
    }
}
