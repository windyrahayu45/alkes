<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kondisi extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->session->set_flashdata(array('parent' => 'kondisi'));
		$this->auth->cek();
		$this->load->model('mv_kondisi','kondisi');
		
		
	}
	function index()
	{
		$data['status_barang']= $this->general2->lihatisitabel('status_barang',null)->result();
		$data['page']='admin/kondisi/index';
		$this->load->view('main_page/main',$data);	
	}

	
	function get_data(){
		$list = $this->kondisi->get_datatables();

		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->nama;
			$row[] = $fetch->merk;
			$row[] = $fetch->type;
			$row[] = $fetch->SN;
			$row[] = $fetch->tahun;
			$row[] = $fetch->nama_ruangan;
			$row[] = $fetch->harga;
			$row[] = $fetch->status_barang;
			
						
			
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kondisi->count_all(),
						"recordsFiltered" => $this->kondisi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	



	



	
	

	
	
}