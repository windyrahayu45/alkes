<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rw extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id_kel = $this->get('id_kel');
        $this->db->group_by('rw');
        $result = $this->general2->lihatisitabel('zona',["id_kel"=>$id_kel]);
        if($result->num_rows()>0){
           $this->response(["rw"=>$result->result()], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
