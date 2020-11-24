<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Makassar');
    }
    public function index()
    {
        if ($this->session->userdata('email')) {
            // fungsi ini berfungsi untuk mengecek jika sudah ada user yg login tdk boleh lagi kembali di auth
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // valid success
            $this->_login();
        }
    }
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('dt_user', ['email' => $email])->row_array();
        // Jika usernya ada
        if ($user) {
            if ($user['is_active'] == 1) {
                // cek password 
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'id_user_login' => $user['id_user']
                    ];
                    $this->session->set_userdata($data);
                    // kirim ke log 
                    $date = date("Y-m-d");
                    $time = date("H:i:s");
                    $this->db->insert('dt_logs', [
                        'id_user' => $user['id_user'],
                        'logs' => "User Login Sukses : " . $data['email'],
                        'id_sub_menu' => '2',
                        'tgl' => $date,
                        'waktu' => $time
                    ]);
                    // redirect user 
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Password! </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email has not been activated! </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not registred! </div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            // fungsi ini berfungsi untuk mengecek jika sudah ada user yg login tdk boleh lagi kembali di auth
            redirect('user');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[dt_user.email]', [
            'is_unique' => 'This email already registred!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'USER REGISTRATION';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'nm_user' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            $register = $this->db->insert('dt_user', $data);
            if ($register) {
                // ambil idnya 
                $iduser = $this->db->get_where('dt_user', ['email' => $data['email']])->row_array();
                $date = date("Y-m-d");
                $time = date("H:i:s");
                $this->db->insert('dt_logs', [
                    'id_user' => $iduser['id_user'],
                    'logs' => "New Account Created : " . $data['email'],
                    'id_sub_menu' => '2',
                    'tgl' => $date,
                    'waktu' => $time
                ]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulation! Account has been created. Please contact the administrator for activate your account. </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Error! Unable to create Account. Please contact your admin. </div>');
            }
            redirect('auth');
        }
    }

    public function logout()
    {
        // kirim Ke Log 
        $datetime = date("Y-m-d");
        $time = date("H:i:s");
        $this->db->insert('dt_logs', [
            'id_user' => $this->session->userdata('id_user_login'),
            'logs' => "User Logout dari aplikasi",
            'id_sub_menu' => 2,
            'tgl' => $datetime,
            'waktu' => $time
        ]);
        // mengakhiri sesion login dengan unset_userdata
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id_user_login');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out! </div>');
        redirect('auth');
    }

    public function notfound()
    {
        $this->load->view('auth/notfound');
    }
}
