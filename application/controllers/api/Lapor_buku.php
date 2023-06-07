<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lapor_buku extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }

    public function index_get()
    {
    
        $id = $this->get('id_status');
        $no_survey = $this->get('no_survey');

        if($id == "221"){
            $id = "32";
        }
        else if($id == "222"){
            $id = "33";
        }
        else if($id == "253"){
            $id = "46";
        }
        else{
            $id = "47";
        }

        if($no_survey == 'null'){
            $this->db->SELECT('a.*');
            $this->db->from('pertanyaan a');
            $this->db->join('set_pertanyaan b','a.id=b.pertanyaan_id');
            $this->db->where('b.bidang_id',$id);
            $this->db->where('a.status','1');
            $this->db->order_by('a.urutan','asc');
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
        $list = $this->post('list');
        $data['id_rumah'] = $this->post('id_rumah');
        $no_survey = $this->post('no_survey');
        $data['created_by'] = $this->post('id_kader');
        $data['buku3'] = 1;
        
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
