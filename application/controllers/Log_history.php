<?php
class Log_history extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek login dan privilege di sini
        // $this->load->model('M_log_history');
    }

    public function index()
    {
        $data['logs'] = $this->M_log_history->get_all();
        $data['avatar'] = $this->M_karyawan->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
        $data['title'] = 'Log History Sistem';

        $this->load->view('header/header', $data);
        $this->load->view('log_history/list', $data);
        $this->load->view('footer/footer', $data);
    }
}
