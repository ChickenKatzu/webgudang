<?php

class M_admin extends CI_Model
{

  #############################################
  // START OF PT INFO TEKNO SIAGA REQUEST NEEDED
  #############################################
  // public function get_kode_transaksi($kategori)
  // {
  //   $kode = [
  //     'Laptop'     => 'LT',
  //     'Charger'    => 'CG',
  //     'Headset'    => 'HS',
  //     'Mouse'      => 'MS',
  //     'Pheriperal' => 'PH'
  //   ];

  //   $prefix = strtolower($kategori) . '/' . $kode[$kategori] . '-' . date('mY') . '-';

  //   $this->db->like('id_transaksi', $prefix, 'after');
  //   $this->db->order_by('id_transaksi', 'DESC');
  //   $query = $this->db->get('barang_masuk', 1);

  //   if ($query->num_rows() > 0) {
  //     $last = $query->row()->id_transaksi;
  //     $last_number = (int)substr($last, -4);
  //     $next_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
  //   } else {
  //     $next_number = '0001';
  //   }

  //   return $prefix . $next_number;
  // }

  // Menyimpan alias kategori
  // public function __construct()
  // {
  //   parent::__construct();
  //   $this->aliasMap = [
  //     'Laptop'     => 'Lt',
  //     'Charger'    => 'Cg',
  //     'Headset'    => 'Hs',
  //     'Mouse'      => 'Ms',
  //     'Pheriperal' => 'Ph'
  //   ];
  // }
  // Ambil seluruh data barang_masuk
  public function getAll()
  {
    return $this->db->get('tb_barang_masuk')->result();
  }

  // Dapatkan 1 record by id_transaksi
  public function getById($id_transaksi)
  {
    return $this->db->get_where('tb_barang_masuk', ['id_transaksi' => $id_transaksi])->row();
  }

  // insert data keluar
  public function insert_keluar($table, $data)
  {
    // Ubah menjadi single insert saja
    return $this->db->insert($table, $data);
  }

  // Tambahkan fungsi untuk update stok
  public function update_stok_masuk($id_transaksi, $kode_barang, $jumlah_keluar)
  {
    $this->db->where('id_transaksi', $id_transaksi)
      ->where('kode_barang', $kode_barang)
      ->set('jumlah', 'jumlah-' . $jumlah_keluar, FALSE)
      ->update('tb_barang_masuk');

    return $this->db->affected_rows();
  }

  // Insert data baru
  public function insert_batch($table, $data)
  {
    return $this->db->insert_batch($table, $data);
  }


  public function update($tabel, $data, $where)
  {
    $this->db->where($where);
    $this->db->update($tabel, $data);
  }
  // Delete data
  public function delete($table, $where)
  {
    return $this->db->delete($table, $where);
  }

  // function delete($where,$table)
  // {
  // 	$this->db->where($where);
  // 	$this->db->delete($table);
  // }
  // Generate ID Transaksi
  // public function generate_id_transaksi($kategori)
  // {
  //   // Cari alias berdasarkan kategori
  //   $alias = isset($this->aliasMap[$kategori]) ? $this->aliasMap[$kategori] : 'xx';

  //   // Bulan (MM)
  //   $bulan = date('m');

  //   // Prefix misal: "Laptop/LT-04-"
  //   $prefix = $alias . '-' . $bulan . '-';

  //   // Cek record terakhir yang mirip prefix ini
  //   $this->db->like('id_transaksi', $prefix, 'after');
  //   $this->db->order_by('id_transaksi', 'DESC');
  //   $this->db->limit(1);
  //   $query = $this->db->get('barang_masuk');

  //   if ($query->num_rows() > 0) {
  //     // Contoh last_id: "Laptop/LT-04-0005"
  //     $last_id = $query->row()->id_transaksi;
  //     // Ambil 4 digit terakhir → 0005
  //     $last_num = (int)substr($last_id, -4);
  //     $new_num  = $last_num + 1;
  //   } else {
  //     $new_num = 1;
  //   }

  //   // Format nomor urut jadi 4 digit
  //   $new_num_formatted = str_pad($new_num, 4, '0', STR_PAD_LEFT);
  //   return $prefix . $new_num_formatted;
  // }

  // public function generate_id_transaksi($kategori)
  // {
  //   $alias = isset($this->aliasMap[$kategori]) ? $this->aliasMap[$kategori] : 'XX';
  //   $bulan = date('m');
  //   $prefix = $alias . '-' . $bulan . '-';

  //   $new_num = 1;
  //   do {
  //     $new_num_formatted = str_pad($new_num, 4, '0', STR_PAD_LEFT);
  //     $new_id = $prefix . $new_num_formatted;

  //     // Cek apakah ID ini sudah ada
  //     $this->db->where('id_transaksi', $new_id);
  //     $exists = $this->db->get('barang_masuk')->num_rows();
  //     $new_num++;
  //   } while ($exists > 0);

  //   return $new_id;
  // }


  // id_transaksi_user auto generate

  public function generate_id_transaksi($lokasi, $kategori)
  {
    // Ambil kode lokasi dan kode kategori
    $kode_lokasi = strtoupper(substr($lokasi, 0, 2));     // Contoh: "Cideng" → "CD"
    $kode_kategori = strtoupper(substr($kategori, 0, 2)); // Contoh: "Laptop" → "LT"

    $bulan = date('y'); // Bulan sekarang (misalnya: 04)

    // Format Awal: CD-LT-04
    $prefix = $kode_lokasi . '-' . $kode_kategori . '-' . $bulan;

    // Cari nomor urut terakhir dengan prefix tersebut
    $this->db->select('id_transaksi');
    $this->db->like('id_transaksi', $prefix, 'after');
    $this->db->order_by('id_transaksi', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('tb_barang_masuk');

    if ($query->num_rows() > 0) {
      $last_id = $query->row()->id_transaksi;
      $last_number = (int) substr($last_id, -4); // Ambil 4 digit terakhir
      $new_number = $last_number + 1;
    } else {
      $new_number = 1;
    }

    $new_id = $prefix . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    return $new_id;
  }

  // id_transaksi_user auto generate
  public function generate_id_transaksi_user($lokasi, $kategori)
  {
    // Ambil kode lokasi dan kode kategori
    $kode_lokasi = strtoupper(substr($lokasi, 0, 2));     // Contoh: "Cideng" → "CD"
    $kode_kategori = strtoupper(substr($kategori, 0, 2)); // Contoh: "Laptop" → "LT"

    $bulan = date('y'); // Bulan sekarang (misalnya: 04)

    // Format Awal: CD-LT-04
    $prefix = $kode_lokasi . '-' . $kode_kategori . '-' . $bulan;

    // Cari nomor urut terakhir dengan prefix tersebut
    $this->db->select('id_transaksi');
    $this->db->like('id_transaksi', $prefix, 'after');
    $this->db->order_by('id_transaksi', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('tb_barang_masuk');

    if ($query->num_rows() > 0) {
      $last_id = $query->row()->id_transaksi;
      $last_number = (int) substr($last_id, -4); // Ambil 4 digit terakhir
      $new_number = $last_number + 1;
    } else {
      $new_number = 1;
    }

    $new_id = $prefix . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    return $new_id;
  }









  #############################################
  // END OF PT INFO TEKNO SIAGA REQUEST NEEDED
  #############################################

  public function select($tabel)
  {
    $query = $this->db->get($tabel);
    return $query->result();
  }

  public function cek_jumlah($tabel, $id_transaksi)
  {
    return  $this->db->select('*')
      ->from($tabel)
      ->where('id_transaksi', $id_transaksi)
      ->get();
  }

  public function get_data_array($tabel, $id_transaksi)
  {
    $query = $this->db->select()
      ->from($tabel)
      ->where($id_transaksi)
      ->get();
    return $query->result_array();
  }

  public function get_data($tabel, $id_transaksi)
  {
    $query = $this->db->select()
      ->from($tabel)
      ->where($id_transaksi)
      ->get();
    return $query->result();
  }
  public function mengurangi($tabel, $id_transaksi, $jumlah)
  {
    $this->db->set("jumlah", "jumlah - $jumlah");
    $this->db->where('id_transaksi', $id_transaksi);
    $this->db->update($tabel);
  }

  public function update_password($tabel, $where, $data)
  {
    $this->db->where($where);
    $this->db->update($tabel, $data);
  }

  public function get_data_gambar($tabel, $username)
  {
    $query = $this->db->select()
      ->from($tabel)
      ->where('username_user', $username)
      ->get();
    return $query->result();
  }

  public function sum($tabel, $field)
  {
    $query = $this->db->select_sum($field)
      ->from($tabel)
      ->get();
    return $query->result();
  }

  public function numrows($tabel)
  {
    $query = $this->db->select()
      ->from($tabel)
      ->get();
    return $query->num_rows();
  }

  public function kecuali($tabel, $username)
  {
    $query = $this->db->select()
      ->from($tabel)
      ->where_not_in('username', $username)
      ->get();

    return $query->result();
  }
}
