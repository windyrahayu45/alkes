<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id = $this->key->enkripsi($this->get('no_kk'));
        //echo $id;die;
        $id_rumah = $this->general2->lihatisitabel("dasawisma_kk",["no_kk"=>$id])->row()->id_rumah;
         //$status_ver = $this->general2->lihatisitabel("dasawisma_rumah",["id_rumah"=>$id_rumah])->row()->status_verifikasi;
        $status_ver = $this->general2->lihatisitabel("dasawisma_kk",["no_kk"=>$id])->row()->status;

        //echo $this->db->last_query();die;

        $syarat = $this->db->from('pertanyaan a');
        $syarat = $this->db->where(['a.anggota' => 1]);;
        $data['syarat'] = $this->db->get()->result();

        $query = 'SELECT no_survey,';

        foreach($data['syarat'] as $d) {
            $query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
        }

        $query .="no_kk FROM dasawisma_survey a";
        $query .=" WHERE no_kk='".$id."' GROUP BY no_survey";
        $val = $this->db->query($query);
       //echo $this->db->last_query();die;
        if ($val->num_rows()>0){
                // Set the response and exit
            $col=array();
            foreach ($val->result() as $key ) {
                $data=array();
                $data['nik'] = $key->nik;
                $data['nama'] = $key->nama;
                $data['no_kk'] = $this->key->deskripsi($key->no_kk);
                $data['no_survey'] = $key->no_survey;
                $data['status'] = $this->general2->lihatisitabel('jawaban',["pertanyaan_id"=>'78',"id"=>$key->status])->row()->jawaban;
                $data['verifikasi'] = $status_ver;
                $col[]=$data;
            }
            $this->response(["anggota"=>$col,"verifikasi"=>intval($status_ver)], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Anggota Keluarga tidak ditemukan'
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
