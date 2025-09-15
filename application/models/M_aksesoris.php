<?php

class M_aksesoris extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_data_gambar($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username_user', $username)
            ->get();
        return $query->result();
    }

    public function get_next_number($type)
    {
        // Query untuk mendapatkan nomor terakhir berdasarkan jenis aksesoris
        $this->db->select('kode');
        $this->db->from('tb_aset_aksesoris1');
        $this->db->like('kode', $type, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_code = $query->row()->kode;
            // Extract number from code (e.g., C0001 -> 1)
            $last_number = intval(substr($last_code, 1));
            return $last_number + 1;
        } else {
            // Jika belum ada data, mulai dari 1
            return 1;
        }
    }

    public function simpan_data($data)
    {
        $this->db->insert('tb_aset_aksesoris1', $data);
        return $this->db->insert_id();
    }

    public function get_all_aksesoris_masuk($limit, $start, $search = null, $sort_by = 'id', $sort_order = 'asc')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('kode', $search);
            $this->db->or_like('jenis', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('lokasi', $search);
            $this->db->or_like('kondisi', $search);
            $this->db->or_like('tanggal_masuk', $search);
            $this->db->group_end();
        }
        $this->db->order_by($sort_by, $sort_order);
        $this->db->limit($limit, $start);
        $query = $this->db->get('tb_aset_aksesoris1');
        return $query->result();
    }

    public function count_all_aksesoris_masuk($search = null)
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('kode', $search);
            $this->db->or_like('jenis', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('lokasi', $search);
            $this->db->or_like('kondisi', $search);
            $this->db->or_like('tanggal_masuk', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('tb_aset_aksesoris1');
    }

    public function get_aksesoris_masuk_paginated($limit, $start, $search = null, $sort_by = 'id', $sort_order = 'asc')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('kode', $search);
            $this->db->or_like('jenis', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('lokasi', $search);
            $this->db->or_like('kondisi', $search);
            $this->db->or_like('tanggal_masuk', $search);
            $this->db->group_end();
        }
        $this->db->order_by($sort_by, $sort_order);
        $this->db->limit($limit, $start);
        return $this->db->get('tb_aset_aksesoris1')->result();
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
                                $this->M_admin->pinjam_aksesoris($this->input->post('kode_aset'), $id_aksesoris);
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
        $data['aksesoris'] = $this->M_admin->get_aksesoris_tersedia(); // untuk dropdown aksesoris

        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

        $this->load->view('header/header', $data);
        $this->load->view('admin/perpindahan_barang/form_aset_keluar', $data);
        $this->load->view('footer/footer', $data);
    }

    // application/models/M_admin.php

    public function get_aksesoris_tersedia()
    {
        $this->db->where('status', 'tersedia');
        return $this->db->get('tb_aset_aksesoris1')->result();
    }

    // Method untuk meminjam aksesoris
    public function pinjam_aksesoris($kode_aset, $id_aksesoris)
    {
        $data = array(
            'status' => 'dipinjam',
            'kode_aset_peminjam' => $kode_aset
        );
        $this->db->where('id', $id_aksesoris);
        return $this->db->update('tb_aset_aksesoris1', $data);
    }

    public function getById($id)
    {
        return $this->db->get_where('tb_aset_aksesoris1', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tb_aset_aksesoris1', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_aset_aksesoris1');
    }

    public function insert($data)
    {
        return $this->db->insert('tb_aset_aksesoris1', $data);
    }
}
