<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPetugas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // Dummy data petugas
        $data['petugas'] = [
            [
                'no' => 1,
                'nip' => 'ADMIN001',
                'nama' => 'Administrator',
                'email' => 'admin@contoh.com',
                'role' => 'Admin',
            ],
            [
                'no' => 2,
                'nip' => 'EMP002',
                'nama' => 'Jane Smith',
                'email' => 'jane@contoh.com',
                'role' => 'Manager',
            ],
        ];
        $data['title'] = 'Data Petugas';
        $data['user'] = $this->session->userdata();
        $this->load->view('data_petugas/index', $data);
    }
}
