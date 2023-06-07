<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
    

    public function index_get()
    {
    
        //$id = $this->get('id_bidang');
       // $id=(31,32,33);
        $this->db->SELECT('a.*,b.bidang_id');
        $this->db->from('pertanyaan a');
        $this->db->join('set_pertanyaan b','a.id=b.pertanyaan_id');
        $this->db->where('b.bidang_id in (31,32,33)');
        $val=$this->db->get();

        //print_r($val->result());die;


        // $this->db->SELECT('a.*');
        // $this->db->from('pertanyaan a');
        // $this->db->join('set_pertanyaan b','a.id=b.pertanyaan_id');
        // $this->db->where('b.bidang_id',"32");
        // $melahirkan=$this->db->get();

        // foreach ($melahirkan->result() as $key) {

        //    $type=$this->general2->lihatisitabel('type',array('id_type'=>$key->type_jawaban))->row();
          
        //    $jawaban=$this->general2->lihatisitabel('jawaban',array('pertanyaan_id'=>$key->id));

        //     if($jawaban->num_rows()>0){
        //         $res_jawaban=$jawaban->result();
        //     }
        //     else{
        //          $res_jawaban=[];
        //     }


        //     $y[]=array(
        //       'id'=>$key->id,
        //       'pertanyaan'=>$key->pertanyaan,
        //       'type'=>$key->type_jawaban,
        //       'jawaban'=>$res_jawaban
        //     );  
       
        // }



        // $this->db->SELECT('a.*');
        // $this->db->from('pertanyaan a');
        // $this->db->join('set_pertanyaan b','a.id=b.pertanyaan_id');
        // $this->db->where('b.bidang_id',"33");
        // $kematian=$this->db->get();

        //  foreach ($kematian->result() as $key) {

        //    $type=$this->general2->lihatisitabel('type',array('id_type'=>$key->type_jawaban))->row();
          
        //    $jawaban=$this->general2->lihatisitabel('jawaban',array('pertanyaan_id'=>$key->id));

        //     if($jawaban->num_rows()>0){
        //         $res_jawaban=$jawaban->result();
        //     }
        //     else{
        //          $res_jawaban=[];
        //     }


        //     $z[]=array(
        //       'id'=>$key->id,
        //       'pertanyaan'=>$key->pertanyaan,
        //       'type'=>$key->type_jawaban,
        //       'jawaban'=>$res_jawaban
        //     );  
       
        // }

        //$bidang=$this->general2->lihatisitabel('bidang',array('id'=>$id))->row();

        foreach ($val->result() as $key) {

           $type=$this->general2->lihatisitabel('type',array('id_type'=>$key->type_jawaban))->row();
          
           $jawaban=$this->general2->lihatisitabel('jawaban',array('pertanyaan_id'=>$key->id));

            if($jawaban->num_rows()>0){
                $res_jawaban=$jawaban->result();
            }
            else{
                 $res_jawaban=[];
            }

            if($key->bidang_id == '31'){
              $note = 'utama';
            }
            else if($key->bidang_id == '32'){
              $note = 'kelahiran';
            }
             else if($key->bidang_id == '33'){
              $note = 'kematian';
            }



            $x[]=array(
              'id'=>$key->id,
              'pertanyaan'=>$key->pertanyaan,
              'type'=>$key->type_jawaban,
              'status'=>$note,
              'jawaban'=>$res_jawaban,
              
            );  
       
        }
        // $c['kelahiran']=$y;
        // $a['dasar'] =$x;
        // $b['kematian'] =$z;
        // $x= array_merge($a,$c,$b);
        // print_r($x);die;
        if ($val->num_rows()>0){
                // Set the response and exit
            // $hasil['pertanyaan']=$x;
            $this->response(["laporan"=>$x], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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
