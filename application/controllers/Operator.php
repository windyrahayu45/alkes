<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Operator extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_operator','operator');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'operator','middle' => 'setting_data'));
		$this->auth->cek('admin');
	}
	function index()
	{
		
		$data['page']='admin/operator/index';
		
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
		$list = $this->operator->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->modul;

			$token=$this->session->userdata('token');
			$hasil=$this->api->detail_pegawai($fetch->id_pegawai,$token);
			$datax=json_decode($hasil);
			
			
			$row[] = $datax[0]->nama_lengkap;
			$row[] = $datax[0]->namauptd;
			$row[] = $fetch->created_at;

			//add html for action
			if($fetch->status==1){
				$type='checked';
			}
			else{
				$type='';
			}

			$row[] = '<label class="custom-switch"><input type="radio" name=""'.$fetch->id.'"" id="'.$fetch->id.'" onclick="change_state('."'".$fetch->id."'".','."'".$fetch->status."'".')" class="custom-switch-input" '.$type.'><span class="custom-switch-indicator"></span></label>';
		
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->operator->count_all(),
						"recordsFiltered" => $this->operator->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		$data = $_POST;
		$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'admin_modul');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function delete(){
		$status=$this->input->post('status');
		if($status==1){
			$data2['status'] = '0';
		}
		else{
			$data2['status'] = '1';
		}
		$where['id'] = $this->input->post('id');
		
		$update = $this->general2->update_data($where,$data2,'admin_modul');

		if($update)
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Peringatan!','msg' => 'Terjadi Kesalahan!'));
		}
	}

	function modal(){
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
		$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();
		$this->load->view('admin/operator/modal',$data);
	}

	
	
}