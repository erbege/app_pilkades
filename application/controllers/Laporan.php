<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_penyelenggara','desapemilihan');
		$this->load->model('M_laporan','laporan');
	}

	public function index() {

		$this->load->helper('url');
		$this->load->helper('form');


		$kecamatans = $this->desapemilihan->get_list_kec();

		$opt = array('' => '');
		foreach ($kecamatans as $kec) {
			$opt[$kec] = $kec;
		}

		$data['form_kec'] 		= form_dropdown('',$opt,'','id="nama_kec" name="nama_kec" class="form-control"');

		if ($this->input->post('nama_kec')) {
			$data['datalaporan'] 	= $this->laporan->select_by_kec($this->input->post('nama_kec'));
		} else {
			$data['datalaporan'] 	= $this->laporan->select_all();
		}
		
		//$data['datalaporan'] 	= $this->laporan->select_all();
		$data['pst'] 			= $this->input->post('nama_kec');
		$data['userdata'] 		= $this->userdata;
		$data['page'] 			= "Laporan Hasil Pilkades";
		$data['judul'] 			= "Laporan";
		$data['deskripsi'] 		= "Laporan Hasil Pemilihan Kepala Desa";
		
		$this->template->views('laporan/home', $data);
	}

	public function cetakPDF() {

		$data['userdata'] 		= $this->userdata;
		
		if ($this->input->post('nama_kec')) {
			$data['datalaporan'] 	= $this->laporan->select_by_kec($this->input->post('nama_kec'));
		} else {
			$data['datalaporan'] 	= $this->laporan->select_all();
		}

		//memanggil library mpdf
		include_once './assets/mpdf614/mpdf.php';

		// $mpdf = new \Mpdf\Mpdf([
		// 	'format' => 'A4',
		// 	'margin_left' => 10,
		// 	'margin_right' => 10,
		// 	'margin_top' => 15,
		// 	'margin_bottom' => 10,
		// 	'margin_header' => 10,
		// 	'margin_footer' => 10,
		// 	'orientation' => 'L'
		// ]);

		$mpdf = new mpdf('c','A4-L');
		$mpdf->charset_in = 'UTF-8';
		$mpdf->SetMargins(0, 0, 25);
		$mpdf->SetWatermarkText("TAPEM");
		$mpdf->showWatermarkText = true;
		//$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->WatermarkTextAlpha = 0.1;


		$data = $this->load->view('laporan/cetak_pdf', $data, TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.pdf', 'I');

		//$this->load->view('laporan/cetak_pdf', $data, TRUE);
	}

	public function export7x() {
		error_reporting(E_ALL);
    
		//include_once './assets/phpexcel/Classes/PHPExcel.php';
		$spreadsheet  = new Spreadsheet();

		$data = $this->laporan->select_all();

		//$spreadsheet = new PHPExcel(); 
		$spreadsheet->setActiveSheetIndex(0); 

		$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		$spreadsheet->getActiveSheet()->mergeCells('A1:A3');
		$spreadsheet->getActiveSheet()->mergeCells('B1:B3');
		$spreadsheet->getActiveSheet()->mergeCells('C1:C3');
		$spreadsheet->getActiveSheet()->mergeCells('D1:F2');
		$spreadsheet->getActiveSheet()->mergeCells('G1:K1');
		$spreadsheet->getActiveSheet()->mergeCells('L1:W1');

		$spreadsheet->getActiveSheet()->mergeCells('G2:G3');
		$spreadsheet->getActiveSheet()->mergeCells('H2:H3');
		$spreadsheet->getActiveSheet()->mergeCells('I2:I3');
		$spreadsheet->getActiveSheet()->mergeCells('J2:J3');
		$spreadsheet->getActiveSheet()->mergeCells('K2:K3');
		$spreadsheet->getActiveSheet()->mergeCells('L2:M2');
		$spreadsheet->getActiveSheet()->mergeCells('N2:O2');
		$spreadsheet->getActiveSheet()->mergeCells('P2:Q2');
		$spreadsheet->getActiveSheet()->mergeCells('R2:S2');
		$spreadsheet->getActiveSheet()->mergeCells('T2:U2');
		$spreadsheet->getActiveSheet()->mergeCells('V2:W2');

		$spreadsheet->getActiveSheet()->SetCellValue('A1', "NO");
		$spreadsheet->getActiveSheet()->SetCellValue('B1', "KECAMATAN");
		$spreadsheet->getActiveSheet()->SetCellValue('C1', "DESA");
		$spreadsheet->getActiveSheet()->SetCellValue('D1', "DPT");
		$spreadsheet->getActiveSheet()->SetCellValue('G1', "SURAT SUARA");
		$spreadsheet->getActiveSheet()->SetCellValue('L1', "PEROLEHAN SUARA");

		$spreadsheet->getActiveSheet()->SetCellValue('G2', "SS SAH");
		$spreadsheet->getActiveSheet()->SetCellValue('H2', "SS TIDAK SAH");
		$spreadsheet->getActiveSheet()->SetCellValue('I2', "SS RUSAK");
		$spreadsheet->getActiveSheet()->SetCellValue('J2', "SS TIDAK DIGUNAKAN");
		$spreadsheet->getActiveSheet()->SetCellValue('K2', "JUMLAH");
		$spreadsheet->getActiveSheet()->SetCellValue('L2', "CALON NO URUT 1");
		$spreadsheet->getActiveSheet()->SetCellValue('N2', "CALON NO URUT 2");
		$spreadsheet->getActiveSheet()->SetCellValue('P2', "CALON NO URUT 3");
		$spreadsheet->getActiveSheet()->SetCellValue('R2', "CALON NO URUT 4");
		$spreadsheet->getActiveSheet()->SetCellValue('T2', "CALON NO URUT 5");
		$spreadsheet->getActiveSheet()->SetCellValue('V2', "JUMLAH TOTAL");

		$spreadsheet->getActiveSheet()->SetCellValue('D3', "L");
		$spreadsheet->getActiveSheet()->SetCellValue('E3', "P");
		$spreadsheet->getActiveSheet()->SetCellValue('F3', "JUMLAH");
		$spreadsheet->getActiveSheet()->SetCellValue('K3', "ANGKA");
		$spreadsheet->getActiveSheet()->SetCellValue('L3', "%");
		$spreadsheet->getActiveSheet()->SetCellValue('M3', "ANGKA");
		$spreadsheet->getActiveSheet()->SetCellValue('O3', "%");
		$spreadsheet->getActiveSheet()->SetCellValue('P3', "ANGKA");
		$spreadsheet->getActiveSheet()->SetCellValue('Q3', "%");
		$spreadsheet->getActiveSheet()->SetCellValue('R3', "ANGKA");
		$spreadsheet->getActiveSheet()->SetCellValue('S3', "%");
		$spreadsheet->getActiveSheet()->SetCellValue('T3', "ANGKA");
		$spreadsheet->getActiveSheet()->SetCellValue('U3', "%");
		$spreadsheet->getActiveSheet()->SetCellValue('V3', "ANGKA");
		$spreadsheet->getActiveSheet()->SetCellValue('W3', "%");

		$rowCount = 3; 
		$rowCount++;

		foreach($data as $value){
		    $spreadsheet->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-3); 

		    $spreadsheet->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_kec); 
		    $spreadsheet->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama_desa); 
		    $spreadsheet->getActiveSheet()->SetCellValue('D'.$rowCount, $value->dpt_l); 
		    $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('E'.$rowCount, $value->dpt_p); 
		    $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('F'.$rowCount, $value->dpt_jml); 
		    $spreadsheet->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('G'.$rowCount, $value->sssah); 
		    $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('H'.$rowCount, $value->sstdksah); 
		    $spreadsheet->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('I'.$rowCount, $value->ssrusak); 
		    $spreadsheet->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('J'.$rowCount, $value->sstidakterpakai); 
		    $spreadsheet->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('K'.$rowCount, ($value->sssah+$value->sstdksah+$value->ssrusak+$value->sstidakterpakai)); 
		    $spreadsheet->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');

		    //persen1
            if (($value->A > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen1 = $value->A / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen1 = 0;
            }
		    $spreadsheet->getActiveSheet()->SetCellValue('L'.$rowCount, $value->A); 
		    $spreadsheet->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('M'.$rowCount, $persen1); 
		    $spreadsheet->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen2
            if (($value->B > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen2 = $value->B / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen2 = 0;
            }
		    $spreadsheet->getActiveSheet()->SetCellValue('N'.$rowCount, $value->B); 
		    $spreadsheet->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('O'.$rowCount, $persen2); 
		    $spreadsheet->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen3
            if (($value->C > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen3 = $value->C / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen3 = 0;
            }
		    $spreadsheet->getActiveSheet()->SetCellValue('P'.$rowCount, $value->C); 
		    $spreadsheet->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('Q'.$rowCount, $persen3); 
		    $spreadsheet->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen4
            if (($value->D > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen4 = $value->D / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen4 = 0;
            }
		    $spreadsheet->getActiveSheet()->SetCellValue('R'.$rowCount, $value->D); 
		    $spreadsheet->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('S'.$rowCount, $persen4); 
		    $spreadsheet->getActiveSheet()->getStyle('S')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen5
            if (($value->E > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen5 = $value->E / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen5 = 0;
            }
		    $spreadsheet->getActiveSheet()->SetCellValue('T'.$rowCount, $value->E); 
		    $spreadsheet->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('U'.$rowCount, $persen5); 
		    $spreadsheet->getActiveSheet()->getStyle('U')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    $jml_hasil = $value->A+$value->B+$value->C+$value->D+$value->E;
            $jml_persen = $persen1+$persen2+$persen3+$persen4+$persen5;
            $spreadsheet->getActiveSheet()->SetCellValue('V'.$rowCount, $jml_hasil); 
		    $spreadsheet->getActiveSheet()->getStyle('V')->getNumberFormat()->setFormatCode('[Blue][>=10000]#,##0;[Red][<0]#,##0;#,##0');
		    $spreadsheet->getActiveSheet()->SetCellValue('W'.$rowCount, $jml_persen); 
		    $spreadsheet->getActiveSheet()->getStyle('W')->getNumberFormat()->setFormatCode('#,##0.00');

		    $rowCount++; 
		} 

		$sheet = $spreadsheet->getActiveSheet();

		/* start BLOK UNTUK BORDER */
		// $thick = array();
		// $thick['borders'] = array();
		// $thick['borders']['allborders'] = array();
		// $thick['borders']['allborders']['style'] = \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;
		// $thick['alignment'] = array();
		// $thick['alignment']['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
		// $thick['alignment']['vertical'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER;
		// $sheet->getStyle('A1:W3')->applyFromArray($thick);
		// $sheet->getStyle('A1:W3')->getAlignment()->setWrapText(true);
		// $sheet->getStyle('A1:W3')->getFont()->setBold(true);

		// $thin = array();
		// $thin['borders'] = array();
		// $thin['borders']['allborders'] = array();
		// $thin['borders']['allborders']['style'] = \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR;
		// $sheet->getStyle('A4:W'.$rowCount)->applyFromArray($thin);
		/* end BLOK UNTUK BORDER */

		//align header center
		// $spreadsheet->getActiveSheet()->getStyle('A1:W3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// $spreadsheet->getActiveSheet()->getStyle('A1:W3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		// $spreadsheet->getActiveSheet()->getStyle('A1:W3')->getAlignment()->setWrapText(true);
		// $spreadsheet->getActiveSheet()->getStyle('A1:W3')->getFont()->setBold(true);

		// header border
		
		$styleArray = [
		    'font' => [
		        'bold' => true,
		    ],
		    'alignment' => [
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		        'wrapText'	=> true,
		    ],
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ],
		    ],
		    'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
		        'rotation' => 90,
		        'startColor' => [
		            'argb' => 'FFA0A0A0',
		        ],
		        'endColor' => [
		            'argb' => 'FFFFFFFF',
		        ],
		    ],
		];

		$spreadsheet->getActiveSheet()->getStyle('A1:W3')->applyFromArray($styleArray);

		// body border
		$bodyArray = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ],
		    ],
		];

		$spreadsheet->getActiveSheet()->getStyle('A4:W'.$rowCount)->applyFromArray($bodyArray);

		//repeat heading
		$spreadsheet->getActiveSheet()->getPageSetup()->setRowsTorepeatAtTopByStartAndEnd(1,3);
		//$objWriter = new PHPExcel_Writer_Excel2007($spreadsheet); 
		//$objWriter->save('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx'); 

		//$this->load->helper('download');
		//force_download('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx', NULL);

		$writer = new Xlsx($spreadsheet);
		
		$filename = 'laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx';
		
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		// header('Cache-Control: max-age=0');
		//$writer->save('php://output');

		$writer->save('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx', NULL);
	}
	
	public function export() {
		error_reporting(E_ALL);
    	
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->laporan->select_all();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 

		$objPHPExcel->getActiveSheet()->mergeCells('A1:A3');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:B3');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:C3');
		$objPHPExcel->getActiveSheet()->mergeCells('D1:F2');
		$objPHPExcel->getActiveSheet()->mergeCells('G1:K1');
		$objPHPExcel->getActiveSheet()->mergeCells('L1:W1');

		$objPHPExcel->getActiveSheet()->mergeCells('G2:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('H2:H3');
		$objPHPExcel->getActiveSheet()->mergeCells('I2:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('J2:J3');
		$objPHPExcel->getActiveSheet()->mergeCells('K2:K3');
		$objPHPExcel->getActiveSheet()->mergeCells('L2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('N2:O2');
		$objPHPExcel->getActiveSheet()->mergeCells('P2:Q2');
		$objPHPExcel->getActiveSheet()->mergeCells('R2:S2');
		$objPHPExcel->getActiveSheet()->mergeCells('T2:U2');
		$objPHPExcel->getActiveSheet()->mergeCells('V2:W2');

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "NO");
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', "KECAMATAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', "DESA");
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', "DPT");
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', "SURAT SUARA");
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', "PEROLEHAN SUARA");

		$objPHPExcel->getActiveSheet()->SetCellValue('G2', "SAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('H2', "TIDAK SAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('I2', "RUSAK");
		$objPHPExcel->getActiveSheet()->SetCellValue('J2', "TIDAK DIGUNAKAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('K2', "JUMLAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('L2', "CALON NO URUT 1");
		$objPHPExcel->getActiveSheet()->SetCellValue('N2', "CALON NO URUT 2");
		$objPHPExcel->getActiveSheet()->SetCellValue('P2', "CALON NO URUT 3");
		$objPHPExcel->getActiveSheet()->SetCellValue('R2', "CALON NO URUT 4");
		$objPHPExcel->getActiveSheet()->SetCellValue('T2', "CALON NO URUT 5");
		$objPHPExcel->getActiveSheet()->SetCellValue('V2', "JUMLAH TOTAL");

		$objPHPExcel->getActiveSheet()->SetCellValue('D3', "L");
		$objPHPExcel->getActiveSheet()->SetCellValue('E3', "P");
		$objPHPExcel->getActiveSheet()->SetCellValue('F3', "JUMLAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('L3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('M3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('N3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('O3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('P3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('Q3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('R3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('S3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('T3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('U3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('V3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('W3', "%");

		$rowCount = 3; 
		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-3); 

		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_kec); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama_desa); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->dpt_l); 
		    $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->dpt_p); 
		    $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->dpt_jml); 
		    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->sssah); 
		    $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->sstdksah); 
		    $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value->ssrusak); 
		    $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value->sstidakterpakai); 
		    $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, ($value->sssah+$value->sstdksah+$value->ssrusak+$value->sstidakterpakai)); 
		    $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');

		    //persen1
            if (($value->A > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen1 = $value->A / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen1 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value->A); 
		    $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $persen1); 
		    $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen2
            if (($value->B > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen2 = $value->B / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen2 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $value->B); 
		    $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $persen2); 
		    $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen3
            if (($value->C > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen3 = $value->C / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen3 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $value->C); 
		    $objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $persen3); 
		    $objPHPExcel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen4
            if (($value->D > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen4 = $value->D / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen4 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $value->D); 
		    $objPHPExcel->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $persen4); 
		    $objPHPExcel->getActiveSheet()->getStyle('S')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen5
            if (($value->E > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen5 = $value->E / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen5 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $value->E); 
		    $objPHPExcel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $persen5); 
		    $objPHPExcel->getActiveSheet()->getStyle('U')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    $jml_hasil = $value->A+$value->B+$value->C+$value->D+$value->E;
            $jml_persen = $persen1+$persen2+$persen3+$persen4+$persen5;
            $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $jml_hasil); 
		    $objPHPExcel->getActiveSheet()->getStyle('V')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $jml_persen); 
		    $objPHPExcel->getActiveSheet()->getStyle('W')->getNumberFormat()->setFormatCode('#,##0.00');

		    $rowCount++; 
		} 

		$sheet = $objPHPExcel->getActiveSheet();

		/* start BLOK UNTUK BORDER */
		$thick = array();
		$thick['borders'] = array();
		$thick['borders']['allborders'] = array();
		$thick['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_THIN;
		$thick['alignment'] = array();
		$thick['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
		$thick['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;

		$sheet->getStyle('A1:W3')->applyFromArray($thick);
		
		$sheet->getStyle('A1:W3')->getAlignment()->setWrapText(true);
		$sheet->getStyle('A1:W3')->getFont()->setBold(true);

		$thin = array();
		$thin['borders'] = array();
		$thin['borders']['allborders'] = array();
		$thin['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_HAIR;
		$sheet->getStyle('A4:W'.$rowCount)->applyFromArray($thin);
		/* end BLOK UNTUK BORDER */


		//repeat heading
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsTorepeatAtTopByStartAndEnd(1,2);

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/laporan_pilkades_'.$this->session->userdata('thn_data').'.xlsx', NULL);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
