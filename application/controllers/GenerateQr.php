<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GenerateQr extends CI_Controller
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
        $this->load->model('Qr_model');
        $data['qrcodes'] = $this->Qr_model->get_all_qr_codes();
        $data['title'] = 'Generate QR Code';
        $data['user'] = $this->session->userdata();
        $this->load->view('generate_qr/index', $data);
    }

    public function create()
    {
        $this->load->model('Qr_model');
        $data = [
            'code' => $this->Qr_model->generate_unique_code(),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'valid_from' => $this->input->post('valid_from'),
            'valid_until' => $this->input->post('valid_until'),
            'created_by' => $this->session->userdata('user_id'),
            'is_active' => 1
        ];
        $this->Qr_model->create_qr_code($data);
        $insert_id = $this->db->insert_id();
        redirect('generate_qr/show/' . $insert_id);
    }

    public function show($id)
    {
        $this->load->model('Qr_model');
        $qr = $this->Qr_model->get_qr_by_id($id);
        if (!$qr) {
            show_404();
        }
        $data['qr'] = $qr;
        $data['title'] = 'Detail QR Code';
        $data['user'] = $this->session->userdata();
        $this->load->view('generate_qr/show', $data);
    }
}
