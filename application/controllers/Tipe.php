<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Tipe extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_tipe','tipe');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'tipe','middle' => 'setting_data'));
		$this->auth->cek('admin');
	}
	function index()
	{
		
		$data['page']='admin/tipe/index';
		$this->load->view('main_page/main',$data);

	}

	function get_pegawai($id_instansi){
		$token=$this->session->userdata('token');
		$hasil=$this->api->pegawai_uptd($id_instansi,$token);
		$datax=json_decode($hasil);

		$result = array();
		foreach($datax as $fetch){
			$data = array();
			$data['id_pegawai'] = $fetch->id_pegawai;
			$data['nama'] = $fetch->nama_tanpa_gelar;
			$result[] = $data;
		}
		
		
		echo json_encode($result);
	}

	function get_data(){
		$list = $this->tipe->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->type_jawaban;
			$row[] = $fetch->created_at;

			
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" 
						onclick="edit_bidang('."'".$fetch->id_type."'".')">
						<i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_bidang('."'".$fetch->id_type."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tipe->count_all(),
						"recordsFiltered" => $this->tipe->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		$data = $_POST;
		if($data['id_type'] == ''){
			$data['created_by']=$this->session->userdata('id_pegawai');
			$insert = $this->general2->input_data($data,'type');

			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
		else{

			$where['id_type']=$data['id_type'];
			unset($data['id_type']);
		
			$insert = $this->general2->update_data($where,$data,'type');
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}

		}
	}

	
	

	function delete(){
		$where['id_type'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'type');
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

		$where['id_type'] = $this->input->post('id');
		$cek = $this->general2->lihatisitabel('type', $where);
		if($cek->num_rows() > 0){
			$data['tipe'] = $cek->row();
		}
		else{
			$data = null;
		}

		//$data['tipe'] = $this->general2->lihatisitabel('type',null)->result();
		$this->load->view('admin/tipe/modal',$data);
	}

	
	
}