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
}
