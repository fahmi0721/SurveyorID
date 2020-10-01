<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Select All users 
        $dbUsers = $this->db->get('dt_user');
        $data['users'] = $dbUsers->num_rows();
        // total pengwasan harian masuk
        $dbHarian = $this->db->get('harianlapangan');
        $data['harian'] = $dbHarian->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        // Form AddRole
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            // jika form validasi tdk jalan maka tampilkan
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>New role added!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('admin/role');
        }
    }
    // Delete Role 
    public function roleDel($id)
    {
        $where = array('id' => $id);
        $this->db->delete('user_role', $where);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Role has been deleted!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>');
        redirect('admin/role');
    }
    // Delete Role 
    public function roleEdit($id)
    {
        $this->db->update('user_role', ['role' => $this->input->post('role')], ['id' => $id]);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Role has been updated!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('admin/role');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        // Query Semua data menu yang ada di tabel menu kecuali admin
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        // cek apakah datanya ada di user_access_menu
        $result = $this->db->get_where('user_access_menu', $data);
        // apakah ada atau tidak ada?
        if ($result->num_rows() < 1) {
            // jika tdk ada akan ditambahkan
            $this->db->insert('user_access_menu', $data);
        } else {
            // Jika ada akan dihapus
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Access Changed!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
        );
    }
    public function manageuser()
    {
        $data['title'] = 'Manage Users';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'users');
        $data['userRole'] = $this->users->getUserRole();
        $data['role'] = $this->db->get('user_role')->result_array(); //query untuk rolenya
        // Registrasi user baru
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[dt_user.email]', [
            'is_unique' => 'This email already registred!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/mng-user', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nm_user' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => htmlspecialchars($this->input->post('role_id', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
                'date_created' => time()
            ];
            $this->db->insert('dt_user', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>New user account added successfully!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('admin/manageuser');
        }
    }
    public function userUpdate($id)
    {
        // validasi form 
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Cannot be changed.</strong> Invalid Email!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
            );
            redirect('admin/manageuser');
        } else {
            $nama = htmlspecialchars($this->input->post('name', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $role_id = $this->input->post('role_id');
            $is_active = $this->input->post('is_active');
            $password1 = $this->input->post('password1');
            $password2 = $this->input->post('password2');

            if ($password1 == "" || $password2 == "") {
                // jika passwordnya kosong update yg lainnya
                $this->db->update('dt_user', [
                    'nm_user' => $nama,
                    'email' => $email,
                    'role_id' => $role_id,
                    'is_active' => $is_active
                ], ['id_user' => $id]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>User updated!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>'
                );
                redirect('admin/manageuser');
            } else {
                // jika passwordnya diisi update semuanya
                if ($password1 != $password2) {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Password must be same!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                    );
                    redirect('admin/manageuser');
                } else {
                    $this->db->update('dt_user', [
                        'nm_user' => $nama,
                        'email' => $email,
                        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                        'role_id' => $role_id,
                        'is_active' => $is_active
                    ], ['id_user' => $id]);
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>User has been updated!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                    );
                    redirect('admin/manageuser');
                }
            }
        }
    }

    public function userDel($id)
    {
        $where = array('id_user' => $id);
        $data = $this->db->get_where('dt_user', $where)->row_array();
        $gambar = $data['image'];
        // hapus gambar profilenya jika selain default 
        if ($gambar != 'default.jpg') {
            unlink(FCPATH . 'assets/img/profile/' . $gambar);
        }
        $this->db->delete('dt_user', $where);
        // $this->db->delete('user_role', $where);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>User has been deleted!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>');
        redirect('admin/manageuser');
    }

    public function supervisor()
    {
        $data['title'] = 'Supervisor Anggota';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // Select  users Supervisor
        $this->load->model('Menu_model', 'supervisor');
        $data['userVisor'] = $this->supervisor->getSupervisor();
        // Select  Semua users Kecuali Supervisor
        $this->load->model('Menu_model', 'nonsupervisor');
        $data['nonvis'] = $this->nonsupervisor->getNonSupervisor();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/supervisor', $data);
        $this->load->view('templates/footer');
    }
    public function supervisoradd()
    {
        $data = [
            'id_supervisor' => $this->input->post('id_supervisor'),
            'id_anggota' => $this->input->post('id_anggota'),
            'ket_user_anggota' => $this->input->post('ket')
        ];
        $insert = $this->db->insert('user_anggota', $data);
        if ($insert) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>User anggota supervisor berhasil ditambahkan!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/supervisor');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>User anggota supervisor gagal ditambahkan!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/supervisor');
        }
    }

    public function anggotaDel($id)
    {
        $where = [
            'id_user_anggota' => $id
        ];
        $hapus = $this->db->delete('user_anggota', $where);
        if ($hapus) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Anggota supervisor telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/supervisor');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Anggota supervisor gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/supervisor');
        }
    }
    public function kegiatan()
    {
        $data['title'] = 'Kegiatan';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // tampilkan jenis kegiatan
        $data['kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();
        $data['bibit'] = $this->db->get('bibit')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/kegiatan', $data);
        $this->load->view('templates/footer');
    }
    public function kegiatanAdd()
    {
        $data = $this->db->insert('jenis_kegiatan', [
            'nm_kegiatan' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true)),
        ]);
        if ($data) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show pb-1" role="alert">
                <strong> Sukses! </strong> Jenis Kegiatan Berhasil ditambahkan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show pb-1" role="alert">
                <strong> Kesalahan! </strong> Gagal Memproses Data.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
            );
        }
        redirect('admin/kegiatan');
    }
    public function kegiatanDel($id)
    {
        $hapus = $this->db->delete('jenis_kegiatan', ['id_kegiatan' => $id]);
        if ($hapus) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data kegiatan  telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Data kegiatan gagal dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('admin/kegiatan');
    }
    public function kegiatanUpdate($id)
    {
        $where = [
            'id_kegiatan' => $id
        ];
        $update = $this->db->update('jenis_kegiatan', [
            'nm_kegiatan' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true)),
            'flag_keg' => $this->input->post('flag', true),
        ], $where);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Jenis kegiatan  telah diperbaharui.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Jenis Kegiatan gagal diperbaharui.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('admin/kegiatan');
    }
    public function bibitAdd()
    {
        $insert = $this->db->insert('bibit', [
            'nm_bibit' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true))
        ]);
        if ($insert) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Bibit berhasil ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Gagal memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('admin/kegiatan');
    }
    public function bibitEdit($id)
    {
        $edit = $this->db->update('bibit', [
            'nm_bibit' => htmlspecialchars($this->input->post('nama', true)),
            'satuan' => htmlspecialchars($this->input->post('satuan', true)),
            'flag_bibit' => $this->input->post('flag', true)
        ], ['id_bibit' => $id]);
        if ($edit) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Bibit berhasil diedit.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Gagal memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('admin/kegiatan');
    }
    public function bibitdel($id)
    {
        $edit = $this->db->delete('bibit', ['id_bibit' => $id]);
        if ($edit) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Bibit berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong> Gagal memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('admin/kegiatan');
    }
}
