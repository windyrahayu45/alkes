<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Sistem extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_sistem','sistem');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'sistem','middle' => 'setting_data'));
		$this->auth->cek($this->session->userdata('level'));
	}
	function index()
	{
		
		$data['page']='admin/sistem/index';
		$this->load->view('main_page/main',$data);

	}

	function tambah(){

		$data['pertanyaan']=$this->db->query("select * from pertanyaan where (type_jawaban='3' or type_jawaban='4') and id not in (select pertanyaan_id from jawaban)")->result();
		// $this->db->select('*');
		// $this->db->from('pertanyaan');
		// $this->db->where('type_jawaban','3');
		// $this->db->or_where('type_jawaban','4');
		// $data['pertanyaan']=$this->db->get()->result();
		//echo $this->db->last_query();die;
		$data['page']='admin/tambah_opsi';
		$this->load->view('admin/main',$data);
	}

	function get_data(){
		$list = $this->sistem->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			
			$row = array();
			$row[] = $a;
			$row[] = $fetch->modul;
			if($fetch->sistem=='1'){
				$row[] = 'Tahunan';
				$row[] = $fetch->tahun;
			}
			else if($fetch->sistem=='2'){
				$row[] = 'Semester';
				$row[] = $fetch->bagian;
			}
			else if($fetch->sistem=='3'){
				$row[] = 'Tri wulan';
				$row[] = $fetch->bagian;
			}
			else{
				$row[] = 'Bulanan';
				$row[] = $fetch->bagian;
			}

			
			
			$row[] = $fetch->tahun;
			
			if($fetch->status==1){
				$type='checked';
			}
			else{
				$type='';
			}
			$row[] = '<label class="custom-switch"><input type="radio" name=""'.$fetch->id_sistem.'"" id="'.$fetch->id_sistem.'" onclick="change_state('."'".$fetch->id_sistem."'".','."'".$fetch->status."'".')" class="custom-switch-input" '.$type.'><span class="custom-switch-indicator"></span></label>';

			$row[] = '
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_bidang('."'".$fetch->id_sistem."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sistem->count_all(),
						"recordsFiltered" => $this->sistem->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		$this->db->query("update sistem set status = '0'");
		$data = $_POST;
		$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'sistem');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
		
	}

	function proses_edit(){


		$jawaban=$this->input->post('jawaban');
		$point=$this->input->post('point');
		$total=count($jawaban);

		//print_r($jawaban);die;
		$hapus = $this->general2->hapus_data(["pertanyaan_id"=>$this->input->post('pertanyaan_id')],'jawaban');

		for($i=0;$i<$total;$i++){
			$data=array();
			$data['pertanyaan_id']=$this->input->post('pertanyaan_id');
			$data['jawaban']=$jawaban[$i];
			$data['point']=$point[$i];
			$data['created_by']=$this->session->userdata('id_pegawai');
			$insert = $this->general2->input_data($data,'jawaban');
			
		}
		
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
			$this->db->query("update sistem set status = '0'");
			$data2['status'] = '1';
		}
		$where['id_sistem'] = $this->input->post('id');
		
		$update = $this->general2->update_data($where,$data2,'sistem');

		if($update)
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Peringatan!','msg' => 'Terjadi Kesalahan!'));
		}
	}

	function delete(){
		$where['id_sistem'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'sistem');
		//echo $delete;die;
		if(empty($delete))
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data dihapus!'));
		}
		else{
			echo json_encode(array('type' => 'warning','title' => 'Terjadi Kendala','msg' => 'Data gagal dihapus'));
		}
	}

	function edit($id_pertanyaan){
		
		
		
		$data['detail'] = $this->general2->lihatisitabel('jawaban',array('pertanyaan_id'=>$id_pertanyaan))->result();
		
		$data['pertanyaan']=$this->db->query("select * from pertanyaan where id='".$id_pertanyaan."'")->result();
		
		$data['page']='admin/edit_opsi';
		$this->load->view('admin/main',$data);		

		
	}

	function modal(){

	
		if($this->session->userdata('level')=='admin'){
			$data['modul'] = $this->general2->lihatisitabel('modul',null)->result();
		}
		else{
			$data['modul'] = $this->general2->lihatisitabel('modul',["id"=>$this->session->userdata('modul_id')])->result();
		}
		$this->load->view('admin/sistem/modal',$data);
	}

	
	
}