<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kalibrasi extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_kalibrasi','kalibrasi');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'kalibrasi','middle' => 'setting_data'));
		$this->auth->cek();
	}
	function index()
	{
		
		$data['page']='admin/kalibrasi/index';
		$this->load->view('main_page/main',$data);

	}

	
	function get_data(){
		$list = $this->kalibrasi->get_datatables();

		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->id_barang;
			$row[] = $fetch->nama;
			$row[] = $fetch->merk;
			$row[] = $fetch->type;
			$row[] = $fetch->SN;
			$row[] = $fetch->nama_ruangan;
			$row[] = $fetch->tgl;
			$row[] = $fetch->pelaksana;
			$row[] = $fetch->kondisi;

			
			
		
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kalibrasi->count_all(),
						"recordsFiltered" => $this->kalibrasi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	

	
	
	
}