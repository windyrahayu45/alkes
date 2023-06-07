<?php 
if(!defined("BASEPATH")) exit("No direct script access allowed");
class Auth
{
	var $allowedsession = array('username','nama','level','foto','nik','id_petugas');
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	function cek()
	{
		
		if($this->ci->session->userdata('level') == ''){
			redirect(site_url(''));
		}
	}
	function cek_to_login()
	{


		$cek = 0;
		foreach($this->allowedsession as $data){
			if($this->ci->session->userdata('username')){
				$cek = $cek + 1;
			}
		}
		
		
		if(count($this->allowedsession) == $cek)
		{
			if($this->ci->session->userdata('level') != ''){ 
				redirect(site_url('dashboard')); }
			else{
				redirect(site_url(''));
			}
			
		}
	}


	
}