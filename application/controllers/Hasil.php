<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_hasil','hasil');
		$this->load->model('M_desa','desa');
		$this->load->model('M_penyelenggara','desapemilihan');
	}

	public function index() {

		$this->load->helper('url');
		$this->load->helper('form');

		$kecamatans = $this->desapemilihan->get_list_kec();

		$opt = array('' => '');
		foreach ($kecamatans as $kec) {
			$opt[$kec] = $kec;
		}

		$data['form_kec'] 		= form_dropdown('',$opt,'','id="nama_kec" class="form-control"');


		$data['kecamatan'] 		= $this->desapemilihan->getKec();
		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Hasil Pemilihan";
		$data['judul'] 			= "Hasil Pemilihan";
		$data['deskripsi'] 		= "Data hasil pemilihan kepala desa";
		$this->template->views('hasil/home', $data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->hasil->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $hasil) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $hasil->nama;
			$row[] = $hasil->nama_desa.',<br /> '.$hasil->nama_kec;
			$row[] = $hasil->s_hasil;

			if (getStatusTransaksi('Input Hasil Pemilihan')) {

				$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';	  
			} else {
				$row[] = 'N/A';
			}
		    
	  		
			$data[] = $row;

		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->hasil->count_all(),
						"recordsFiltered" => $this->hasil->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->hasil->get_by_id($id);

		echo json_encode($data);
	}

	public function ajax_update()
	{
		//$this->_validate();
		$data = array(
				's_hasil' => $this->input->post('s_hasil'),
			);

		$this->hasil->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kddesa') == '')
		{
			$data['inputerror'][] = 'kddesa';
			$data['error_string'][] = 'Nama desa tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('tmp_lahir') == '')
		{
			$data['inputerror'][] = 'tmp_lahir';
			$data['error_string'][] = 'Tempat Lahir tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('tgl_lahir') == '')
		{
			$data['inputerror'][] = 'tgl_lahir';
			$data['error_string'][] = 'Tanggal Lahir tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('kelamin') == '')
		{
			$data['inputerror'][] = 'kelamin';
			$data['error_string'][] = 'Pilih kelamin';
			$data['status'] = FALSE;
		}


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->hasil->select_by_kategori();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "NO");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "KECAMATAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "DESA");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "NAMA CALON");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "JUMLAH SUARA");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "JUMLAH PEMILIH");
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "PERSENTASE");
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "JUMLAH SURAT SUARA");
		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_kec); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama_desa); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->nama); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->s_hasil); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->dpt_l+$value->dpt_p); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->s_hasil/($value->dpt_l+$value->dpt_p)*100);
		    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->suratsuara); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/DtHasil'.$this->session->userdata('id_kec').'.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/DtHasil'.$this->session->userdata('id_kec').'.xlsx', NULL);
	}

	public function add_ajax_desa($id_kc)
	{
	    //$query = $this->db->get_where('tbl_desa_penyelenggara',array('kdkec'=>$id_kc));
	    
		$query1 = $this->db->select('*')->from('tbl_desa_penyelenggara')->join('tbl_wdesa', 'tbl_wdesa.id_desa=tbl_desa_penyelenggara.kddesa')->where($where)->get();
		$query = $this->db->get('tbl_desa_penyelenggara');

	    $data = "<option value=''>- Pilih Desa -</option>";
	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->kddesa."'>".$value->kddesa."</option>";
	    }
	    echo $data;
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */