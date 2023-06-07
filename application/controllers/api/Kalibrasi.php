<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kalibrasi  extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_post(){
      
        $data['id_petugas'] = $this->post('id_petugas');
        $data['id_barang'] = $this->post('id_barang');
        $data['tgl'] = date('Y-m-d');
        //cek_mutasi
        // $this->db->order_by('tgl_dipinjam','desc');
        // $data_barang = $this->general2->lihatisitabel('mutasi',['id_barang'=>$data['id_barang'],"jenis_mutasi"=>'Mutasi']);

        // if($data_barang->num_row()>0){
        //     $data['id_ruangan'] = $data_barang->row()->id_ruangan_penerima;
        // }
        // else{
        //     $data['id_ruangan'] = $this->general2->lihatisitabel('data_barang',['id_barang'=>$data['id_barang']])->row()->id_ruangan;
        // }
   
        $data['pelaksana'] = $this->post("pelaksana");
        $data['kondisi'] = $this->post("kondisi");

        


        $input = $this->general2->input_data($data,'kalibrasi');
        
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Kalibrasi berhasil disimpan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Kalibrasi Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
