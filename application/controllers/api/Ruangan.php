<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
        $id_ruangan = $this->get('id_ruangan');
        $this->db->where("id_ruangan <>",$id_ruangan);
        $getSistem = $this->general2->lihatisitabel('ruangan',null);
        if($getSistem->num_rows()>0){
           $this->response(["ruangan"=>$getSistem->result()], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    

   

}
