<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $kader = $this->get('kader');
        $id_sistem = $this->get('id_sistem');

        $this->db->select("a.*,b.no_kk,b.nama_kk");
        $this->db->from("dasawisma_rumah a");
        $this->db->join("dasawisma_kk b","a.id_rumah=b.id_rumah");
        $this->db->where('a.status_verifikasi','1');
        $this->db->where('a.created_by',$kader);
        $this->db->where('a.id_sistem',$id_sistem);
        $rumah =  $this->db->get();

       
        
       //echo $this->db->last_query();die;
        if ($rumah->num_rows()>0){
                // Set the response and exit
            
            $this->response(["rumah_filter"=>$rumah->result()], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   

    

   

}
