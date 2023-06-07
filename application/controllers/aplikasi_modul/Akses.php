<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Akses extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('modul/mv_akses','akses');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'akses','middle' => 'setting_data'));
		$this->auth->cek('admin_modul');
	}
	function index()
	{
		
		$data['page']='aplikasi_modul/akses/index';
		$data['title']=$this->general2->lihatisitabel('modul',array('id'=>$this->session->userdata('modul_id')))->row()->modul;
		
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

	function save(){
		$data['id_level']=$this->input->post('level');
		$data['id_pegawai']=$this->input->post('id_pegawai');
		$data['modul_id']=$this->session->userdata('modul_id');
		$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'akses_modul');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function get_data(){
		$list = $this->akses->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		ob_start();
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->level;
			
			$token=$this->session->userdata('token');
			$hasil=$this->api->detail_pegawai($fetch->id_pegawai,$token);

			$datax=json_decode($hasil);
			//print_r($datax);
			//print_r($datax[0]->nama_lengkap);die;
			if($datax==null || $datax==''){
				$row[] = '';
				$row[] = '';
				
			}
			else{
				$row[] = $datax[0]->nama_lengkap;
				$row[] = $datax[0]->namauptd;
			}
			
			
			$row[] = '
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_level('."'".$fetch->id_akses."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
			$a++;
		}
		ob_get_clean(); 

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->akses->count_all(),
						"recordsFiltered" => $this->akses->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function delete(){
		$where['id_akses'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'akses_modul');
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

		$data['level']=$this->general2->lihatisitabel('level_modul',array('modul_id'=>$this->session->userdata('modul_id')))->result();

		$this->load->view('aplikasi_modul/akses/modal',$data);
	}
	
	
}