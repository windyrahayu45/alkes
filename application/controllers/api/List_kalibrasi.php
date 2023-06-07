<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class List_kalibrasi extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $query = "SELECT a.*,b.*,c.`nama_ruangan` FROM kalibrasi a
            LEFT JOIN data_barang b ON a.`id_barang` = b.`id_barang`
            LEFT JOIN ruangan c ON b.`id_ruangan`=c.`id_ruangan`
            WHERE a.`id_barang` NOT IN (SELECT id_barang FROM mutasi)
            UNION
            SELECT x.*,m.*,e.nama_ruangan FROM kalibrasi X
            LEFT JOIN mutasi d ON x.`id_barang`=d.`id_barang`
            LEFT JOIN data_barang m ON d.`id_barang`=m.`id_barang`
            LEFT JOIN ruangan e ON d.`id_ruangan_penerima`=e.`id_ruangan`
            WHERE d.`jenis_mutasi`='Mutasi'";

            $res = $this->db->query($query);
       

        if ($res->num_rows()>0){

            
            $this->response(["kalibrasi"=>$res->result()], REST_Controller::HTTP_OK);
            
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   

    

   

}
