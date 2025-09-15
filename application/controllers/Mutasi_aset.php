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
class Mutasi_aset extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_aksesoris');
        $this->load->model('M_admin');
        $this->load->model('M_aset');
        $this->load->model('M_gudang');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }
}
