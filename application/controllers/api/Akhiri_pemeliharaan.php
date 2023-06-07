<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Akhiri_pemeliharaan  extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_post(){
      
        $where['id_pemeliharaan'] = $this->post('id_pemeliharaan');
        $data['kondisi_sesudah'] = $this->post('kondisi_setelah');
        $data['ket'] = $this->post('ket');
        $data['tgl_selesai'] = date('Y-m-d');

        $id_barang = $this->post("id_barang");
        $id_petugas = $this->post('id_petugas');

        $update = $this->general2->update_data($where,$data,'pemeliharaan');

        //echo $this->db->last_query();die;

        if($data['kondisi_sesudah'] == 3){
             

             //input_afkir
            $data2['tgl'] = date('Y-m-d');
            $data2['id_barang'] = $id_barang;
            $data2['id_petugas']= $id_petugas;
            $data2['ket'] = $this->post('ket');
            $update = $this->general2->input_data($data2,'afkir');
        }
        else{

            $where2['id_barang'] = $id_barang;
            $data3['id_status'] = $this->post('kondisi_setelah');
            $update = $this->general2->update_data($where2,$data3,'data_barang');

        }
    
        
        if($update){
            $this->response([
                    'error' => false,
                    'message' => 'Tindakan berhasil Diselesaikan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Tindakan Gagal Diselesaikan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
