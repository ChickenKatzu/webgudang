<?php

class M_Karyawan extends CI_Model
{

    public function get_data_gambar($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username_user', $username)
            ->get();
        return $query->result();
    }
    public function getAll()
    {
        return $this->db->get('karyawan')->result();
    }

    public function getById($id)
    {
        return $this->db->get_where('karyawan', ['id_karyawan' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('karyawan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_karyawan', $id);
        return $this->db->update('karyawan', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_karyawan', $id);
        return $this->db->delete('karyawan');
    }
    public function count_karyawan($search = null)
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_karyawan', $search);
            $this->db->or_like('jabatan', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('karyawan');
    }
    public function get_karyawan_paginated($limit, $start, $search = null, $sort_by = 'id_karyawan', $sort_order = 'asc')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_karyawan', $search);
            $this->db->or_like('jabatan', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }
        $this->db->order_by($sort_by, $sort_order);
        $this->db->limit($limit, $start);
        return $this->db->get('karyawan')->result();
    }
    // Hitung total untuk pagination
    public function count_all_karyawan($search = null)
    {
        $this->db->from('karyawan k1');
        $this->db->join('karyawan k2', 'k1.id_atasan = k2.id_karyawan', 'left');

        if ($search) {
            $this->db->group_start();
            $this->db->like('k1.nama_karyawan', $search);
            $this->db->or_like('k1.jabatan', $search);
            $this->db->or_like('k1.status', $search);
            $this->db->or_like('k2.nama_karyawan', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }
}
