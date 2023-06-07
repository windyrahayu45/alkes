<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id_petugas = $this->get('id_petugas');
        $password = $this->get('password');
        $data2['password'] = strrev(sha1($password));
        
        $where['id_petugas'] = $id_petugas;
        
        $update = $this->general2->update_data($where,$data2,'petugas');
        if($update){
            $this->response([
                    'error' => false,
                    'message' => 'Reset password berhasil'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Reset password Gagal'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   
    

   

}
