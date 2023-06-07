<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ubah extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

   

    public function index_post(){
        $data['nama'] = $this->post('nama');
        $data['nik'] = $this->post('nik');
        $data['telp'] = $this->post('telp');
        $where['id_petugas'] = $this->post('id_petugas');
       
        $update = $this->general2->update_data($where,$data,'petugas');
        if($update){
            $this->response([
                    'error' => false,
                    'message' => 'Data berhasil disimpan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Data Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
