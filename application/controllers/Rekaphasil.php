<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaphasil extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_rekaphasil','rekaphasil');
	}

	public function index() {

		$this->load->helper('url');
		$this->load->helper('form');


		$rekapsatu = $this->rekaphasil->select_all();
		$data['rekapsatu'] 		= $rekapsatu;

		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Rekap Hasil";
		$data['judul'] 			= "Rekapitulasi";
		$data['deskripsi'] 		= "Rekapitulasi Hasil Pemilihan Kepala Desa";
		
		$this->template->views('rekaphasil/home', $data);
	}

	
}

/* End of file Rekaphasil.php */
/* Location: ./application/controllers/Rekaphasil.php */