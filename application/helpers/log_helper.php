<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('log_history')) {
    function log_history($action_type, $table_name, $description, $kode_aset = null, $id_aksesoris = null, $old_data = null, $new_data = null)
    {
        $CI = &get_instance();
        $CI->load->model('M_log_history');

        $log_data = array(
            'kode_aset' => $kode_aset,
            'id_aksesoris' => $id_aksesoris,
            'id_user' => $CI->session->userdata('id') ? $CI->session->userdata('id') : 0,
            'id_karyawan' => $CI->session->userdata('id_karyawan') ? $CI->session->userdata('id_karyawan') : null,
            'action_type' => $action_type,
            'table_name' => $table_name,
            'description' => $description,
            'old_data' => $old_data ? json_encode($old_data) : null,
            'new_data' => $new_data ? json_encode($new_data) : null
        );

        $CI->M_log_history->save_log($log_data);
    }
}

if (!function_exists('log_login')) {
    function log_login($username, $status)
    {
        log_history('login', 'user', $status . ' login attempt by ' . $username);
    }
}

if (!function_exists('log_aset_masuk')) {
    function log_aset_masuk($action, $kode_aset, $data)
    {
        $description = $action . ' aset masuk: ' . $kode_aset;
        log_history($action, 'tb_aset_masuk', $description, $kode_aset, null, null, $data);
    }
}

if (!function_exists('log_aksesoris')) {
    function log_aksesoris($action, $kode, $data)
    {
        $description = $action . ' aksesoris: ' . $kode;
        log_history($action, 'tb_aset_aksesoris1', $description, null, null, null, $data);
    }
}
