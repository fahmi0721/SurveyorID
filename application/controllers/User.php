<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    // Cek Apakah ada user yang Login
    public function __construct()
    {
        parent::__construct();
        cek_userLogin();
        date_default_timezone_set('Asia/Makassar');
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();
        // cek id menu 
        $sql = $this->db->get_where('user_sub_menu', ['title' => $data['title']])->row_array();
        $data['id_menu'] = $sql['id'];
        $datetime = date("Y-m-d");
        $waktu = date("H:i:s");

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['gambarx']['name'];
            if ($upload_image) {
                // Atur dan cek file gambarnya
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = '200';
                $config['upload_path'] = 'assets/img/profile/';

                // Meng upload file 
                $this->load->library('upload', $config);
                // jika gambar berhasil di upload ?
                if ($this->upload->do_upload('gambarx')) {
                    // cek gambar lama
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        // untuk mengetahui path file namenya dimana? menggunakan FCPATH
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    // mengambil nama file baru image yg di upload 
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata(
                        'msgUpload',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Picture failed to upload !</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                }
            }

            $this->db->set('nm_user', $name);
            $this->db->where('email', $email);
            $update = $this->db->update('dt_user');
            if ($update) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your profile has been updated!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                );
                // kirim Ke Log 
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "User " . $email . " Update data profile.",
                    'id_sub_menu' => $data['id_menu'],
                    'tgl' => $datetime,
                    'waktu' => $waktu
                ]);
            }
            redirect('user/edit');
        }
    }

    public function changepassword()
    {
        $datetime = date("Y-m-d");
        $waktu = date("H:i:s");
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('dt_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[8]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[8]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                // cek apakah password lama benar
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Wrong current password!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                );
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    // cek apakah password lama sama dengan password baru
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>New password can not be the same as current password!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                    );
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $update = $this->db->update('dt_user');
                    if ($update) {
                        // kirim Ke Log 
                        $this->db->insert('dt_logs', [
                            'id_user' => $this->session->userdata('id_user_login'),
                            'logs' => "User change the password.",
                            'id_sub_menu' => $data['id_menu'],
                            'tgl' => $datetime,
                            'waktu' => $waktu
                        ]);
                        $this->session->set_flashdata(
                            'message',
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Password Changed!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button> </div>'
                        );
                    }
                    redirect('user/changepassword');
                }
            }
        }
    }
}
