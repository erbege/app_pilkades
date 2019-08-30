<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengguna extends CI_Model {

	public function select_all_pengguna() {
		$sql = "SELECT * FROM tbl_user 
			LEFT JOIN tbl_opd ON tbl_user.id_opd = tbl_opd.id_opd";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT tbl_user.id as id, tbl_user.first_name as first_name,tbl_user.last_name as last_name,tbl_user.phone as phone,
			tbl_user.username as username,tbl_user.email as email,tbl_user.id_opd as id_opd,tbl_wkecamatan.nama_kec as nama_instansi,
			tbl_user.created_on as created_on,tbl_user.last_login as last_login,tbl_user.active as active, tbl_user.id_role as id_role, tbl_role.name as nama_role, tbl_user.id_kec as id_kec 
			FROM tbl_user 
			LEFT JOIN tbl_wkecamatan ON tbl_user.id_kec = tbl_wkecamatan.id_kec
			LEFT JOIN tbl_role ON tbl_user.id_role = tbl_role.id";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT tbl_user.id as id, tbl_user.first_name as first_name,tbl_user.last_name as last_name,tbl_user.phone as phone,
			tbl_user.username as username,tbl_user.email as email,tbl_user.id_opd as id_opd,tbl_opd.nama_instansi as nama_instansi,
			tbl_user.created_on as created_on,tbl_user.last_login as last_login,tbl_user.active as active, tbl_user.id_role as id_role, tbl_user.id_kec as id_kec 
			FROM tbl_user 
			LEFT JOIN tbl_opd ON tbl_user.id_opd = tbl_opd.id_opd
			WHERE tbl_user.id ='{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function update2($data) {
		$sql = "UPDATE tbl_user SET username='" .$data['username'] ."', phone='" .$data['phone'] ."', id_kota=" .$data['kota'] .", id_kelamin=" .$data['jk'] .", id_posisi=" .$data['posisi'] ." WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function update($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_user', $data);

        return $this->db->affected_rows();
    }

	public function delete($id) {
		$sql = "DELETE FROM tbl_user WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert2($data) {
		$id = md5(DATE('ymdhms').rand());
		$sql = "INSERT INTO tbl_user VALUES('',
											'" .$data['id_role'] ."',
											'" .$data['username'] ."',
											'" .$data['password'] ."',
											'" .$data['first_name'] ."',
											'" .$data['last_name'] ."',
											'" .$data['email'] ."',
											'" .$data['phone'] ."',
											'',
											'',
											'',
											'',
											'',
											'1',
											'" .$data['id_opd'] ."'
											)";


		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert($data)
    {
        $this->db->insert('tbl_user', $data);
        return $this->db->affected_rows();
    }

	public function insert_batch($data) {
		$this->db->insert_batch('tbl_user', $data);
		
		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('username', $nama);
		$data = $this->db->get('username');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tbl_user');

		return $data->num_rows();
	}
}

/* End of file M_pegawai.php */
/* Location: ./application/models/M_pegawai.php */