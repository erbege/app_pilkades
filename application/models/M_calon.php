<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_calon extends CI_Model {

	var $table = 'tbl_calon';
	var $column_order = array('tbl_wkecamatan.nama_kec','tbl_wdesa.nama_desa','tbl_calon.nourut','tbl_calon.nama','tbl_calon.tgl_lahir','tbl_calon.agama','tbl_calon.kelamin','tbl_pendidikan.nama_pendidikan','tbl_pekerjaan.nama_pekerjaan','tbl_calon.photo',null); //set column field database for datatable orderable
	var $column_search = array('tbl_wkecamatan.nama_kec','tbl_wdesa.nama_desa','tbl_calon.nama','tbl_calon.kelamin','tbl_pendidikan.nama_pendidikan','tbl_pekerjaan.nama_pekerjaan','tbl_calon.agama'); 
	var $order = array('tbl_calon.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$this->db->join('tbl_pendidikan','tbl_pendidikan.id_pendidikan=tbl_calon.id_pendidikan', 'left');
		$this->db->join('tbl_pekerjaan','tbl_pekerjaan.id_pekerjaan=tbl_calon.id_pekerjaan', 'left');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');

		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('tbl_calon.kdkec',$this->session->userdata('id_kec'));
		}
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));


		//add custom filter here
		// if($this->input->post('nama_kec'))
		// {
		// 	$this->db->like('tbl_wkecamatan.nama_kec', $this->input->post('nama_kec'));
		// }

		// if($this->input->post('nama_desa'))
		// {
		// 	$this->db->like('tbl_wdesa.nama_desa', $this->input->post('nama_desa'));
		// }

		if (($this->session->userdata('id_role') == '1') || ($this->session->userdata('id_role') == '2')){

			if($this->input->post('kdkec'))
			{
				$this->db->like('tbl_calon.kdkec', $this->input->post('kdkec'));
			}

			if($this->input->post('kddesa'))
			{
				$this->db->like('tbl_calon.kddesa', $this->input->post('kddesa'));
			}

			if($this->input->post('nama_pendidikan'))
			{
				$this->db->where('tbl_pendidikan.nama_pendidikan', $this->input->post('nama_pendidikan'));
			}

			if($this->input->post('nama_pekerjaan'))
			{
				$this->db->like('tbl_pekerjaan.nama_pekerjaan', $this->input->post('nama_pekerjaan'));
			}

			if($this->input->post('kelamin'))
			{
				$this->db->like('tbl_calon.kelamin', $this->input->post('kelamin'));
			}

			if($this->input->post('agama'))
			{
				$this->db->like('tbl_calon.agama', $this->input->post('agama'));
			}

			if($this->input->post('photo') == 'Y')
			{
				// $where = 'tbl_calon.photo is not null';
				// $this->db->where($where);
				$this->db->where('tbl_calon.photo !=', null);
			}
		}
		

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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered()
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

	public function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_calon');
		$this->db->join('tbl_pendidikan', 'tbl_calon.id_pendidikan = tbl_pendidikan.id_pendidikan', 'left');
		$this->db->join('tbl_pekerjaan','tbl_pekerjaan.id_pekerjaan=tbl_calon.id_pekerjaan', 'left');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');
		$this->db->where('tbl_calon.id',$id);

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

	public function select_jml_calon($kc) {
		if ($this->session->userdata('id_role') == '3') {
			$sql = "SELECT COUNT(*) AS jmlcalon, SUM(s_hasil) AS jmlsuara FROM tbl_calon WHERE kdkec LIKE {$kc} AND thn_pemilihan = ".$this->session->userdata('thn_data');
		} else {
			$sql = "SELECT COUNT(*) AS jmlcalon, SUM(s_hasil) AS jmlsuara FROM tbl_calon WHERE thn_pemilihan = ".$this->session->userdata('thn_data');
		}

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_kec()
	{
		$this->db->select('*');
		$this->db->from('tbl_calon');
		$this->db->join('tbl_pendidikan', 'tbl_pendidikan.id_pendidikan = tbl_calon.id_pendidikan', 'left');
		$this->db->join('tbl_pekerjaan','tbl_pekerjaan.id_pekerjaan=tbl_calon.id_pekerjaan', 'left');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));
		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('tbl_calon.kdkec',$this->session->userdata('id_kec'));
		}
		//$this->db->order_by('tbl_calon.kdkec,tbl_calon.kddesa,tbl_calon.nourut', 'ASC');
		$this->db->order_by('tbl_wkecamatan.nama_kec,tbl_wdesa.nama_desa,tbl_calon.nourut', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_by_desa($desa)
	{
		$this->db->select('*');
		$this->db->from('tbl_calon');
		$this->db->join('tbl_pendidikan', 'tbl_pendidikan.id_pendidikan = tbl_calon.id_pendidikan', 'left');
		$this->db->join('tbl_pekerjaan','tbl_pekerjaan.id_pekerjaan=tbl_calon.id_pekerjaan', 'left');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));
		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('tbl_calon.kddesa',$desa);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function select_all() {
		$this->db->select('*');
		$this->db->from('tbl_calon');

		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));
		//$this->db->where('tbl_calon.kdkec',$this->session->userdata('id_kec'));

		$data = $this->db->get();

		return $data->result();
	}

	function load_data($ds)
	{
		$this->db->order_by('nourut', 'ASC');
		$this->db->where('kddesa',$ds);
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	function update_hasil($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function select_sebaran()
	{
		$this->db->select('tbl_wkecamatan.nama_kec,tbl_wdesa.nama_desa, COUNT(tbl_calon.kddesa) as jml_calon');
		$this->db->from('tbl_calon');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));
		$this->db->group_by('tbl_calon.kdkec,tbl_calon.kddesa');
		$this->db->order_by('jml_calon', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_jml_desa() {
		if ($this->session->userdata('id_role') == '3') {
			$sql = "SELECT COUNT(DISTINCT(kddesa)) AS jmldesa FROM tbl_calon WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."' AND kdkec = '".$this->session->userdata('id_kec')."'";
		} else {
			$sql = "SELECT COUNT(DISTINCT(kddesa)) AS jmldesa FROM tbl_calon WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."'";
		}

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_jml_kec() {
		if ($this->session->userdata('id_role') == '3') {
			$sql = "SELECT COUNT(DISTINCT(kdkec)) AS jmlkec FROM tbl_calon WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."' AND kdkec = '".$this->session->userdata('id_kec')."'";
		} else {
			$sql = "SELECT COUNT(DISTINCT(kdkec)) AS jmlkec FROM tbl_calon WHERE thn_pemilihan = '".$this->session->userdata('thn_data')."'";
		}

		$data = $this->db->query($sql);

		return $data->row();
	}

}

/* End of file M_calon.php */
/* Location: ./application/models/M_calon.php */