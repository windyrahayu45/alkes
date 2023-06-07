<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Simpan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

   

    public function index_post(){
        $list = $this->post('list');
        $data['id_rumah'] = $this->post('id_rumah');
        $no_survey = $this->post('no_survey');
        $data['created_by'] = $this->post('id_kader');


        

        if($this->post('no_kk')!="null"){
            $data['no_kk'] = $this->key->enkripsi($this->post('no_kk'));
        }

        
        if($no_survey!="null"){
            $this->general2->hapus_data(["no_survey"=>$no_survey],'dasawisma_survey');
        }
       
        $data['no_survey'] = date('YmdHis');
        
        foreach ($list as $key ) {
            $data['id_pertanyaan'] = $key['idPertanyaan'];
            $data['jawaban'] = $key['jawaban'];
            $input = $this->general2->input_data($data,'dasawisma_survey');
        }

        
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Survey berhasil disimpan'
            ], REST_Controller::HTTP_OK);
        }
        else{
             $this->response([
                    'error' => TRUE,
                    'message' => 'Survey Gagal disimpan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    

   

}
