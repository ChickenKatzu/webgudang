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

  // public function getById($id_transaksi)
  // {
  //   return $this->db->get_where('tb_barang_masuk', ['id_transaksi' => $id_transaksi])->row();
  // }

  // insert data keluar

  //////////////////////////////////////////////
  ////////// PERLU DIRUBAH ////////////////////
  // Fungsi untuk INSERT data ke tabel barang keluar

  // Dapatkan 1 record by id_transaksi
  // public function getById($id_transaksi)
  // {
  //   $this->db->where('id_transaksi', $id_transaksi);
  //   return $this->db->get('tb_barang_masuk')->row();
  // }

  public function getById($id)
  {
    return $this->db->get_where('tb_barang_masuk', ['id' => $id])->row();
  }

  public function insert_keluar($table, $data)
  {
    return $this->db->insert($table, $data);
  }

  // Fungsi untuk DELETE 1 baris dari tb_barang_masuk
  public function delete_one_item($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete('tb_barang_masuk');
    // echo $this->db->last_query();
    // die();
    return $result;
  }
  ///////////// END OF PERLU DIRUBAH //////////////


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
    $this->db->insert_batch($table, $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    } else {
      return false;
    }
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
  public function delete_item($id_transaksi)
  {
    $this->db->where('id_transaksi', $id_transaksi);
    return $this->db->delete('tb_barang_masuk');
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

  // Hitung barang masuk yang lokasinya tidak null
  public function count_masuk()
  {
    $this->db->where('lokasi IS NOT NULL');
    return $this->db->count_all_results('tb_aset_masuk');
  }
  public function count_keluar($table, $column)
  {
    $this->db->select('nama_penerima, COUNT(*) as total');
    $this->db->group_by('nama_penerima');
    return $this->db->get('tb_aset_keluar')->result(); // Return array of objects
  }
  public function count_rows($table)
  {
    $this->db->select('COUNT(*) as total');
    return $this->db->get($table)->row()->total;
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


  // new function barang masuk not used yet 
  // Insert data
  public function insert_barang($data)
  {
    return $this->db->insert('tb_aset', $data);
  }

  // Get all data with pagination
  public function get_barang($limit, $start, $search = null)
  {
    if ($search) {
      $this->db->like('nama_aset', $search);
      $this->db->or_like('kode_aset', $search);
      $this->db->or_like('lokasi', $search);
    }
    $this->db->limit($limit, $start);
    $this->db->order_by('id', 'DESC');
    return $this->db->get('tb_aset')->result();
  }

  // Count all data
  public function count_barang($search = null)
  {
    if ($search) {
      $this->db->like('nama_aset', $search);
      $this->db->or_like('kode_aset', $search);
      $this->db->or_like('lokasi', $search);
    }
    return $this->db->count_all_results('tb_aset');
  }

  // start of aset masuk
  // ASET MASUK
  public function insert_masuk($data)
  {
    return $this->db->insert('tb_aset_masuk', $data);
  }

  public function get_aset_masuk($limit, $start)
  {
    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  // ASET KELUAR
  public function get_aset_tersedia()
  {
    return $this->db->query("
            SELECT * FROM tb_aset_masuk 
            WHERE kode_aset NOT IN (SELECT kode_aset FROM tb_aset_keluar)
        ")->result();
  }

  public function insert_aset_keluar($data)
  {
    return $this->db->insert('tb_aset_keluar', $data);
  }
  // end of aset masuk

  // start of aset masuk part 2
  public function generate_kode_aset($tipe)
  {
    $prefix_map = [
      'Laptop' => '01',
      'Monitor' => '02',
      'Router' => '03',
      'Firewall' => '04'
    ];

    $prefix = isset($prefix_map[$tipe]) ? $prefix_map[$tipe] : '00';

    $this->db->like('kode_aset', 'IT-' . $prefix . '-', 'after');
    $this->db->order_by('kode_aset', 'DESC');
    $this->db->limit(1);
    $last_asset = $this->db->get('tb_aset_masuk')->row();

    $last_number = 0;
    if ($last_asset) {
      $parts = explode('-', $last_asset->kode_aset);
      $last_number = (int)end($parts);
    }

    $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
    return 'IT-' . $prefix . '-' . $new_number;
  }

  // CRUD Aset Masuk
  public function create_aset_masuk($data)
  {
    return $this->db->insert('tb_aset_masuk', $data);
  }

  public function get_all_aset_masuk()
  {
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function get_aset_masuk_by_kode($kode_aset)
  {
    return $this->db->get_where('tb_aset_masuk', ['kode_aset' => $kode_aset])->row();
  }

  // CRUD Aset Keluar
  public function create_aset_keluar($data)
  {
    return $this->db->insert('tb_aset_keluar', $data);
  }

  public function get_all_aset_keluar()
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    return $this->db->get()->result();
  }

  // Cek apakah aset sudah keluar
  public function is_aset_keluar($kode_aset)
  {
    return $this->db->get_where('tb_aset_keluar', ['kode_aset' => $kode_aset])->num_rows() > 0;
  }
  // Fungsi untuk Aset Masuk dengan pagination dan search
  public function get_aset_masuk_paginated($limit, $start, $search = null)
  {
    $this->db->limit($limit, $start);
    $this->db->where('status', 'tersedia');

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }

    return $this->db->get('tb_aset_masuk')->result();
  }

  // Hitung total Aset Masuk untuk pagination
  public function count_all_aset_masuk($search = null)
  {
    $this->db->from('tb_aset_masuk');
    $this->db->where('status', 'tersedia');
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results();
  }

  // Fungsi untuk Aset Keluar dengan pagination dan search
  public function get_aset_keluar_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }

  // Hitung total Aset Keluar untuk pagination
  public function count_all_aset_keluar($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->count_all_results('tb_aset_keluar');
  }

  // Kembalikan Aset
  // public function kembalikan_aset($kode_aset, $data_kembali)
  // {
  //   $this->db->trans_start();
  //   $this->db->where('kode_aset', $kode_aset);
  //   $this->db->update('tb_aset_masuk', ['status' => 'tersedia']);
  //   $this->db->where('kode_aset', $kode_aset);
  //   $this->db->delete('tb_aset_keluar');
  //   $this->db->trans_complete();
  //   return $this->db->trans_status();
  // }

  // public function get_aset_keluar_with_join()
  // {
  //   $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
  //   $this->db->from('tb_aset_keluar');
  //   $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
  //   return $this->db->get()->result();
  // }

  public function kembalikan_aset($kode_aset)
  {
    $this->db->where('kode_aset', $kode_aset);
    $delete = $this->db->delete('tb_aset_keluar');

    if ($delete) {
      $this->db->where('kode_aset', $kode_aset);
      $update = $this->db->update('tb_aset_masuk', [
        'tanggal_masuk' => date('Y-m-d'),
        'lokasi' => 'gudang'
      ]);

      return $update;
    }

    return false;
  }

  // Fungsi untuk menghitung jumlah aset masuk berdasarkan tipe laptop
  public function count_aset_masuk_laptop($search = null)
  {
    $this->db->where('tipe', 'laptop'); // Filter hanya laptop

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_laptop_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'laptop'); // Filter hanya laptop

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_laptop($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'laptop'); // Filter hanya laptop

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->count_all_results('tb_aset_keluar');
  }

  public function get_aset_keluar_laptop_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk,tb_aset_masuk.status');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'laptop'); // Filter hanya laptop
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }
  public function count_aset_masuk_monitor($search = null)
  {
    $this->db->where('tipe', 'monitor'); // Filter hanya monitor

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_monitor_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'monitor'); // Filter hanya monitor

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_monitor($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'monitor'); // Filter hanya monitor

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->count_all_results('tb_aset_keluar');
  }

  public function get_aset_keluar_monitor_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'monitor'); // Filter hanya monitor
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }

  // model untuk firewall
  public function count_aset_masuk_firewall($search = null)
  {
    $this->db->where('tipe', 'firewall'); // Filter hanya firewall

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_firewall_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'firewall'); // Filter hanya firewall

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_firewall($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'firewall'); // Filter hanya firewall

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->count_all_results('tb_aset_keluar');
  }

  public function get_aset_keluar_firewall_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'firewall'); // Filter hanya firewall
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }

  // model untuk router switch
  public function count_aset_masuk_router($search = null)
  {
    $this->db->where('tipe', 'router'); // Filter hanya router

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_router_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'router'); // Filter hanya router

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_router($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'router'); // Filter hanya router

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->count_all_results('tb_aset_keluar');
  }

  public function get_aset_keluar_router_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'router'); // Filter hanya router
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }

  // model untuk pc
  public function count_aset_masuk_pc($search = null)
  {
    $this->db->where('tipe', 'pc'); // Filter hanya PC

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_pc_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'pc'); // Filter hanya PC

    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_pc($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'pc'); // Filter hanya PC

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->count_all_results('tb_aset_keluar');
  }

  public function get_aset_keluar_pc_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'pc'); // Filter hanya PC
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }

  // model untuk cctv
  public function count_aset_masuk_cctv($search = null)
  {
    $this->db->where('tipe', 'cctv'); // Filter hanya CCTV
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_cctv_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'cctv'); // Filter hanya CCTV
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_cctv($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'cctv'); // Filter hanya CCTV
    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_keluar');
  }
  public function get_aset_keluar_cctv_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'cctv'); // Filter hanya CCTV
    $this->db->limit($limit, $start);
  }

  // model untuk wifi ap
  public function count_aset_masuk_wifi_ap($search = null)
  {
    $this->db->where('tipe', 'wifi_ap'); // Filter hanya WiFi AP
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_masuk');
  }

  public function get_aset_masuk_wifi_ap_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'wifi_ap'); // Filter hanya WiFi AP
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }

  public function count_aset_keluar_wifi_ap($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'wifi_ap'); // Filter hanya WiFi AP
    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_keluar');
  }

  public function get_aset_keluar_wifi_ap_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'wifi_ap'); // Filter hanya WiFi AP
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
  }

  // model untuk server
  public function count_aset_masuk_server($search = null)
  {
    $this->db->where('tipe', 'server'); // Filter hanya Server
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
  }
  public function get_aset_masuk_server_paginated($limit, $start, $search = null)
  {
    $this->db->where('tipe', 'server'); // Filter hanya Server
    if ($search) {
      $this->db->group_start();
      $this->db->like('kode_aset', $search);
      $this->db->or_like('nama_barang', $search);
      $this->db->or_like('merk', $search);
      $this->db->or_like('tipe', $search);
      $this->db->or_like('serial_number', $search);
      $this->db->or_like('lokasi', $search);
      $this->db->group_end();
    }
    $this->db->limit($limit, $start);
    return $this->db->get('tb_aset_masuk')->result();
  }
  public function count_aset_keluar_server($search = null)
  {
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'server'); // Filter hanya Server
    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }
    return $this->db->count_all_results('tb_aset_keluar');
  }
  public function get_aset_keluar_server_paginated($limit, $start, $search = null)
  {
    $this->db->select('tb_aset_keluar.*, tb_aset_masuk.nama_barang, tb_aset_masuk.merk, tb_aset_masuk.tipe, tb_aset_masuk.serial_number, tb_aset_masuk.lokasi, tb_aset_masuk.kondisi, tb_aset_masuk.tanggal_masuk');
    $this->db->from('tb_aset_keluar');
    $this->db->join('tb_aset_masuk', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.tipe', 'server'); // Filter hanya Server
    $this->db->limit($limit, $start);

    if ($search) {
      $this->db->group_start();
      $this->db->like('tb_aset_keluar.kode_aset', $search);
      $this->db->or_like('tb_aset_masuk.nama_barang', $search);
      $this->db->or_like('tb_aset_masuk.merk', $search);
      $this->db->or_like('tb_aset_masuWk.tipe', $search);
      $this->db->or_like('tb_aset_keluar.nama_penerima', $search);
      $this->db->or_like('tb_aset_keluar.posisi_penerima', $search);
      $this->db->group_end();
    }

    return $this->db->get()->result();
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

  // numrow parameter cideng all
  public function numrows_cideng_all_keluar()
  {
    $this->db->from('tb_aset_masuk');
    $this->db->join('tb_aset_keluar', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.lokasi', 'cideng');
    return $this->db->count_all_results();
  }
  public function numrows_cideng_all_masuk()
  {
    $this->db->from('tb_aset_masuk');
    $this->db->where('lokasi', 'cideng');
    return $this->db->count_all_results();
  }
  public function number_cideng($tabel)
  {
    $query = $this->db->get($tabel);
    return $query->result();
  }
  // numrow parameter bungur all
  public function numrows_bungur_all_keluar()
  {
    $this->db->from('tb_aset_masuk');
    $this->db->join('tb_aset_keluar', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.lokasi', 'bungur');
    return $this->db->count_all_results();
  }
  public function numrows_bungur_all_masuk()
  {
    $this->db->from('tb_aset_masuk');
    $this->db->where('lokasi', 'bungur');
    return $this->db->count_all_results();
  }

  // numrow parameter Capital Place all
  public function numrows_capital_all_keluar()
  {
    $this->db->from('tb_aset_masuk');
    $this->db->join('tb_aset_keluar', 'tb_aset_masuk.kode_aset = tb_aset_keluar.kode_aset');
    $this->db->where('tb_aset_masuk.lokasi', 'capital place');
    return $this->db->count_all_results();
  }
  public function numrows_capital_all_masuk()
  {
    $this->db->from('tb_aset_masuk');
    $this->db->where('lokasi', 'capital place');
    return $this->db->count_all_results();
  }

  // riwayat peggunaan

  public function get_riwayat_by_karyawan($id_karyawan)
  {
    $this->db->select('r.*, a.nama_barang, a.merk, a.tipe, a.nama_karyawan');
    $this->db->from('riwayat_penggunaan r');
    $this->db->join('tb_aset_masuk a', 'r.kode_aset = a.kode_aset');
    $this->db->where('r.id_karyawan', $id_karyawan);
    $this->db->order_by('r.tanggal_penggunaan', 'DESC');
    return $this->db->get()->result();
  }

  public function get_riwayat_by_aset($kode_aset)
  {
    $this->db->select('r.*, k.nama_karyawan, k.jabatan, d.nama_departemen');
    $this->db->from('riwayat_penggunaan r');
    $this->db->join('karyawan k', 'r.id_karyawan = k.id_karyawan');
    $this->db->join('departement d', 'k.id_departemen = d.id_departemen', 'left');
    $this->db->where('r.kode_aset', $kode_aset);
    $this->db->order_by('r.tanggal_mulai', 'desc');
    return $this->db->get()->result();
  }
  public function add_riwayat($data)
  {
    $this->db->insert('riwayat_penggunaan', $data);
    return $this->db->insert_id();
  }

  public function update_riwayat($id_riwayat, $data)
  {
    $this->db->where('id_riwayat', $id_riwayat);
    return $this->db->update('riwayat_penggunaan', $data);
  }
}
