<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_aksesoris $M_aksesoris
 * @property M_admin $M_admin
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_aksesoris');
        $this->load->model('M_admin');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    // Tambahkan di Controller Aset
    public function index()
    {
        $data['title'] = 'Daftar Aksesoris';
        $data['aksesoris'] = $this->M_admin->get_all_aksesoris();
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/aksesoris/daftar_aksesoris', $data);
        $this->load->view('footer/footer', $data);
    }

    public function masuk()
    {
        $data['title'] = 'Daftar Aksesoris';
        $data['aksesoris'] = $this->M_admin->get_all_aksesoris();
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
        $this->load->view('header/header', $data);
        $this->load->view('admin/form_aksesoris/form_aksesoris_masuk');
        $this->load->view('footer/footer', $data);
    }
    public function get_next_numbers()
    {
        // Pastikan request adalah AJAX
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $types = $this->input->post('types');
        $next_numbers = array();

        if (!empty($types)) {
            foreach ($types as $type) {
                $next_number = $this->M_aksesoris->get_next_number($type);
                $next_numbers[$type] = $next_number;
            }
        }

        echo json_encode(array(
            'status' => 'success',
            'data' => $next_numbers
        ));
    }

    public function simpan()
    {
        // Validasi form
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        $this->form_validation->set_rules('kondisi', 'Kondisi', 'required');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form kembali
            $data['title'] = 'Input Data Aksesoris Masuk';
            $data['aksesoris'] = $this->M_admin->get_all_aksesoris();
            $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
            $this->load->view('header/header', $data);
            $this->load->view('admin/form_aksesoris/form_aksesoris_masuk', $data);
            $this->load->view('footer/footer', $data);
        } else {
            // Simpan data ke database
            $data_common = array(
                'merk' => $this->input->post('merk'),
                'lokasi' => $this->input->post('lokasi'),
                'kondisi' => $this->input->post('kondisi'),
                'tanggal_masuk' => $this->input->post('tanggal_masuk')
            );

            $count = 0;

            // Simpan setiap aksesoris yang dipilih
            if ($this->input->post('kode_c')) {
                $data_c = $data_common;
                $data_c['jenis'] = 'Charger';
                $data_c['kode'] = $this->input->post('kode_c');
                $this->M_aksesoris->simpan_data($data_c);
                $count++;
            }

            if ($this->input->post('kode_h')) {
                $data_h = $data_common;
                $data_h['jenis'] = 'Headset';
                $data_h['kode'] = $this->input->post('kode_h');
                $this->M_aksesoris->simpan_data($data_h);
                $count++;
            }

            if ($this->input->post('kode_m')) {
                $data_m = $data_common;
                $data_m['jenis'] = 'Mouse';
                $data_m['kode'] = $this->input->post('kode_m');
                $this->M_aksesoris->simpan_data($data_m);
                $count++;
            }

            if ($count > 0) {
                $this->session->set_flashdata('success', $count . ' data aksesoris berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data aksesoris yang dipilih');
            }

            redirect('aksesoris/masuk');
        }
    }
}
