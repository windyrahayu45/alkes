<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id = $this->get('id_rumah');
        
        $status_ver = $this->general2->lihatisitabel("dasawisma_rumah",["id_rumah"=>$id])->row()->status_verifikasi;
        $val=$this->db->query("SELECT no_survey,id_rumah,
            MAX(CASE WHEN id_pertanyaan= '69' THEN jawaban END) AS status
         FROM dasawisma_survey WHERE id_rumah='".$id."' and buku3='1' GROUP BY no_survey");
       //echo $this->db->last_query();die;
        if ($val->num_rows()>0){
                // Set the response and exit
            $col=array();
            foreach ($val->result() as $key ) {
                $data=array();
                $data['id_rumah'] = $key->id_rumah;
                $data['no_survey'] = $key->no_survey;
                $data['id_status'] = $key->status;
                $data['status'] = $this->general2->lihatisitabel('jawaban',["id"=>$key->status])->row()->jawaban;
                $data['verifikasi'] = $status_ver;
                $col[]=$data;
            }
            $this->response(["daftar"=>$col,"verifikasi"=>intval($status_ver)], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Anggota Keluarga tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   

    

   

}
