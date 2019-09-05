<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_penyelenggara','desapemilihan');
		$this->load->model('M_rekap','rekap');
	}

	public function index() {

		$this->load->helper('url');
		$this->load->helper('form');


		$rekapsatu = $this->rekap->select_detail();
		$data['rekapsatu'] 		= $rekapsatu;

		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Rekapitulasi";
		$data['judul'] 			= "Rekapitulasi";
		$data['deskripsi'] 		= "Rekapitulasi Hasil Pemilihan Kepala Desa";
		
		$this->template->views('rekap/home', $data);
	}

	public function detailkec($kec) {

		$rekapkec = $this->rekap->select_detail_kec($kec);
		$data['rekapkec'] 		= $rekapkec;

		$nama_kec = $this->rekap->getkec_by_kode($kec);
		$data['nama_kec']		= $nama_kec->nama_kec;

		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Rekapitulasi";
		$data['judul'] 			= "Rekapitulasi";
		$data['deskripsi'] 		= "Rekapitulasi Hasil Pemilihan Kepala Desa";

		$this->template->views('rekap/detailkec', $data);
	}

	public function detaildesa($desa) {

		$rekapdesa = $this->rekap->select_detail_desa($desa);
		$data['rekapdesa'] 		= $rekapdesa;

		$nama_desa= $this->rekap->getdesa_by_kode($desa);
		$data['nama_desa']		= $nama_desa->nama_desa;

		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Rekapitulasi";
		$data['judul'] 			= "Rekapitulasi";
		$data['deskripsi'] 		= "Rekapitulasi Hasil Pemilihan Kepala Desa";

		$this->template->views('rekap/detaildesa', $data);
	}

}

/* End of file Rekap.php */
/* Location: ./application/controllers/Rekap.php */