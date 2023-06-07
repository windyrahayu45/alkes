<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Ketua_rt extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('modul/mv_kader','kader');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'kader','middle' => 'setting_data'));
		$this->auth->cek($this->session->userdata('level'));
	}
	function index()
	{
		

		//$this->auth->cek('admin_modul');
		$data['page']='aplikasi_modul/kader';
		$data['title']="Kader Dasawisma";
		

		if($this->session->userdata('level')=='Kelurahan'){
			$token=$this->session->userdata('token');
			$id_pegawai=$this->session->userdata('id_pegawai');
			$hasil=$this->api->detail_pegawai($id_pegawai,$token);
			$datax=json_decode($hasil);

			if(isset($datax->status)){
				$this->session->set_flashdata(array('type' => 'warning', 'title' => 'gagal mengambil asal instansi', 'msg' => $datax->message));
				//redirect(site_url('Welcome/logout'));
			}
			else{
				//var_dump($datax[0]->namauptd);die;
				$nama_instansi=$datax[0]->namauptd;
				$result = str_replace("KELURAHAN ","",$nama_instansi);
				
				$this->db->from('kelurahan');
				$this->db->like('kelurahan',$result);
				$final_res = $this->db->get();

				//echo $this->db->last_query();die;
				if($final_res->num_rows()>0){
					$data['kelurahan']= $final_res->result();
					$this->session->set_userdata(['id_kel'=>$final_res->row()->id]);
				}
				else{
					$this->session->set_flashdata(array('type' => 'warning', 'title' => 'Peringatan', 'msg' => 'anda bukan dari kelurahan manapun'));
				//redirect(site_url('Welcome/logout'));

				}
			}
		}
		else{
			$data['kelurahan'] = $this->general2->lihatisitabel('kelurahan',null)->result();
		}


		$this->load->view('main_page/main',$data);

	}

	function get_rw($id_kelurahan){
		
		$this->db->group_by('rw');
		$result = $this->general2->lihatisitabel('zona',["id_kel"=>$id_kelurahan])->result();
		//echo $this->db->last_query();die;
		$row = array();
		foreach($result as $fetch){
			$data = array();
			$data['rw'] = $fetch->rw;
			
			$row[] = $data;
		}
		
		
		echo json_encode($row);
	}

	function get_rt($rw,$kelurahan){
		
		
		$result = $this->general2->lihatisitabel('zona',["id_kel"=>$kelurahan,"rw"=>$rw])->result();
		//echo $this->db->last_query();die;
		$row = array();
		foreach($result as $fetch){
			$data = array();
			$data['rt'] = $fetch->rt;
			
			$row[] = $data;
		}
		
		
		echo json_encode($row);
	}

	function change_status(){
		$status=$this->input->post('status');
		if($status==1){
			$data2['status'] = '0';
		}
		else{
			$data2['status'] = '1';
		}
		$where['id'] = $this->input->post('id');
		
		$update = $this->general2->update_data($where,$data2,'kader_dasawisma');

		if($update)
		{
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Peringatan!','msg' => 'Terjadi Kesalahan!'));
		}
	}

	function change(){
		$username = $this->input->post('username');
		$id = $this->input->post('id');

		if($id==null){
			$check_up = $this->general2->lihatisitabel('kader_dasawisma',['username'=>$username]);
		}
		else{
			$check = $this->general2->lihatisitabel('kader_dasawisma',['id'=>$id]);
			if($check->row()->username != $username){
				$check_up = $this->general2->lihatisitabel('kader_dasawisma',['username'=>$username]);
			}
			else{
				$data['pesan'] = "username bisa digunakan";
				$data['kode'] = 1;
				echo json_encode($data);
				die;
			}
		}
		
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
		$data['password'] =  strrev(sha1($this->input->post('password',true)));
		$data['created_by']=$this->session->userdata('id_pegawai');
		$insert = $this->general2->input_data($data,'kader_dasawisma');
		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data disimpan!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function get_data(){
		$list = $this->kader->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			$row[] = $fetch->nama;
			$row[] = $fetch->dasawisma;
			$row[] = $fetch->telp;
			$row[] = $fetch->alamat. " RW." .$fetch->rw. " RT." .$fetch->rt.  " , Kel." .$fetch->kelurahan;
			if($fetch->status==1){
				$type='checked';
			}
			else{
				$type='';
			}
			$row[] = '<label class="custom-switch"><input type="radio" name=""'.$fetch->id.'"" id="'.$fetch->id.'" onclick="change_state('."'".$fetch->id."'".','."'".$fetch->status."'".')" class="custom-switch-input" '.$type.'><span class="custom-switch-indicator"></span></label>';
			$row[] = '
				  <a class="btn btn-danger" href="javascript:void()" title="Hapus" 
				  onclick="delete_level('."'".$fetch->id."'".')">
				  <i class="fas fa-trash"></i> </a>
				  <a class="btn  btn-primary" href="javascript:void()" title="Edit" 
				  onclick="edit_bidang('."'".$fetch->id."'".')">
				  <i class="fas fa-pencil-alt"></i> </a>';
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kader->count_all(),
						"recordsFiltered" => $this->kader->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function delete(){
		$where['id'] = $this->input->post('id');
		$delete = $this->general2->hapus_data($where,'kader_dasawisma');
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
		$data['detail'] = $this->general2->lihatisitabel('kader_dasawisma',array('id'=>$id))->row();
		
		

		echo json_encode($data);

	}

	function proses_edit(){
		$where['id']=$this->input->post('id_edit');
		
		
		$data['nama']=$this->input->post('nama_edit');
		$data['dasawisma']=$this->input->post('dasawisma_edit');
		$data['alamat']=$this->input->post('alamat_edit');
		$data['kelurahan']=$this->input->post('kelurahan_edit');
		$data['rw']=$this->input->post('rw_edit');
		$data['rt']=$this->input->post('rt_edit');
		$data['username']=$this->input->post('username_edit');
		$data['updated_by']=$this->session->userdata('id_pegawai');
		$data['updated_at']=date('Y-m-d H:i:s');
		if($this->input->post('password_edit')!=null){
			$data['password'] =  strrev(sha1($this->input->post('password',true)));
		}

		$insert = $this->general2->update_data($where,$data,'kader_dasawisma');

		

		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}
	
	
}