<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rumah extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $getSistem = $this->general2->lihatisitabel('sistem',['modul_id'=>"8","status"=>'1'])->row();
        $id = $this->get('id_kader');
        $val = $this->general2->lihatisitabel('dasawisma_rumah',['created_by'=>$id,'id_sistem'=>$getSistem->id_sistem]);

        $col=array();
        $i=0;
        foreach ($val->result() as $key) {
            // $data=[];
            $this->db->from('dasawisma_survey');
            $this->db->where('id_rumah',$key->id_rumah);
            $this->db->where('buku3',0);
            $this->db->where('(no_kk IS NULL OR no_kk = "null")');
            $this->db->group_by('no_survey');
            $rumah=$this->db->get()->num_rows();

           // echo $this->db->last_query();die;
        
            $this->db->from('dasawisma_survey');
            $this->db->where('id_rumah',$key->id_rumah);
            $this->db->where('((no_kk IS NOT NULL and no_kk <> "null"))');
            $keluarga=$this->db->get()->num_rows();
            //echo $keluarga;
            if($keluarga>0){
                $keluarga=1;
            }
            $total = $rumah+$keluarga;;
            if($total>1){
                $total=1;
            }
            else{
                $total=0;
            }
            $key->status = $total;

            //echo $total.'<br>';
            //$hasil=array_push($val->result(), $data['status2']);
            $col[]=$key;
            //$i++;
        }
        //die;
        //$hasil=array_push($val->result(), $col);
        //print_r($col);die;

        if ($val->num_rows()>0){
                // Set the response and exit
            $this->response(["bangunan"=>$col], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Bangunan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_post(){
        $data['nama_rt'] = $this->post('nama_rt');
        $data['alamat'] = $this->post('alamat');
        $data['lat'] = $this->post('lat');
        $data['long'] = $this->post('long');

        $id = $this->post('id_kader');
        $val = $this->general2->lihatisitabel('kader_dasawisma',['username'=>$id])->row();
        //echo $this->db->last_query();die;
        $data['rt'] = $val->rt;
        $data['rw'] = $val->rw;
        $data['kel'] = $val->kelurahan;
        $data['created_by'] = $id;
        $getSistem = $this->general2->lihatisitabel('sistem',['modul_id'=>"8","status"=>'1'])->row();

        $data['id_sistem'] = $getSistem->id_sistem;

        $input = $this->general2->input_data($data,'dasawisma_rumah');
        if($input){
            $this->response([
                    'error' => false,
                    'message' => 'Data Bangunan berhasil disimpan'
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
