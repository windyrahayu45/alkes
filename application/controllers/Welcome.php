<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
	}
	function index()
	{
		$data = array(
            'captcha' => $this->create_captcha(),
        );
		$this->load->view('login/index',$data);
		$this->auth->cek_to_login();
		
	}

	function create_captcha(){
	    $data = array(
	        'img_path' => APPPATH . '../captcha/',
	        'img_url' => base_url('captcha'),
	        'img_width' => '325',
	        'img_height' => '60',
	        'font_size' => 50,
	        'expiration' => 7200
	    );

	    $captcha = create_captcha($data);
	    $image = $captcha['image'];

	    $this->session->set_userdata('captchaword', $captcha['word']);

	    return $image;
	}

	function login(){
		$captcha=$this->input->post('captcha',true);
		if($captcha != $this->session->userdata('captchaword')){
			$this->session->set_flashdata(array('type' => 'error', 'title' => 'Keamanan Salah', 'msg' => 'ulangi login'));
			
			redirect(site_url(''));
		}
		$where['username'] = $this->input->post('username',true);
		$password = strrev(sha1($this->input->post('password',true)));
		
		$cek = $this->general2->lihatisitabel('petugas',$where);

		if($cek->num_rows() > 0){
			$datauser = $cek->row();
			if($password != $datauser->password){
				$this->session->set_flashdata(array('type' => 'error', 'title' => 'Password Salah', 'msg' => 'Silahkan Ulangi'));
			
				redirect(site_url(''));
			}
			else{
				$this->session->set_userdata(array(
					'username' => $datauser->username,
					'nama'=> $datauser->nama,
					'level'=>$datauser->level,
					'foto'=>$datauser->foto,
					'nik'=> $datauser->nik,
					'id_petugas' => $datauser->id_petugas
				));

				
				$this->session->set_flashdata(array('type' => 'success', 'title' => 'Berhasil login!', 'msg' => 'Selamat Datang '.$datauser->nama));
				
				redirect(site_url(''));
			}
		}
		else{
			$this->session->set_flashdata(array('type' => 'error', 'title' => 'Username tidak ditemukan', 'msg' => 'Silahkan Ulangi'));
			
			redirect(site_url(''));
		}


	}

	function logout()
	{
		$this->session->unset_userdata(array('username','nama','level','foto','nik','id_petugas'));
		
		 $this->session->set_flashdata(array('type' => 'error', 'title' => 'Akses ditolak!', 'msg' => 'Silakan login!'));
		redirect(site_url(''));
	}
	
}