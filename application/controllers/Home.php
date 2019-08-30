<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_penyelenggara','penyelenggara');
		$this->load->model('M_calon','calon');
		$this->load->model('M_hasil','hasil');
	}

	public function index() {

		$jmlcalon				= $this->calon->select_jml_calon($this->session->userdata('id_kec'));
		$jmlpemilih				= $this->penyelenggara->select_jml_pemilih($this->session->userdata('id_kec'));
		$jmldesa				= $this->penyelenggara->select_jml_desa();

		$data['jmlcalon']		= $jmlcalon;
		$data['jmlpemilih']		= $jmlpemilih;
		$data['jmldesa']		= $jmldesa;
		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Dashboard";
		$data['judul'] 			= "Dashboard";
		$data['deskripsi'] 		= "";
		$this->template->views('home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */