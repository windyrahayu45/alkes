<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pengguna extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_pengguna','pengguna');
		$this->session->set_flashdata(array('parent' => 'pengguna'));

		$this->auth->cek();

	}
	function index()
	{
		
		
		$data['page']='admin/pengguna/index';
		$this->load->view('main_page/main',$data);

	}

	function get_data(){
		$list = $this->pengguna->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->nama;
			$row[] = $fetch->username;
			$row[] = $fetch->level;
			$row[] = $fetch->nama_ruangan;
			$row[] = $fetch->telp;
			$row[] = $fetch->nik;
			if($fetch->foto != null){
				$row[] = '<a href="'.base_url('upload/'.$fetch->foto).'" target="_blank" >Lihat Foto</a>';
			}else{
				$row[]='';
			}
			

			
			$row[] = '<a class="btn btn-primary btn-action mr-1" href="javascript:void()" title="Edit" data-toggle="tooltip" title data-original-title="Edit" onclick="edit_bidang('."'".$fetch->id_petugas."'".')"><i class="fas fa-pencil-alt"></i>
			<a class="btn btn-danger btn-action" href="javascript:void()" title="Hapus" data-toggle="tooltip" title data-original-title="Hapus"
			  onclick="delete_bidang('."'".$fetch->id_petugas."'".')"><i class="fas fa-trash"></i>';
		
			
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pengguna->count_all(),
						"recordsFiltered" => $this->pengguna->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function cekUsername(){
		$username = $this->input->post('username');
		
		$check_up = $this->general2->lihatisitabel('petugas',['username'=>$username]);
		
		
		if($check_up->num_rows()>0){
			$data['pesan'] = 'username sudah digunakan';
			$data['kode'] = 0;
		}
		else{
			$data['pesan'] = "username bisa digunakan";
			$data['kode'] = 1;
		}

		echo json_encode($data);
	}

	function save(){
		$data = $_POST;
		if($data['id_petugas'] == ''){
			$data['created_by']=$this->session->userdata('id_pegawai');
			$data['password'] = strrev(sha1($data['password']));
			if(!empty($_FILES['foto']['name'])){
				
				$fileName = $_FILES['foto']['name'];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));
				$allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'bmp');

				if (in_array($fileExtension, $allowedfileExtensions)) {
				$fileTmpPath = $_FILES['foto']['tmp_name'];
				$upl_dir = APPPATH.'../upload/';
				$x = str_replace("/","-",rand(100,100000));
				$newfilename = 'pendukung-'.$x.'.'.$fileExtension;
				$dest_path = $upl_dir . $newfilename;
					if(move_uploaded_file($fileTmpPath, $dest_path)){
						$data['foto']	= $newfilename;
					
					}

				}
				
			}



			$insert = $this->general2->input_data($data,'petugas');
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
		else{
			$where['id_petugas']=$data['id_petugas'];
			unset($data['id_petugas']);
			if($data['password'] != ''){
				$data['password'] = strrev(sha1($data['password']));
			}
			else{
				$check_up = $this->general2->lihatisitabel('petugas',['id_petugas'=>$data['id_petugas']])->row();
				$data['password'] = $check_up->password;
			}

			if(!empty($_FILES['foto']['name'])){
				
				$fileName = $_FILES['foto']['name'];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));
				$allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'bmp');

				if (in_array($fileExtension, $allowedfileExtensions)) {
				$fileTmpPath = $_FILES['foto']['tmp_name'];
				$upl_dir = APPPATH.'../upload/';
				$x = str_replace("/","-",rand(100,100000));
				$newfilename = 'pendukung-'.$x.'.'.$fileExtension;
				$dest_path = $upl_dir . $newfilename;
					if(move_uploaded_file($fileTmpPath, $dest_path)){
						$data['foto']	= $newfilename;
					
					}

				}
				
			}

			$insert = $this->general2->update_data($where,$data,'petugas');
			if($insert){
				echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
			}
			else{
				echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
			}
		}
	}

	
	function delete(){
		$where['id_petugas'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'petugas');
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

		$where['id_petugas'] = $this->input->post('id');
		$cek = $this->general2->lihatisitabel('petugas', $where);
		if($cek->num_rows() > 0){
			$data['petugas'] = $cek->row();
		}
		else{
			$data = null;
		}
		
		$data['ruangan']= $this->general2->lihatisitabel('ruangan',null)->result();
		
		$this->load->view('admin/pengguna/modal',$data);
	}

	
	
}