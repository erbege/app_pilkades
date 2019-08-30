<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pekerjaan extends CI_Model {

	public function select_all() {
		$this->db->select('*');
		$this->db->from('tbl_pekerjaan');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM tbl_pekerjaan WHERE id_pekerjaan = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}


	public function insert($data) {
		$sql = "INSERT INTO tbl_pekerjaan VALUES('','" .$data['nama_pekerjaan'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('tbl_pekerjaan', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE tbl_pekerjaan SET nama_pekerjaan='" .$data['nama_pekerjaan'] ."' WHERE id_pekerjaan='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM tbl_pekerjaan WHERE id_pekerjaan='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama_pekerjaan', $nama);
		$data = $this->db->get('tbl_pekerjaan');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tbl_pekerjaan');

		return $data->num_rows();
	}
}

/* End of file M_pekerjaan.php */
/* Location: ./application/models/M_pekerjaan.php */