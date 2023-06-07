<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Afkir extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_afkir','afkir');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'afkir','middle' => 'setting_data'));
		$this->auth->cek();
	}
	function index()
	{
		
		$data['page']='admin/afkir/index';
		$this->load->view('main_page/main',$data);

	}

	
	function get_data(){
		$list = $this->afkir->get_datatables();

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
			$row[] = $fetch->tgl;
			$row[] = $fetch->nama_ruangan;
			$row[] = $fetch->status_barang." / ". $fetch->ket ;
			$row[] = $fetch->nama;
		
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->afkir->count_all(),
						"recordsFiltered" => $this->afkir->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	

	
	
	
}