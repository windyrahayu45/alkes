<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_post(){
        $list = $this->post('list');
        $data['id_petugas'] = $this->post('id_petugas');
        $data['id_ruangan'] = $this->post('id_ruangan');
        $data['id_ruangan_penerima'] = $this->post('id_ruangan_penerima');
        $data['tgl_dipinjam'] = date('Y-m-d');
        $data['ket'] = $this->post('ket');
        $data['nama_penerima'] = $this->post('nama_penerima');
        $data['jenis_mutasi'] = $this->post('jenis_mutasi');

        if($data['jenis_mutasi'] != "Mutasi"){
            $data['tgl_dikembalikan'] = $this->post('tgl_dikembalikan');
             $data['status_mutasi'] = 'Belum Dikembalikan';
        }
        else{
            $data['tgl_dikembalikan'] = date('Y-m-d');
            $data['status_mutasi'] = 'Dikembalikan';
        }
        


        foreach ($list as $key ) {
            $data['id_barang'] = $key['id_barang'];
            $data_barang = $this->general2->lihatisitabel('data_barang',['id_barang'=>$key['id_barang']])->row()->id_status;
            $data['kondisi_sebelum'] = $data_barang;
            $input = $this->general2->input_data($data,'mutasi');

            if($data['jenis_mutasi'] == "Mutasi"){
                $where2['id_barang'] = $key['id_barang'];
                $data2['id_ruangan'] = $data['id_ruangan_penerima'];
                $update = $this->general2->update_data($where2,$data2,'data_barang');
            }
        }

        
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Mutasi berhasil disimpan'
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
