<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ScanQr extends CI_Controller
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
        $data['title'] = 'Scan QR & Riwayat Presensi';
        $data['user'] = $this->session->userdata();
        $qr_code = $this->input->get('code');
        $data['success'] = null;
        $data['error'] = null;
        if ($qr_code) {
            $this->load->model('Qr_model');
            $qr = $this->Qr_model->get_qr_by_code($qr_code);
            if ($qr && $qr->is_active && $qr->valid_from <= date('Y-m-d H:i:s') && $qr->valid_until >= date('Y-m-d H:i:s')) {
                $this->load->model('Attendance_model');
                // Cek apakah user sudah absen hari ini dengan QR ini (berdasarkan qr_code_id)
                $already = $this->db->get_where('attendance', [
                    'user_id' => $data['user']['user_id'],
                    'qr_code_id' => $qr->id,
                    'DATE(created_at)' => date('Y-m-d')
                ])->row();
                if (!$already) {
                    // Catat absensi
                    $this->Attendance_model->create_attendance([
                        'user_id' => $data['user']['user_id'],
                        'qr_code_id' => $qr->id,
                        'check_in' => date('Y-m-d H:i:s'),
                        'status' => 'present',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $data['success'] = 'Absensi berhasil dicatat!';
                    $data['redirect_report'] = false;
                } else {
                    $data['error'] = 'Anda sudah absen dengan QR ini hari ini.';
                }
            } else {
                $data['error'] = 'QR code tidak valid atau sudah tidak berlaku.';
            }
        }
        // Ambil riwayat presensi user dari database
        $this->load->model('Attendance_model');
        $riwayat = $this->Attendance_model->get_attendance_by_user($data['user']['user_id']);
        $data['riwayat'] = [];
        foreach ($riwayat as $row) {
            $data['riwayat'][] = [
                'tanggal' => date('Y-m-d', strtotime($row->created_at)),
                'waktu_masuk' => $row->check_in ? date('H:i', strtotime($row->check_in)) : '-',
                'waktu_pulang' => $row->check_out ? date('H:i', strtotime($row->check_out)) : '-',
                'status' => ucfirst($row->status),
            ];
        }
        $this->load->view('scan_qr/index', $data);
    }
}
