<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('mv_ruangan','ruangan');
		$this->session->set_flashdata(array('parent' => 'setting-menu','child' => 'ruangan','middle' => 'setting-atur'));
		$this->auth->cek();
	}
	function index()
	{
		
		$data['page']='admin/ruangan/index';
		$this->load->view('main_page/main',$data);

	}

	
	function get_data(){
		$list = $this->ruangan->get_datatables();
		//echo $this->db->last_query();die;
		$data = array();
		$no = $_POST['start'];
		$x = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $x;
			$row[] = $fetch->nama_ruangan;
			// $row[] = $fetch->tgl_tindakan;
			// $row[] = $fetch->tgl_selesai;
			// $row[] = $fetch->nama_petugas;
			// $row[] = $fetch->ket;

			// if($fetch->kondisi_sesudah == 1){
			// 	$row[] = "Baik";
			// }
			// else if($fetch->kondisi_sesudah == 2){
			// 	$row[] = "Rusak Berat";
			// }
			// else{
			// 	$row[] = "Afkir";
			// }
			
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_bidang('."'".$fetch->id_ruangan."'".')">
				  <i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
			$x++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->ruangan->count_all(),
						"recordsFiltered" => $this->ruangan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function save(){
		$data = $_POST;
		//$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'ruangan');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function delete(){
		$where['id_ruangan'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'ruangan');
		//echo $delete;die;
		if(empty($delete))
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data dihapus!'));
		}
		else{
			echo json_encode(array('type' => 'warning','title' => 'Terjadi Kendala','msg' => 'Data gagal dihapus'));
		}
	}

	

	
	
	
}