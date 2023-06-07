<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pimpinan extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		//$this->load->model('modul/mv_pimpinan','pimpinan');
		$this->session->set_flashdata(array('parent' => 'setting','child' => 'pimpinan','middle' => 'setting_data'));
		$this->auth->cek($this->session->userdata('level'));
	}
	function index()
	{
		

		//$this->auth->cek('admin_modul');
		$data['page']='aplikasi_modul/pimpinan/index';
		$data['title']="Akses Pimpinan";
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
		

		$manal = $this->general2->lihatisitabel('kader_dasawisma',['kode_level'=>4])->result();
		$col2=array();
		foreach ($manal as $key) {
			$key->kode = 1;
			$col2[]=$key;
		}
		$data['manual'] = $col2;

		$auto = $this->general2->lihatisitabel('akses_modul',['id_level'=>9])->result();
		$col = array();
		foreach ($auto as $fetch ) {
			$row = array();
			$row['kode'] = 2;
			$token=$this->session->userdata('token');
			$hasil=$this->api->detail_pegawai($fetch->id_pegawai,$token);

			$datax=json_decode($hasil);

			$row['nama'] = $datax[0]->nama_lengkap;
			$row['username'] = $datax[0]->nip;
			$row['telp'] = $datax[0]->telp2;
			$row['alamat'] = $datax[0]->alamat;
			$col[] = $row;
		}

		$data['auto'] = $col;


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

	function reset(){
		$data = $_POST;
		$where['id'] = $data['id'];
		$update['password'] = strrev(sha1($this->input->post('password',true)));
		$insert = $this->general2->update_data($where,$update,'kader_dasawisma');

		if($insert){
			echo json_encode(array('type' => 'success','title' => 'Berhasil!','msg' => 'Data Diupdate!'));
		}
		else{
			echo json_encode(array('type' => 'error','title' => 'Gagal!','msg' => 'Terjadi kesalahan!'));
		}
	}

	function save(){
		$data = $_POST;
		if($data['kode_level'] == 1){
			$data2['id_level'] = 9;
			$data2['id_pegawai']=$this->input->post('id_pegawai');
			$data2['modul_id']=$this->session->userdata('modul_id');
			$data2['created_by']=$this->session->userdata('id_pegawai');
			$insert = $this->general2->input_data($data2,'akses_modul');
		}
		else{
			$data2['nama']=$this->input->post('nama');
			$data2['telp']=$this->input->post('telp');
			$data2['username']=$this->input->post('username');
			$data2['alamat']=$this->input->post('alamat');
			$data2['kode_level']=4;
			$data2['password'] =  strrev(sha1($this->input->post('password',true)));
			$data2['created_by']=$this->session->userdata('id_pegawai');
			$insert = $this->general2->input_data($data2,'kader_dasawisma');
		}
		
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
			if($fetch->kode_level == 1){
				$row[] = 'Kader Dasawisma';
			}
			else if($fetch->kode_level == 2){
				$row[] = 'Ketua RT';
			}
			else if($fetch->kode_level == 3){
				$row[] = 'Ketua RW';
			}
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
		$data['kode_level']=$this->input->post('kode_level_edit');
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