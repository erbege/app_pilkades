<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_hasil','hasil');
		$this->load->model('M_calon','calon');
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

			$row[] = $hasil->nama_desa;
			$row[] = number_format($hasil->dpt_jml);
			$row[] = number_format($hasil->sssah);
			$row[] = number_format($hasil->sstdksah);
			$row[] = number_format($hasil->sstidakterpakai);
			$row[] = number_format($hasil->sssah+$hasil->sstdksah+$hasil->sstidakterpakai);
			if (($hasil->sssah+$hasil->sstdksah+$hasil->sstidakterpakai > 0) && ($hasil->dpt_jml > 0)) {
				$row[] = number_format((($hasil->sssah+$hasil->sstdksah) / $hasil->dpt_jml) * 100,2);
			} else {
				$row[] = '<span class="text-danger">N/A</span>';
			}

			if ($this->session->userdata('id_role') == '3') {
				if (getStatusTransaksi('Input Hasil Pemilihan')) {

					$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';	  
				} else {
					$row[] = 'N/A';
				}
		    } else {
		    	$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';
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

	public function ajax_edit_calon($desa)
	{
		$data = $this->calon->select_by_desa($id);

		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'suratsuara' => $this->input->post('suratsuara'),
				'sssah' => $this->input->post('sssah'),
				'sstdksah' => $this->input->post('sstdksah'),
				'sstidakterpakai' => $this->input->post('sstidakterpakai'),

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

		if(($this->input->post('suratsuara') == '') || ($this->input->post('suratsuara') == 0))
		{
			$data['inputerror'][] = 'suratsuara';
			$data['error_string'][] = 'Surat suara tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if(($this->input->post('sssah') == '') || ($this->input->post('sssah') == 0))
		{
			$data['inputerror'][] = 'sssah';
			$data['error_string'][] = 'Suara sah tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if ($this->input->post('suratsuara') < ($this->input->post('sssah')+$this->input->post('sstdksah')))
		{
			$data['inputerror'][] = 'sstidakterpakai';
			$data['error_string'][] = 'Jumlah tidak valid';
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

	function load_data($kdds)
	{
		$data = $this->calon->load_data($kdds);
		echo json_encode($data);
	}

	function update_hasil()
	{
		$data = array(
		$this->input->post('table_column') => $this->input->post('value')
		);
		$this->calon->update_hasil($data, $this->input->post('id'));
	}
}

/* End of file Hasil.php */
/* Location: ./application/controllers/Hasil.php */