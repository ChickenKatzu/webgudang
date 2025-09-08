<?php
class M_Aset extends CI_Model
{
    public function insert_mutasi($data)
    {
        return $this->db->insert('mutasi_aset', $data);
    }

    public function update_lokasi($kode_aset, $lokasi_baru)
    {
        $this->db->where('kode_aset', $kode_aset);
        return $this->db->update('tb_aset_masuk', ['lokasi' => $lokasi_baru]);
    }
}
