<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataGuru extends CI_Controller
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
        // Dummy data guru
        $data['guru'] = [
            [
                'no' => 1,
                'nuptk' => '200808621112120',
                'nama' => 'ELINASIAH SARTINI S.E S.PD',
                'email' => 'elinasiah@contoh.com',
            ],
            [
                'no' => 2,
                'nuptk' => '200808621112121',
                'nama' => 'ENTIS SUTISNA S.KOM',
                'email' => 'entis@contoh.com',
            ],
            [
                'no' => 3,
                'nuptk' => '200808621112122',
                'nama' => 'HELDA HYODIR S.PD',
                'email' => 'helda@contoh.com',
            ],
            [
                'no' => 4,
                'nuptk' => '200808621112123',
                'nama' => 'HELM ABDUL AZIS S.KOM',
                'email' => 'helm@contoh.com',
            ],
        ];
        $data['title'] = 'Data Guru';
        $data['user'] = $this->session->userdata();
        $this->load->view('data_guru/index', $data);
    }
}
