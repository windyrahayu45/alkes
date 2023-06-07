<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class List_mutasi extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get(){
        $id_ruangan = $this->get('id_ruangan');

       

        $this->db->SELECT('*,c.nama_ruangan as ruangan_penerima');
        $this->db->from('mutasi a');
        $this->db->join('data_barang b','a.id_barang=b.id_barang');
        $this->db->join('ruangan c','a.id_ruangan_penerima=c.id_ruangan');
        $this->db->where('a.id_ruangan',$id_ruangan);
        $this->db->order_by('a.tgl_dipinjam','asc');
        $val=$this->db->get();

        if ($val->num_rows()>0){
           
            $this->response(["list_mutasi"=>$val->result()], REST_Controller::HTTP_OK);       
        
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
