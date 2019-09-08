<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Calon extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_calon','calon');
		$this->load->model('M_pekerjaan','pekerjaan');
		$this->load->model('M_pendidikan','pendidikan');
		$this->load->model('M_penyelenggara','desapemilihan');
		$this->load->model('M_desa','desa');
		
		$this->load->helper('url', 'form');
	}

	public function index() {

		//$this->load->helper('url', 'form');

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
			$row[] = "<div class='numberCircleSmall'>".$calon->nourut."</div>";
			$row[] = $calon->nama;
			$row[] = $calon->tmp_lahir.',<br /> '.$calon->tgl_lahir;
			$row[] = $calon->agama;
			$row[] = $calon->kelamin;
			$row[] = $calon->nama_pendidikan;
			$row[] = $calon->nama_pekerjaan;
			$row[] = $calon->nama_desa.',<br /> '.$calon->nama_kec;
			if($calon->photo)
				$row[] = '<a href="'.base_url('upload/'.$calon->photo).'" target="_blank"><img src="'.base_url('upload/small/'.$calon->photo).'" class="profile-user-img img-responsive" /></a>';
			else
				$row[] = '(No photo)';

			if ($this->session->userdata('id_role') == '3') {
				if (getStatusTransaksi('Pengelolaan Data Calon Kepala Desa')) {
					$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
					  <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Lihat" onclick="view_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-search"></i></a>';
				} else {
					$row[] = '
					  <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Lihat" onclick="view_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-search"></i></a>';	  
				
				}
			} else {
				$row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$calon->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
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
		$data->tgl_lahir = ($data->tgl_lahir == '0000-00-00') ? '' : $data->tgl_lahir; 
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
			
			//if(file_exists('upload/large/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
			//	unlink('upload/large/'.$this->input->post('remove_photo'));
			if(file_exists('upload/medium/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('upload/medium/'.$this->input->post('remove_photo'));
			if(file_exists('upload/small/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('upload/small/'.$this->input->post('remove_photo'));
			$data['photo'] = '';
		}

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$calon = $this->calon->get_by_id($this->input->post('id'));
			if(file_exists('upload/'.$calon->photo) && $calon->photo)
				unlink('upload/'.$calon->photo);
			
			//if(file_exists('upload/large/'.$calon->photo) && $calon->photo)
			//	unlink('upload/large/'.$calon->photo);
			if(file_exists('upload/medium/'.$calon->photo) && $calon->photo)
				unlink('upload/medium/'.$calon->photo);
			if(file_exists('upload/small/'.$calon->photo) && $calon->photo)
				unlink('upload/small/'.$calon->photo);
			
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
		
		//if(file_exists('upload/large/'.$calon->photo) && $calon->photo)
		//	unlink('upload/large/'.$calon->photo);
		if(file_exists('upload/medium/'.$calon->photo) && $calon->photo)
			unlink('upload/medium/'.$calon->photo);
		if(file_exists('upload/small/'.$calon->photo) && $calon->photo)
			unlink('upload/small/'.$calon->photo);
		
		$this->calon->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$nmft1 = preg_replace("/[^a-zA-Z]/", "_", $this->input->post('nama'));
		$nmft2 = $this->session->userdata('thn_data');
		$nmft3 = $this->input->post('kddesa');
		$nmft4 = $this->input->post('nourut');
		//$nmft5 = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		$config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|png|bmp';
        $config['max_size']             = 2048; //set max size allowed in Kilobyte
		$config['overwrite']			= true;
        //$config['encrypt_name'] 		  = true; //enkripsi nama file
        //$config['max_width']            = 1000; // set max width image allowed
        //$config['max_height']           = 1000; // set max height allowed
        //$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        //$config['file_name']            = strtoupper($nmft1).'-'.$nmft2.'_'.$nmft3.'_'.$nmft4.'_'.$nmft5;
		$config['file_name']            = strtoupper($nmft1).'-'.$nmft2.'_'.$nmft3.'_'.$nmft4;

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		
		// begin marker
		$gbr = $this->upload->data();
		$this->_create_thumbs($gbr['file_name']);
		//end marker

		return $this->upload->data('file_name');
	}

	function _create_thumbs($file_name){
        // Image resizing config
        $config = array(
            // Image Large
            //array(
            //    'image_library' => 'GD2',
            //    'source_image'  => 'upload/'.$file_name,
            //    'maintain_ratio'=> FALSE,
            //    'width'         => 600,
            //    'height'        => 800,
            //    'new_image'     => 'upload/large/'.$file_name
            //    ),
            // image Medium
            array(
                'image_library' => 'GD2',
                'source_image'  => 'upload/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 300,
                'height'        => 400,
                'new_image'     => 'upload/medium/'.$file_name
                ),
            // Image Small
            array(
                'image_library' => 'GD2',
                'source_image'  => 'upload/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 90,
                'height'        => 120,
                'new_image'     => 'upload/small/'.$file_name
            ));
 
        $this->load->library('image_lib', $config[0]);
        foreach ($config as $item){
            $this->image_lib->initialize($item);
            if(!$this->image_lib->resize()){
                return false;
            }
            $this->image_lib->clear();
        }
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

		$data = $this->calon->select_by_kec();
    	
		$spreadsheet  = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$spreadsheet->getActiveSheet()->SetCellValue('A'.$rowCount, "NO");
		$spreadsheet->getActiveSheet()->SetCellValue('B'.$rowCount, "KECAMATAN");
		$spreadsheet->getActiveSheet()->SetCellValue('C'.$rowCount, "DESA");
		$spreadsheet->getActiveSheet()->SetCellValue('E'.$rowCount, "NO URUT");
		$spreadsheet->getActiveSheet()->SetCellValue('D'.$rowCount, "NAMA");
		$spreadsheet->getActiveSheet()->SetCellValue('F'.$rowCount, "TEMPAT/TGL LAHIR");
		$spreadsheet->getActiveSheet()->SetCellValue('G'.$rowCount, "L/P");
		$spreadsheet->getActiveSheet()->SetCellValue('H'.$rowCount, "AGAMA");
		$spreadsheet->getActiveSheet()->SetCellValue('I'.$rowCount, "PENDIDIKAN TERAKHIR");
		$spreadsheet->getActiveSheet()->SetCellValue('J'.$rowCount, "PEKERJAAN");

		$rowCount++;

		foreach($data as $value){
		    $spreadsheet->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-1); 
		    $spreadsheet->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_kec); 
		    $spreadsheet->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama_desa); 
		    $spreadsheet->getActiveSheet()->SetCellValue('E'.$rowCount, $value->nourut); 
		    $spreadsheet->getActiveSheet()->SetCellValue('D'.$rowCount, $value->nama); 
		    $spreadsheet->getActiveSheet()->SetCellValue('F'.$rowCount, $value->tmp_lahir); 
		    $spreadsheet->getActiveSheet()->SetCellValue('G'.$rowCount, $value->kelamin); 
		    $spreadsheet->getActiveSheet()->SetCellValue('H'.$rowCount, $value->agama); 
		    $spreadsheet->getActiveSheet()->SetCellValue('I'.$rowCount, $value->nama_pendidikan); 
		    $spreadsheet->getActiveSheet()->SetCellValue('J'.$rowCount, $value->nama_pekerjaan); 
		    $rowCount++; 
		} 

		$writer = new Xlsx($spreadsheet);
		if ($this->session->userdata('id_role') == '3') {
			$filename = 'data_calon_'.$this->session->userdata('thn_data').'_'.$this->session->userdata('id_kec').'.xlsx';
		} else {
			$filename = 'data_calon_'.$this->session->userdata('thn_data').'_all.xlsx';
		}
		
		//header('Content-Type: application/vnd.ms-excel');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'. $filename ); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');

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