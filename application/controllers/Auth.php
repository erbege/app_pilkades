<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_auth');
	}
	
	public function index() {
		$session = $this->session->userdata('status');

		if ($session == '') {
			$this->load->view('login');
		} else {
			redirect('Home');
		}

	}

	public function login() {
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[25]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('tahundata', 'Tahun Data', 'required');

		if ($this->form_validation->run() == TRUE) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$tahunnya = trim($_POST['tahundata']);

			$data = $this->M_auth->login($username, $password);

			if ($data == false) {
				$this->session->set_flashdata('error_msg', '<b style="font-size: 20px">GALAT</b><br>Username / Password Anda Salah.');
				//$this->session->set_flashdata('error_msg', show_err_msg('<b style="font-size: 20px">GAGAL</b><br>Username / Password Anda Salah.'));

				redirect('Auth');
			} else {

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
					'id_opd'  	  => $data->id_opd,
					'id_kab'  	  => $data->id_kab,
					'id_kec'  	  => $data->id_kec,
					'nama_kec'	  => $data->nama_kec,
					'thn_data' 	  => $tahunnya,
					'status'  	  => "Loged in",
					'idnya' 	  => $data->id
            	);
				$this->session->set_userdata($userdata);

				$this->session->set_flashdata('msg', show_succ_msg('<b style="font-size: 20px">Selamat datang '.$data->first_name.' '.$data->last_name.'......</b>'));

				redirect('Home');
			}
		} else {
			$this->session->set_flashdata('error_msg', validation_errors());
			redirect('Auth');
		}
	}

	public function logout() {
		// update last login
		date_default_timezone_set("ASIA/JAKARTA");
		$date = array('last_login' => date('Y-m-d H:i:s'));
		$id = $this->session->userdata('idnya');
        $this->M_auth->logout($date, $id);
		 // destroy session
		$this->session->sess_destroy();
		redirect('Auth');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */