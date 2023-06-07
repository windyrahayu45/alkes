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

		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->nama;
			$row[] = $fetch->nama_ruangan;
			$row[] = $fetch->tgl_tindakan;
			$row[] = $fetch->tgl_selesai;
			$row[] = $fetch->nama_petugas;
			$row[] = $fetch->ket;

			if($fetch->kondisi_sesudah == 1){
				$row[] = "Baik";
			}
			else if($fetch->kondisi_sesudah == 2){
				$row[] = "Rusak Berat";
			}
			else{
				$row[] = "Afkir";
			}
			
		
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

	

	
	
	
}