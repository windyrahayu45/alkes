<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Peralatan extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->session->set_flashdata(array('parent' => 'peralatan'));
		$this->auth->cek();
		$this->load->model('mv_peralatan','peralatan');
		
		
	}
	function index()
	{
		$data['ruangan']= $this->general2->lihatisitabel('ruangan',null)->result();
		$data['page']='admin/peralatan/index';
		$this->load->view('main_page/main',$data);	
	}

	
	function get_data(){
		$list = $this->peralatan->get_datatables();

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
						"recordsTotal" => $this->peralatan->count_all(),
						"recordsFiltered" => $this->peralatan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	



	



	
	

	
	
}