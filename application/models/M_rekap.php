<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekap extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getkec_by_kode($kode)
	{
		$this->db->select('*');
		$this->db->from('tbl_wkecamatan');
		$this->db->where('id_kec',$kode);

		$query = $this->db->get();

		return $query->row();
	}

	public function getdesa_by_kode($kode)
	{
		$this->db->select('*');
		$this->db->from('tbl_wdesa');
		$this->db->where('id_desa',$kode);

		$query = $this->db->get();

		return $query->row();
	}

	public function select_detail() {
		if ($this->session->userdata('id_role') == 3){
			$sql = "SELECT a.kdkec,a.kddesa,c.nama_kec,a.suratsuara,d.s_hasil, ";
			$sql = $sql."	(SELECT SUM(dpt_l) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.id_kec) AS DPTL, ";
			$sql = $sql."	(SELECT SUM(dpt_p) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.id_kec) AS DPTP, ";
			$sql = $sql."	(SELECT SUM(s_hasil) FROM tbl_calon AS b WHERE b.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND b.kdkec = c.id_kec ) AS SUARA ";
			$sql = $sql."	FROM tbl_desa_penyelenggara AS a ";
			$sql = $sql."LEFT JOIN tbl_wkecamatan AS c ON c.id_kec = a.kdkec ";
			$sql = $sql."LEFT JOIN tbl_calon AS d ON d.kddesa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			$sql = $sql."AND a.kdkec LIKE '". $this->session->userdata('id_kec')."' ";
			$sql = $sql."GROUP BY a.kdkec ";

		} else {

			$sql = "SELECT a.kdkec,a.kddesa,c.nama_kec,a.suratsuara,d.s_hasil, ";
			$sql = $sql."	(SELECT SUM(dpt_l) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.id_kec) AS DPTL, ";
			$sql = $sql."	(SELECT SUM(dpt_p) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.id_kec) AS DPTP, ";
			$sql = $sql."	(SELECT SUM(s_hasil) FROM tbl_calon AS b WHERE b.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND b.kdkec = c.id_kec ) AS SUARA ";
			$sql = $sql."	FROM tbl_desa_penyelenggara AS a ";
			$sql = $sql."LEFT JOIN tbl_wkecamatan AS c ON c.id_kec = a.kdkec ";
			$sql = $sql."LEFT JOIN tbl_calon AS d ON d.kddesa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			$sql = $sql."GROUP BY a.kdkec ";
		}

		$data = $this->db->query($sql);

		return $data->result();
	}


	public function select_detail_kec($kc) {
		if ($this->session->userdata('id_role') == 3){

			$sql = "SELECT a.kdkec,a.kddesa,c.nama_desa,a.suratsuara, ";
			$sql = $sql."	(SELECT SUM(dpt_l) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.kecamatan_id AND a.kddesa = c.id_desa) AS DPTL, ";
			$sql = $sql."	(SELECT SUM(dpt_p) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.kecamatan_id AND a.kddesa = c.id_desa) AS DPTP, ";
			$sql = $sql."	(SELECT SUM(s_hasil) FROM tbl_calon AS b WHERE b.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND b.kdkec = c.kecamatan_id AND b.kddesa = a.kddesa) AS SUARA ";
			$sql = $sql."	FROM tbl_desa_penyelenggara AS a ";
			$sql = $sql."LEFT JOIN tbl_wdesa AS c ON c.id_desa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			//$sql = $sql."AND a.kdkec LIKE '". $this->session->userdata('id_kec')."' ";
			$sql = $sql."AND a.kdkec LIKE '". $kc."' ";
		} else {

$sql = "SELECT a.kdkec,a.kddesa,c.nama_desa,a.suratsuara, ";
			$sql = $sql."	(SELECT SUM(dpt_l) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.kecamatan_id AND a.kddesa = c.id_desa) AS DPTL, ";
			$sql = $sql."	(SELECT SUM(dpt_p) FROM tbl_desa_penyelenggara AS a WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND a.kdkec = c.kecamatan_id AND a.kddesa = c.id_desa) AS DPTP, ";
			$sql = $sql."	(SELECT SUM(s_hasil) FROM tbl_calon AS b WHERE b.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND b.kdkec = c.kecamatan_id AND b.kddesa = a.kddesa) AS SUARA ";
			$sql = $sql."	FROM tbl_desa_penyelenggara AS a ";
			$sql = $sql."LEFT JOIN tbl_wdesa AS c ON c.id_desa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			$sql = $sql."AND a.kdkec LIKE '". $kc."' ";
		}

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_detail_desa($ds) {

			$sql = "SELECT a.kdkec,a.kddesa,a.nama,a.nourut,a.s_hasil,(b.dpt_l + b.dpt_p) AS jml_pemilih, ";
			$sql = $sql."(SELECT SUM(s_hasil) FROM tbl_calon WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' AND tbl_calon.kddesa LIKE b.kddesa) AS totalsuaramasuk ";
			$sql = $sql."FROM tbl_calon AS a ";
			$sql = $sql."LEFT JOIN tbl_desa_penyelenggara AS b ON b.kddesa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			$sql = $sql."AND a.kddesa LIKE '". $ds."' ";
			$sql = $sql."ORDER BY a.nourut ASC";

		$data = $this->db->query($sql);

		return $data->result();
	}
}

/* End of file M_rekap.php */
/* Location: ./application/models/M_rekap.php */