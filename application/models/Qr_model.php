<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qr_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Get all QR codes
    public function get_all_qr_codes()
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->order_by('qr_codes.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get QR code by ID
    public function get_qr_by_id($id)
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('qr_codes.id', $id);
        return $this->db->get()->row();
    }

    // Get QR code by code
    public function get_qr_by_code($code)
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('qr_codes.code', $code);
        $this->db->where('qr_codes.is_active', 1);
        return $this->db->get()->row();
    }

    // Get active QR codes
    public function get_active_qr_codes()
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('qr_codes.is_active', 1);
        $this->db->where('qr_codes.valid_from <=', date('Y-m-d H:i:s'));
        $this->db->where('qr_codes.valid_until >=', date('Y-m-d H:i:s'));
        $this->db->order_by('qr_codes.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Create new QR code
    public function create_qr_code($data)
    {
        return $this->db->insert('qr_codes', $data);
    }

    // Update QR code
    public function update_qr_code($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('qr_codes', $data);
    }

    // Delete QR code
    public function delete_qr_code($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('qr_codes');
    }

    // Generate unique QR code
    public function generate_unique_code()
    {
        $prefix = 'QR';
        $date = date('Y-m-d');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        $code = $prefix . '-' . $date . '-' . $random;

        // Check if code exists
        while ($this->code_exists($code)) {
            $random = strtoupper(substr(md5(uniqid()), 0, 6));
            $code = $prefix . '-' . $date . '-' . $random;
        }

        return $code;
    }

    // Check if code exists
    public function code_exists($code)
    {
        $this->db->where('code', $code);
        return $this->db->get('qr_codes')->num_rows() > 0;
    }

    // Get QR codes by date range
    public function get_qr_codes_by_date_range($start_date, $end_date)
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('DATE(qr_codes.created_at) >=', $start_date);
        $this->db->where('DATE(qr_codes.created_at) <=', $end_date);
        $this->db->order_by('qr_codes.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get QR codes by location
    public function get_qr_codes_by_location($location)
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('qr_codes.location', $location);
        $this->db->where('qr_codes.is_active', 1);
        $this->db->order_by('qr_codes.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get expired QR codes
    public function get_expired_qr_codes()
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('qr_codes.valid_until <', date('Y-m-d H:i:s'));
        $this->db->order_by('qr_codes.valid_until', 'DESC');
        return $this->db->get()->result();
    }

    // Get QR codes created by user
    public function get_qr_codes_by_creator($user_id)
    {
        $this->db->select('qr_codes.*, users.name as created_by_name');
        $this->db->from('qr_codes');
        $this->db->join('users', 'users.id = qr_codes.created_by');
        $this->db->where('qr_codes.created_by', $user_id);
        $this->db->order_by('qr_codes.created_at', 'DESC');
        return $this->db->get()->result();
    }
}
