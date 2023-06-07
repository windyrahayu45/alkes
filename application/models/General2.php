<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class General2 extends CI_Model
{
	
	function __construct()
	{
	 
		parent:: __construct();
	}
	public function lihatisitabel($tabel,$where) {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			 
			$query = $this->db->get_where($tabel, $where);
			return $query;
			
			/* contoh datanya
			$data = array('username' => $this->input->post('username', TRUE),
				'password' => md5($this->input->post('password', TRUE))
			);*/
		}
		public function lihatisitabelselect($select,$tabel,$where) {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			
			$this->db->select($select);
			$query = $this->db->get_where($tabel, $where);
			return $query;
			
			 
		}
		public function lihatisitabelorder($tabel,$where,$urutkolom, $tipeurut) {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			
			$this->db->order_by($urutkolom, $tipeurut);
			$query = $this->db->get_where($tabel, $where);
			
			return $query;
			
			/* contoh datanya
			$data = array('username' => $this->input->post('username', TRUE),
				'password' => md5($this->input->post('password', TRUE))
			);*/
		}
		public function lihatisitabelorderselect($select,$tabel,$where,$urutkolom, $tipeurut) {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			
			$this->db->select($select);
			$this->db->order_by($urutkolom, $tipeurut);
			$query = $this->db->get_where($tabel, $where);
			
			return $query;
			
			/* contoh datanya
			$data = array('username' => $this->input->post('username', TRUE),
				'password' => md5($this->input->post('password', TRUE))
			);*/
		}
		function update_data($where,$data,$table){///update semua tabel
			
			$this->db->where($where);
			return $this->db->update($table,$data);
			 
		}
		function hapus_data($where,$table){////hapus semua tabel
			
			$this->db->where($where);
			$this->db->delete($table);
			}
		function input_data($data,$table){ ///tambah data semua tabel
				
				return $this->db->insert($table,$data);
		}
		 

		public function tabelpaging($jumlahtampil,$mulaidari,$urutkolom,$tipeurut,$tabel,$where){//buat tampilan paging
		 		
				$this->db->order_by($urutkolom, $tipeurut);
				$this->db->where($where);
			    $query = $this->db->get($tabel,$jumlahtampil,$mulaidari);
				return $query;
		
		}	
		function query($data){ ///tambah data semua tabel
				
				$query = $this->db->query($data);
				return $query;
		}		
		
			public function lihatisitabellike($tabel,$title,$match,$after, $where) {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			
			$this->db->like($title,$match,$after); 
			$query = $this->db->get_where($tabel, $where);
			return $query;
			
			 
		}
		public function lihatisitabellikeorder($tabel,$title,$match,$after, $where,$urutkolom,$tipeurut) {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			
			$this->db->like($title,$match,$after);
			$this->db->order_by($urutkolom, $tipeurut);			
			$query = $this->db->get_where($tabel, $where);
			return $query;
			
			 
		}
		
public function lastid() {//bisa semua tabel pakai ->num_rows() untuk lihat isi pakai ->result(buat tampil
			 
			 $query = $this->db->insert_id();
			 
			return $query;
			
			 
		}
	
}



?>