<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hasil extends CI_Model {

	var $table = 'tbl_desa_penyelenggara';
	var $column_order = array(null, 'tbl_wdesa.nama_desa','tbl_desa_penyelenggara.dpt_jml','tbl_desa_penyelenggara.sssah','tbl_desa_penyelenggara.sstdksah','tbl_desa_penyelenggara.sstidakterpakai',null,null); //set column field database for datatable orderable
	var $column_search = array('tbl_wdesa.nama_desa','tbl_wkecamatan.nama_kec'); //set column field database for datatable searchable 
	var $order = array('tbl_wdesa.nama_desa' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_desa_penyelenggara.kdkec', 'left');
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_desa_penyelenggara.kddesa', 'left');

		if ($this->session->userdata('id_role') == '3') {
			$this->db->where('tbl_desa_penyelenggara.kdkec',$this->session->userdata('id_kec'));
		}
		$this->db->where('tbl_desa_penyelenggara.thn_pemilihan',$this->session->userdata('thn_data'));


		//add custom filter here
		if($this->input->post('nama_kec'))
		{
			$this->db->like('tbl_wkecamatan.nama_kec', $this->input->post('nama_kec'));
		}
		if($this->input->post('nama_desa'))
		{
			$this->db->like('tbl_wdesa.nama_desa', $this->input->post('nama_desa'));
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
		$this->db->from($this->table);
		$this->db->join('tbl_wdesa','tbl_wdesa.id_desa=tbl_desa_penyelenggara.kddesa');
		$this->db->join('tbl_wkecamatan','tbl_wkecamatan.id_kec=tbl_desa_penyelenggara.kdkec');
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

	public function select_by_kategori() {
		if ($this->session->userdata('id_role') == 3){
			$sql = "SELECT * FROM tbl_desa_penyelenggara AS a ";
			$sql = $sql."LEFT JOIN tbl_wkecamatan AS b ON b.id_kec = a.kdkec ";
			$sql = $sql."LEFT JOIN tbl_wdesa AS c ON c.id_desa = a.kddesa ";
			$sql = $sql."LEFT JOIN tbl_calon AS d ON d.kddesa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			$sql = $sql."AND tbl_desa_penyelenggara.kdkec = '". $this->session->userdata('id_kec')."' ";
			$sql = $sql."ORDER BY a.kddesa,d.s_hasil DESC ";
		} else {
			$sql = "SELECT * FROM tbl_desa_penyelenggara AS a ";
			$sql = $sql."LEFT JOIN tbl_wkecamatan AS b ON b.id_kec = a.kdkec ";
			$sql = $sql."LEFT JOIN tbl_wdesa AS c ON c.id_desa = a.kddesa ";
			$sql = $sql."LEFT JOIN tbl_calon AS d ON d.kddesa = a.kddesa ";
			$sql = $sql."WHERE a.thn_pemilihan = '". $this->session->userdata('thn_data')."' ";
			$sql = $sql."ORDER BY a.kddesa,d.s_hasil DESC ";
		}

		$data = $this->db->query($sql);

		return $data->result();
	}
}

/* End of file M_hasil.php */
/* Location: ./application/models/M_hasil.php */