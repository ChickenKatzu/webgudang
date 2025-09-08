<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_log_history extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Menyimpan log history
    public function save_log($data)
    {
        return $this->db->insert('log_history', $data);
    }

    // Mendapatkan semua log history
    public function get_all_logs($limit = 100, $offset = 0)
    {
        $this->db->select('lh.*, u.username, k.nama_karyawan');
        $this->db->from('log_history lh');
        $this->db->join('user u', 'lh.id_user = u.id_user', 'left');
        $this->db->join('karyawan k', 'lh.id_karyawan = k.id_karyawan', 'left');
        $this->db->order_by('lh.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    // Filter log berdasarkan jenis aksi
    public function get_logs_by_action($action_type, $limit = 100, $offset = 0)
    {
        $this->db->select('lh.*, u.username, k.nama_karyawan');
        $this->db->from('log_history lh');
        $this->db->join('user u', 'lh.id_user = u.id_user', 'left');
        $this->db->join('karyawan k', 'lh.id_karyawan = k.id_karyawan', 'left');
        $this->db->where('lh.action_type', $action_type);
        $this->db->order_by('lh.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    // Filter log berdasarkan kode aset
    public function get_logs_by_aset($kode_aset, $limit = 50, $offset = 0)
    {
        $this->db->select('lh.*, u.username, k.nama_karyawan');
        $this->db->from('log_history lh');
        $this->db->join('user u', 'lh.id_user = u.id_user', 'left');
        $this->db->join('karyawan k', 'lh.id_karyawan = k.id_karyawan', 'left');
        $this->db->where('lh.kode_aset', $kode_aset);
        $this->db->order_by('lh.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    // Filter log berdasarkan tanggal
    public function get_logs_by_date($start_date, $end_date, $limit = 100, $offset = 0)
    {
        $this->db->select('lh.*, u.username, k.nama_karyawan');
        $this->db->from('log_history lh');
        $this->db->join('user u', 'lh.id_user = u.id_user', 'left');
        $this->db->join('karyawan k', 'lh.id_karyawan = k.id_karyawan', 'left');
        $this->db->where('DATE(lh.created_at) >=', $start_date);
        $this->db->where('DATE(lh.created_at) <=', $end_date);
        $this->db->order_by('lh.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    // Mendapatkan total jumlah log
    public function get_total_logs()
    {
        return $this->db->count_all('log_history');
    }
}
