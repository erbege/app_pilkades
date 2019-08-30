<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_desa extends CI_Model {

	public function select_all() {
		$this->db->select('*');
		$this->db->from('tbl_wdesa');
		$this->db->order_by('nama_desa', 'asc');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_kec() {
		if ($this->session->userdata('id_role') == 3){
			$this->db->select('*');
			$this->db->from('tbl_wdesa');
			$this->db->like('kecamatan_id', $this->session->userdata('id_kec'));
			$this->db->order_by('nama_desa', 'asc');
		} else {
			$this->db->select('*');
			$this->db->from('tbl_wdesa');
			$this->db->order_by('nama_desa', 'asc');
		}

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM tbl_wdesa WHERE id_desa = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}


	public function insert($data) {
		$sql = "INSERT INTO tbl_wdesa VALUES('','" .$data['nama_desa'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('tbl_wdesa', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE tbl_wdesa SET nama_desa='" .$data['nama_desa'] ."' WHERE id_desa='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM tbl_wdesa WHERE id_desa='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama_desa', $nama);
		$data = $this->db->get('tbl_wdesa');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tbl_wdesa');

		return $data->num_rows();
	}
}

/* End of file M_desa.php */
/* Location: ./application/models/M_desa.php */