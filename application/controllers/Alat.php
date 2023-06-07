<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alat extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_alat','alat');
		$this->session->set_flashdata(array('parent' => 'alat'));
		$this->auth->cek();
	}
	function index()
	{
		
		$data['page']='admin/alat/index';
		$this->load->view('main_page/main',$data);

	}

	function tambah(){

		$data['ruangan']= $this->general2->lihatisitabel('ruangan',null)->result();
		$data['status']= $this->general2->lihatisitabel('status_barang',null)->result();
		
		$data['page']='admin/alat/tambah';
		$this->load->view('main_page/main',$data);
	}

	function edit($id_barang){

		$data['ruangan']= $this->general2->lihatisitabel('ruangan',null)->result();
		$data['status']= $this->general2->lihatisitabel('status_barang',null)->result();

		$data['id_barang']= $this->general2->lihatisitabel('data_barang',['id_barang'=>$id_barang])->row();
		
		$data['page']='admin/alat/tambah';
		$this->load->view('main_page/main',$data);
	}

	function get_data(){
		$list = $this->alat->get_datatables();

		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->id_barang;
			$row[] = $fetch->nama;
			$row[] = $fetch->merk;
			$row[] = $fetch->type;
			$row[] = $fetch->SN;
			$row[] = $fetch->tahun;
			$row[] = $fetch->nama_ruangan;
			$row[] = $fetch->harga;
			$row[] = $fetch->status_barang;
			$row[] = '<img src="'.base_url('qrcode/'.$fetch->id_barang.'.png').'"></img>';

						
			$row[] = '
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Afkir" 
				  onclick="delete_bidang('."'".$fetch->id_barang."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Afkir</a>
				  <a type="button"  class="btn btn-sm btn-primary" href="'.base_url("alat/edit/".$fetch->id_barang).'">Edit</a>';
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->alat->count_all(),
						"recordsFiltered" => $this->alat->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		
		
		if($this->input->post('id_barang') == ''){
			$total=$this->input->post('stok');
			$data['jenis_barang'] = $this->random_jenis();
			for($i=0;$i<$total;$i++){
				$data=array();
				$data['nama'] = $this->input->post('nama');
				$data['merk'] = $this->input->post('merk');
				$data['type'] = $this->input->post('type');
				$data['SN'] = $this->input->post('sn');
				$data['tahun'] = $this->input->post('tahun');
				$data['harga'] = str_replace(array("Rp", "."), array("", ""), $this->input->post('harga')); 
				;
				$data['id_ruangan'] = $this->input->post('id_ruangan');
				$data['link'] = $this->input->post('link');
				$data['tgl'] = date('Y-m-d');
				$data['id_status'] = $this->input->post('id_status');
				$data['created_by'] = $this->session->userdata('username');
				
				$data['id_barang'] = $this->random_string();
				$insert = $this->general2->input_data($data,'data_barang');

				//generate qrcode

				$this->load->library('qr_code');
				$file_name = $data['id_barang'].'.pdf';
				$generate = $this->qr_code->generate($file_name,$data['id_barang']);
				
			}
			
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
		else{
			//$data = $_POST;
			$where['id_barang'] =$this->input->post('id_barang');
			
			$data['nama'] = $this->input->post('nama');
			$data['merk'] = $this->input->post('merk');
			$data['type'] = $this->input->post('type');
			$data['SN'] = $this->input->post('sn');
			$data['tahun'] = $this->input->post('tahun');
			$data['harga'] = str_replace(array("Rp", "."), array("", ""), $this->input->post('harga')); 
			;
			$data['id_ruangan'] = $this->input->post('id_ruangan');
			$data['link'] = $this->input->post('link');
			$data['tgl'] = date('Y-m-d');
			$data['id_status'] = $this->input->post('id_status');
			$data['updated_by'] = $this->session->userdata('username');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$insert = $this->general2->update_data($where,$data,'data_barang');
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
		
		
	}

	function random_jenis(){
		return "GDG-".rand(100,100000);
	}

	function random_string() {
	    $first = 'KD-';
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		
		  
	    for ($i = 0; $i < 6; $i++) {
	        $index = rand(0, strlen($characters) - 1);
	        $first .= $characters[$index];
	    }
	  
	    return $first;
		
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


	function modal()
	{
		$data['id_barang'] = $this->input->post('id');
		$this->load->view('admin/alat/modal',$data);
	}

	function delete(){
		$data = $_POST;
		$data['tgl'] = date('Y-m-d');
		$data['created_by']=$this->session->userdata('id_pegawai');
		$data['id_petugas']=$this->session->userdata('id_petugas');
		$insert = $this->general2->input_data($data,'afkir');
		if($insert)
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Masuk afkir!'));
		}
		else{
			echo json_encode(array('type' => 'warning','title' => 'Terjadi Kendala','msg' => 'Data gagal dihapus'));
		}
	}

	
	
	
}