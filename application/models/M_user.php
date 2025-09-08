<?php
class M_user extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_user_by_id($id)
  {
    $this->db->select('u.*, up.*, k.nama_karyawan, k.jabatan');
    $this->db->from('user u');
    $this->db->join('user_privileges up', 'u.id_privilege = up.id_privilege', 'left');
    $this->db->join('karyawan k', 'u.id_karyawan = k.id_karyawan', 'left');
    $this->db->where('u.id_user', $id);
    return $this->db->get()->row();
  }
  public function get_all_users()
  {
    $this->db->select('u.*, up.role_name, k.nama_karyawan, k.jabatan');
    $this->db->from('user u');
    $this->db->join('user_privileges up', 'u.id_privilege = up.id_privilege', 'left');
    $this->db->join('karyawan k', 'u.id_karyawan = k.id_karyawan', 'left');
    $this->db->where('u.is_active', 1);
    $this->db->order_by('u.username', 'ASC');
    return $this->db->get()->result();
  }

  public function get_all_privileges()
  {
    return $this->db->get('user_privileges')->result();
  }


  public function get_available_karyawan()
  {
    $this->db->select('k.*');
    $this->db->from('karyawan k');
    $this->db->where('k.status', 'aktif');
    $this->db->where('NOT EXISTS (SELECT 1 FROM user u WHERE u.id_karyawan = k.id_karyawan)', NULL, FALSE);
    return $this->db->get()->result();
  }

  // Create new user
  public function create_user($data)
  {
    // Hash password
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    $data['created_at'] = date('Y-m-d H:i:s');
    return $this->db->insert('user', $data);
  }

  // Update user
  public function update_user($id, $data)
  {
    if (isset($data['password']) && !empty($data['password'])) {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    } else {
      unset($data['password']);
    }

    $this->db->where('id', $id);
    return $this->db->update('user', $data);
  }

  public function update_password($tabel, $where, $data)
  {
    $this->db->where($where);
    $this->db->update($tabel, $data);
  }

  public function select($tabel)
  {
    return $this->db->select()
      ->from($tabel)
      ->get()->result();
  }

  // Delete user (soft delete)
  public function delete_user($id)
  {
    $this->db->where('id', $id);
    return $this->db->update('user', array('is_active' => 0));
  }

  // Check privilege access
  public function check_privilege($user_id, $module, $action)
  {
    $this->db->select('up.*');
    $this->db->from('user u');
    $this->db->join('user_privileges up', 'u.id_privilege = up.id_privilege');
    $this->db->where('u.id_user', $user_id);
    $privilege = $this->db->get()->row();

    if (!$privilege) return false;

    // Check module access
    $module_field = 'module_' . strtolower($module);
    if (!isset($privilege->$module_field) || $privilege->$module_field != 1) {
      return false;
    }

    // Check action permission
    $action_field = 'can_' . strtolower($action);
    if (!isset($privilege->$action_field) || $privilege->$action_field != 1) {
      return false;
    }

    return true;
  }

  // Update last activity
  public function update_last_activity($user_id)
  {
    $this->db->where('id', $user_id);
    $this->db->update('user', array('last_activity' => date('Y-m-d H:i:s')));
  }
}
