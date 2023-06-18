<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_ruangan','ruangan');
		$this->session->set_flashdata(array('parent' => 'setting-menu','child' => 'history','middle' => 'setting-atur'));
		$this->auth->cek();
	}
	function index()
	{
		$data['history'] = $this->general2->lihatisitabel('history_pemeliharaan',null)->row();
		$data['page']='admin/history/index';
		$this->load->view('main_page/main',$data);

	}

	function save(){
		$data = $_POST;
		$where['id_history'] = 1;
		$insert = $this->general2->update_data($where,$data,'history_pemeliharaan');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}


	
	

	

	
	
	
}