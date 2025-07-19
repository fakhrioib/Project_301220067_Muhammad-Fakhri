<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Get all users
    public function get_all_users()
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->order_by('users.name', 'ASC');
        return $this->db->get()->result();
    }

    // Get user by ID
    public function get_user_by_id($id)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    }

    // Get user by email
    public function get_user_by_email($email)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.email', $email);
        return $this->db->get()->row();
    }

    // Get user by NIP
    public function get_user_by_nip($nip)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.nip', $nip);
        return $this->db->get()->row();
    }

    // Create new user
    public function create_user($data)
    {
        return $this->db->insert('users', $data);
    }

    // Update user
    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // Delete user
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // Get users by role
    public function get_users_by_role($role_id)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.role_id', $role_id);
        $this->db->where('users.is_active', 1);
        return $this->db->get()->result();
    }

    // Get active users
    public function get_active_users()
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.is_active', 1);
        $this->db->order_by('users.name', 'ASC');
        return $this->db->get()->result();
    }

    // Check if email exists
    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('users')->num_rows() > 0;
    }

    // Check if NIP exists
    public function nip_exists($nip, $exclude_id = null)
    {
        $this->db->where('nip', $nip);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('users')->num_rows() > 0;
    }

    // Get user count by role
    public function get_user_count_by_role($role_id)
    {
        $this->db->where('role_id', $role_id);
        $this->db->where('is_active', 1);
        return $this->db->count_all_results('users');
    }

    // Get total users
    public function get_total_users()
    {
        return $this->db->count_all('users');
    }

    public function count_by_role($role_id)
    {
        $this->db->where('role_id', $role_id);
        $this->db->where('is_active', 1);
        return $this->db->count_all_results('users');
    }
}
