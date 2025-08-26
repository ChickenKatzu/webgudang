<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_aksesoris $M_aksesoris
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_aksesoris');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    // Tambahkan di Controller Aset
    public function aksesoris_masuk()
    {
        if ($_POST) {
            $jenis = $this->input->post('jenis_aksesoris');
            $kode_baru = $this->M_admin->generate_kode_aksesoris($jenis);

            $data = [
                'jenis_aksesoris' => $jenis,
                'kode_aksesoris'  => $kode_baru
            ];
            $this->db->insert('tb_aset_aksesoris', $data);

            $this->session->set_flashdata('success', 'Aksesoris berhasil ditambahkan');
            redirect('aset/aksesoris_masuk');
        }

        $data['title'] = 'Form Aksesoris Masuk';
        $this->load->view('header/header', $data);
        $this->load->view('admin/perpindahan_barang/form_aksesoris_masuk', $data);
        $this->load->view('footer/footer', $data);
    }
}
