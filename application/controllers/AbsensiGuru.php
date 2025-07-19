<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsensiGuru extends CI_Controller
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
        $data['tanggal'] = date('Y-m-d');
        // Dummy data absen guru
        $data['absen'] = [
            [
                'no' => 1,
                'nuptk' => '200808621112120',
                'nama' => 'ELINASIAH SARTINI S.E S.PD',
                'kehadiran' => 'TANPA KETERANGAN',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'keterangan' => '',
            ],
            [
                'no' => 2,
                'nuptk' => '200808621112121',
                'nama' => 'ENTIS SUTISNA S.KOM',
                'kehadiran' => 'TANPA KETERANGAN',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'keterangan' => '',
            ],
            [
                'no' => 3,
                'nuptk' => '200808621112122',
                'nama' => 'HELDA HYODIR S.PD',
                'kehadiran' => 'TANPA KETERANGAN',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'keterangan' => '',
            ],
            [
                'no' => 4,
                'nuptk' => '200808621112123',
                'nama' => 'HELM ABDUL AZIS S.KOM',
                'kehadiran' => 'TANPA KETERANGAN',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'keterangan' => '',
            ],
        ];
        $data['title'] = 'Absensi Guru';
        $data['user'] = $this->session->userdata();
        $this->load->view('absensi_guru/index', $data);
    }
}
