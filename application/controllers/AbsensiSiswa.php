<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsensiSiswa extends CI_Controller
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
        // Dummy data kelas
        $data['kelas'] = [
            'X OTP',
            'X BDP',
            'X AKL',
            'X DKV',
            'XI OTP',
            'XI BDP',
            'XI AKL',
            'XI DKV',
            'XII OTP',
            'XII BDP',
            'XII AKL',
            'XII DKV'
        ];
        $data['kelas_aktif'] = 'XII AKL';
        $data['tanggal'] = date('Y-m-d');
        // Dummy data absen siswa
        $data['absen'] = [
            [
                'no' => 1,
                'nis' => '0071599',
                'nama' => 'Asmuil Hasan Maulana S.Kom',
                'kehadiran' => 'HADIR',
                'jam_masuk' => '07:15:00',
                'jam_pulang' => '-',
                'keterangan' => '',
            ],
            [
                'no' => 2,
                'nis' => '3811891',
                'nama' => 'Kenari Ajimin Saputra',
                'kehadiran' => 'IZIN',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'keterangan' => '',
            ],
            [
                'no' => 3,
                'nis' => '3086265',
                'nama' => 'Najwa Agustina',
                'kehadiran' => 'SAKIT',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'keterangan' => 'Sakit',
            ],
        ];
        $data['title'] = 'Absensi Siswa';
        $data['user'] = $this->session->userdata();
        $this->load->view('absensi_siswa/index', $data);
    }
}
