<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_management extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Master User Management';
        $data['users'] = $this->M_user->get_all_users();

        $this->load->view('header/header', $data);
        $this->load->view('user_managememt/user_managememt', $data);
        $this->load->view('footer/footer', $data);
    }

    public function create()
    {
        // Check create privilege
        if (!$this->M_user->check_privilege($this->session->userdata('id'), 'user', 'create')) {
            show_error('Anda tidak memiliki akses untuk membuat user baru.', 403, 'Akses Ditolak');
        }

        $data['title'] = 'Tambah User Baru';
        $data['privileges'] = $this->M_user->get_all_privileges();
        $data['available_karyawan'] = $this->M_user->get_available_karyawan();

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('id_privilege', 'Hak Akses', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('user_management/create', $data);
            $this->load->view('footer');
        } else {
            $user_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'id_privilege' => $this->input->post('id_privilege'),
                'id_karyawan' => $this->input->post('id_karyawan') ?: null,
                'role' => $this->input->post('id_privilege') == 1 ? 1 : 0 // Backward compatibility
            );

            if ($this->M_user->create_user($user_data)) {
                $this->session->set_flashdata('success', 'User berhasil dibuat');
                // Log activity
                log_history('insert', 'user', 'Membuat user baru: ' . $user_data['username']);
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat user');
            }

            redirect('user_management');
        }
    }

    public function edit($id)
    {
        // Check update privilege
        if (!$this->M_user->check_privilege($this->session->userdata('id'), 'user', 'update')) {
            show_error('Anda tidak memiliki akses untuk mengedit user.', 403, 'Akses Ditolak');
        }

        $data['title'] = 'Edit User';
        $data['user'] = $this->M_user->get_user_by_id($id);
        $data['privileges'] = $this->M_user->get_all_privileges();

        if (!$data['user']) {
            show_404();
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('id_privilege', 'Hak Akses', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('user_management/edit', $data);
            $this->load->view('footer');
        } else {
            $user_data = array(
                'email' => $this->input->post('email'),
                'id_privilege' => $this->input->post('id_privilege'),
                'role' => $this->input->post('id_privilege') == 1 ? 1 : 0 // Backward compatibility
            );

            // Only update password if provided
            if ($this->input->post('password')) {
                $user_data['password'] = $this->input->post('password');
            }

            if ($this->M_user->update_user($id, $user_data)) {
                $this->session->set_flashdata('success', 'User berhasil diupdate');
                // Log activity
                log_history('update', 'user', 'Mengupdate user: ' . $data['user']->username);
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate user');
            }

            redirect('user_management');
        }
    }

    public function delete($id)
    {
        // Check delete privilege
        if (!$this->M_user->check_privilege($this->session->userdata('id'), 'user', 'delete')) {
            show_error('Anda tidak memiliki akses untuk menghapus user.', 403, 'Akses Ditolak');
        }

        $user = $this->M_user->get_user_by_id($id);

        if (!$user) {
            show_404();
        }

        // Prevent self-deletion
        if ($user->id == $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri');
            redirect('user_management');
        }

        if ($this->M_user->delete_user($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
            // Log activity
            log_history('delete', 'user', 'Menghapus user: ' . $user->username);
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }

        redirect('user_management');
    }

    public function profile()
    {
        $data['title'] = 'Profile User';
        $data['user'] = $this->M_user->get_user_by_id($this->session->userdata('id'));

        $this->load->view('header', $data);
        $this->load->view('user_management/profile', $data);
        $this->load->view('footer');
    }
}
