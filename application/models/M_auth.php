<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

	public function login($user, $pass) {
		$this->db->select('*');
		$this->db->from('tbl_user');
		//$this->db->join('tbl_opd', 'tbl_opd.id = tbl_user.id_opd');
		$this->db->where('tbl_user.username', $user);
		$this->db->where('tbl_user.password', md5($pass));

		$this->db->join('tbl_wkecamatan', 'tbl_wkecamatan.id_kec = tbl_user.id_kec','left');		

		$data = $this->db->get();

		if ($data->num_rows() == 1) {
			return $data->row();
		} else {
			return false;
		}
	}

	public function logout($date, $id)
    {
        $this->db->where('tbl_user.id', $id);
        $this->db->update('tbl_user', $date);
    }
}

/* End of file M_auth.php */
/* Location: ./application/models/M_auth.php */