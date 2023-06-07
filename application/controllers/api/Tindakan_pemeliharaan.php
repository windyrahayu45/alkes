<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_pemeliharaan  extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_post(){
      
        $data['id_petugas'] = $this->post('id_petugas');
        $data['id_barang'] = $this->post('id_barang');
        $data['tgl_tindakan'] = date('Y-m-d');
        $data_barang = $this->general2->lihatisitabel('data_barang',['id_barang'=>$data['id_barang']])->row()->id_status;
        $data['kondisi_sebelum'] = $data_barang;

        $val = $this->general2->lihatisitabel('history_pemeliharaan',null)->row();

        $tgl_awal_pemeliharaan = $val->tgl;

        $tgl_awal =  date('Y-m-d', strtotime('+6 month' , strtotime(date($tgl_awal_pemeliharaan))));

        $tgl_akhir =  date('Y-m-d', strtotime('+7 days' , strtotime(date($tgl_awal))));

        $date1= date('Y-m-d');
        if((strtotime($date1) <= strtotime($tgl_akhir)) && (strtotime($date1) >= strtotime($tgl_awal))){
            $data['berkala'] = 'Ya';
        }
        else{
             $data['berkala'] = 'Tidak';
        }


        $input = $this->general2->input_data($data,'pemeliharaan');
        
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Tindakan berhasil disimpan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Tindakan Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
