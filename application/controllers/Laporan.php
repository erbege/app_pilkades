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
		$objPHPExcel->getActiveSheet()->mergeCells('G1:J1');
		$objPHPExcel->getActiveSheet()->mergeCells('K1:V1');
		$objPHPExcel->getActiveSheet()->mergeCells('W1:W3');

		$objPHPExcel->getActiveSheet()->mergeCells('G2:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('H2:H3');
		$objPHPExcel->getActiveSheet()->mergeCells('I2:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('J2:J3');
		$objPHPExcel->getActiveSheet()->mergeCells('K2:L2');
		$objPHPExcel->getActiveSheet()->mergeCells('M2:N2');
		$objPHPExcel->getActiveSheet()->mergeCells('O2:P2');
		$objPHPExcel->getActiveSheet()->mergeCells('Q2:R2');
		$objPHPExcel->getActiveSheet()->mergeCells('S2:T2');
		$objPHPExcel->getActiveSheet()->mergeCells('U2:V2');

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "NO");
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', "KECAMATAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', "DESA");
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', "DPT");
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', "SURAT SUARA");
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', "PEROLEHAN SUARA");
		$objPHPExcel->getActiveSheet()->SetCellValue('W1', "PARTSIPASI (%)");

		$objPHPExcel->getActiveSheet()->SetCellValue('G2', "SAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('H2', "TIDAK SAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('I2', "TIDAK DIGUNAKAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('J2', "JUMLAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('K2', "CALON NO URUT 1");
		$objPHPExcel->getActiveSheet()->SetCellValue('M2', "CALON NO URUT 2");
		$objPHPExcel->getActiveSheet()->SetCellValue('O2', "CALON NO URUT 3");
		$objPHPExcel->getActiveSheet()->SetCellValue('Q2', "CALON NO URUT 4");
		$objPHPExcel->getActiveSheet()->SetCellValue('S2', "CALON NO URUT 5");
		$objPHPExcel->getActiveSheet()->SetCellValue('U2', "JUMLAH TOTAL");

		$objPHPExcel->getActiveSheet()->SetCellValue('D3', "L");
		$objPHPExcel->getActiveSheet()->SetCellValue('E3', "P");
		$objPHPExcel->getActiveSheet()->SetCellValue('F3', "JUMLAH");
		$objPHPExcel->getActiveSheet()->SetCellValue('K3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('L3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('M3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('N3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('O3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('P3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('Q3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('R3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('S3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('T3', "%");
		$objPHPExcel->getActiveSheet()->SetCellValue('U3', "ANGKA");
		$objPHPExcel->getActiveSheet()->SetCellValue('V3', "%");

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

		    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value->sstidakterpakai); 
		    $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');

		    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, ($value->sssah+$value->sstdksah+$value->ssrusak+$value->sstidakterpakai)); 
		    $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');

		    //persen1
            if (($value->A > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen1 = $value->A / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen1 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value->A); 
		    $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $persen1); 
		    $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen2
            if (($value->B > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen2 = $value->B / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen2 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value->B); 
		    $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $persen2); 
		    $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen3
            if (($value->C > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen3 = $value->C / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen3 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $value->C); 
		    $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $persen3); 
		    $objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen4
            if (($value->D > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen4 = $value->D / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen4 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $value->D); 
		    $objPHPExcel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $persen4); 
		    $objPHPExcel->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    //persen5
            if (($value->E > 0) && (($value->A+$value->B+$value->C+$value->D+$value->E) > 0)) {
                $persen5 = $value->E / ($value->A+$value->B+$value->C+$value->D+$value->E)*100;
            } else {
                $persen5 = 0;
            }
		    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $value->E); 
		    $objPHPExcel->getActiveSheet()->getStyle('S')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $persen5); 
		    $objPHPExcel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    $jml_hasil = $value->A+$value->B+$value->C+$value->D+$value->E;
            $jml_persen = $persen1+$persen2+$persen3+$persen4+$persen5;
            $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $jml_hasil); 
		    $objPHPExcel->getActiveSheet()->getStyle('U')->getNumberFormat()->setFormatCode('[Blue][>=1000]#,##0;[Red][<0]#,##0;#,##0');
		    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $jml_persen); 
		    $objPHPExcel->getActiveSheet()->getStyle('V')->getNumberFormat()->setFormatCode('#,##0.00');

		    // partisipasi
		    $partisipasi = (($value->sssah+$value->sstdksah) / $value->dpt_jml) * 100;
		    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $partisipasi); 
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

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */
