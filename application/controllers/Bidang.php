<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Bidang extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_bidang','bidang');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'bidang','middle' => 'setting_data'));

		$this->auth->cek($this->session->userdata('level'));

	}
	function index()
	{
		//$this->auth->cek('admin');

		
		$data['page']='admin/bidang/index';
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

		
		
		$data['pertanyaan'] = $this->general2->lihatisitabel('pertanyaan',array('status'=>'1'))->result();
		
		
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

	function get_pertanyaan($id){
		
		$datax= $this->general2->lihatisitabel('set_pertanyaan',array('bidang_id'=>$id))->result();

		$result = array();
		foreach($datax as $fetch){
			$data = array();
			$data = $fetch->pertanyaan_id;
			$result[] = $data;
		}

		echo json_encode($result);
	}

	function get_list(){
		$id=$this->input->post('id');
		$data['judul']=$this->input->post('judul');
		$this->db->select('*');
		$this->db->from("set_pertanyaan");
		$this->db->join("pertanyaan","set_pertanyaan.pertanyaan_id=pertanyaan.id");
		$this->db->where('bidang_id',$id);
		$datax=$this->db->get()->result();
		//$datax= $this->general2->lihatisitabel('set_pertanyaan',array('bidang_id'=>$id))->result();

		$data['list'] ="";
		$no=1;
		foreach($datax as $fetch){
			
			$data['list'].=$no++.' . '. $fetch->pertanyaan.'<br>';
			
			
		}
		
		//$data['list'] = $result;
		//print_r($data);die;

		$this->load->view('admin/bidang/modal_list',$data);
	}

	function get_data(){
		$list = $this->bidang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->modul;
			$row[] = $fetch->judul;
			$row[] = $fetch->created_at;

			//add html for action
			if($fetch->status==1){
				$type='checked';
			}
			else{
				$type='';
			}

			$cek_pertanyaan= $this->general2->lihatisitabel('set_pertanyaan',array('bidang_id'=>$fetch->id))->num_rows();

			if($cek_pertanyaan>0){
				$list='<a class="btn btn-warning btn-action mr-1" href="javascript:void()" data-toggle="tooltip" title="List Pertanyaan"  data-original-title="List Pertanyaan" 
				  onclick="list_bidang('."'".$fetch->id."'".','."'".$fetch->judul."'".')">
				  <i class="far fa-file"></i> </a>';
			}
			else{
				$list='';
			}

			$row[] = '<label class="custom-switch"><input type="radio" name=""'.$fetch->id.'"" id="'.$fetch->id.'" onclick="change_state('."'".$fetch->id."'".','."'".$fetch->status."'".')" class="custom-switch-input" '.$type.'><span class="custom-switch-indicator"></span></label>';
			if($this->session->userdata('modul_id')!=0){
				$row[] = '
				<a style ="margin:5px" class="btn btn-info btn-action mr-1" href="javascript:void()" data-toggle="tooltip" title="Atur Pertanyaan"  data-original-title="Atur Pertanyaan" 
				  onclick="set_bidang('."'".$fetch->id."'".','."'".$fetch->judul."'".')">
				  <i class="fas fa-info-circle"></i> </a>'.$list;
			}
			else{
				$row[] = '<a class="btn btn-primary btn-action mr-1" href="javascript:void()" title="Edit" data-toggle="tooltip" title data-original-title="Edit" onclick="edit_bidang('."'".$fetch->id."'".')"><i class="fas fa-pencil-alt"></i>
				<a class="btn btn-danger btn-action" href="javascript:void()" title="Hapus" data-toggle="tooltip" title data-original-title="Hapus"
				  onclick="delete_bidang('."'".$fetch->id."'".')"><i class="fas fa-trash"></i>
				<a style ="margin:5px" class="btn btn-info btn-action mr-1" href="javascript:void()" data-toggle="tooltip" title="Atur Pertanyaan"  data-original-title="Atur Pertanyaan" 
				  onclick="set_bidang('."'".$fetch->id."'".','."'".$fetch->judul."'".')">
				  <i class="fas fa-info-circle"></i> </a>'.$list;
			}
			
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->bidang->count_all(),
						"recordsFiltered" => $this->bidang->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		$data = $_POST;
		if($data['id'] == ''){
			$data['created_by']=$this->session->userdata('id_pegawai');
			$insert = $this->general2->input_data($data,'bidang');
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
		else{
			$where['id']=$data['id'];
			unset($data['id']);
			$insert = $this->general2->update_data($where,$data,'bidang');
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
	}

	function save_pertanyaan(){

		$where['bidang_id'] = $this->input->post('id_bidang');
		$delete = $this->general2->hapus_data($where,'set_pertanyaan');

		$pertanyaan=$this->input->post('pertanyaan_id');
		
		$total=count($pertanyaan);
		for($i=0;$i<$total;$i++){
			$data=array();
			$data['bidang_id']=$this->input->post('id_bidang');
			$data['pertanyaan_id']=$pertanyaan[$i];
			$data['created_by']=$this->session->userdata('id_pegawai');
			$insert = $this->general2->input_data($data,'set_pertanyaan');
		}
		// $data = $_POST;
		// $data['created_by']=$this->session->userdata('id_pegawai');
		// $insert = $this->general2->input_data($data,'bidang');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
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
		
		$update = $this->general2->update_data($where,$data2,'bidang');

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
		$delete = $this->general2->hapus_data($where,'bidang');
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
		$data['detail'] = $this->general2->lihatisitabel('bidang',array('id'=>$id))->row();
		$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();
		

		echo json_encode($data);

	}

	function modal(){

		$where['id'] = $this->input->post('id');
		$cek = $this->general2->lihatisitabel('bidang', $where);
		if($cek->num_rows() > 0){
			$data['bidang'] = $cek->row();
		}
		else{
			$data = null;
		}
		//print_r($data['bidang']);die;
		if($this->session->userdata('modul_id')!=0){
			$data['modul'] = $this->general2->lihatisitabel('modul',array('id'=>$this->session->userdata('modul_id')))->result();
		}
		else{
			$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();
		}

		//$data['tipe'] = $this->general2->lihatisitabel('type',null)->result();
		$this->load->view('admin/bidang/modal',$data);
	}

	
	
}