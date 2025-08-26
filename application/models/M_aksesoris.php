<?php

class M_aksesoris extends CI_Model
{

    public function get_data_gambar($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username_user', $username)
            ->get();
        return $query->result();
    }


    // Tambahkan di Model M_admin
    // public function generate_kode_aksesoris($jenis_aksesoris)
    // {
    //     // Tentukan prefix berdasarkan jenis aksesoris
    //     $prefix = '';
    //     switch ($jenis_aksesoris) {
    //         case 'Headset':
    //             $prefix = 'H';
    //             break;
    //         case 'Mouse':
    //             $prefix = 'M';
    //             break;
    //         case 'Charger':
    //             $prefix = 'C';
    //             break;
    //         default:
    //             return false;
    //     }

    //     // Cari kode terakhir untuk jenis aksesoris ini
    //     $this->db->like('kode_aksesoris', $prefix, 'after');
    //     $this->db->order_by('id', 'DESC');
    //     $last_record = $this->db->get('tb_aset_aksesoris')->row();

    //     if ($last_record) {
    //         // Jika ada record sebelumnya, ambil nomor urutnya dan tambah 1
    //         $last_kode = $last_record->kode_aksesoris;
    //         $last_number = intval(substr($last_kode, 1)); // Hapus prefix dan ambil angkanya
    //         $next_number = $last_number + 1;
    //     } else {
    //         // Jika tidak ada, mulai dari 1
    //         $next_number = 1;
    //     }

    //     // Format nomor menjadi 4 digit dengan leading zeros
    //     $formatted_number = str_pad($next_number, 4, '0', STR_PAD_LEFT);

    //     // Gabungkan menjadi kode aksesoris lengkap
    //     $kode_aksesoris = $prefix . $formatted_number;

    //     return $kode_aksesoris;
    // }

    public function insert_aksesoris($data)
    {
        return $this->db->insert('tb_aset_aksesoris', $data);
    }

    public function get_all_kode_aset()
    {
        $this->db->select('kode_aset');
        $this->db->from('tb_aset_masuk');
        $this->db->where('status', 'tersedia');
        $this->db->order_by('kode_aset', 'ASC');
        return $this->db->get()->result();
    }

    // public function generate_kode_aksesoris($jenis)
    // {
    //     $prefix = '';
    //     if ($jenis == 'Headset') $prefix = 'H';
    //     elseif ($jenis == 'Mouse') $prefix = 'M';
    //     elseif ($jenis == 'Charger') $prefix = 'C';

    //     $this->db->like('kode_aksesoris', $prefix, 'after');
    //     $this->db->order_by('kode_aksesoris', 'DESC');
    //     $last = $this->db->get('tb_aset_aksesoris')->row();

    //     if ($last) {
    //         $last_num = (int)substr($last->kode_aksesoris, 1); // ambil angka setelah prefix
    //         $new_num = str_pad($last_num + 1, 4, '0', STR_PAD_LEFT);
    //     } else {
    //         $new_num = '0001';
    //     }

    //     return $prefix . $new_num;
    // }

    public function generate_kode_aksesoris($jenis)
    {
        $prefix = '';
        if ($jenis == 'Headset') $prefix = 'H';
        elseif ($jenis == 'Mouse') $prefix = 'M';
        elseif ($jenis == 'Charger') $prefix = 'C';

        $this->db->like('kode_aksesoris', $prefix, 'after');
        $this->db->order_by('kode_aksesoris', 'DESC');
        $last = $this->db->get('tb_aset_aksesoris')->row();

        if ($last) {
            $last_num = (int)substr($last->kode_aksesoris, 1); // ambil angka setelah prefix
            $new_num = str_pad($last_num + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new_num = '0001';
        }

        return $prefix . $new_num;
    }
}
