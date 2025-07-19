<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataSiswa extends CI_Controller
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
        // Dummy data siswa
        $data['siswa'] = [
            [
                'no' => 1,
                'nis' => '0071599',
                'nama' => 'Asmuil Hasan Maulana S.Kom',
                'kelas' => 'XII AKL',
                'email' => 'asmuil@contoh.com',
            ],
            [
                'no' => 2,
                'nis' => '3811891',
                'nama' => 'Kenari Ajimin Saputra',
                'kelas' => 'XII AKL',
                'email' => 'kenari@contoh.com',
            ],
            [
                'no' => 3,
                'nis' => '3086265',
                'nama' => 'Najwa Agustina',
                'kelas' => 'XII AKL',
                'email' => 'najwa@contoh.com',
            ],
        ];
        $data['title'] = 'Data Siswa';
        $data['user'] = $this->session->userdata();
        $this->load->view('data_siswa/index', $data);
    }
}
