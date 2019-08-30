<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		//$this->load->model('M_pegawai');
		//$this->load->model('M_posisi');
		//$this->load->model('M_kota');
	}

	public function index() {

		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Data Pokok";
		$data['judul'] 			= "Data Pokok";
		$data['deskripsi'] 		= "";
		$this->template->views('galat/home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */