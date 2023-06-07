<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kepala_keluarga extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id = $this->get('id_rumah');
        $val = $this->general2->lihatisitabel('dasawisma_kk',['id_rumah'=>$id]);
       
        $status_verifikasi = $this->general2->lihatisitabel("dasawisma_rumah",["id_rumah"=>$id])->row()->status_verifikasi;
        if ($val->num_rows()>0){
                // Set the response and exit
            $col=array();
            foreach ($val->result() as $key ) {
                $data=array();
                $data['id_kk'] = $key->id_kk;
                $data['id_rumah'] = $key->id_rumah;
                $data['nama_kk'] = $key->nama_kk;
                $data['no_kk'] = $this->key->deskripsi($key->no_kk);
                $data['created_by'] = $key->created_by;
                $data['created_at'] = $key->created_at;
                $data['verifikasi'] = $key->status;
                $data['status'] =  $this->general2->lihatisitabel('dasawisma_survey',['no_kk'=>$key->no_kk])->num_rows();
                $col[]=$data;
            }
            $this->response([
                "kk"=>$col,
                "verifikasi"=>intval($status_verifikasi)
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Kepala Keluarga tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_post(){
        $data['nama_kk'] = $this->post('nama_kk');
        $data['no_kk'] =$this->key->enkripsi ($this->post('no_kk'));
        $data['id_rumah'] = $this->post('id_rumah');
        $data['created_by'] = $this->post('id_kader');

        $cek_kk = $this->general2->lihatisitabel("dasawisma_kk",["no_kk"=>$data['no_kk']])->num_rows();

        if($cek_kk != 0){
            $this->response([
                    'error' => true,
                    'message' => 'NO KK telah disimpan sebelumnya'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        else{
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

    

   

}
