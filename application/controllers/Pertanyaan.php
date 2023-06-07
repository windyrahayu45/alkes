<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pertanyaan extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_pertanyaan','pertanyaan');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'pertanyaan','middle' => 'setting_data'));
		$this->auth->cek($this->session->userdata('level'));
	}
	function index()
	{
		
		
		$data['page']='admin/pertanyaan/index';
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
		
		
		
		$data['tipe'] = $this->general2->lihatisitabel('type',null)->result();
		$data['urusan'] = $this->general2->lihatisitabel('urusan_spbe',null)->result();
		if($this->session->userdata('level')=='admin'){
			$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();
		}
		else{
			$data['modul'] = $this->general2->lihatisitabel('modul',["id"=>$this->session->userdata('modul_id')])->result();
		}
		$this->load->view('main_page/main',$data);

	}

	function get_bidang($modul_id){
		$datax = $this->general2->lihatisitabel('bidang',array('modul_id'=>$modul_id,'status'=>'1'))->result();

		$result = array();
		foreach($datax as $fetch){
			$data = array();
			$data['id_bidang'] = $fetch->id;
			$data['bidang'] = $fetch->judul;
			$result[] = $data;
		}
		
		
		echo json_encode($result);
	}

	function get_data(){
		$list = $this->pertanyaan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			// $row[] = $fetch->modul;
			// $row[] = $fetch->judul;
			$row[] = $fetch->pertanyaan;
			$row[] = $fetch->type_jawaban;
			// if($fetch->wajib==1){
			// 	$row[] = 'Ya';
			// }
			// else{
			// 	$row[] = 'Tidak';
			// }
			if($fetch->status==1){
				$type='checked';
			}
			else{
				$type='';
			}
			$row[] = '<label class="custom-switch"><input type="radio" name=""'.$fetch->id.'"" id="'.$fetch->id.'" onclick="change_state('."'".$fetch->id."'".','."'".$fetch->status."'".')" class="custom-switch-input" '.$type.'><span class="custom-switch-indicator"></span></label>';

			// <a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" 
			// 			onclick="edit_bidang('."'".$fetch->id."'".')">
			// 			<i class="glyphicon glyphicon-pencil"></i> Edit</a>
			// </a> <a class="btn  btn-info" href="javascript:void()" title="Info" 
			// 	  onclick="delete_bidang('."'".$fetch->id."'".')">
			// 	  <i class="fas fa-info-circle"></i> </a>
			// <a class="btn  btn-danger" href="javascript:void()" title="Hapus" 
			// 	  onclick="delete_bidang('."'".$fetch->id."'".')">
			// 	  <i class="fas fa-trash"></i> </a>
			$row[] = '
				  
				  <a class="btn  btn-primary" href="javascript:void()" title="Edit" 
				  onclick="edit_bidang('."'".$fetch->id."'".')">
				  <i class="fas fa-pencil-alt"></i>
				   ';
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pertanyaan->count_all(),
						"recordsFiltered" => $this->pertanyaan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		//$data = $_POST;
		$data['created_by'] = $this->session->userdata('id_pegawai');
		$data['pertanyaan'] = $this->input->post('pertanyaan');
		$data['type_jawaban'] = $this->input->post('type_jawaban');
		$data['wajib'] = $this->input->post('wajib');
		$data['urutan'] = $this->input->post('urutan');
		$data['point'] = $this->input->post('point');
		$data['slug'] =  strtolower(str_replace(" ","_",$data['pertanyaan']));
		$insert = $this->general2->input_data($data,'pertanyaan');
		$insert_id = $this->db->insert_id();
		$bidang['bidang_id'] = $this->input->post('bidang_id');
		$bidang['pertanyaan_id'] = $insert_id;

		$var1 = array('instansi' =>$this->input->post('instansi'));
		
		$bidang['instansi'] = json_encode($var1);
		$bidang['id_urusan'] = $this->input->post('urusan');
		if($this->input->post('pokja')!=null){
			$bidang['pokja'] = $this->input->post('pokja');
		}
		$insert = $this->general2->input_data($bidang,'set_pertanyaan');


		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function proses_edit(){
		$where['id']=$this->input->post('id');
		
		
		$data['pertanyaan']=$this->input->post('pertanyaan_edit');
		$data['urutan']=$this->input->post('urutan_edit');
		$data['point']=$this->input->post('point_edit');
		$data['type_jawaban']=$this->input->post('type_jawaban_edit');
		$data['updated_by']=$this->session->userdata('id_pegawai');
		$data['updated_at']=date('Y-m-d H:i:s');
		//$data['slug'] =  strtolower(str_replace(" ","_",$data['pertanyaan']));
		$insert = $this->general2->update_data($where,$data,'pertanyaan');

		$bidang['bidang_id'] = $this->input->post('bidang_id_edit');
		

		$var1 = array('instansi' =>$this->input->post('instansi_edit'));
		
		$bidang['instansi'] = json_encode($var1);
		$bidang['id_urusan'] = $this->input->post('urusan_edit');
		if($this->input->post('pokja')!=null){
			$bidang['pokja'] = $this->input->post('pokja_edit');
		}
		$insert = $this->general2->update_data($where,$bidang,'set_pertanyaan');
		$bidang['updated_by']=$this->session->userdata('id_pegawai');
		$bidang['updated_at']=date('Y-m-d H:i:s');

		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function change(){
		$status=$this->input->post('status');
		if($status==1){
			$data2['status'] = '0';
		}
		else{
			$data2['status'] = '1';
		}
		$where['id'] = $this->input->post('id');
		
		$update = $this->general2->update_data($where,$data2,'pertanyaan');

		if($update)
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Peringatan!','msg' => 'Terjadi Kesalahan!'));
		}
	}

	function delete(){
		$where['id'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'pertanyaan');
		$where2['pertanyaan_id'] = $this->input->post('id');
		$delete2 = $this->general2->hapus_data($where,'set_pertanyaan');
		//echo $delete;die;
		if(empty($delete))
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data dihapus!'));
		}
		else{
			echo json_encode(array('type' => 'warning','title' => 'Terjadi Kendala','msg' => 'Data gagal dihapus'));
		}
	}

	function edit(){
		$id=$this->input->post('id');
		
		$data = array();
		$data['detail'] = $this->general2->lihatisitabel('pertanyaan',array('id'=>$id))->row();
		$data['set_pertanyaan'] = $this->general2->lihatisitabel('set_pertanyaan',["pertanyaan_id"=>$id])->row();
		$data['modul_id']=$this->general2->lihatisitabel('bidang',["id"=>$data['set_pertanyaan']->bidang_id])->row()->modul_id;

		$instansi=$data['set_pertanyaan']->instansi;
		if($instansi!='{"instansi":null}'){
			$decode_data=json_decode($instansi ,true);
			$row=array();
			foreach ($decode_data['instansi'] as $jwb) {
				$row[]=$jwb;
			}
			$data['instansi']= $row;
		}
		else{
			$data['instansi']=null;
		}
		
		

		echo json_encode($data);

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
		
		
		
		$data['tipe'] = $this->general2->lihatisitabel('type',null)->result();
		$data['urusan'] = $this->general2->lihatisitabel('urusan_spbe',null)->result();
		if($this->session->userdata('level')=='admin'){
			$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();
		}
		else{
			$data['modul'] = $this->general2->lihatisitabel('modul',["id"=>$this->session->userdata('modul_id')])->result();
		}
		$this->load->view('admin/pertanyaan/modal',$data);
	}

	
	
}