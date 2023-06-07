<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_anggota extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $where['no_survey'] = $this->get('no_survey');
        $delete = $this->general2->hapus_data($where,'dasawisma_survey');

       if(empty($delete)){
            $this->response([
                    'error' => false,
                    'message' => 'berhasil dihapus'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Gagal dihapus '
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_post(){
        $data['nama_kk'] = $this->post('nama_kk');
        $data['no_kk'] =$this->key->enkripsi ($this->post('no_kk'));
        $data['id_rumah'] = $this->post('id_rumah');
        $data['created_by'] = $this->post('id_kader');
       
        $input = $this->general2->input_data($data,'dasawisma_kk');
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Kepala Keluarga berhasil disimpan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Kepala Keluarga Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
