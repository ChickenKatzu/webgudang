<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_log_history extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Ambil data log dengan filter dan join
    public function get_logs($filters = array(), $limit = 10, $offset = 0)
    {
        $this->db->select('
            lh.*, 
            u.username, 
            k.nama_karyawan,
            a.nama_barang as nama_aset,
            ak.jenis as jenis_aksesoris
        ');
        $this->db->from('log_history lh');
        $this->db->join('user u', 'u.id_user = lh.id_user', 'left');
        $this->db->join('karyawan k', 'k.id_karyawan = lh.id_karyawan', 'left');
        $this->db->join('tb_aset_masuk a', 'a.kode_aset = lh.kode_aset', 'left');
        $this->db->join('tb_aset_aksesoris1 ak', 'ak.id = lh.id_aksesoris', 'left');

        // Filter berdasarkan action_type
        if (!empty($filters['action_type'])) {
            $this->db->where('lh.action_type', $filters['action_type']);
        }

        // Filter berdasarkan kode_aset
        if (!empty($filters['kode_aset'])) {
            $this->db->like('lh.kode_aset', $filters['kode_aset']);
        }

        // Filter berdasarkan table_name
        if (!empty($filters['table_name'])) {
            $this->db->where('lh.table_name', $filters['table_name']);
        }

        // Filter berdasarkan tanggal
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(lh.created_at) >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(lh.created_at) <=', $filters['end_date']);
        }

        $this->db->order_by('lh.created_at', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    // application/models/M_log_history.php

    public function get_recent_activities($limit = 5)
    {
        $this->db->select('lh.*, u.username, k.nama_karyawan');
        $this->db->from('log_history lh');
        $this->db->join('user u', 'u.id_user = lh.id_user', 'left');
        $this->db->join('karyawan k', 'k.id_karyawan = lh.id_karyawan', 'left');
        $this->db->order_by('lh.created_at', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    // Hitung total log untuk pagination
    public function count_logs($filters = array())
    {
        $this->db->from('log_history lh');

        // Filter berdasarkan action_type
        if (!empty($filters['action_type'])) {
            $this->db->where('lh.action_type', $filters['action_type']);
        }

        // Filter berdasarkan kode_aset
        if (!empty($filters['kode_aset'])) {
            $this->db->like('lh.kode_aset', $filters['kode_aset']);
        }

        // Filter berdasarkan table_name
        if (!empty($filters['table_name'])) {
            $this->db->where('lh.table_name', $filters['table_name']);
        }

        // Filter berdasarkan tanggal
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(lh.created_at) >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(lh.created_at) <=', $filters['end_date']);
        }

        return $this->db->count_all_results();
    }

    // Insert log baru
    public function insert($data)
    {
        return $this->db->insert('log_history', $data);
    }
}
