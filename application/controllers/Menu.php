<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        // query data menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        // form Menu validasi
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $add = $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            if ($add) {
                // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "New Menu Added : " . $this->input->post('menu'),
                    'id_sub_menu' => 4,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>New menu added!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kesalahan! </strong> Tidak dapat memproses data
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
            redirect('menu');
        }
    }

    public function delete($id)
    {
        $where = array('id' => $id);
        $nmmenu = $this->db->get_where('user_menu', $id)->row_array();
        $edit = $this->db->delete('user_menu', $where);
        if ($edit) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Menu Deleted : " . $nmmenu['menu'],
                'id_sub_menu' => 4,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Menu has been deleted!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan! </strong> Tidak dapat memproses data
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('menu');
    }

    public function edit($id)
    {
        $update = $this->db->update('user_menu', ['menu' => $this->input->post('menu')], ['id' => $id]);
        if ($update) {
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Menu Updated : " . $this->input->post('menu'),
                'id_sub_menu' => 4,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
        }
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Menu has been updated!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button> </div>'
        );
        redirect('menu');
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        // form Sub Menu
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $insert = $this->db->insert('user_sub_menu', $data);
            if ($insert) {
                // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "New Sub Menu Added : " . $data['title'],
                    'id_sub_menu' => 5,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>New sub menu added!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
            redirect('menu/submenu');
        }
    }

    public function submenuUpdt($id)
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('dt_user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $update = $this->db->update('user_sub_menu', $data, ['id' => $id]);
            if ($update) {
                // kirim Ke Log 
                $datetime = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $this->session->userdata('id_user_login'),
                    'logs' => "Sub Menu Updated : " . $data['title'],
                    'id_sub_menu' => 5,
                    'tgl' => $datetime,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sub menu has been updated</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Kesalahan</strong> Tidak dapat memproses data.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button> </div>'
                );
            }
            redirect('menu/submenu');
        }
    }

    public function submenuDelete($id)
    {
        $dihapus = $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();
        $del = $this->db->delete('user_sub_menu', ['id' => $id]);
        if ($del) {
            # code...
            // kirim Ke Log 
            $datetime = date("Y-m-d");
            $time = date("H:i:s");
            $this->db->insert('dt_logs', [
                'id_user' => $this->session->userdata('id_user_login'),
                'logs' => "Sub Menu Deleted : " . $dihapus['title'],
                'id_sub_menu' => 5,
                'tgl' => $datetime,
                'waktu' => $time
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Submenu has been deleted!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan! </strong> Tidak dapat memproses data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button> </div>');
        }
        redirect('menu/submenu');
    }
}
