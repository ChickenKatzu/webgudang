<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_Gudang $M_Gudang
 * @property CI_Form_validation $form_validation
 */

class Gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_gudang');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->library('pagination');
    }

    // Gudang
    public function tambah_gudang()
    {
        if ($_POST) {
            $this->form_validation->set_rules('nama_gudang', 'Nama Gudang', 'required|trim');
            $this->form_validation->set_rules('lokasi_gudang', 'Lokasi Gudang', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');

            if ($this->form_validation->run() == TRUE) {
                // Generate kode gudang otomatis (hanya butuh lokasi)
                $kode_gudang = $this->M_gudang->generate_kode_gudang(
                    $this->input->post('lokasi_gudang')
                );

                $data = array(
                    'kode_gudang' => $kode_gudang,
                    'nama_gudang' => $this->input->post('nama_gudang'),
                    'lokasi_gudang' => $this->input->post('lokasi_gudang'),
                    'status' => strtolower($this->input->post('status')),
                    'created_at' => date('Y-m-d H:i:s')
                );

                if ($this->M_gudang->insert_gudang($data)) {
                    $this->session->set_flashdata('success', 'Gudang berhasil ditambahkan.');
                    redirect('aset/list_gudang');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan gudang.');
                    redirect('aset/tambah_gudang');
                }
            }
        }

        $data['title'] = 'Form Tambah Gudang';
        $data['avatar'] = $this->M_gudang->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/form_gudang/form_tambah_gudang', $data);
        $this->load->view('footer/footer', $data);
    }

    public function generate_kode_ajax()
    {
        $lokasi = $this->input->post('lokasi_gudang');

        if ($lokasi) {
            $kode = $this->M_gudang->generate_kode_gudang($lokasi);
            echo json_encode(array('success' => true, 'kode' => $kode));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    public function list_gudang()
    {
        $config = array();
        $config['base_url'] = site_url('aset/list_gudang');
        $config['total_rows'] = $this->M_gudang->count_gudang($this->input->get('search'));
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

        $data['title'] = 'Daftar Gudang';
        $data['gudangs'] = $this->M_gudang->get_gudang_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_gudang->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_list_gudang', $data);
        $this->load->view('footer/footer', $data);
    }

    // mutasi aset
    public function mutasi_aset()
    {
        $config = array();
        $config['base_url'] = site_url('aset/mutasi_aset');
        $config['total_rows'] = $this->M_gudang->count_mutasi($this->input->get('search'));
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
        $data['title'] = 'Mutasi Aset';
        $data['mutasi'] = $this->M_gudang->get_mutasi_aset_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_gudang->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_mutasi_aset', $data);
        $this->load->view('footer/footer', $data);
    }
}
