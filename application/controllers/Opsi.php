<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Opsi extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_opsi','opsi');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'opsi','middle' => 'setting_data'));
		$this->auth->cek($this->session->userdata('level'));
	}
	function index()
	{
		//$this->auth->cek('admin');
		$data['page']='admin/opsi/index';
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
		$data['page']='admin/opsi/tambah';
		$this->load->view('main_page/main',$data);
	}

	function get_data(){
		$list = $this->opsi->get_datatables();

		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->pertanyaan;
			$row[] = $fetch->type_jawaban;

			$jawaban= $this->general2->lihatisitabel('jawaban',array('pertanyaan_id'=>$fetch->id))->result();

			$getJwb='';
			$getPoint='';
			$a=1;
			$b=1;
			foreach ($jawaban as $key ) {
				$getJwb.=$a++.'. '.$key->jawaban.'<br>';
				$getPoint.=$b++.'. '.$key->point.'<br>';
				//$res[]=$get;
			}

			$row[] = $getJwb;
			$row[] = $getPoint;

						
			$row[] = '
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_bidang('."'".$fetch->id."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a><a type="button"  class="btn btn-sm btn-primary" href="'.base_url("opsi/edit/".$fetch->id).'">Edit</a>
';
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->opsi->count_all(),
						"recordsFiltered" => $this->opsi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		
		$jawaban=$this->input->post('jawaban');
		$point=$this->input->post('point');
		
		$total=count($jawaban);

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
		$where['pertanyaan_id'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'jawaban');
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
		
		$data['page']='admin/opsi/edit';
		$this->load->view('main_page/main',$data);		

		
	}

	
	
}