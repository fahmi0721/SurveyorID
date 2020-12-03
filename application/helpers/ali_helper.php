<?php
// function untuk cek user login dan akan di direct dimana 
function cek_userLogin()
{
    // Membuat Instan CI baru dan helper tdk Mengenal '$this'
    $al = get_instance();
    // Cek User yang Login 
    if (!$al->session->userdata('email')) {
        redirect('auth');
    } else {
        // jika berhasil login tapi mengakses url yg bekan aksesnya
        // mengambil role id nya
        $role_id = $al->session->userdata('role_id');
        // cek lagi di menu dimana
        $menu = $al->uri->segment(1);
        // Query tabel menu berdasarkan nama $menu untuk mendapatkan menu_id
        $querMenu = $al->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $querMenu['id'];
        // Cek lagi $role_id dan $menu_id adakah di tabel User_akses_menu? contoh role 2 mengakses menu 1
        $userAccess = $al->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);
        // Cek 
        if ($userAccess->num_rows() < 1) {
            redirect('auth/notfound');
        }
    }
}

// Function untuk role access. menu apa saja yang dapat diakses 

function check_access($role_id, $menu_id)
{
    $al = get_instance();

    $result = $al->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
