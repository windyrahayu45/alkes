<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->auth->cek('admin_modul');
	}
	function index()
	{
		
		$data['page']='admin/page';
		$this->session->set_flashdata(array('parent' => 'dashboard'));
		$this->load->view('main_page/main',$data);
		
	}

	
	
}