<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GenerateLaporan extends CI_Controller
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
        // Dummy data laporan
        $data['laporan'] = [
            [
                'no' => 1,
                'nama' => 'Asmuil Hasan Maulana S.Kom',
                'kelas' => 'XII AKL',
                'hadir' => 20,
                'izin' => 2,
                'sakit' => 1,
                'alfa' => 0,
            ],
            [
                'no' => 2,
                'nama' => 'Kenari Ajimin Saputra',
                'kelas' => 'XII AKL',
                'hadir' => 18,
                'izin' => 3,
                'sakit' => 2,
                'alfa' => 0,
            ],
            [
                'no' => 3,
                'nama' => 'Najwa Agustina',
                'kelas' => 'XII AKL',
                'hadir' => 19,
                'izin' => 1,
                'sakit' => 1,
                'alfa' => 2,
            ],
        ];
        $data['title'] = 'Generate Laporan';
        $data['user'] = $this->session->userdata();
        $this->load->view('generate_laporan/index', $data);
    }
}
