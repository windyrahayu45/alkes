<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mv_mutasi extends CI_Model {

	var $table = 'data_barang a';
	var $column = array('a.nama','a.merk','a.type','a.SN','b.nama_ruangan','y.nama ruangan','c.status_barang','z.status_barang');
	var $order = array('a.id_barang' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		$this->db->select('a.nama,a.merk,a.type,a.SN,b.nama_ruangan as asal,y.nama_ruangan as penerima,c.status_barang as kondisi_sesudah,z.status_barang as kondisi_sebelum,x.nama_penerima,v.nama as pemberi,x.ket,x.tgl_dipinjam,x.jenis_mutasi,x.status_mutasi');
		$this->db->from($this->table);
		$this->db->join("mutasi x","a.id_barang = x.id_barang");
		$this->db->join("ruangan b","x.id_ruangan = b.id_ruangan",'left');
		$this->db->join("ruangan y","x.id_ruangan_penerima = y.id_ruangan",'left');
		$this->db->join("status_barang c","x.kondisi_sesudah = c.id_status",'left');
		$this->db->join("status_barang z","x.kondisi_sebelum = z.id_status",'left');

		$this->db->join("petugas v","x.id_petugas = v.id_petugas",'left');
		
		if($this->input->post('ruangan'))
        {
            $this->db->where('x.id_ruangan', $this->input->post('ruangan'));
        }
		

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
