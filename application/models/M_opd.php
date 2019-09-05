<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_opd extends CI_Model {

	public function select_all() {
		$this->db->select('*');
		$this->db->from('tbl_pekerjaan');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM tbl_pekerjaan WHERE id = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}


	public function insert($data) {
		$sql = "INSERT INTO tbl_opd VALUES('','" .$data['nama_instansi'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('kota', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE kota SET nama='" .$data['kota'] ."' WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM tbl_opd WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('id_opd', $nama);
		$data = $this->db->get('tbl_opd');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tbl_opd');

		return $data->num_rows();
	}
}

/* End of file M_opd.php */
/* Location: ./application/models/M_opd.php */