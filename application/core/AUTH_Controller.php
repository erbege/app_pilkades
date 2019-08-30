<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AUTH_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_admin');

		$this->userdata = $this->session->userdata('userdata');
		
		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));

		if ($this->session->userdata('status') == '') {
			redirect('Auth');
		}
	}

	public function updateProfil() {
		if ($this->session->userdata() != '') {
			$data = $this->M_admin->select($this->session->userdata('id'));

			//$this->session->set_userdata('userdata', $data);
			//$this->userdata = $this->session->userdata('userdata');
			$userdata = array(
					'is_login'    => true,
					'id'          => $data->id,
					'password'    => $data->password,
					'id_role'     => $data->id_role,
					'username'    => $data->username,
					'first_name'  => $data->first_name,
					'last_name'   => $data->last_name,
					'email'       => $data->email,
					'phone'       => $data->phone,
					'photo'       => $data->photo,
					'created_on'  => $data->created_on,
					'last_login'  => $data->last_login,
					'id_opd'  => $data->id_opd,
					'nama_instansi'=> $data->nama_instansi,
					'status' => "Loged in",
					'thn_pkpt' => $thn_pkpt,
					'idnya' => $data->id
            	);
			//$this->session->unset_userdata();
			$this->session->set_userdata($userdata);
			//$this->userdata = $this->session->userdata($userdata);
		}
	}
}

/* End of file MY_Auth.php */
/* Location: ./application/core/MY_Auth.php */