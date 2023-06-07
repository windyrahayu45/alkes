<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pertanyaan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $id = $this->get('id_bidang');
        $no_survey = $this->get('no_survey');

        //echo $id;die;

        if($no_survey == 'null'){
            $this->db->SELECT('a.*');
            $this->db->from('pertanyaan a');
            $this->db->join('set_pertanyaan b','a.id=b.pertanyaan_id');
            $this->db->where('b.bidang_id',$id);
            $this->db->where('a.status','1');
            $val=$this->db->get();

           
        }
        else{

            $this->db->SELECT('a.*,c.jawaban');
            $this->db->from('pertanyaan a');
            $this->db->join('set_pertanyaan b','a.id=b.pertanyaan_id');
            $this->db->join('dasawisma_survey c','a.id=c.id_pertanyaan');
            $this->db->where('b.bidang_id',$id);
            $this->db->where('a.status','1');
            $this->db->where('c.no_survey',$no_survey);
            $val=$this->db->get();

        }
      
       //echo $this->db->last_query();die;
        //echo $this->db->last_query();die;
        $bidang=$this->general2->lihatisitabel('bidang',array('id'=>$id))->row();

        foreach ($val->result() as $key) {

        if (!empty($key->jawaban)){
            $pilih = $key->jawaban;
        }
        else{
            $pilih ='';
        }
           $type=$this->general2->lihatisitabel('type',array('id_type'=>$key->type_jawaban))->row();
           $jawaban=$this->general2->lihatisitabel('jawaban',array('pertanyaan_id'=>$key->id));
           $jawaban_tipe = $key->type_jawaban;

            if($jawaban->num_rows()>0){
                $res_jawaban=$jawaban->result();
            }
            else{
                if($key->type_jawaban == "5"){
                    $jawaban_tipe = "3";
                    $jawaban2=$this->general2->lihatisitabel('jawaban_ya',null);
                    $res_jawaban=$jawaban2->result();
                }
                else{
                    $res_jawaban=[];
                }
            }

            $x[]=array(
              'id'=>$key->id,
              'pertanyaan'=>$key->pertanyaan,
              'value'=>$pilih,
              'type'=>$jawaban_tipe,
              'bidang'=>$bidang->judul,
              'jawaban'=>$res_jawaban
            );

              
       
        }

        if ($val->num_rows()>0){
                // Set the response and exit
            // $hasil['pertanyaan']=$x;
            $this->response(["pertanyan"=>$x], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Pertanyaan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_post(){
        $data['nama_rt'] = $this->post('nama_rt');
        $data['alamat'] = $this->post('alamat');
        $id = $this->post('id_kader');
        $val = $this->general2->lihatisitabel('kader_dasawisma',['username'=>$id])->row();
        //echo $this->db->last_query();die;
        $data['rt'] = $val->rt;
        $data['rw'] = $val->rw;
        $data['kel'] = $val->kelurahan;

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
