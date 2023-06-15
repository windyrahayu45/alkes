<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeliharaan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get(){

        $val = $this->general2->lihatisitabel('history_pemeliharaan',null)->row();

        $tgl_awal_pemeliharaan = $val->tgl;

        $tgl_awal =  date('Y-m-d', strtotime('+6 month' , strtotime(date($tgl_awal_pemeliharaan))));

        $tgl_akhir =  date('Y-m-d', strtotime('+30 days' , strtotime(date($tgl_awal))));

        $date1= date('Y-m-d');
        if((strtotime($date1) <= strtotime($tgl_akhir)) && (strtotime($date1) >= strtotime($tgl_awal))){

            $this->db->SELECT('*,a.id_barang as id_barang_live');
            $this->db->from('data_barang a');
            $this->db->join('ruangan c','a.id_ruangan=c.id_ruangan');
            $this->db->join('status_barang d','a.id_status=d.id_status');
            $this->db->join('pemeliharaan x','a.id_barang=x.id_barang','left');
            $this->db->where('x.kondisi_sesudah IS NULL');
            $this->db->where('a.id_barang not in (select id_barang from afkir)');
            $val=$this->db->get();

        }
        else{
            $this->db->SELECT('*,a.id_barang as id_barang_live');
            $this->db->from('data_barang a');
            $this->db->join('ruangan c','a.id_ruangan=c.id_ruangan');
            $this->db->join('status_barang d','a.id_status=d.id_status');
             $this->db->join('pemeliharaan x','a.id_barang=x.id_barang','left');
            $this->db->where('x.kondisi_sesudah IS NULL');
            $this->db->where('a.id_status',2);
            $this->db->where('a.id_barang not in (select id_barang from afkir)');
            $val=$this->db->get();


        }
        
       //echo $this->db->last_query();die;


        if ($val->num_rows()>0){
           
            $this->response(["list_pemeliharaan"=>$val->result()], REST_Controller::HTTP_OK);       
        
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
