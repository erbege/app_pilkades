<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_terpilih extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function select_all($kecamatan = '') {
		$this->db->select('*');
		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('kdkec', $this->session->userdata('id_kec'));
		} 
		//$this->db->like('tbl_laporan_pivot.nama_kec', $this->input->post('nama_kec'));
		$this->db->like('tbl_calon_terpilih.nama_kec', $kecamatan);
		$this->db->where('tbl_calon_terpilih.thn_pemilihan',$this->session->userdata('thn_data'));
		$this->db->from('tbl_calon_terpilih');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_kec($kec) {
		$this->db->select('*');
		$this->db->where('tbl_calon_terpilih.nama_kec', $kec);
		$this->db->where('tbl_calon_terpilih.thn_pemilihan',$this->session->userdata('thn_data'));
		$this->db->from('tbl_calon_terpilih');
		//$this->db->order_by('kddesa', 'asc');

		$data = $this->db->get();

		return $data->result();
	}
}

/* End of file M_laporan.php */
/* Location: ./application/models/M_laporan.php */