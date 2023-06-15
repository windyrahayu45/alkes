<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id_barang = $this->get('id_barang');
        $id_ruangan = $this->get('id_ruangan');

        $this->db->where('id_barang not in (select id_barang from afkir)');
        $val = $this->general2->lihatisitabel('data_barang',['id_barang'=>$id_barang]);

        if ($val->num_rows()>0){

            if($val->row()->id_ruangan == $id_ruangan){
                $this->response(["Qr_barang"=>$val->row()], REST_Controller::HTTP_OK);
            }
            else if($id_ruangan==""){
                $this->response(["Qr_barang"=>$val->row()], REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                        'error' => TRUE,
                        'message' => 'Anda tidak berhak akses data ruangan lain'
                ], REST_Controller::HTTP_NOT_FOUND);
               
            }

            $mutasi = $this->general2->lihatisitabel('mutasi',['id_barang'=>$id_barang]);

            if($mutasi->num_rows() > 0){
                $hasil = $mutasi->row();
                if($hasil->jenis_mutasi == 'Mutasi'){
                    $this->response([
                        'error' => TRUE,
                        'message' => 'Barang yang dipilih telah dimutasi sebelumnya'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
                else if($hasil->jenis_mutasi == 'Peminjaman'){
                    if($hasil->status_mutasi == 'Belum Dikembalikan'){
                        $this->response([
                        'error' => TRUE,
                        'message' => 'Barang yang dipilih telah dipinjam sebelumnya'
                        ], REST_Controller::HTTP_NOT_FOUND);
                    }
                    else{
                        $this->response(["Qr_barang"=>$val->row()], REST_Controller::HTTP_OK);
                    }
                }
            }


        
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   

    

   

}
