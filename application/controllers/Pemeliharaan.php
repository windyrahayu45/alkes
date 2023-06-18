<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeliharaan extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_pemeliharaan','pemeliharaan');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'pemeliharaan','middle' => 'setting_data'));
		$this->auth->cek();
	}
	function index()
	{
		
		$data['page']='admin/pemeliharaan/index';
		$this->load->view('main_page/main',$data);

	}

	
	function get_data(){
		$list = $this->pemeliharaan->get_datatables();
		//echo $this->db->last_query();die;
		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->kode_barang;
			$row[] = $fetch->nama;
			$row[] = $fetch->nama_ruangan;
			// $row[] = $fetch->tgl_tindakan;
			// $row[] = $fetch->tgl_selesai;
			// $row[] = $fetch->nama_petugas;
			// $row[] = $fetch->ket;

			// if($fetch->kondisi_sesudah == 1){
			// 	$row[] = "Baik";
			// }
			// else if($fetch->kondisi_sesudah == 2){
			// 	$row[] = "Rusak Berat";
			// }
			// else{
			// 	$row[] = "Afkir";
			// }
			
			$row[] = '<a type="button"  class="btn btn-sm btn-primary" href="'.base_url("pemeliharaan/detail/".$fetch->kode_barang).'">Detail</a>';
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pemeliharaan->count_all(),
						"recordsFiltered" => $this->pemeliharaan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function detail($id_barang){
		//data_barang
		$this->db->select('*');
		$this->db->from('data_barang a');
        $this->db->join('ruangan c','a.id_ruangan=c.id_ruangan');
        $this->db->join('status_barang d','a.id_status=d.id_status');
        $this->db->where('a.id_barang',$id_barang);
        $query = $this->db->get();
		$data['barang']= $query->row();

		//berkala

		$this->db->select('*,x.nama as petugas');
		$this->db->from("pemeliharaan a");
		$this->db->join("petugas x","a.id_petugas = x.id_petugas",'left');
		$this->db->where('a.id_barang',$id_barang);
		$this->db->where('a.berkala', 'Ya');
		//$this->db->where('a.`kondisi_sesudah` IS NOT NULL ');
		$query = $this->db->get();
		$data['berkala']= $query->result();

		//echo $this->db->last_query();die;

		//berkala
		//$data['perbaikan']= $this->general2->lihatisitabel('pemeliharaan',['id_barang'=>$id_barang,'berkala'=>'Tidak'])->result();

		$this->db->select('*,x.nama as petugas');
		$this->db->from("pemeliharaan a");
		$this->db->join("petugas x","a.id_petugas = x.id_petugas",'left');
		$this->db->where('a.id_barang',$id_barang);
		$this->db->where('a.berkala', 'Tidak');

		$query = $this->db->get();
		$data['perbaikan']= $query->result();

		//berkala
		//$data['kalibrasi']= $this->general2->lihatisitabel('pemeliharaan',['id_barang'=>$id_barang,'berkala'=>'Tidak'])->result();
		$this->db->select('*,x.nama as petugas');
		$this->db->from("kalibrasi a");
		$this->db->join("petugas x","a.id_petugas = x.id_petugas",'left');
		$this->db->where('a.id_barang',$id_barang);
		$query = $this->db->get();
		$data['kalibrasi']= $query->result();
		//print_r($data['berkala']);die;
		$data['page']='admin/pemeliharaan/detail';
		$this->load->view('main_page/main',$data);
		
	}

	

	
	
	
}