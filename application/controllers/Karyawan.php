<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_karyawan $M_karyawan
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */

class Karyawan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_karyawan');
        $this->load->model('M_log_history');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

        if ($this->form_validation->run() == FALSE) {
            if ($this->input->post('id_karyawan')) {
                $this->edit($this->input->post('id_karyawan'));
            } else {
                $this->tambah();
            }
        } else {
            $data = [
                'nama_karyawan' => $this->input->post('nama_karyawan'),
                'jabatan'       => $this->input->post('jabatan'),
                'id_atasan'     => ($this->input->post('jabatan') == 'leader') ? NULL : $this->input->post('id_atasan'),
                'status'        => $this->input->post('status'),
            ];

            if ($this->input->post('id_karyawan')) {
                // Ambil data lama untuk log
                $old_data = $this->M_karyawan->getById($this->input->post('id_karyawan'));

                $this->M_karyawan->update($this->input->post('id_karyawan'), $data);

                // >>> LOG HISTORY <<<
                log_update(
                    'karyawan',
                    (array)$old_data,
                    $data,
                    'Update data karyawan: ' . $data['nama_karyawan'],
                    $this->input->post('id_karyawan')
                );
                // >>> END LOG <<<

                $this->session->set_flashdata('msg', 'Data karyawan berhasil diupdate.');
            } else {
                $this->M_karyawan->insert($data);
                $new_id = $this->db->insert_id();

                // >>> LOG HISTORY <<<
                log_insert(
                    'karyawan',
                    $data,
                    'Tambah data karyawan: ' . $data['nama_karyawan'],
                    $new_id
                );
                // >>> END LOG <<<

                $this->session->set_flashdata('msg', 'Data karyawan berhasil ditambahkan.');
            }
            redirect('karyawan');
        }
    }


    public function delete($id)
    {
        // Ambil data sebelum dihapus untuk log
        $old_data = $this->M_karyawan->getById($id);

        if ($old_data) {
            $this->M_karyawan->delete($id);

            // >>> LOG HISTORY <<<
            log_delete(
                'karyawan',
                (array)$old_data,
                'Menghapus data karyawan: ' . $old_data->nama_karyawan,
                $id
            );
            // >>> END LOG <<<

            $this->session->set_flashdata('msg', 'Data berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
        }
        redirect('karyawan');
    }


    public function list_karyawan()
    {
        $config = array();
        $config['base_url'] = site_url('karyawan/list_karyawan');
        $config['total_rows'] = $this->M_karyawan->count_all_karyawan($this->input->get('search'));
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
        $sort_by = $this->input->get('sort_by') ?: 'nama_karyawan';
        $sort_order = $this->input->get('sort_order') ?: 'asc';

        $data['title'] = 'Daftar Karyawan';
        $data['karyawan'] = $this->M_karyawan->get_karyawan_paginated($per_page, $page, $search, $sort_by, $sort_order);
        $data['pagination'] = $this->pagination->create_links();
        $data['per_page'] = $per_page;
        $data['search'] = $search;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $data['page'] = $page;
        $data['avatar'] = $this->M_karyawan->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/tabel/tabel_karyawan', $data);
        $this->load->view('footer/footer', $data);
    }
    public function tambah()
    {
        $data['list_atasan'] = $this->M_karyawan->getAll();
        $data['avatar'] = $this->M_karyawan->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
        $data['title'] = 'Form Tambah Karyawan';
        $this->load->view('header/header', $data);
        $this->load->view('admin/form_karyawan/form_karyawan', $data);
        $this->load->view('footer/footer', $data);
    }

    public function edit($id)
    {
        $data['karyawan'] = $this->M_karyawan->getById($id);
        $data['list_atasan'] = $this->M_karyawan->getAll();
        $data['avatar'] = $this->M_karyawan->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
        $data['title'] = 'Form Edit Karyawan';

        $this->load->view('header/header', $data);
        $this->load->view('admin/form_karyawan/form_karyawan', $data);
        $this->load->view('footer/footer', $data);
    }




    // deepseek
    // public function simpan()
    // {
    //     $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');

    //     if ($this->form_validation->run() == TRUE) {
    //         $data = array(
    //             'nama_karyawan' => $this->input->post('nama_karyawan'),
    //             'jabatan' => $this->input->post('jabatan'),
    //             'id_atasan' => $this->input->post('id_atasan'),
    //             'status' => $this->input->post('status')
    //         );

    //         if ($this->input->post('id_karyawan')) {
    //             // Mode edit
    //             $old_data = $this->M_karyawan->getById($this->input->post('id_karyawan'));
    //             $this->M_karyawan->update($this->input->post('id_karyawan'), $data);

    //             // Catat log
    //             log_update(
    //                 'karyawan',
    //                 $old_data,
    //                 $data,
    //                 'Update data karyawan: ' . $data['nama_karyawan'] . ' (ID: ' . $this->input->post('id_karyawan') . ')'
    //             );

    //             $this->session->set_flashdata('success', 'Data karyawan berhasil diupdate.');
    //         } else {
    //             // Mode tambah
    //             $this->M_karyawan->insert($data);
    //             $new_id = $this->db->insert_id();

    //             // Catat log
    //             log_insert(
    //                 'karyawan',
    //                 $data,
    //                 'Tambah data karyawan: ' . $data['nama_karyawan'] . ' (ID: ' . $new_id . ')'
    //             );

    //             $this->session->set_flashdata('success', 'Data karyawan berhasil ditambahkan.');
    //         }

    //         redirect('karyawan');
    //     }

    //     // Tampilkan form dengan error
    //     $data['list_atasan'] = $this->M_karyawan->getAll();
    //     $this->load->view('header/header', $data);
    //     $this->load->view('karyawan/form_karyawan', $data);
    //     $this->load->view('footer/footer', $data);
    // }
    // // deepseek
    // public function delete($id)
    // {
    //     $karyawan = $this->M_karyawan->getById($id);

    //     if ($karyawan) {
    //         $this->M_karyawan->delete($id);

    //         // Catat log
    //         log_delete(
    //             'karyawan',
    //             (array)$karyawan,
    //             'Hapus data karyawan: ' . $karyawan->nama_karyawan . ' (ID: ' . $id . ')'
    //         );

    //         $this->session->set_flashdata('success', 'Data karyawan berhasil dihapus.');
    //     } else {
    //         $this->session->set_flashdata('error', 'Data karyawan tidak ditemukan.');
    //     }

    //     redirect('karyawan');
    // }
}
