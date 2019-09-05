<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyelenggara extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_penyelenggara','desapemilihan');
		$this->load->model('M_desa','desa');
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
		$data['dataDesanya']   	= $this->desa->select_by_kec();
		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Data Pokok";
		$data['judul'] 			= "Data Pokok";
		$data['deskripsi'] 		= "Daftar desa penyelenggara pilkades serentak";
		$this->template->views('penyelenggara/home', $data);
	}

	public function ajax_list()
	{
		$list = $this->desapemilihan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $desapem) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $desapem->nama_kec;
			$row[] = $desapem->nama_desa;
			$row[] = $desapem->dpt_l;
			$row[] = $desapem->dpt_p;
			$row[] = $desapem->dpt_l+$desapem->dpt_p;
			$row[] = $desapem->suratsuara;

			//add html for action
			if ($this->session->userdata('id_role') == '3') {
				if (getStatusTransaksi('Pengelolaan Data Pokok/DPT')) {

					$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_desa('."'".$desapem->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_desa('."'".$desapem->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
				} else {
					$row[] = 'N/A';
				}
			} else {
				$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_desa('."'".$desapem->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_desa('."'".$desapem->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->desapemilihan->count_all(),
						"recordsFiltered" => $this->desapemilihan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->desapemilihan->get_by_id($id);

		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'kdkab' => $this->input->post('kdkab'),
				'kdkec' => $this->input->post('kdkec'),
				'kddesa' => $this->input->post('kddesa'),
				'thn_pemilihan' => $this->session->userdata('thn_data'),
				'dpt_l' => $this->input->post('dpt_l'),
				'dpt_p' => $this->input->post('dpt_p'),
				'dpt_jml' => $this->input->post('dpt_jml'),
				'suratsuara' => $this->input->post('suratsuara'),
				'ketua' => $this->input->post('ketua'),
			);

		$insert = $this->desapemilihan->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'kdkab' => $this->input->post('kdkab'),
				'kdkec' => $this->input->post('kdkec'),
				'kddesa' => $this->input->post('kddesa'),
				'dpt_l' => $this->input->post('dpt_l'),
				'dpt_p' => $this->input->post('dpt_p'),
				'dpt_jml' => $this->input->post('dpt_jml'),
				'suratsuara' => $this->input->post('suratsuara'),
				'ketua' => $this->input->post('ketua'),
			);

		$this->desapemilihan->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		$person = $this->desapemilihan->get_by_id($id);
		
		$this->desapemilihan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kdkec') == '')
		{
			$data['inputerror'][] = 'kdkec';
			$data['error_string'][] = 'Kolom Kecamatan tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('kddesa') == '')
		{
			$data['inputerror'][] = 'kddesa';
			$data['error_string'][] = 'Kolom Desa tidak boleh kosong';
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

		$data = $this->desapemilihan->select_by_kategori();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "NO");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "KECAMATAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "DESA");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "PEMILIH LAKI-LAKI");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "PEMILIH PEREMPUAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "JUMLAH PEMILIH");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "JUMLAH SURAT SUARA");
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "KETUA PANITIA");
		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-1); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_kec); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama_desa); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->dpt_l); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->dpt_p); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->dpt_l+$value->dpt_p); 
		    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
		    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->suratsuara); 
		    $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->ketua); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/DtPokok'.$this->session->userdata('id_kec').'.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/DtPokok'.$this->session->userdata('id_kec').'.xlsx', NULL);
	}

	function xadd_ajax_des($id_kec){
	    //$query = $this->db->get_where('tbl_wdesa',array('kecamatan_id'=>$id_kec));
	    $query = $this->db->get_where('tbl_wdesa',array('kecamatan_id'=>$id_kec));
	    //$data = "<option value=''> - Pilih Desa - </option>";
	    
	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->id_desa."'>".$value->nama_desa."</option>";
	    }
	    echo $data;
	}

	function add_ajax_des($id_kec){

	    $this->db->select('*');
		$this->db->from('tbl_wdesa');
		$this->db->like('kecamatan_id',$id_kec);
		$query=$this->db->get();

	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->id_desa."'>".$value->nama_desa."</option>";
	    }
	    echo $data;
	}

	
}

/* End of file Penyelenggara.php */
/* Location: ./application/controllers/Penyelenggara.php */