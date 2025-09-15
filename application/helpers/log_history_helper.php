<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('log_history')) {
    function log_history($id_user, $id_referensi, $action_type, $table_name, $description, $old_data = null, $new_data = null)
    {
        $ci = &get_instance();
        $ci->load->model('M_log_history');

        $log_data = array(
            'id_user' => $id_user,
            'action_type' => $action_type,
            'table_name' => $table_name,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        );

        // Set data referensi berdasarkan tabel
        switch ($table_name) {
            case 'tb_aset_masuk':
            case 'tb_aset_keluar':
            case 'mutasi_aset':
                $log_data['kode_aset'] = $id_referensi;
                break;

            case 'tb_aset_aksesoris1':
                $log_data['id_aksesoris'] = $id_referensi;
                break;

            case 'karyawan':
                $log_data['id_karyawan'] = $id_referensi;
                break;

            case 'department':
                $log_data['id_departemen'] = $id_referensi;
                break;
        }

        // Set old_data dan new_data jika ada
        if ($old_data !== null) {
            $log_data['old_data'] = is_array($old_data) ? json_encode($old_data) : $old_data;
        }

        if ($new_data !== null) {
            $log_data['new_data'] = is_array($new_data) ? json_encode($new_data) : $new_data;
        }

        return $ci->M_log_history->insert($log_data);
    }
}

// Helper khusus untuk setiap jenis operasi
if (!function_exists('log_insert')) {
    function log_insert($table_name, $new_data, $description = '', $id_referensi = null)
    {
        $ci = &get_instance();
        $id_user = $ci->session->userdata('id_user') ? $ci->session->userdata('id_user') : 0;

        if (empty($description)) {
            $description = 'Menambah data ' . $table_name;

            // Deskripsi lebih spesifik berdasarkan tabel
            switch ($table_name) {
                case 'tb_aset_masuk':
                    $description = 'Menambah aset: ' . $new_data['nama_barang'] . ' (' . $new_data['kode_aset'] . ')';
                    $id_referensi = $new_data['kode_aset'];
                    break;

                case 'tb_aset_aksesoris1':
                    $description = 'Menambah aksesoris: ' . $new_data['jenis'] . ' - ' . $new_data['merk'];
                    $id_referensi = isset($new_data['id']) ? $new_data['id'] : null;
                    break;

                case 'karyawan':
                    $description = 'Menambah karyawan: ' . $new_data['nama_karyawan'];
                    $id_referensi = isset($new_data['id_karyawan']) ? $new_data['id_karyawan'] : null;
                    break;
            }
        }

        return log_history($id_user, $id_referensi, 'insert', $table_name, $description, null, $new_data);
    }
}

if (!function_exists('log_update')) {
    function log_update($table_name, $old_data, $new_data, $description = '', $id_referensi = null)
    {
        $ci = &get_instance();
        $id_user = $ci->session->userdata('id_user') ? $ci->session->userdata('id_user') : 0;

        if (empty($description)) {
            $description = 'Mengupdate data ' . $table_name;

            // Deskripsi lebih spesifik berdasarkan tabel
            switch ($table_name) {
                case 'tb_aset_masuk':
                    $description = 'Mengupdate aset: ' . $new_data['nama_barang'] . ' (' . $new_data['kode_aset'] . ')';
                    $id_referensi = $new_data['kode_aset'];
                    break;

                case 'tb_aset_aksesoris1':
                    $description = 'Mengupdate aksesoris: ' . $new_data['jenis'] . ' - ' . $new_data['merk'];
                    $id_referensi = isset($new_data['id']) ? $new_data['id'] : null;
                    break;

                case 'karyawan':
                    $description = 'Mengupdate karyawan: ' . $new_data['nama_karyawan'];
                    $id_referensi = isset($new_data['id_karyawan']) ? $new_data['id_karyawan'] : null;
                    break;
            }
        }

        return log_history($id_user, $id_referensi, 'update', $table_name, $description, $old_data, $new_data);
    }
}

if (!function_exists('log_delete')) {
    function log_delete($table_name, $old_data, $description = '', $id_referensi = null)
    {
        $ci = &get_instance();
        $id_user = $ci->session->userdata('id_user') ? $ci->session->userdata('id_user') : 0;

        if (empty($description)) {
            $description = 'Menghapus data ' . $table_name;

            // Deskripsi lebih spesifik berdasarkan tabel
            switch ($table_name) {
                case 'tb_aset_masuk':
                    $description = 'Menghapus aset: ' . $old_data['nama_barang'] . ' (' . $old_data['kode_aset'] . ')';
                    $id_referensi = $old_data['kode_aset'];
                    break;

                case 'tb_aset_aksesoris1':
                    $description = 'Menghapus aksesoris: ' . $old_data['jenis'] . ' - ' . $old_data['merk'];
                    $id_referensi = isset($old_data['id']) ? $old_data['id'] : null;
                    break;

                case 'karyawan':
                    $description = 'Menghapus karyawan: ' . $old_data['nama_karyawan'];
                    $id_referensi = isset($old_data['id_karyawan']) ? $old_data['id_karyawan'] : null;
                    break;
            }
        }

        return log_history($id_user, $id_referensi, 'delete', $table_name, $description, $old_data, null);
    }
}

if (!function_exists('log_pinjam')) {
    function log_pinjam($kode_aset, $id_karyawan, $description = '')
    {
        $ci = &get_instance();
        $id_user = $ci->session->userdata('id_user') ? $ci->session->userdata('id_user') : 0;

        if (empty($description)) {
            $description = 'Meminjam aset: ' . $kode_aset;
        }

        return log_history($id_user, $kode_aset, 'pinjam', 'tb_aset_keluar', $description, null, array(
            'kode_aset' => $kode_aset,
            'id_karyawan' => $id_karyawan
        ));
    }
}

if (!function_exists('log_kembali')) {
    function log_kembali($kode_aset, $description = '')
    {
        $ci = &get_instance();
        $id_user = $ci->session->userdata('id_user') ? $ci->session->userdata('id_user') : 0;

        if (empty($description)) {
            $description = 'Mengembalikan aset: ' . $kode_aset;
        }

        return log_history($id_user, $kode_aset, 'kembali', 'tb_aset_keluar', $description);
    }
}

if (!function_exists('log_mutasi')) {
    function log_mutasi($kode_aset, $dari_lokasi, $ke_lokasi, $description = '')
    {
        $ci = &get_instance();
        $id_user = $ci->session->userdata('id_user') ? $ci->session->userdata('id_user') : 0;

        if (empty($description)) {
            $description = 'Memutasikan aset ' . $kode_aset . ' dari ' . $dari_lokasi . ' ke ' . $ke_lokasi;
        }

        return log_history($id_user, $kode_aset, 'mutasi', 'mutasi_aset', $description, null, array(
            'kode_aset' => $kode_aset,
            'dari_lokasi' => $dari_lokasi,
            'ke_lokasi' => $ke_lokasi
        ));
    }
}

if (!function_exists('log_login')) {
    function log_login($user_id, $username)
    {
        return log_history($user_id, $user_id, 'login', 'user', 'User login: ' . $username);
    }
}

if (!function_exists('log_logout')) {
    function log_logout($user_id, $username)
    {
        return log_history($user_id, $user_id, 'logout', 'user', 'User logout: ' . $username);
    }
}
