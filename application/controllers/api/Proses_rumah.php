<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_rumah extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

  

    public function index_post(){
        $data['nama_rt'] = $this->post('nama_rt');
        $data['alamat'] = $this->post('alamat');
        $data['lat'] = $this->post('lat');
        $data['long'] = $this->post('long');
        $where['id_rumah'] = $this->post('id_rumah');

        $id = $this->post('id_kader');
        $val = $this->general2->lihatisitabel('kader_dasawisma',['username'=>$id])->row();
        //echo $this->db->last_query();die;
        $data['rt'] = $val->rt;
        $data['rw'] = $val->rw;
        $data['kel'] = $val->kelurahan;
        $data['created_by'] = $id;
        $getSistem = $this->general2->lihatisitabel('sistem',['modul_id'=>"8","status"=>'1'])->row();

        $data['id_sistem'] = $getSistem->id_sistem;

        $input = $this->general2->update_data($where,$data,'dasawisma_rumah');
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Data Bangunan berhasil Diupdate'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Data Bangunan Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
