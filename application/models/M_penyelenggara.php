<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penyelenggara extends CI_Model {

	var $table = 'tbl_desa_penyelenggara';
	var $column_order = array(null, 'tbl_wdesa.nama_desa','tbl_wkecamatan.nama_kec','tbl_desa_penyelenggara.dpt_l','tbl_desa_penyelenggara.dpt_p',null,'tbl_desa_penyelenggara.suratsuara',null); //set column field database for datatable orderable
	var $column_search = array('tbl_wdesa.nama_desa','tbl_wkecamatan.nama_kec'); //set column field database for datatable searchable 
	var $order = array('tbl_wkecamatan.nama_kec' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	private function _get_datatables_query()
	{
		
		//table join
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_desa_penyelenggara.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_desa_penyelenggara.kddesa', 'left');

		//filter tahun pelaksanaan
		$this->db->where('tbl_desa_penyelenggara.thn_pemilihan', $this->session->userdata('thn_data'));

		//filter by role
		if ($this->session->userdata('id_role') == 3){
			$this->db->like('tbl_desa_penyelenggara.kdkec', $this->session->userdata('id_kec'));
		}

		//add custom filter here
		if($this->input->post('nama_kec'))
		{
			$this->db->like('tbl_wkecamatan.nama_kec', $this->input->post('nama_kec'));
		}
		if($this->input->post('nama_desa'))
		{
			$this->db->like('tbl_wdesa.nama_desa', $this->input->post('nama_desa'));
		}
		
		
		

		$this->db->from($this->table);
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_list_kec()
	{
		$this->db->select('tbl_desa_penyelenggara.kdkec,tbl_wkecamatan.nama_kec');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_desa_penyelenggara.kdkec', 'left');
		//filter tahun penlaksanaan
		$this->db->where('tbl_desa_penyelenggara.thn_pemilihan', $this->session->userdata('thn_data'));

		if ($this->session->userdata('id_role') == 3){
			$this->db->where('tbl_desa_penyelenggara.kdkec', $this->session->userdata('id_kec'));
		}
		
		$this->db->from($this->table);
		$this->db->order_by('tbl_wkecamatan.nama_kec','asc');
		$query = $this->db->get();
		$result = $query->result();

		$countries = array();
		foreach ($result as $row) 
		{
			$countries[] = $row->nama_kec;
		}
		return $countries;
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	public function select_by_kategori2()
	{
		$this->db->select('tbl_wkecamatan.nama_kec,tbl_wdesa.nama_desa,tbl_desa_penyelenggara.dpt_l,tbl_desa_penyelenggara.dpt_p,tbl_desa_penyelenggara.suratsuara');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_desa_penyelenggara.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_desa_penyelenggara.kddesa', 'left');
		//filter tahun penlaksanaan
		$this->db->where('tbl_desa_penyelenggara.thn_pemilihan', $this->session->userdata('thn_data'));

		if ($this->session->userdata('id_role') == 3){
			$this->db->where('tbl_desa_penyelenggara.kdkec', $this->session->userdata('id_kec'));
		}
		
		$this->db->from($this->table);
		$this->db->order_by('tbl_wkecamatan.nama_kec','asc');
		$query = $this->db->get();
		$result = $query->result();

		$countries = array();
		foreach ($result as $row) 
		{
			$countries[] = $row->nama_kec;
		}
		return $countries;
	}

	public function select_by_kategori() {
		if ($this->session->userdata('id_role') == 3){
		$sql = "SELECT * FROM tbl_desa_penyelenggara 
			LEFT JOIN tbl_wkecamatan ON tbl_wkecamatan.id_kec = tbl_desa_penyelenggara.kdkec
			LEFT JOIN tbl_wdesa ON tbl_wdesa.id_desa = tbl_desa_penyelenggara.kddesa
			WHERE tbl_desa_penyelenggara.thn_pemilihan = '". $this->session->userdata('thn_data')."'
			AND tbl_desa_penyelenggara.kdkec = '". $this->session->userdata('id_kec')."'";
		} else {
			$sql = "SELECT * FROM tbl_desa_penyelenggara 
			LEFT JOIN tbl_wkecamatan ON tbl_wkecamatan.id_kec = tbl_desa_penyelenggara.kdkec
			LEFT JOIN tbl_wdesa ON tbl_wdesa.id_desa = tbl_desa_penyelenggara.kddesa
			WHERE tbl_desa_penyelenggara.thn_pemilihan = '". $this->session->userdata('thn_data')."'";
		}

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_kec() {
		$sql = "SELECT DISTINCT tbl_desa_penyelenggara.kddesa,tbl_wdesa.nama_desa FROM tbl_desa_penyelenggara 
			LEFT JOIN tbl_wdesa ON tbl_wdesa.id_desa = tbl_desa_penyelenggara.kddesa
			WHERE tbl_desa_penyelenggara.thn_pemilihan = '". $this->session->userdata('thn_data')."'";

		$sql1 = "SELECT DISTINCT kddesa FROM tbl_desa_penyelenggara 
			WHERE tbl_desa_penyelenggara.thn_pemilihan = '". $this->session->userdata('thn_data')."'";

		$data = $this->db->query($sql);

		return $data->result();
	}

	// Get Kecamatan
	function getKec(){

		$response = array();

		// Select record
		$this->db->select('*');
		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('id_kec', $this->session->userdata('id_kec'));
		} 
		$this->db->order_by('nama_kec');
		$q = $this->db->get('tbl_wkecamatan');
		$response = $q->result_array();

		return $response;
	}

	// Get Desa
  function getDesa($postData){
    $response = array();
 
    // Select record
    $this->db->select('id_desa,nama_desa');
    //$this->db->where('kecamatan_id', $postData['kdkec']);
    $q = $this->db->get('tbl_wdesa');
    $response = $q->result_array();

    return $response;
  }

  public function select_jml_pemilih($kc) {
		if ($this->session->userdata('id_role') == '3') {
			$sql = "SELECT SUM(dpt_l+dpt_p) AS jmlpilih, SUM(suratsuara) AS jmlss FROM tbl_desa_penyelenggara WHERE kdkec LIKE {$kc} AND thn_pemilihan = '".$this->session->userdata('thn_data')."'";
		} else {
			$sql = "SELECT SUM(dpt_l+dpt_p) AS jmlpilih, SUM(suratsuara) AS jmlss FROM tbl_desa_penyelenggara WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."'";
		}

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_jml_desa() {
		if ($this->session->userdata('id_role') == '3') {
			$sql = "SELECT COUNT(DISTINCT(kddesa)) AS jmldesa FROM tbl_desa_penyelenggara WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."' AND kdkec = '".$this->session->userdata('id_kec')."'";
		} else {
			$sql = "SELECT COUNT(DISTINCT(kddesa)) AS jmldesa FROM tbl_desa_penyelenggara WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."'";
		}

		$data = $this->db->query($sql);

		return $data->row();
	}
}

/* End of file M_penyelenggara.php */
/* Location: ./application/models/M_penyelenggara.php */