<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik_teknisi extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get(){
      
        // $id_petugas = $this->get('id_petugas');
        // $id_ruangan = $this->get('id_ruangan');

        //mutasi bulan ini
        $data['baik'] = $this->general2->lihatisitabel('data_barang',['id_status'=>1])->num_rows();


         //peminjaman bulan ini
        $data['mutasi'] = $this->general2->lihatisitabel('data_barang',['id_status'=>2])->num_rows();


        $this->response(["Grafik_teknisi"=>$data], REST_Controller::HTTP_OK);   
       

    }

    

   

}
