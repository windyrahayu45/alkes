<?php 
if(!defined("BASEPATH")) exit("No direct script access allowed");
class Api
{
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	function cek_login($username,$password,$aplikasi) {
		$post = [
		'username' => $username,
		'password' => $password,
		'aplikasi' => $aplikasi,
		]; $ch = curl_init('http://api.solokkota.go.id/index.php/pegawai/login');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($ch);
		curl_close($ch);
		return($response);
	}

	function get_token($username,$password) {
		
		$ch = curl_init('http://api.solokkota.go.id/index.php/pegawai/load_token?username='.$username);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	function list_uptd($token){
		$authorization = "Authorization: Bearer ".$token;
		$ch = curl_init('http://api.solokkota.go.id/index.php/instansi/uptd');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	function detail_instansi($id_instansi,$token){
		$authorization = "Authorization: Bearer ".$token;
		$ch = curl_init('http://api.solokkota.go.id/index.php/instansi/detail?id_instansi='.$id_instansi);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	function pegawai_uptd($uptd,$token){
		$authorization = "Authorization: Bearer ".$token;
		$ch = curl_init('http://api.solokkota.go.id/index.php/pegawai/per_uptd?id_instansi='.$uptd);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	function detail_pegawai($id_pegawai,$token){
		$authorization = "Authorization: Bearer ".$token;
		$ch = curl_init('http://api.solokkota.go.id/index.php/pegawai/detail?id_pegawai='.$id_pegawai);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}


	
}