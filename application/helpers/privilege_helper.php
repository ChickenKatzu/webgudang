<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('has_access')) {
    function has_access($module, $action)
    {
        $CI = &get_instance();
        $CI->load->model('M_user');

        return $CI->M_user->check_privilege($CI->session->userdata('id'), $module, $action);
    }
}

if (!function_exists('show_if_has_access')) {
    function show_if_has_access($module, $action, $content)
    {
        if (has_access($module, $action)) {
            return $content;
        }
        return '';
    }
}

if (!function_exists('disable_if_no_access')) {
    function disable_if_no_access($module, $action)
    {
        if (!has_access($module, $action)) {
            return 'disabled onclick="return false;"';
        }
        return '';
    }
}
