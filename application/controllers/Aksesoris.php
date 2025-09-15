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
        $this->load->model(('M_user'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    public function simpan()
    {
        // Validasi form
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        $this->form_validation->set_rules('kondisi', 'Kondisi', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal Masuk', 'required');

        if ($this->form_validation->run() == FALSE) {
            // ... kode form validation ...
        } else {
            $data_common = array(
                'merk' => $this->input->post('merk'),
                'lokasi' => $this->input->post('lokasi'),
                'kondisi' => $this->input->post('kondisi'),
                'tanggal' => $this->input->post('tanggal')
            );

            $count = 0;

            // Simpan setiap aksesoris yang dipilih
            if ($this->input->post('kode_c')) {
                $data_c = $data_common;
                $data_c['jenis'] = 'Charger';
                $data_c['kode'] = $this->input->post('kode_c');
                $new_id = $this->M_aksesoris->simpan_data($data_c);

                // >>> LOG HISTORY <<<
                log_insert(
                    'tb_aset_aksesoris1',
                    $data_c,
                    'Menambah aksesoris Charger: ' . $data_c['merk'],
                    $new_id
                );
                // >>> END LOG <<<

                $count++;
            }

            if ($this->input->post('kode_h')) {
                $data_h = $data_common;
                $data_h['jenis'] = 'Headset';
                $data_h['kode'] = $this->input->post('kode_h');
                $new_id = $this->M_aksesoris->simpan_data($data_h);

                // >>> LOG HISTORY <<<
                log_insert(
                    'tb_aset_aksesoris1',
                    $data_h,
                    'Menambah aksesoris Headset: ' . $data_h['merk'],
                    $new_id
                );
                // >>> END LOG <<<

                $count++;
            }

            if ($this->input->post('kode_m')) {
                $data_m = $data_common;
                $data_m['jenis'] = 'Mouse';
                $data_m['kode'] = $this->input->post('kode_m');
                $new_id = $this->M_aksesoris->simpan_data($data_m);

                // >>> LOG HISTORY <<<
                log_insert(
                    'tb_aset_aksesoris1',
                    $data_m,
                    'Menambah aksesoris Mouse: ' . $data_m['merk'],
                    $new_id
                );
                // >>> END LOG <<<

                $count++;
            }

            if ($count > 0) {
                $this->session->set_flashdata('success', $count . ' data aksesoris berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data aksesoris yang dipilih');
            }

            redirect('aksesoris/tabel_aksesoris_masuk');
        }
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

    // list aksesoris masuk
    public function list_aksesoris()
    {
        $config = array();
        $config['base_url'] = site_url('aksesoris/list_aksesoris');
        $config['total_rows'] = $this->M_aksesoris->count_all_aksesoris_masuk($this->input->get('search'));
        $config['per_page'] = $this->input->get('per_page') ?: 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = $this->input->get('page') ?: 0;
        $per_page = $this->input->get('per_page') ?: 10;
        $search = $this->input->get('search');

        // Parameter sorting
        $sort_by = $this->input->get('sort_by') ?: 'tanggal';
        $sort_order = $this->input->get('sort_order') ?: 'desc';
        $data['title'] = 'Daftar Aksesoris Masuk';
        $data['aksesoris'] = $this->M_aksesoris->get_aksesoris_masuk_paginated($per_page, $page, $search, $sort_by, $sort_order);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $data['page'] = $page;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aksesoris_masuk', $data);
        $this->load->view('footer/footer', $data);
    }
}
