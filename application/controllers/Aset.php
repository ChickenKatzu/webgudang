<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property M_aksesoris $M_aksesoris
 * @property M_admin $M_admin
 * @property M_aset $M_aset
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Aset extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_aksesoris');
        $this->load->model('M_admin');
        $this->load->model('M_aset');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    public function mutasi_aset()
    {
        $data = [
            'kode_aset' => $this->input->post('kode_aset'),
            'dari_lokasi' => $this->input->post('dari_lokasi'),
            'ke_lokasi' => $this->input->post('ke_lokasi'),
            'tanggal_mutasi' => $this->input->post('tanggal_mutasi'),
            'alasan_mutasi' => $this->input->post('alasan_mutasi'),
            'id_karyawan_pemohon' => $this->input->post('id_karyawan_pemohon'),
            'id_karyawan_penanggungjawab' => $this->input->post('id_karyawan_penanggungjawab'),
        ];

        // insert histori mutasi
        $this->M_Aset->insert_mutasi($data);

        // update lokasi aset utama
        $this->M_Aset->update_lokasi($data['kode_aset'], $data['ke_lokasi']);

        redirect('aset/list_mutasi');
    }
}
