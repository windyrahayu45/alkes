<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notif_petugas extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get(){
        $id_ruangan = $this->get('id_ruangan');

      
    
        $val = $this->general2->lihatisitabel('mutasi',['id_ruangan'=>$id_ruangan,'tgl_dikembalikan'=>date('Y-m-d'),'status_mutasi'=>'Belum Dikembalikan']);

        if ($val->num_rows()>0){
           
            $this->response(["list_pengembalian"=>$val->result(),'total'=>$val->num_rows()], REST_Controller::HTTP_OK);       
        
        }else{
                // Set the response and exit
            $this->response(["list_pengembalian"=>[],'total'=>0], REST_Controller::HTTP_OK);   // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
