<?php

class M_gudang extends CI_Model
{
    public function get_data_gambar($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username_user', $username)
            ->get();
        return $query->result();
    }

    // model untuk gudang

    public function count_gudang($search = null)
    {
        $this->db->where('nama_gudang', 'gudang'); // Filter hanya gudang
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_gudang', $search);
            $this->db->or_like('kode_gudang', $search);
            $this->db->or_like('alamat_gudang', $search);
            $this->db->or_like('kota', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('gudang');
    }
    public function get_gudang_paginated($limit, $start, $search = null)
    {
        $this->db->where('nama_gudang', 'gudang'); // Filter hanya gudang
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_gudang', $search);
            $this->db->or_like('kode_gudang', $search);
            $this->db->or_like('alamat_gudang', $search);
            $this->db->or_like('kota', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }
        $this->db->limit($limit, $start);
        return $this->db->get('gudang')->result();
    }
    public function get_kode_gudang($limit, $start)
    {
        $this->db->limit($limit, $start);
        return $this->db->get('gudang')->result();
    }

    public function insert_gudang($data)
    {
        return $this->db->insert('gudang', $data);
    }
    public function generate_kode_gudang($lokasi_gudang)
    {
        $prefix_map = [
            'Adapundi' => 'ADP',
            'Credinex' => 'CRD'
        ];
        $prefix = isset($prefix_map[$lokasi_gudang]) ? $prefix_map[$lokasi_gudang] : '00';

        $this->db->like('kode_gudang' . $prefix . '-', 'after');
        $this->db->order_by('kode_gudang', 'desc');
        $this->db->limit(1);
        $gudang_terakhir = $this->db->get('gudang')->row();

        $nomor_terakhir = 0;
        if ($gudang_terakhir) {
            $parts = explode('-', $gudang_terakhir->kode_gudang);
            $nomor_terakhir = (int)end($parts);
        }
        $nomor_baru = str_pad($nomor_terakhir + 1, 4, '0', STR_PAD_LEFT);
        return $prefix . '-' . $nomor_baru;
    }
}
