<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahapan extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_transaksi','tahapan');
	}

	public function index() {

		$data['transaksi']		= $this->tahapan->select_all();
		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Tahapan";
		$data['judul'] 			= "Tahapan";
		$data['deskripsi'] 		= "ON/OFF Tahapan Entri Data";
		$this->template->views('tahapan/home', $data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->tahapan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $hasil) {
			$row = array();
			$row[] = $hasil->tahap;
			//$row[] = $hasil->stat;
			if ($hasil->stat == '1') {
				$row[] = '<i class="fa  fa-toggle-on text-success"></i>';
			} else {
				$row[] = '<i class="fa  fa-toggle-off text-danger"></i>';
			}
			$row[] = $hasil->tgl_awal;
			$row[] = $hasil->tgl_akhir;

			$row[] = '<a class="btn btn-xs btn-success" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';	  
		    
			$data[] = $row;

		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tahapan->count_all(),
						"recordsFiltered" => $this->tahapan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->tahapan->get_by_id($id);

		echo json_encode($data);
	}

	public function ajax_update()
	{
		//$this->_validate();
		$data = array(
				'stat' => $this->input->post('stat'),
				'tgl_awal' => $this->input->post('tgl_awal'),
				'tgl_akhir' => $this->input->post('tgl_akhir'),
				'ket' => $this->input->post('ket'),
			);

		$this->tahapan->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('tgl_awal') == '')
		{
			$data['inputerror'][] = 'tgl_awal';
			$data['error_string'][] = 'Tanggal awal tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('tgl_akhir') == '')
		{
			$data['inputerror'][] = 'tgl_akhir';
			$data['error_string'][] = 'Tanggal akhir tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}

/* End of file Tahapan.php */
/* Location: ./application/controllers/Tahapan.php */