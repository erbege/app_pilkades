<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calon extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_calon','calon');
		$this->load->model('M_pekerjaan','pekerjaan');
		$this->load->model('M_pendidikan','pendidikan');
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
		
		$data['page'] 			= "calon";
		$data['judul'] 			= "Daftar Calon";
		$data['deskripsi'] 		= "Data Calon Kepala Desa Tahun ".$this->session->userdata('thn_data');
		$data['dataPekerjaan'] 	= $this->pekerjaan->select_all();
		$data['dataPendidikan'] = $this->pendidikan->select_all();
		//$data['dataDesanya']   	= $this->desa->select_all();

		//$data['modal_tambah_posisi'] = show_my_modal('modals/modal_tambah_posisi', 'tambah-posisi', $data);

		$this->template->views('calon/home', $data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->calon->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $calon) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $calon->nama;
			$row[] = $calon->tmp_lahir.',<br /> '.$calon->tgl_lahir;
			$row[] = $calon->agama;
			$row[] = $calon->kelamin;
			$row[] = $calon->nama_pendidikan;
			$row[] = $calon->nama_pekerjaan;
			$row[] = $calon->nama_desa.',<br /> '.$calon->nama_kec;
			if($calon->photo)
				$row[] = '<a href="'.base_url('upload/'.$calon->photo).'" target="_blank"><img src="'.base_url('upload/'.$calon->photo).'" class="profile-user-img img-responsive" /></a>';
			else
				$row[] = '(No photo)';

			//add html for action
			/*
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			*/
			if (getStatusTransaksi('Pengelolaan Data Calon Kepala Desa')) {
				$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Lihat" onclick="view_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-search"></i></a>';
			} else {
				$row[] = '
				  <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Lihat" onclick="view_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-search"></i></a>';	  
			
			}
		    
	  		
			$data[] = $row;

		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->calon->count_all(),
						"recordsFiltered" => $this->calon->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->calon->get_by_id($id);
		$data->tgl_lahir = ($data->tgl_lahir == '0000-00-00') ? '' : $data->tgl_lahir; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'nourut' => $this->input->post('nourut'),
				'nama' => $this->input->post('nama'),
				'nik' => $this->input->post('nik'),
				'tmp_lahir' => $this->input->post('tmp_lahir'),
				'tgl_lahir' => $this->input->post('tgl_lahir'),
				'kelamin' => $this->input->post('kelamin'),
				'agama' => $this->input->post('agama'),
				'alamat1' => $this->input->post('alamat1'),
				'id_pendidikan' => $this->input->post('id_pendidikan'),
				'id_pekerjaan' => $this->input->post('id_pekerjaan'),
				'organisasi' => $this->input->post('organisasi'),
				'keterangan' => $this->input->post('keterangan'),
				'kdkab' => '3210',
				'kdkec' => $this->input->post('kdkec'),
				'kddesa' => $this->input->post('kddesa'),
				'thn_pemilihan' => $this->input->post('thn_pemilihan'),
			);

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->_do_upload();
			$data['photo'] = $upload;
		}

		$insert = $this->calon->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nourut' => $this->input->post('nourut'),
				'nama' => $this->input->post('nama'),
				'nik' => $this->input->post('nik'),
				'tmp_lahir' => $this->input->post('tmp_lahir'),
				'tgl_lahir' => $this->input->post('tgl_lahir'),
				'kelamin' => $this->input->post('kelamin'),
				'agama' => $this->input->post('agama'),
				'alamat1' => $this->input->post('alamat1'),
				'id_pendidikan' => $this->input->post('id_pendidikan'),
				'id_pekerjaan' => $this->input->post('id_pekerjaan'),
				'organisasi' => $this->input->post('organisasi'),
				'keterangan' => $this->input->post('keterangan'),
				'kdkab' => '3210',
				'kdkec' => $this->input->post('kdkec'),
				'kddesa' => $this->input->post('kddesa'),
				'thn_pemilihan' => $this->input->post('thn_pemilihan'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('upload/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('upload/'.$this->input->post('remove_photo'));
			$data['photo'] = '';
		}

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$calon = $this->calon->get_by_id($this->input->post('id'));
			if(file_exists('upload/'.$calon->photo) && $calon->photo)
				unlink('upload/'.$calon->photo);

			$data['photo'] = $upload;
		}

		$this->calon->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		$calon = $this->calon->get_by_id($id);
		if(file_exists('upload/'.$calon->photo) && $calon->photo)
			unlink('upload/'.$calon->photo);
		
		$this->calon->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$nmft2 = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
		$nmft1 = 'photo';
		$nmft1 = $this->input->post('nama');

		$config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048; //set max size allowed in Kilobyte
        //$config['max_width']            = 1000; // set max width image allowed
        //$config['max_height']           = 1000; // set max height allowed
        //$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $config['file_name']            = strtoupper($nmft1).'-'.$nmft2;

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
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

		$data = $this->calon->select_by_kec();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "NO");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "KECAMATAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "DESA");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "NAMA");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "NO URUT");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "TEMPAT/TGL LAHIR");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "L/P");
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "AGAMA");
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "PENDIDIKAN TERAKHIR");
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "PEKERJAAN");

		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-1); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_kec); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama_desa); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->nama); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->nourut); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->tmp_lahir.'/'.$value->tgl_lahir); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->kelamin); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->agama); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->nama_pendidikan); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value->nama_pekerjaan); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/DataCalon'.$this->session->userdata('id_kec').'.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/DataCalon'.$this->session->userdata('id_kec').'.xlsx', NULL);
	}

	public function add_ajax_desaasas($id_kc)
	{
	    //$query = $this->db->get_where('tbl_desa_penyelenggara',array('kdkec'=>$id_kc));
	     
		$query = $this->db->select('*')->from('tbl_desa_penyelenggara')->join('tbl_wdesa', 'tbl_wdesa.id_desa=tbl_desa_penyelenggara.kddesa')->where('tbl_desa_penyelenggara',array('kdkec'=>$id_kc))->get();
		$query1 = $this->db->get('tbl_desa_penyelenggara');

	    $data = "<option value=''>- Pilih Desa -</option>";
	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->kddesa."'>".$value->kddesa."</option>";
	    }
	    echo $data;
	}

	public function add_ajax_desasss($id_kc) {
			$sql = "SELECT * FROM tbl_desa_penyelenggara AS a 
			]LEFT JOIN tbl_wkecamatan AS b ON b.id_kec = a.kdkec 
			LEFT JOIN tbl_wdesa AS c ON c.id_desa = a.kddesa 
			WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' 
			AND tbl_desa_penyelenggara.kdkec = '". $id_kc."' ";

		$query = $this->db->query($sql);

		$data = "<option value=''>- Pilih Desa -</option>";
	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->kddesa."'>".$value->kddesa."</option>";
	    }
	    echo $data;
	}

	public function add_ajax_desaaaaaaaaa($id_kc)
	{
	    //$query = $this->db->get_where('tbl_desa_penyelenggara',array('kdkec'=>$id_kc));
	    $where = array('kdkec'=>$id_kc);

	    $query = $this->db->distinct()->select('tbl_wdesa.id_desa,tbl_wdesa.nama_desa')->from('tbl_desa_penyelenggara')->join('tbl_wdesa', 'tbl_wdesa.kecamatan_id=tbl_desa_penyelenggara.kdkec','left')->where($where)->get();
	    //$query = $this->db->select('DISTINCT(tbl_desa_penyelenggara.kddesa)')->from('tbl_desa_penyelenggara')->join('tbl_wdesa', 'tbl_wdesa.kecamatan_id=tbl_desa_penyelenggara.kdkec','left')->where($where)->get();

	    $data = "<option value=''>- Pilih Desa -</option>";
	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->id_desa."'>".$value->nama_desa."</option>";
	    }
	    echo $data;
	}

	function add_ajax_desa($id_kec){
	    $query = $this->db->get_where('tbl_wdesa',array('kecamatan_id'=>$id_kec));
	    //$data = "<option value=''> - Pilih Desa - </option>";
	    
	    foreach ($query->result() as $value) {
	        $data .= "<option value='".$value->id_desa."'>".$value->nama_desa."</option>";
	    }
	    echo $data;
	}

}

/* End of file Calon.php */
/* Location: ./application/controllers/Calon.php */