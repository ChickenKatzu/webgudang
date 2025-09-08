<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_karyawan $M_log_history
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Pagination $pagination
 */
class Log_history extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->model('M_log_history');
        // Pastikan hanya admin yang bisa mengakses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 1) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Log History System';

        // Pagination setup
        $this->load->library('pagination');
        $config['base_url'] = site_url('log_history/index');
        $config['total_rows'] = $this->M_log_history->get_total_logs();
        $config['per_page'] = 50;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['logs'] = $this->M_log_history->get_all_logs($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('header', $data);
        $this->load->view('log_history_view', $data);
        $this->load->view('footer');
    }

    public function filter()
    {
        $data['title'] = 'Filter Log History';

        $action_type = $this->input->get('action_type');
        $kode_aset = $this->input->get('kode_aset');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Pagination setup
        $this->load->library('pagination');
        $config['base_url'] = site_url('log_history/filter');
        $config['per_page'] = 50;
        $config['uri_segment'] = 3;

        if (!empty($action_type)) {
            $data['logs'] = $this->M_log_history->get_logs_by_action($action_type, $config['per_page'], $this->uri->segment(3));
            $config['total_rows'] = $this->db->where('action_type', $action_type)->count_all_results('log_history');
        } elseif (!empty($kode_aset)) {
            $data['logs'] = $this->M_log_history->get_logs_by_aset($kode_aset, $config['per_page'], $this->uri->segment(3));
            $config['total_rows'] = $this->db->where('kode_aset', $kode_aset)->count_all_results('log_history');
        } elseif (!empty($start_date) && !empty($end_date)) {
            $data['logs'] = $this->M_log_history->get_logs_by_date($start_date, $end_date, $config['per_page'], $this->uri->segment(3));
            $this->db->where('DATE(created_at) >=', $start_date);
            $this->db->where('DATE(created_at) <=', $end_date);
            $config['total_rows'] = $this->db->count_all_results('log_history');
        } else {
            redirect('log_history');
        }

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter_params'] = array(
            'action_type' => $action_type,
            'kode_aset' => $kode_aset,
            'start_date' => $start_date,
            'end_date' => $end_date
        );

        $this->load->view('header', $data);
        $this->load->view('log_history_view', $data);
        $this->load->view('footer');
    }

    public function export()
    {
        // Export log history to CSV or Excel
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');

        $query = $this->db->query("
            SELECT lh.*, u.username, k.nama_karyawan 
            FROM log_history lh 
            LEFT JOIN user u ON lh.id_user = u.id_user 
            LEFT JOIN karyawan k ON lh.id_karyawan = k.id_karyawan 
            ORDER BY lh.created_at DESC
        ");

        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';

        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

        force_download('log_history_' . date('Y-m-d') . '.csv', $data);
    }
}
