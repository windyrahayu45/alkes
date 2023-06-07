<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
       
        $jawaban=$this->general2->lihatisitabel('kecamatan',null);
        if($jawaban->num_rows()>0){
           $this->response(["kecamatan"=>$jawaban->result()], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
