<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_calon extends CI_Model {

	var $table = 'tbl_calon';
	var $column_order = array(null,'tbl_calon.nama','tbl_calon.tgl_lahir','tbl_calon.agama','tbl_calon.kelamin','tbl_pendidikan.nama_pendidikan','tbl_pekerjaan.nama_pekerjaan',null,null); //set column field database for datatable orderable
	var $column_search = array('tbl_calon.nama','tbl_pendidikan.nama_pendidikan','tbl_wdesa.nama_desa'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('tbl_calon.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		// where condition
		//$this->db->where('kelamin','L');
		//$this->db->where('thn_pemilihan','2019');
		$this->db->join('tbl_pendidikan','tbl_pendidikan.id_pendidikan=tbl_calon.id_pendidikan', 'left');
		$this->db->join('tbl_pekerjaan','tbl_pekerjaan.id_pekerjaan=tbl_calon.id_pekerjaan', 'left');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');

		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('tbl_calon.kdkec',$this->session->userdata('id_kec'));
		}
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));


		//add custom filter here
		if($this->input->post('nama_kec'))
		{
			$this->db->like('tbl_wkecamatan.nama_kec', $this->input->post('nama_kec'));
		}
		if($this->input->post('nama_desa'))
		{
			$this->db->like('tbl_wdesa.nama_desa', $this->input->post('nama_desa'));
		}
		
		
		//$this->db->from($this->table);

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

		//$this->db->from($this->table);
		//$this->db->join('tbl_pendidikan','tbl_pendidikan.id=tbl_calon.id_pendidikan');
		//$this->db->where('tbl_calon.id',$id);

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
		$this->db->join('tbl_pendidikan', 'tbl_calon.id_pendidikan = tbl_pendidikan.id_pendidikan', 'left');
		$this->db->join('tbl_pekerjaan','tbl_pekerjaan.id_pekerjaan=tbl_calon.id_pekerjaan', 'left');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_calon.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_calon.kddesa', 'left');
		$this->db->where('tbl_calon.thn_pemilihan',$this->session->userdata('thn_data'));
		$this->db->where('tbl_calon.kdkec',$this->session->userdata('id_kec'));

		$query = $this->db->get();

		return $query->result();

		// marker
		// if ($this->session->userdata('id_role') == 3){
		// 	$sql = "SELECT * FROM tbl_calon 
		// 		LEFT JOIN tbl_wkecamatan ON tbl_wkecamatan.id_kec = tbl_calon.kdkec
		// 		LEFT JOIN tbl_wdesa ON tbl_wdesa.id_desa = tbl_calon.kddesa
		// 		LEFT JOIN tbl_pendidikan ON tbl_pendidikan.id_pendidikan = tbl_calon.id_pendidikan
		// 		LEFT JOIN tbl_pekerjaan ON tbl_pekerjaan.id_pekerjaan = tbl_calon.id_pekerjaan
		// 		WHERE tbl_calon.thn_pemilihan = '". $this->session->userdata('thn_data')."'
		// 		AND tbl_calon.kdkec = '". $this->session->userdata('id_kec')."'";
		// } else {
		// 	$sql = "SELECT * FROM tbl_calon 
		// 		LEFT JOIN tbl_wkecamatan ON tbl_wkecamatan.id_kec = tbl_calon.kdkec
		// 		LEFT JOIN tbl_wdesa ON tbl_wdesa.id_desa = tbl_calon.kddesa
		// 		LEFT JOIN tbl_pendidikan ON tbl_pendidikan.id_pendidikan = tbl_calon.id_pendidikan
		// 		LEFT JOIN tbl_pekerjaan ON tbl_pekerjaan.id_pekerjaan = tbl_calon.id_pekerjaan
		// 		WHERE tbl_calon.thn_pemilihan = '". $this->session->userdata('thn_data')."'";
		// }

		// $data = $this->db->query($sql);

		// return $data->result();
	}

}
