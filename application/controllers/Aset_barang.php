<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_aset');
        $this->load->model('M_karyawan');
        $this->load->model('M_log_history');
        $this->load->model('M_user');
        $this->load->model('M_admin');
        $this->load->model('M_aksesoris');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'form', 'privilege_helper'));
    }

    // Form Aset Keluar
    public function keluar($kode_aset = null)
    {
        if ($_POST) {
            $this->form_validation->set_rules('kode_aset', 'Kode Aset', 'required');
            $this->form_validation->set_rules('id_karyawan', 'Nama Penerima', 'required');
            $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required');

            if ($this->form_validation->run()) {
                // ambil data karyawan untuk simpan nama & jabatan
                $karyawan = $this->M_admin->get_karyawan_by_id($this->input->post('id_karyawan'));

                $data = [
                    'kode_aset'       => $this->input->post('kode_aset'),
                    'id_karyawan'     => $karyawan->id_karyawan,
                    'id_departemen'   => null,
                    'nama_penerima'   => $karyawan->nama_karyawan,
                    'posisi_penerima' => $karyawan->jabatan,
                    'tanggal_keluar'  => $this->input->post('tanggal_keluar'),
                    'catatan'         => $this->input->post('catatan') // Perbaiki spasi berlebih
                ];

                // insert ke aset keluar
                if ($this->M_admin->create_aset_keluar($data)) {
                    // update status aset jadi dipinjam
                    $this->M_admin->update_status_aset($this->input->post('kode_aset'), 'dipinjam');

                    // simpan aksesoris kalau ada
                    if ($this->input->post('aksesoris')) {
                        foreach ($this->input->post('aksesoris') as $id_aksesoris) {
                            if (!empty($id_aksesoris)) {
                                $this->M_aksesoris->pinjam_aksesoris($this->input->post('kode_aset'), $id_aksesoris);
                            }
                        }
                    }

                    // >>> LOG HISTORY <<<
                    log_pinjam(
                        $this->input->post('kode_aset'),
                        $karyawan->id_karyawan,
                        'Peminjaman aset: ' . $this->input->post('kode_aset') . ' oleh ' . $karyawan->nama_karyawan
                    );
                    // >>> END LOG <<<

                    $this->session->set_flashdata('success', 'Aset berhasil dikeluarkan');
                    redirect('aset/list_keluar');
                }
            }
        }

        $data['title'] = 'Form Aset Keluar';
        $data['asset'] = $kode_aset ? $this->M_admin->get_aset_masuk_by_kode($kode_aset) : null;
        $data['karyawan'] = $this->M_admin->get_all_karyawan_aktif(); // untuk dropdown

        // UBAH INI: Ambil aksesoris yang tersedia saja
        $data['aksesoris'] = $this->M_aksesoris->get_aksesoris_tersedia(); // untuk dropdown aksesoris

        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/perpindahan_barang/form_aset_keluar', $data);
        $this->load->view('footer/footer', $data);
    }

    // aset barang masuk
    public function masuk()
    {
        if ($_POST) {
            $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
            $this->form_validation->set_rules('tipe', 'Tipe', 'required');

            if ($this->form_validation->run()) {
                $kode_aset = $this->M_admin->generate_kode_aset($this->input->post('tipe'));

                $data = [
                    'kode_aset' => $kode_aset,
                    'nama_barang' => $this->input->post('nama_barang'),
                    'merk' => $this->input->post('merk'),
                    'tipe' => $this->input->post('tipe'),
                    'serial_number' => $this->input->post('serial_number'),
                    'lokasi' => $this->input->post('lokasi'),
                    'kondisi' => $this->input->post('kondisi'),
                    'tanggal_masuk' => $this->input->post('tanggal_masuk')
                ];

                if ($this->M_admin->create_aset_masuk($data)) {
                    // >>> LOG HISTORY <<<
                    log_insert('tb_aset_masuk', $data, 'Menambah aset baru: ' . $data['nama_barang'], $kode_aset);
                    // >>> END LOG <<<

                    $this->session->set_flashdata('success', 'Aset berhasil ditambahkan');
                    redirect('aset/list_masuk');
                }
                // insert aset 
                if ($this->M_admin->create_aset_masuk($data)) {
                    $this->session->set_flashdata('success', 'Aset berhasil ditambahkan');
                    redirect('aset/list_masuk');
                }
            }
        }

        $data['title'] = 'Form Aset Masuk';
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/form_barangmasuk/form_aset_masuk', $data);
        $this->load->view('footer/footer', $data);
    }

    // kembalikan aset
    public function kembalikan($kode_aset)
    {
        if ($this->M_admin->kembalikan_aset($kode_aset)) {
            // >>> LOG HISTORY <<<
            log_kembali($kode_aset, 'Pengembalian aset: ' . $kode_aset);
            // >>> END LOG <<<

            $this->session->set_flashdata('success', 'Aset berhasil dikembalikan');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengembalikan aset');
        }
        redirect('aset/list_keluar');
    }
    // aset list masuk
    public function list_masuk()
    {
        $config = array();
        $config['base_url'] = site_url('aset/list_masuk');
        $config['total_rows'] = $this->M_admin->count_all_aset_masuk($this->input->get('search'));
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
        $sort_by = $this->input->get('sort_by') ?: 'tanggal_masuk';
        $sort_order = $this->input->get('sort_order') ?: 'desc';

        $data['title'] = 'Daftar Aset Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_paginated($per_page, $page, $search, $sort_by, $sort_order);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $data['page'] = $page;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk', $data);
        $this->load->view('footer/footer', $data);
    }


    // // List Aset Keluar dengan pagination dan search
    // public function list_keluar()
    // {
    //     $config = array();
    //     $config['base_url'] = site_url('aset/list_keluar');
    //     $config['total_rows'] = $this->M_admin->count_all_aset_keluar($this->input->get('search'));
    //     $config['per_page'] = $this->input->get('per_page') ?: 10;
    //     $config['page_query_string'] = TRUE;
    //     $config['query_string_segment'] = 'page';
    //     $config['reuse_query_string'] = TRUE;

    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul>';
    //     $config['first_tag_open'] = '<li>';
    //     $config['first_tag_close'] = '</li>';
    //     $config['last_tag_open'] = '<li>';
    //     $config['last_tag_close'] = '</li>';
    //     $config['next_tag_open'] = '<li>';
    //     $config['next_tag_close'] = '</li>';
    //     $config['prev_tag_open'] = '<li>';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['cur_tag_open'] = '<li class="active"><a href="#">';
    //     $config['cur_tag_close'] = '</a></li>';
    //     $config['num_tag_open'] = '<li>';
    //     $config['num_tag_close'] = '</li>';

    //     $this->pagination->initialize($config);

    //     $page = $this->input->get('page') ?: 0;
    //     $per_page = $this->input->get('per_page') ?: 10;
    //     $search = $this->input->get('search');

    //     $data['title'] = 'Daftar Aset Keluar';
    //     $data['assets'] = $this->M_admin->get_aset_keluar_paginated($per_page, $page, $search);
    //     $data['pagination'] = $this->pagination->create_links();
    //     $data['per_page'] = $per_page;
    //     $data['search'] = $search;
    //     $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));


    //     $this->load->view('header/header', $data);
    //     $this->load->view('admin/tabel/tabel_aset_keluar', $data);
    //     $this->load->view('footer/footer', $data);
    // }

    public function list_keluar()
    {
        $config = array();
        $config['base_url'] = site_url('aset/list_keluar');
        $config['total_rows'] = $this->M_admin->count_all_aset_keluar($this->input->get('search'));
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

        $data['title'] = 'Daftar Aset Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_paginated($per_page, $page, $search);

        // Ambil detail aksesoris untuk setiap aset
        if (!empty($data['assets'])) {
            foreach ($data['assets'] as $asset) {
                $asset->detail_aksesoris = $this->M_admin->get_aksesoris_by_kode_aset($asset->kode_aset);
            }
        }

        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar', $data);
        $this->load->view('footer/footer', $data);
    }

    // table table aset masuk keluar per kategori
    // list aset masuk laptop
    public function list_masuk_laptop()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_laptop');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_laptop($this->input->get('search'));
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

        $data['title'] = 'Daftar laptop Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_laptop_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_laptop', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_laptop()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_laptop');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_laptop($this->input->get('search'));
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

        $data['title'] = 'Daftar laptop Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_laptop_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_laptop', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar monitor
    public function list_masuk_monitor()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_monitor');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_monitor($this->input->get('search'));
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

        $data['title'] = 'Daftar Monitor Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_monitor_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_monitor', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_monitor()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_monitor');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_monitor($this->input->get('search'));
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

        $data['title'] = 'Daftar Monitor Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_monitor_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_monitor', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar firewall
    public function list_masuk_firewall()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_firewall');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_firewall($this->input->get('search'));
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

        $data['title'] = 'Daftar Firewall Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_firewall_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_firewall', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_firewall()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_firewall');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_firewall($this->input->get('search'));
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

        $data['title'] = 'Daftar Firewall Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_firewall_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_firewall', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar router/switch
    public function list_masuk_router_switch()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_router_switch');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_router_switch($this->input->get('search'));
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

        $data['title'] = 'Daftar Router/Switch Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_router_switch_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_router_switch', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_router_switch()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_router_switch');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_router_switch($this->input->get('search'));
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

        $data['title'] = 'Daftar Router/Switch Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_router_switch_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_router_switch', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar pc
    public function list_masuk_pc()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_pc');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_pc($this->input->get('search'));
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

        $data['title'] = 'Daftar PC Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_pc_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_pc', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_pc()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_pc');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_pc($this->input->get('search'));
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

        $data['title'] = 'Daftar PC Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_pc_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_pc', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar cctv/dvr
    public function list_masuk_cctv_dvr()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_cctv_dvr');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_cctv_dvr($this->input->get('search'));
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

        $data['title'] = 'Daftar CCTV/DVR Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_cctv_dvr_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_cctv_dvr', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_cctv_dvr()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_cctv_dvr');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_cctv_dvr($this->input->get('search'));
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

        $data['title'] = 'Daftar CCTV/DVR Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_cctv_dvr_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_cctv_dvr', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar wifi/ap
    public function list_masuk_wifi_ap()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_wifi_ap');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_wifi_ap($this->input->get('search'));
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

        $data['title'] = 'Daftar WiFi/AP Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_wifi_ap_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_wifi_ap', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_wifi_ap()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_wifi_ap');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_wifi_ap($this->input->get('search'));
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

        $data['title'] = 'Daftar WiFi/AP Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_wifi_ap_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_wifi_ap', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar server
    public function list_masuk_server()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_server');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_server($this->input->get('search'));
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
        $data['title'] = 'Daftar Server Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_server_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_server', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_server()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_server');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_server($this->input->get('search'));
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

        $data['title'] = 'Daftar Server Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_server_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_server', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar projector
    public function list_masuk_projector()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_projector');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_projector($this->input->get('search'));
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
        $data['title'] = 'Daftar Projector Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_projector_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_projector', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_projector()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_projector');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_projector($this->input->get('search'));
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

        $data['title'] = 'Daftar Projector Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_projector_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_projector', $data);
        $this->load->view('footer/footer', $data);
    }

    // list aset masuk keluar harddisk
    public function list_masuk_harddisk()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_harddisk');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_harddisk($this->input->get('search'));
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
        $data['title'] = 'Daftar Harddisk Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_harddisk_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_harddisk', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_harddisk()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_harddisk');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_harddisk($this->input->get('search'));
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

        $data['title'] = 'Daftar Harddisk Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_harddisk_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_harddisk', $data);
        $this->load->view('footer/footer', $data);
    }

    //  list aset masuk keluar rack server
    public function list_masuk_rack_server()
    {
        $config = array();
        $config['base_url'] = site_url('aset/masuk_rack_server');
        $config['total_rows'] = $this->M_admin->count_aset_masuk_rack_server($this->input->get('search'));
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
        $data['title'] = 'Daftar Rack Server Masuk';
        $data['assets'] = $this->M_admin->get_aset_masuk_rack_server_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_masuk_rack_server', $data);
        $this->load->view('footer/footer', $data);
    }

    public function list_keluar_rack_server()
    {
        $config = array();
        $config['base_url'] = site_url('aset/keluar_rack_server');
        $config['total_rows'] = $this->M_admin->count_aset_keluar_rack_server($this->input->get('search'));
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

        $data['title'] = 'Daftar Rack Server Keluar';
        $data['assets'] = $this->M_admin->get_aset_keluar_rack_server_paginated($per_page, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_aset_keluar_rack_server', $data);
        $this->load->view('footer/footer', $data);
    }
}
