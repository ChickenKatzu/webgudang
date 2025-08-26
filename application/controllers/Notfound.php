<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_Gudang $M_Gudang
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 */

class Notfound extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_gudang');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }
    public function index()
    {
        $data['title'] = '404 Not Found';
        $data['avatar'] = $this->M_gudang->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
        $this->load->view('header/header', $data);
        $this->load->view('404');
        $this->load->view('footer/footer', $data);
    }
}
