<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_post(){
        $id_mutasi = $this->post('id_mutasi');
        $id_barang = $this->post('id_barang');
        $data['tgl_dikembalikan'] = $this->post('tgl_dikembalikan');
        $data['kondisi_sesudah'] = $this->post('kondisi_setelah');
        $data['status_mutasi'] = 'Dikembalikan';

        $where['id_mutasi'] = $id_mutasi;
        $update = $this->general2->update_data($where,$data,'mutasi');

        $where2['id_barang'] = $id_barang;
        $data2['id_status'] = $this->post('kondisi_setelah');
        $update = $this->general2->update_data($where2,$data2,'data_barang');

        

        
        if($update){
            $this->response([
                    'error' => false,
                    'message' => 'Pengembalian berhasil disimpan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Mutasi Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
