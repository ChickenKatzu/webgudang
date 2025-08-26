<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_admin $M_admin
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_admin');
    $this->load->library('upload');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->helper(array('form', 'url'));
    $this->load->library('pagination');
  }

  public function index()
  {
    if ($this->session->userdata('status') == 'login' && $this->session->userdata('role') == 1) {
      $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
      $data['totalBarangMasuk'] = $this->M_admin->count_rows('tb_aset_masuk');
      $data['totalBarangKeluar'] = $this->M_admin->count_rows('tb_aset_keluar');
      $data['stokBarangMasukCideng'] = $this->M_admin->numrows_cideng_all_masuk('tb_aset_masuk');
      $data['stokBarangKeluarCideng'] = $this->M_admin->numrows_cideng_all_keluar('tb_aset_keluar');
      $data['stokBarangMasukBungur'] = $this->M_admin->numrows_bungur_all_masuk('tb_aset_masuk');
      $data['stockBarangKeluarBungur'] = $this->M_admin->numrows_bungur_all_keluar('tb_aset_keluar');
      $data['stockBarangMasukCapitalPlace'] = $this->M_admin->numrows_capital_all_masuk('tb_aset_masuk');
      $data['stockBarangKeluarCapitalPlace'] = $this->M_admin->numrows_capital_all_keluar('tb_aset_keluar');
      $data['dataUser'] = $this->M_admin->numrows('user');
      $this->load->view('header/header', $data);
      $this->load->view('admin/index', $data);
      $this->load->view('footer/footer');
    } else {
      $this->load->view('header/header', $data);
      $this->load->view('login/login');
      $this->load->view('footer/footer', $data);
    }
  }

  public function sigout()
  {
    session_destroy();
    redirect('login');
  }

  ####################################
  // Profile
  ####################################

  public function profile()
  {
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('header/header', $data);
    $this->load->view('admin/profile', $data);
    $this->load->view('footer/footer', $data);
  }

  public function token_generate()
  {
    return $tokens = md5(uniqid(rand(), true));
  }

  private function hash_password($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  public function proses_new_password()
  {
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('new_password', 'New Password', 'required');
    $this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'required|matches[new_password]');

    if ($this->form_validation->run() == TRUE) {
      if ($this->session->userdata('token_generate') === $this->input->post('token')) {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $new_password = $this->input->post('new_password');

        $data = array(
          'email'    => $email,
          'password' => $this->hash_password($new_password)
        );

        $where = array(
          'id' => $this->session->userdata('id')
        );

        $this->M_admin->update_password('user', $where, $data);

        $this->session->set_flashdata('msg_berhasil', 'Password Telah Diganti');
        redirect(base_url('admin/profile'));
      }
    } else {
      $this->load->view('header/header', $data);
      $this->load->view('admin/profile');
      $this->load->view('footer/footer', $data);
    }
  }

  public function proses_gambar_upload()
  {
    $config =  array(
      'upload_path'     => "./assets/upload/user/img/",
      'allowed_types'   => "gif|jpg|png|jpeg",
      'encrypt_name'    => False, //
      'max_size'        => "50000",  // ukuran file gambar
      'max_height'      => "9680",
      'max_width'       => "9024"
    );
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if (! $this->upload->do_upload('userpicture')) {
      $this->session->set_flashdata('msg_error_gambar', $this->upload->display_errors());
      $this->load->view('admin/profile', $data);
    } else {
      $upload_data = $this->upload->data();
      $nama_file = $upload_data['file_name'];
      $ukuran_file = $upload_data['file_size'];

      //resize img + thumb Img -- Optional
      $config['image_library']     = 'gd2';
      $config['source_image']      = $upload_data['full_path'];
      $config['create_thumb']      = FALSE;
      $config['maintain_ratio']    = TRUE;
      $config['width']             = 150;
      $config['height']            = 150;

      $this->load->library('image_lib', $config);
      $this->image_lib->initialize($config);
      if (!$this->image_lib->resize()) {
        $data['pesan_error'] = $this->image_lib->display_errors();
        $this->load->view('header/header', $data);
        $this->load->view('admin/profile', $data);
        $this->load->view('footer/footer', $data);
      }

      $where = array(
        'username_user' => $this->session->userdata('name')
      );

      $data = array(
        'nama_file' => $nama_file,
        'ukuran_file' => $ukuran_file
      );

      $this->M_admin->update('tb_upload_gambar_user', $data, $where);
      $this->session->set_flashdata('msg_berhasil_gambar', 'Gambar Berhasil Di Upload');
      redirect(base_url('admin/profile'));
    }
  }

  ####################################
  // End Profile
  ####################################



  ####################################
  // Users
  ####################################
  public function users()
  {
    $data['list_users'] = $this->M_admin->kecuali('user', $this->session->userdata('name'));
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('header/header', $data);
    $this->load->view('admin/users', $data);
    $this->load->view('footer/footer', $data);
  }

  public function form_user()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_users/form_insert', $data);
    $this->load->view('footer/footer', $data);
  }

  public function update_user()
  {
    $id = $this->uri->segment(3);
    $where = array('id' => $id);
    $data['token_generate'] = $this->token_generate();
    $data['list_data'] = $this->M_admin->get_data('user', $where);
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_users/form_update', $data);
    $this->load->view('footer/footer', $data);
  }

  public function proses_delete_user()
  {
    $id = $this->uri->segment(3);
    $where = array('id' => $id);
    $this->M_admin->delete('user', $where);
    $this->session->set_flashdata('msg_berhasil', 'User Behasil Di Delete');
    redirect(base_url('admin/users'));
  }

  public function proses_tambah_user()
  {
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');

    if ($this->form_validation->run() == TRUE) {
      if ($this->session->userdata('token_generate') === $this->input->post('token')) {

        $username     = $this->input->post('username', TRUE);
        $email        = $this->input->post('email', TRUE);
        $password     = $this->input->post('password', TRUE);
        $role         = $this->input->post('role', TRUE);

        $data = array(
          'username'     => $username,
          'email'        => $email,
          'password'     => $this->hash_password($password),
          'role'         => $role,
        );
        $this->M_admin->insert('user', $data);

        $this->session->set_flashdata('msg_berhasil', 'User Berhasil Ditambahkan');
        redirect(base_url('admin/form_user'));
      }
    } else {
      $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
      $this->load->view('header/header', $data);
      $this->load->view('admin/form_users/form_insert', $data);
      $this->load->view('footer/footer', $data);
    }
  }

  public function proses_update_user()
  {
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');


    if ($this->form_validation->run() == TRUE) {
      if ($this->session->userdata('token_generate') === $this->input->post('token')) {
        $id           = $this->input->post('id', TRUE);
        $username     = $this->input->post('username', TRUE);
        $email        = $this->input->post('email', TRUE);
        $role         = $this->input->post('role', TRUE);

        $where = array('id' => $id);
        $data = array(
          'username'     => $username,
          'email'        => $email,
          'role'         => $role,
        );
        $this->M_admin->update('user', $data, $where);
        $this->session->set_flashdata('msg_berhasil', 'Data User Berhasil Diupdate');
        redirect(base_url('admin/users'));
      }
    } else {
      $this->load->view('admin/form_users/form_update');
    }
  }


  ####################################
  // End Users
  ####################################



  ####################################
  // DATA BARANG MASUK
  ####################################

  public function tabel_barangmasuk()
  {
    $data = array(
      'list_data' => $this->M_admin->select('tb_barang_masuk'),
      'avatar'    => $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'))
    );
    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_barangmasuk', $data);
    $this->load->view('footer/footer', $data);
  }

  public function form_barangmasuk()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['id_transaksi'] = '';
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_barangmasuk/form_insert', $data);
    $this->load->view('footer/footer', $data);
  }

  public function proses_databarang_masuk_insert()
  {
    $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
    $this->form_validation->set_rules('merek', 'Merek', 'required');
    $this->form_validation->set_rules('kategori', 'Nama Barang', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');

    if ($this->form_validation->run() == TRUE) {
      // $id           = $this->input->post('id', TRUE); // format awal dari input (misalnya: la-ci-25-0001)
      $id_transaksi = $this->input->post('id_transaksi', TRUE); // format awal dari input (misalnya: la-ci-25-0001)
      $kategori     = $this->input->post('kategori', TRUE);
      $merek        = $this->input->post('merek', TRUE);
      $tanggal      = $this->input->post('tanggal', TRUE);
      $lokasi       = $this->input->post('lokasi', TRUE);
      $satuan       = $this->input->post('satuan', TRUE);
      $jumlah       = (int)$this->input->post('jumlah', TRUE);

      // Pecah ID transaksi awal untuk ambil prefix dan nomor urut
      $parts = explode('-', $id_transaksi); // ['la', 'ci', '25', '0001']
      $prefix = $parts[0] . '-' . $parts[1] . '-' . $parts[2] . '-';
      $start = (int)ltrim($parts[3], '0'); // dari '0001' jadi 1

      $data_batch = [];

      for ($i = 0; $i < $jumlah; $i++) {
        $nomor = str_pad($start + $i, 4, '0', STR_PAD_LEFT);
        $id_transaksi = $prefix . $nomor;

        $data_batch[] = [
          // 'id' => $id,
          'id_transaksi' => $id_transaksi,
          'tanggal'      => $tanggal,
          'lokasi'       => $lokasi,
          'kode_barang'  => $merek,
          'nama_barang'  => $kategori,
          'satuan'       => $satuan,
          'jumlah'       => 1
        ];
      }

      $data = $this->M_admin->insert_batch('tb_barang_masuk', $data_batch);
      $data = $this->session->set_flashdata('msg_berhasil', 'Data Barang Berhasil Ditambahkan');
      redirect(base_url('admin/form_barangmasuk'));
    } else {
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $this->load->view('header/header');
      $this->load->view('admin/form_barangmasuk/form_insert', $data);
      $this->load->view('footer/footer');
    }
  }

  public function get_id_transaksi()
  {
    $lokasi   = $this->input->post('lokasi');
    $kategori = $this->input->post('kategori');

    $id_transaksi = $this->M_admin->generate_id_transaksi($lokasi, $kategori);

    echo json_encode(['id_transaksi' => $id_transaksi]);
  }

  // public function generate_id_ajax()
  // {
  //   $kategori = $this->input->post('kategori');
  //   if (!$kategori) {
  //     echo json_encode(['status' => 'error', 'message' => 'Kategori tidak ditemukan']);
  //     return;
  //   }

  //   $id = $this->M_admin->generate_id_transaksi($kategori);
  //   echo json_encode(['status' => 'success', 'id_transaksi' => $id]);
  // }
  // Di Admin.php (controller)
  // public function get_id_transaksi_ajax()
  // {
  //   $kategori = $this->input->post('kategori');
  //   if ($kategori) {
  //     $id_transaksi = $this->M_admin->generate_id_transaksi($kategori);
  //     echo json_encode(['id_transaksi' => $id_transaksi]);
  //   } else {
  //     echo json_encode(['error' => 'Kategori tidak ditemukan']);
  //   }
  // }
  // public function get_id_transaksi()
  // {
  //   $lokasi = $this->input->post('lokasi', TRUE);
  //   $kategori = $this->input->post('kategori', TRUE);
  //   $new_id = $this->M_admin->generate_id_transaksi($lokasi, $kategori);

  //   echo json_encode(['id_transaksi' => $new_id]);
  // }


  public function update_barang($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $data['data_barang_update'] = $this->M_admin->get_data('tb_barang_masuk', $where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_barangmasuk/form_update', $data);
    $this->load->view('footer/footer', $data);
  }

  public function proses_databarang_masuk_update()
  {
    $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
    $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
    $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

    if ($this->form_validation->run() == TRUE) {
      $id_transaksi = $this->input->post('id_transaksi', TRUE);
      $tanggal      = $this->input->post('tanggal', TRUE);
      $lokasi       = $this->input->post('lokasi', TRUE);
      $kode_barang  = $this->input->post('kode_barang', TRUE);
      $nama_barang  = $this->input->post('nama_barang', TRUE);
      $satuan       = $this->input->post('satuan', TRUE);
      $jumlah       = $this->input->post('jumlah', TRUE);

      $where = array('id_transaksi' => $id_transaksi);
      $data = array(
        'id_transaksi' => $id_transaksi,
        'tanggal'      => $tanggal,
        'lokasi'       => $lokasi,
        'kode_barang'  => $kode_barang,
        'nama_barang'  => $nama_barang,
        'satuan'       => $satuan,
        'jumlah'       => $jumlah
      );
      $this->M_admin->update('tb_barang_masuk', $data, $where);
      $this->session->set_flashdata('msg_berhasil', 'Data Barang Berhasil Diupdate');
      redirect(base_url('admin/tabel_barangmasuk'));
    } else {
      $this->load->view('header/header', $data);
      $this->load->view('admin/form_barangmasuk/form_update', $data);
      $this->load->view('footer/footer', $data);
    }
  }

  public function generate_id_transaksi()
  {
    $kategori = $this->input->post('kategori');
    if (!$kategori) {
      echo json_encode(['status' => 'error', 'message' => 'Kategori kosong']);
      return;
    }

    $id = $this->M_admin->generate_id($kategori);
    if ($id) {
      echo json_encode(['status' => 'success', 'id_transaksi' => $id]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Gagal generate ID']);
    }
  }
  ####################################
  // END DATA BARANG MASUK
  ####################################

  ####################################
  // START DATA DELETE BARANG
  ####################################

  public function delete_barang($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $this->M_admin->delete('tb_barang_masuk', $where);
    redirect(base_url('admin/tabel_barangmasuk'));
  }

  ####################################
  // END DATA DELETE BARANG
  ####################################

  ####################################
  // SATUAN
  ####################################

  public function form_satuan()
  {
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_satuan/form_insert', $data);
    $this->load->view('footer/footer', $data);
  }

  public function tabel_satuan()
  {
    $data['list_data'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_satuan', $data);
    $this->load->view('footer/footer', $data);
  }

  public function update_satuan()
  {
    $uri = $this->uri->segment(3);
    $where = array('id_satuan' => $uri);
    $data['data_satuan'] = $this->M_admin->get_data('tb_satuan', $where);
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_satuan/form_update', $data);
    $this->load->view('footer/footer', $data);
  }

  public function delete_satuan()
  {
    $uri = $this->uri->segment(3);
    $where = array('id_satuan' => $uri);
    $this->M_admin->delete('tb_satuan', $where);
    redirect(base_url('admin/tabel_satuan'));
  }

  public function proses_satuan_insert()
  {
    $this->form_validation->set_rules('kode_satuan', 'Kode Satuan', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'trim|required|max_length[100]');

    if ($this->form_validation->run() ==  TRUE) {
      $kode_satuan = $this->input->post('kode_satuan', TRUE);
      $nama_satuan = $this->input->post('nama_satuan', TRUE);

      $data = array(
        'kode_satuan' => $kode_satuan,
        'nama_satuan' => $nama_satuan
      );
      $this->M_admin->insert('tb_satuan', $data);

      $this->session->set_flashdata('msg_berhasil', 'Data satuan Berhasil Ditambahkan');
      redirect(base_url('admin/form_satuan'));
    } else {
      $this->load->view('header/header');
      $this->load->view('admin/form_satuan/form_insert');
      $this->load->view('footer/footer');
    }
  }

  public function proses_satuan_update()
  {
    $this->form_validation->set_rules('kode_satuan', 'Kode Satuan', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'trim|required|max_length[100]');

    if ($this->form_validation->run() ==  TRUE) {
      $id_satuan   = $this->input->post('id_satuan', TRUE);
      $kode_satuan = $this->input->post('kode_satuan', TRUE);
      $nama_satuan = $this->input->post('nama_satuan', TRUE);

      $where = array(
        'id_satuan' => $id_satuan
      );

      $data = array(
        'kode_satuan' => $kode_satuan,
        'nama_satuan' => $nama_satuan
      );
      $this->M_admin->update('tb_satuan', $data, $where);

      $this->session->set_flashdata('msg_berhasil', 'Data satuan Berhasil Di Update');
      redirect(base_url('admin/tabel_satuan'));
    } else {
      $this->load->view('header/header');
      $this->load->view('admin/form_satuan/form_update');
      $this->load->view('footer/footer');
    }
  }

  ####################################
  // END SATUAN
  ####################################


  ####################################
  // DATA MASUK KE DATA KELUAR
  ####################################

  public function barang_keluar()
  {
    $uri = $this->uri->segment(3);
    $where = array('id_transaksi' => $uri);
    $data['list_data'] = $this->M_admin->get_data('tb_barang_masuk', $where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/perpindahan_barang/form_update', $data);
    $this->load->view('footer/footer', $data);
  }
  public function proses_data_keluar()
  {
    $this->form_validation->set_rules('id', 'ID Barang', 'required|numeric');

    if ($this->form_validation->run() === TRUE) {
      $this->db->trans_start();

      $id = $this->input->post('id', TRUE);
      $barang = $this->M_admin->getById($id); // Ambil data berdasarkan ID

      if (!$barang) {
        $this->session->set_flashdata('msg_gagal', 'Barang tidak ditemukan!');
        redirect($_SERVER['HTTP_REFERER']);
      }

      // Data untuk tabel keluar
      $data_keluar = [
        'id_transaksi' => $barang->id_transaksi,
        'tanggal_masuk' => $barang->tanggal,
        'tanggal_keluar' => $this->input->post('tanggal_keluar'),
        'lokasi' => $barang->lokasi,
        'kode_barang' => $barang->kode_barang,
        'nama_barang' => $barang->nama_barang,
        'satuan' => $barang->satuan,
        'jumlah' => 1
      ];

      $this->M_admin->insert_keluar('tb_barang_keluar', $data_keluar);
      $this->M_admin->delete_one_item($id); // Hapus berdasarkan ID

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('msg_gagal', 'Proses gagal!');
      } else {
        $this->session->set_flashdata('msg_berhasil_keluar', 'Barang berhasil dikeluarkan');
      }
      redirect('admin/tabel_barangmasuk');
    } else {
      $this->session->set_flashdata('msg_gagal', 'Validasi gagal!');
      redirect($_SERVER['HTTP_REFERER']);
    }
  }


  ####################################
  // END DATA MASUK KE DATA KELUAR
  ####################################


  ####################################
  // DATA BARANG KELUAR
  ####################################

  public function tabel_barangkeluar()
  {
    $data['list_data'] = $this->M_admin->select('tb_barang_keluar');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_barangkeluar', $data);
    $this->load->view('footer/footer', $data);
  }



  ####################################
  // START DATA RESIGNATION
  ####################################

  public function form_resignation()
  {
    // here is view
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['id_transaksi'] = '';
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_resignation/form_insert', $data);
    $this->load->view('footer/footer', $data);
  }

  // public function update_resignation($id_transaksi)
  // {
  //   $where = array('id_transaksi' => $id_transaksi);
  //   $data['data_barang_update'] = $this->M_admin->get_data('tb_barang_masuk', $where);
  //   $data['list_satuan'] = $this->M_admin->select('tb_satuan');
  //   $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
  //   $this->load->view('header/header', $data);
  //   $this->load->view('admin/form_barangmasuk/form_update', $data);
  //   $this->load->view('footer/footer', $data);
  // }
  ####################################
  // END DATA RESIGNATION
  ####################################



  #############################################
  // END OF PT INFO TEKNO SIAGA REQUEST NEEDED
  #############################################



  #############################################
  // START OF PT INFO TEKNO SIAGA REQUEST NEEDED PART 2
  #############################################
  public function tabel_barangmasuk2()
  {
    $per_page = $this->input->get('per_page') ?? 10;
    $search = $this->input->get('search');
    // Pagination config
    $config['base_url'] = base_url('barang');
    $config['total_rows'] = $this->M_admin->count_barang($search);
    $config['per_page'] = $per_page;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'per_page';
    $config['reuse_query_string'] = TRUE;

    $this->pagination->initialize($config);

    $page = $this->input->get('per_page') ?: 0;

    $data = array(
      'avatar' => $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name')),
      'barang' => $this->M_admin->get_barang($config['per_page'], $page, $search),
      'pagination' => $this->pagination->create_links(),
      'per_page' => $per_page,
      'search' => $search
    );
    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_barangmasuk2', $data);
    $this->load->view('footer/footer', $data);
  }


  // Here is form for barang masuk 2
  public function form_barangmasuk2()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));
    $this->load->view('header/header', $data);
    $this->load->view('admin/form_barangmasuk/form_insert2', $data);
    $this->load->view('footer/footer', $data);
  }


  public function insert()
  {
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('namaAset', 'Nama Aset', 'required');
    // Add more validation rules as needed

    if ($this->form_validation->run() == TRUE) {
      $data = array(
        'nama' => $this->input->post('nama'),
        'nama_aset' => $this->input->post('namaAset'),
        'kode_aset' => $this->input->post('kodeAset'),
        'lokasi' => $this->input->post('lokasi'),
        'departemen' => $this->input->post('departement'),
        'kondisi' => $this->input->post('condition'),
        'merk' => $this->input->post('merk'),
        'tipe' => $this->input->post('type'),
        'ram' => $this->input->post('ram'),
        'os' => $this->input->post('operatingSystem'),
        'chm_mouse' => ($this->input->post('mouse')) ? 1 : 0,
        'chm_charger' => ($this->input->post('charger')) ? 1 : 0,
        'chm_headset' => ($this->input->post('headset')) ? 1 : 0,
        'chm_code' => $this->input->post('chmCode'),
        'serial_number' => $this->input->post('sNSerialNumber'),
        'condition_details' => $this->input->post('conditionDetails'),
        'created_at' => date('Y-m-d H:i:s')
      );

      $this->M_admin->insert_barang($data);
      $this->session->set_flashdata('msg_berhasil', 'Data barang berhasil ditambahkan');
      redirect('barang');
    } else {
      $this->session->set_flashdata('error', validation_errors());
      redirect('barang/form');
    }
  }

  // start of aset masuk
  // ASET MASUK
  public function form_masuk()
  {
    $this->load->view('aset_masuk_form');
  }

  public function insert_masuk()
  {
    $data = [
      'kode_aset' => $this->input->post('kode_aset'),
      'nama_barang' => $this->input->post('nama_barang'),
      'merk' => $this->input->post('merk'),
      'tipe' => $this->input->post('tipe'),
      'serial_number' => $this->input->post('serial_number'),
      'kondisi' => $this->input->post('kondisi'),
      'tanggal_masuk' => $this->input->post('tanggal_masuk')
    ];

    $this->M_aset->insert_masuk($data);
    redirect('aset/daftar_masuk');
  }

  // ASET KELUAR
  public function form_keluar()
  {
    $data['aset_tersedia'] = $this->M_aset->get_aset_tersedia();
    $this->load->view('aset_keluar_form', $data);
  }

  public function insert_keluar()
  {
    $data = [
      'kode_aset' => $this->input->post('kode_aset'),
      'tanggal_keluar' => $this->input->post('tanggal_keluar'),
      'penerima' => $this->input->post('penerima'),
      'lokasi_tujuan' => $this->input->post('lokasi_tujuan'),
      'keterangan' => $this->input->post('keterangan')
    ];

    $this->M_aset->insert_keluar($data);
    redirect('aset/daftar_keluar');
  }

  // start of aset masuk part 2
  public function index_aset()
  {
    $data['title'] = 'Manajemen Aset';
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('footer/footer', $data);
  }

  // Form Aset Masuk
  public function masuk()
  {
    if ($_POST) {
      $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
      $this->form_validation->set_rules('tipe', 'Tipe', 'required');

      if ($this->form_validation->run()) {
        $kode_aset = $this->M_admin->generate_kode_aset($this->input->post('tipe'));

        $data = [
          'kode_aset' => $kode_aset,
          'nama_barang' => $this->input->post('nama_barang'),
          'merk' => $this->input->post('merk'),
          'tipe' => $this->input->post('tipe'),
          'serial_number' => $this->input->post('serial_number'),
          'lokasi' => $this->input->post('lokasi'),
          'kondisi' => $this->input->post('kondisi'),
          'tanggal_masuk' => $this->input->post('tanggal_masuk')
        ];

        if ($this->M_admin->create_aset_masuk($data)) {
          $this->session->set_flashdata('success', 'Aset berhasil ditambahkan');
          redirect('aset/list_masuk');
        }
      }
    }

    $data['title'] = 'Form Aset Masuk';
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/form_barangmasuk/form_aset_masuk', $data);
    $this->load->view('footer/footer', $data);
  }

  // List Aset Masuk All
  public function list_masuk()
  {
    $config = array();
    $config['base_url'] = site_url('aset/list_masuk');
    $config['total_rows'] = $this->M_admin->count_all_aset_masuk($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    // Parameter sorting
    $sort_by = $this->input->get('sort_by') ?: 'tanggal_masuk';
    $sort_order = $this->input->get('sort_order') ?: 'desc';

    $data['title'] = 'Daftar Aset Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_paginated($per_page, $page, $search, $sort_by, $sort_order);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['sort_by'] = $sort_by;
    $data['sort_order'] = $sort_order;
    $data['page'] = $page;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk', $data);
    $this->load->view('footer/footer', $data);
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
          'id_departemen'   => null, // kalau ada tabel departemen bisa diisi
          'nama_penerima'   => $karyawan->nama_karyawan,
          'posisi_penerima' => $karyawan->jabatan,
          'tanggal_keluar'  => $this->input->post('tanggal_keluar')
        ];

        // insert ke aset keluar
        if ($this->M_admin->create_aset_keluar($data)) {
          // update status aset jadi dipinjam
          $this->M_admin->update_status_aset($this->input->post('kode_aset'), 'dipinjam');

          // simpan aksesoris kalau ada
          if ($this->input->post('aksesoris')) {
            foreach ($this->input->post('aksesoris') as $id_aksesoris) {
              $this->M_admin->pinjam_aksesoris($this->input->post('kode_aset'), $id_aksesoris);
            }
          }

          $this->session->set_flashdata('success', 'Aset berhasil dikeluarkan');
          redirect('aset/list_keluar');
        }
      }
    }

    $data['title'] = 'Form Aset Keluar';
    $data['asset'] = $kode_aset ? $this->M_admin->get_aset_masuk_by_kode($kode_aset) : null;
    $data['karyawan'] = $this->M_admin->get_all_karyawan_aktif(); // untuk dropdown
    $data['aksesoris'] = $this->M_admin->get_all_aksesoris(); // untuk checkbox aksesoris
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/perpindahan_barang/form_aset_keluar', $data);
    $this->load->view('footer/footer', $data);
  }



  // List Aset Keluar dengan pagination dan search
  public function list_keluar()
  {
    $config = array();
    $config['base_url'] = site_url('aset/list_keluar');
    $config['total_rows'] = $this->M_admin->count_all_aset_keluar($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Aset Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));


    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar', $data);
    $this->load->view('footer/footer', $data);
  }

  public function kembalikan($kode_aset)
  {
    if ($this->M_admin->kembalikan_aset($kode_aset)) {
      $this->session->set_flashdata('success', 'Aset berhasil dikembalikan');
    } else {
      $this->session->set_flashdata('error', 'Gagal mengembalikan aset');
    }
    redirect('aset/list_keluar');
  }

  // list aset masuk laptop
  public function list_masuk_laptop()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_laptop');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_laptop($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar laptop Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_laptop_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_laptop', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_laptop()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_laptop');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_laptop($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar laptop Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_laptop_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_laptop', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar monitor
  public function list_masuk_monitor()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_monitor');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_monitor($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Monitor Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_monitor_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_monitor', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_monitor()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_monitor');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_monitor($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Monitor Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_monitor_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_monitor', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar firewall
  public function list_masuk_firewall()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_firewall');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_firewall($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Firewall Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_firewall_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_firewall', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_firewall()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_firewall');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_firewall($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Firewall Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_firewall_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_firewall', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar router/switch
  public function list_masuk_router_switch()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_router_switch');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_router_switch($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Router/Switch Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_router_switch_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_router_switch', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_router_switch()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_router_switch');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_router_switch($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Router/Switch Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_router_switch_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_router_switch', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar pc
  public function list_masuk_pc()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_pc');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_pc($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar PC Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_pc_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_pc', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_pc()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_pc');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_pc($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar PC Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_pc_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_pc', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar cctv/dvr
  public function list_masuk_cctv_dvr()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_cctv_dvr');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_cctv_dvr($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar CCTV/DVR Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_cctv_dvr_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_cctv_dvr', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_cctv_dvr()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_cctv_dvr');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_cctv_dvr($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar CCTV/DVR Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_cctv_dvr_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_cctv_dvr', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar wifi/ap
  public function list_masuk_wifi_ap()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_wifi_ap');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_wifi_ap($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar WiFi/AP Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_wifi_ap_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_wifi_ap', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_wifi_ap()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_wifi_ap');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_wifi_ap($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar WiFi/AP Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_wifi_ap_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_wifi_ap', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar server
  public function list_masuk_server()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_server');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_server($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');
    $data['title'] = 'Daftar Server Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_server_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_server', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_server()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_server');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_server($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Server Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_server_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_server', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar projector
  public function list_masuk_projector()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_projector');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_projector($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');
    $data['title'] = 'Daftar Projector Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_projector_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_projector', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_projector()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_projector');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_projector($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Projector Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_projector_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_projector', $data);
    $this->load->view('footer/footer', $data);
  }

  // list aset masuk keluar harddisk
  public function list_masuk_harddisk()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_harddisk');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_harddisk($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');
    $data['title'] = 'Daftar Harddisk Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_harddisk_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_harddisk', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_harddisk()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_harddisk');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_harddisk($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Harddisk Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_harddisk_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_harddisk', $data);
    $this->load->view('footer/footer', $data);
  }

  //  list aset masuk keluar rack server
  public function list_masuk_rack_server()
  {
    $config = array();
    $config['base_url'] = site_url('aset/masuk_rack_server');
    $config['total_rows'] = $this->M_admin->count_aset_masuk_rack_server($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');
    $data['title'] = 'Daftar Rack Server Masuk';
    $data['assets'] = $this->M_admin->get_aset_masuk_rack_server_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_masuk_rack_server', $data);
    $this->load->view('footer/footer', $data);
  }

  public function list_keluar_rack_server()
  {
    $config = array();
    $config['base_url'] = site_url('aset/keluar_rack_server');
    $config['total_rows'] = $this->M_admin->count_aset_keluar_rack_server($this->input->get('search'));
    $config['per_page'] = $this->input->get('per_page') ?: 10;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = $this->input->get('page') ?: 0;
    $per_page = $this->input->get('per_page') ?: 10;
    $search = $this->input->get('search');

    $data['title'] = 'Daftar Rack Server Keluar';
    $data['assets'] = $this->M_admin->get_aset_keluar_rack_server_paginated($per_page, $page, $search);
    $data['pagination'] = $this->pagination->create_links();
    $data['per_page'] = $per_page;
    $data['search'] = $search;
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('name'));

    $this->load->view('header/header', $data);
    $this->load->view('admin/tabel/tabel_aset_keluar_rack_server', $data);
    $this->load->view('footer/footer', $data);
  }
}
#############################################
// END OF PT INFO TEKNO SIAGA REQUEST NEEDED PART 2
#############################################