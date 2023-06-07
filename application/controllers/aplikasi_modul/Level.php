<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Level extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('modul/mv_level','level');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'level','middle' => 'setting_data'));
		$this->auth->cek($this->session->userdata('level'));
	}
	function index()
	{

		


		//$this->auth->cek('admin_modul');
		$data['page']='aplikasi_modul/level/index';
		$data['title']="Level akses di masing-masing modul";
		
		
		$this->load->view('main_page/main',$data);

	}

	function save(){
		$data = $_POST;
		//$data['modul_id']=$this->session->userdata('modul_id');
		$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'level_modul');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function get_data(){
		$list = $this->level->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->modul;
			$row[] = $fetch->level;
			$row[] = $fetch->ket;
			if($this->session->userdata('level')=='admin'){
			$row[] = '
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_level('."'".$fetch->id_level."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a>';
			}
			else{
				$row[]='';
			}
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->level->count_all(),
						"recordsFiltered" => $this->level->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function delete(){
		$where['id_level'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'level_modul');
		//echo $delete;die;
		if(empty($delete))
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data dihapus!'));
		}
		else{
			echo json_encode(array('type' => 'warning','title' => 'Terjadi Kendala','msg' => 'Data gagal dihapus'));
		}
	}

	function modal(){

		
		$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();

		$this->load->view('aplikasi_modul/level/modal',$data);
	}
	
	
}