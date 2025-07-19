<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        // Redirect to login if not logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        redirect('auth/login');
    }

    public function login()
    {
        // Check if already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login - Sistem Presensi QR Code';
            $this->load->view('auth/login', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->get_user_by_email($email);

            if ($user && password_verify($password, $user->password)) {
                if ($user->is_active) {
                    // Set session data
                    $session_data = array(
                        'user_id' => $user->id,
                        'nip' => $user->nip,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role_id' => $user->role_id,
                        'role_name' => $user->role_name,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($session_data);

                    // Log login activity
                    log_message('info', 'User ' . $user->email . ' logged in successfully');

                    // Redirect sesuai role
                    if ($user->role_id == 1) {
                        redirect('dashboard'); // Admin
                    } else {
                        redirect('scan-qr'); // Guru/Siswa/Pegawai
                    }
                } else {
                    $this->session->set_flashdata('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah!');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        // Log logout activity
        if ($this->session->userdata('email')) {
            log_message('info', 'User ' . $this->session->userdata('email') . ' logged out');
        }

        // Destroy session
        $this->session->sess_destroy();

        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('auth/login');
    }

    public function profile()
    {
        // Check if logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $data['title'] = 'Profil Saya';

        $this->load->view('templates/header', $data);
        $this->load->view('auth/profile', $data);
        $this->load->view('templates/footer');
    }

    public function change_password()
    {
        // Check if logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Ubah Password';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/change_password', $data);
            $this->load->view('templates/footer');
        } else {
            $user_id = $this->session->userdata('user_id');
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            $user = $this->User_model->get_user_by_id($user_id);

            if (password_verify($current_password, $user->password)) {
                $data = array(
                    'password' => password_hash($new_password, PASSWORD_DEFAULT)
                );

                if ($this->User_model->update_user($user_id, $data)) {
                    $this->session->set_flashdata('success', 'Password berhasil diubah!');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengubah password!');
                }
            } else {
                $this->session->set_flashdata('error', 'Password saat ini salah!');
            }

            redirect('auth/change_password');
        }
    }

    public function forgot_password()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Lupa Password';
            $this->load->view('auth/forgot_password', $data);
        } else {
            $email = $this->input->post('email');
            $user = $this->User_model->get_user_by_email($email);

            if ($user) {
                // Generate reset token (implementasi sederhana)
                $reset_token = bin2hex(random_bytes(32));

                // In a real application, you would:
                // 1. Save reset token to database with expiry
                // 2. Send email with reset link
                // 3. Create reset password page

                $this->session->set_flashdata('success', 'Link reset password telah dikirim ke email Anda.');
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan!');
            }

            redirect('auth/forgot_password');
        }
    }

    public function register()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nip', 'NIP', 'required|is_unique[users.nip]');
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|in_list[1,2,3]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Registrasi Akun Baru';
            $data['roles'] = [
                ['id' => 1, 'name' => 'Admin'],
                ['id' => 2, 'name' => 'Guru'],
                ['id' => 3, 'name' => 'Siswa/Pegawai']
            ];
            $this->load->view('auth/register', $data);
        } else {
            $data = array(
                'nip' => $this->input->post('nip'),
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id'),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->User_model->create_user($data);
            $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
            redirect('auth/login');
        }
    }
}
