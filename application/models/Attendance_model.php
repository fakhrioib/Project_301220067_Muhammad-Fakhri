<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Get all attendance records
    public function get_all_attendance()
    {
        $this->db->select('attendance.*, users.name as user_name, users.nip, qr_codes.title as qr_title');
        $this->db->from('attendance');
        $this->db->join('users', 'users.id = attendance.user_id');
        $this->db->join('qr_codes', 'qr_codes.id = attendance.qr_code_id');
        $this->db->order_by('attendance.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get attendance by user ID
    public function get_attendance_by_user($user_id, $date = null)
    {
        $this->db->select('attendance.*, qr_codes.title as qr_title, qr_codes.location');
        $this->db->from('attendance');
        $this->db->join('qr_codes', 'qr_codes.id = attendance.qr_code_id');
        $this->db->where('attendance.user_id', $user_id);

        if ($date) {
            $this->db->where('DATE(attendance.created_at)', $date);
        }

        $this->db->order_by('attendance.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get attendance by date
    public function get_attendance_by_date($date)
    {
        $this->db->select('attendance.*, users.name as user_name, users.nip, qr_codes.title as qr_title');
        $this->db->from('attendance');
        $this->db->join('users', 'users.id = attendance.user_id');
        $this->db->join('qr_codes', 'qr_codes.id = attendance.qr_code_id');
        $this->db->where('DATE(attendance.created_at)', $date);
        $this->db->order_by('attendance.created_at', 'ASC');
        return $this->db->get()->result();
    }

    // Check if user already checked in today
    public function check_today_attendance($user_id, $date = null)
    {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('DATE(created_at)', $date);
        $this->db->where('check_in IS NOT NULL');
        return $this->db->get('attendance')->row();
    }

    // Check if user already checked out today
    public function check_today_checkout($user_id, $date = null)
    {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('DATE(created_at)', $date);
        $this->db->where('check_out IS NOT NULL');
        return $this->db->get('attendance')->row();
    }

    // Create attendance record
    public function create_attendance($data)
    {
        return $this->db->insert('attendance', $data);
    }

    // Update attendance
    public function update_attendance($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('attendance', $data);
    }

    // Get attendance statistics
    public function get_attendance_stats($user_id = null, $start_date = null, $end_date = null)
    {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }

        if ($start_date) {
            $this->db->where('DATE(created_at) >=', $start_date);
        }

        if ($end_date) {
            $this->db->where('DATE(created_at) <=', $end_date);
        }

        $this->db->select('
            COUNT(*) as total_records,
            SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
            SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late,
            SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent,
            SUM(CASE WHEN status = "half_day" THEN 1 ELSE 0 END) as half_day
        ');

        return $this->db->get('attendance')->row();
    }

    // Get attendance by QR code
    public function get_attendance_by_qr($qr_code_id)
    {
        $this->db->select('attendance.*, users.name as user_name, users.nip');
        $this->db->from('attendance');
        $this->db->join('users', 'users.id = attendance.user_id');
        $this->db->where('attendance.qr_code_id', $qr_code_id);
        $this->db->order_by('attendance.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get monthly attendance report
    public function get_monthly_report($month, $year)
    {
        $this->db->select('
            users.id,
            users.name,
            users.nip,
            COUNT(attendance.id) as total_days,
            SUM(CASE WHEN attendance.status = "present" THEN 1 ELSE 0 END) as present_days,
            SUM(CASE WHEN attendance.status = "late" THEN 1 ELSE 0 END) as late_days,
            SUM(CASE WHEN attendance.status = "absent" THEN 1 ELSE 0 END) as absent_days,
            SUM(CASE WHEN attendance.status = "half_day" THEN 1 ELSE 0 END) as half_days
        ');
        $this->db->from('users');
        $this->db->join('attendance', 'attendance.user_id = users.id', 'left');
        $this->db->where('MONTH(attendance.created_at)', $month);
        $this->db->where('YEAR(attendance.created_at)', $year);
        $this->db->where('users.is_active', 1);
        $this->db->group_by('users.id');
        $this->db->order_by('users.name', 'ASC');
        return $this->db->get()->result();
    }

    public function recap_today($role_id)
    {
        $today = date('Y-m-d');
        $this->db->select('status, COUNT(*) as total');
        $this->db->from('attendance');
        $this->db->join('users', 'users.id = attendance.user_id');
        $this->db->where('DATE(attendance.created_at)', $today);
        $this->db->where('users.role_id', $role_id);
        $this->db->group_by('status');
        $result = $this->db->get()->result();
        $recap = ['present' => 0, 'late' => 0, 'absent' => 0, 'half_day' => 0];
        foreach ($result as $row) {
            $recap[$row->status] = $row->total;
        }
        return $recap;
    }
}
