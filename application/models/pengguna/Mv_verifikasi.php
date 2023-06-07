<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mv_verifikasi extends CI_Model {

	var $table = 'dasawisma_rumah a';
	var $column = array('c.kelurahan');
	var $order = array('a.id' => 'asc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$token=$this->session->userdata('token');
		$hasil=$this->api->detail_pegawai($id_pegawai,$token);
		$datax=json_decode($hasil);
		//print_r($datax);
		//print_r($datax[0]->instansi_uptd);die;
		$this->db->select("a.created_by,b.`nama`,c.`kelurahan` as nama_kelurahan,b.`kelurahan` ,b.`rw`,b.rt,d.sistem,d.`id_sistem`,COUNT(a.`id_rumah`) AS belum_verifikasi,d.`bagian`,d.`tahun`");
		$this->db->from($this->table);
		$this->db->join("kader_dasawisma b","a.created_by=b.username");
		$this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
		$this->db->join("sistem d","a.`id_sistem`=d.`id_sistem`","LEFT");
		$this->db->where('a.status_verifikasi','0');
		$this->db->where('b.kelurahan',$datax[0]->instansi_uptd);
		$this->db->group_by('a.`created_by`');
		$this->db->group_by('a.`id_sistem`');
		$this->db->having('belum_verifikasi > 0');
		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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

		public function get_by_id_view($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result();
		}
		return $results;
	}


}
