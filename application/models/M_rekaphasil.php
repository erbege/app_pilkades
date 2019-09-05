<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekaphasil extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function select_all() {
		$this->db->select('*');
		if ($this->session->userdata('id_role') == '3') {
			$this->db->like('kdkec', $this->session->userdata('id_kec'));
		}
		$this->db->where('tbl_calon_hasil_pivot.thn_pemilihan',$this->session->userdata('thn_data'));
		$this->db->from('tbl_calon_hasil_pivot');

		$data = $this->db->get();

		return $data->result();
	}

}

/* End of file M_rekaphasil.php */
/* Location: ./application/models/M_rekaphasil.php */