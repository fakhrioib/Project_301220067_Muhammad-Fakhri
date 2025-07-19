<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->load->model('User_model');
        $this->load->model('Attendance_model');
        $data['title'] = 'Dashboard';
        $data['user'] = $this->session->userdata();
        // Statistik
        $data['jumlah_siswa'] = $this->User_model->count_by_role(3);
        $data['jumlah_guru'] = $this->User_model->count_by_role(2);
        $data['jumlah_petugas'] = $this->User_model->count_by_role(1);
        $data['jumlah_kelas'] = 12; // Dummy, ganti jika ada tabel kelas
        // Absensi hari ini
        $data['absensi_siswa'] = $this->Attendance_model->recap_today(3);
        $data['absensi_guru'] = $this->Attendance_model->recap_today(2);
        $this->load->view('dashboard/index', $data);
    }
}
