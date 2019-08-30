<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_pengguna');
		$this->load->model('M_kecamatan');
		$this->load->model('M_opd');
	}

	public function index() {

		if (($this->session->userdata('id_role') == 1) || ($this->session->userdata('id_role') == 2)) {
			$data['userdata'] = $this->userdata;
			$data['dataPengguna'] = $this->M_pengguna->select_all();
			$data['dataKecamatan'] = $this->M_kecamatan->select_all();
			$data['dataOpd'] = $this->M_opd->select_all();

			$data['page'] = "pengguna";
			$data['judul'] = "Data Pengguna";
			$data['deskripsi'] = "Manage Data Pengguna";

			$data['modal_tambah_pengguna'] = show_my_modal('modals/modal_tambah_pengguna', 'tambah-pengguna', $data);

			$this->template->views('pengguna/home', $data);
		} else {
			$data['userdata'] = $this->userdata;
			
			$data['page'] = "error";
			$data['judul'] = "Error 401";
			$data['deskripsi'] = "Unauthorized Access";

			$this->template->views('galat/home', $data);
		}
	}

	public function tampil() {
		$data['dataPengguna'] = $this->M_pengguna->select_all();
		$this->load->view('pengguna/list_data', $data);
	}

	public function prosesTambah() {
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		//$data = $this->input->post();
		$data1 = array(
		'username' => $this->input->post('username',TRUE),
		'password' => md5($this->input->post('password',TRUE)),
		'first_name' => $this->input->post('first_name',TRUE),
		'last_name' => $this->input->post('last_name',TRUE),
		'id_role' => $this->input->post('id_role',TRUE),
		'email' => $this->input->post('email',TRUE),
		'phone' => $this->input->post('phone',TRUE),
		//'id_opd' => $this->input->post('id_opd',TRUE),
		'id_kab' => $this->input->post('id_kabupaten',TRUE),
		'id_kec' => $this->input->post('id_kecamatan',TRUE),
	    );
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_pengguna->insert($data1);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Pengguna Berhasil ditambahkan', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Data Pengguna Gagal ditambahkan', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function update() {
		$id = trim($_POST['id']);

		$data['dataPengguna'] = $this->M_pengguna->select_by_id($id);
		$data['dataKecamatan'] = $this->M_kecamatan->select_all();
		$data['dataOpd'] = $this->M_opd->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_pengguna', 'update-pengguna', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required');

		//$data = $this->input->post();
		if ($this->input->post('password') == '') {
			$data1 = array(
			'id' => $this->input->post('id',TRUE),
			'username' => $this->input->post('username',TRUE),
			'first_name' => $this->input->post('first_name',TRUE),
			'last_name' => $this->input->post('last_name',TRUE),
			'id_role' => $this->input->post('id_role',TRUE),
			'email' => $this->input->post('email',TRUE),
			'phone' => $this->input->post('phone',TRUE),
			//'id_opd' => $this->input->post('id_opd',TRUE),
			'id_kab' => $this->input->post('id_kabupaten',TRUE),
			'id_kec' => $this->input->post('id_kecamatan',TRUE),
			'active' => $this->input->post('statuser',TRUE),
		    );
		} else {
			$data1 = array(
			'id' => $this->input->post('id',TRUE),
			'username' => $this->input->post('username',TRUE),
			'password' => md5($this->input->post('password',TRUE)),
			'first_name' => $this->input->post('first_name',TRUE),
			'last_name' => $this->input->post('last_name',TRUE),
			'id_role' => $this->input->post('id_role',TRUE),
			'email' => $this->input->post('email',TRUE),
			'phone' => $this->input->post('phone',TRUE),
			//'id_opd' => $this->input->post('id_opd',TRUE),
			'id_kab' => $this->input->post('id_kabupaten',TRUE),
			'id_kec' => $this->input->post('id_kecamatan',TRUE),
			'active' => $this->input->post('statuser',TRUE),
		    );
		}
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_pengguna->update($data1);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Pengguna Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Pengguna Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_pengguna->delete($id);

		if ($result > 0) {
			echo show_succ_msg('Data Pengguna Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Pengguna Gagal dihapus', '20px');
		}
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_pengguna->select_all_pengguna();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Username");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Nama Depan");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Nama Belakang");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "ID OPD");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "OPD");
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Email");
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Telp");
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Created On");
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "Last Login");
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "Aktif?");
		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->username); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->first_name); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->last_name); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->id_opd); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->nama_instansi); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->email); 
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value->phone, PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value->created_on); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value->last_login); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value->active); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Pengguna.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Pengguna.xlsx', NULL);
	}

	public function import() {
		$this->form_validation->set_rules('excel', 'File', 'trim|required');

		if ($_FILES['excel']['name'] == '') {
			$this->session->set_flashdata('msg', 'File harus diisi');
		} else {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('excel')){
				$error = array('error' => $this->upload->display_errors());
			}
			else{
				$data = $this->upload->data();
				
				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');

				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

				$inputFileName = './assets/excel/' .$data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

				$index = 0;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$id = md5(DATE('ymdhms').rand());
						$check = $this->M_Pengguna->check_nama($value['B']);

						if ($check != 1) {
							$resultData[$index]['id'] = $id;
							$resultData[$index]['username'] = ucwords($value['B']);
							$resultData[$index]['first_name'] = $value['C'];
							$resultData[$index]['last_name'] = $value['D'];
							$resultData[$index]['id_opd'] = $value['E'];
							$resultData[$index]['email'] = $value['G'];
							$resultData[$index]['phone'] = $value['H'];
							$resultData[$index]['active'] = $value['K'];
						}
					}
					$index++;
				}

				unlink('./assets/excel/' .$data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_Pengguna->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Data Pengguna Berhasil diimport ke database'));
						redirect('Pengguna');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Pengguna Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Pengguna');
				}

			}
		}
	}
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */