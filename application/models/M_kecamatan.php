<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kecamatan extends CI_Model {
	
	public function select_all() {
		$this->db->select('*');
		$this->db->from('tbl_wkecamatan');
		$this->db->order_by('nama_kec', 'asc');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM tbl_wkecamatan WHERE id_kec = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}


	public function insert($data) {
		$sql = "INSERT INTO tbl_wkecamatan VALUES('','" .$data['nama_kecamatan'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('tbl_wkecamatan', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE tbl_wkecamatan SET kecamatan='" .$data['nama_kecamatan'] ."' WHERE id_kec='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM tbl_wkecamatan WHERE id_kec='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama_kec', $nama);
		$data = $this->db->get('tbl_wkecamatan');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tbl_wkecamatan');

		return $data->num_rows();
	}
}

/* End of file M_kecamatan.php */
/* Location: ./application/models/M_kecamatan.php */