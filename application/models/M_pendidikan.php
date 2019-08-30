<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendidikan extends CI_Model {

	public function select_all() {
		$this->db->select('*');
		$this->db->from('tbl_pendidikan');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM tbl_pendidikan WHERE id_pendidikan = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}


	public function insert($data) {
		$sql = "INSERT INTO tbl_pendidikan VALUES('','" .$data['nama_pendidikan'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('tbl_pendidikan', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE tbl_pendidikan SET nama_pendidikan='" .$data['nama_pendidikan'] ."' WHERE id_pendidikan='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM tbl_pendidikan WHERE id_pendidikan='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama_pendidikan', $nama);
		$data = $this->db->get('tbl_pendidikan');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tbl_pendidikan');

		return $data->num_rows();
	}
}

/* End of file M_pendidikan.php */
/* Location: ./application/models/M_pendidikan.php */