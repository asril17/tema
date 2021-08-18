<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // if ($this->session->userdata('login')) {
        //     redirect('Auth');
        // }
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->load->view('Template/Header');
            $this->load->view('Auth/Login');
            $this->load->view('Template/Footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $checklogin = $this->db->get_where('member', ['email' => $email]);

        if ($checklogin->num_rows() > 0) {
            $member = $checklogin->row_array();
            if (md5($password) == $member['password']) {
                // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">berhasil</div> ');
                $data = [
                    'id' => $member['id_member'],
                    'nama' => $member['nama'],
                    'login' => true
                ];
                $this->session->set_userdata($data);

                redirect('Product/prepaidBalance');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah</div> ');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun tidak ditemukan</div> ');
            redirect('Auth');
        }
    }


    public function register()
    {

        $this->load->view('Template/Header');
        $this->load->view('Auth/Register');
        $this->load->view('Template/Footer');
    }

    public function registerPost()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->load->view('Template/Header');
            $this->load->view('Auth/Login');
            $this->load->view('Template/Footer');
        } else {
            $email = $this->input->post('email');
            $nama = $this->input->post('nama');
            $password = $this->input->post('password');

            $data = [
                'nama' => $nama,
                'email' => $email,
                'password' => md5($password)
            ];

            $insertRegister = $this->master->insertMember($data);

            if ($insertRegister) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Register Successful</div> ');
                redirect('Auth');
            }
        }
    }
}
