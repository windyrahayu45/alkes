<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends BD_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->methods['users_get']['limit'] = 2500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 2100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 250; // 50 requests per hour per user/key
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
	        'img_width' => '250',
	        'img_height' => '60',
	        'font_size' => 120,
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
		$userdata = $this->input->post('username',true);
		$password = $this->input->post('password',true);
		$aplikasi='dasawisma_53';
		$hasil=$this->api->cek_login($userdata,$password,$aplikasi);
		$data=json_decode($hasil);

		print_r($data);die;

		if(isset($data->status)){
			$this->session->set_flashdata(array('type' => 'warning', 'title' => 'Gagal login', 'msg' => $data->status));
			
			redirect(site_url('Welcome/logout'));

		}else{

			$session = array('user_name' => $data->username,
				'id_pegawai' => $data->id_pegawai,
				'token' => $data->token
			);
			$aaa = $data->level;
			foreach($aaa as $datalevel ){
				if($datalevel!=""){
					$session['level'] = $datalevel;
				}
			}
			$this->session->set_userdata($session);

			$this->session->set_flashdata(array('type' => 'success', 'title' => 'Berhasil login!', 'msg' => 'Selamat Datang, '.$user->level.'!'));
			
			redirect(site_url(''));
			
			
		}

	}

	function logout()
	{
		$this->session->unset_userdata(array('user_name','id_pegawai','token','level'));
		$this->session->set_flashdata(array('type' => 'success', 'title' => 'Berhasil logout!', 'msg' => 'Silakan login kembali!'));
		redirect(site_url(''));
	}
	
}