<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Modul extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_modul','modul');
		$this->auth->cek('admin');
	}
	function index()
	{
		
		$data['page']='admin/modul/index';
		
		//print_r($data);die;
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'modul','middle' => 'setting_data'));
		$this->load->view('main_page/main',$data);
		
		
	}

	function get_data(){
		$list = $this->modul->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->modul;

			$token=$this->session->userdata('token');
			$hasil=$this->api->detail_instansi($fetch->instansi,$token);
			$datax=json_decode($hasil);
			
			$row[] = $datax[0]->nama_instansi;
			$row[] = $fetch->created_at;

			//add html for action
			$row[] = '
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_module('."'".$fetch->id."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->modul->count_all(),
						"recordsFiltered" => $this->modul->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		$data = $_POST;
		$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'modul');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function delete(){
		$where['id'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'modul');
		
		if(empty($delete))
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data dihapus!'));
		}
		else{
			echo json_encode(array('type' => 'warning','title' => 'Terjadi Kendala','msg' => 'Data gagal dihapus'));
		}
	}

	function modal()
	{
		$token=$this->session->userdata('token');
		$hasil=$this->api->list_uptd($token);
		$datax=json_decode($hasil);
		if(isset($datax->status)){
			$this->session->set_flashdata(array('type' => 'warning', 'title' => 'Gagal login', 'msg' => $data->status));
			
			redirect(site_url('Welcome/logout'));

		}
		else{
			$data['instansi']=$datax;
		}
		$this->load->view('admin/modul/modal',$data);
	}

	
	
}