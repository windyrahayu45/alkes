<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftarbarang extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
       
        $id_ruangan = $this->get('id_ruangan');
        $this->db->from('data_barang a');
        $this->db->join('ruangan c','a.id_ruangan=c.id_ruangan');
        $this->db->join('status_barang d','a.id_status=d.id_status');
        $this->db->where('id_barang not in (select id_barang from afkir)');
         $this->db->where('id_barang not in (select id_barang from mutasi where jenis_mutasi="Peminjaman" and status_mutasi="Belum Dikembalikan" )');
         $this->db->where('a.id_ruangan',$id_ruangan);
          $val=$this->db->get();
        //$val = $this->general2->lihatisitabel('data_barang',['id_ruangan'=>$id_ruangan]);

        if ($val->num_rows()>0){
            
            foreach ($val->result() as $key ) {
                $key->qrcode = base_url('qrcode/'.$key->id_barang.'.png');
                $link = explode("=", $key->link);
                $key->link = $link[1];
            }
            $this->response(["list_barang"=>$val->result()], REST_Controller::HTTP_OK);       
        
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   

    

   

}
