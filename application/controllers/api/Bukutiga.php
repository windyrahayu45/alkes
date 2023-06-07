<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bukutiga extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

   
    public function index_post(){

        $kader = $this->post('kader');
        $id_sistem = $this->post('id_sistem');

        $this->db->select('b.*,c.kelurahan as nama_kelurahan');
        $this->db->from('kader_dasawisma b');
        $this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
        $this->db->where('b.username',$kader);
        $data['kader'] = $this->db->get()->row();

        $fetch = $this->general2->lihatisitabel('sistem',array('id_sistem'=>$id_sistem))->row();

        $data['tahun'] = $fetch->tahun;

        $this->db->select('a.kecamatan');
        $this->db->from('kecamatan a');
        $this->db->join("kelurahan c","a.`id`=c.`kecamatan_id`","LEFT");
        $this->db->where('c.id',$data['kader']->kelurahan);
        $data['kecamatan'] = $this->db->get()->row()->kecamatan;


        $this->db->from('pertanyaan a');
        $this->db->where(['a.buku3_stat' => 1]);;
        $syarat = $this->db->get()->result();

        $rumah = $this->general2->lihatisitabel('dasawisma_rumah',['id_sistem'=>$id_sistem,'created_by'=>$kader,'status_verifikasi'=>'1'])->result();
        $rumah_kader = "";
        foreach ($rumah as $key) {
            
            $rumah_kader .= $key->id_rumah.',';

        }
         $rumah_kader = rtrim($rumah_kader, ',');
        // echo $rumah_kader;die;
        $query = "SELECT * FROM dasawisma_survey a WHERE a.`id_rumah` IN ($rumah_kader) AND buku3='1' GROUP BY no_survey";
        $rumah_yg_memiliki_laporan= $this->db->query($query)->result();
        

        $col = array();
        foreach ($rumah_yg_memiliki_laporan as $key) {
            $row = array();

            $this->db->select('*,a.created_at as tgl_survey');
            $this->db->from('dasawisma_survey a');
            $this->db->join("pertanyaan b","a.id_pertanyaan=b.id");
            $this->db->where('a.`no_survey`',$key->no_survey);
            $get_survey = $this->db->get()->result();
        
        
            $query2 = 'SELECT ';
            foreach ($get_survey as $d) {
                if($d->type_jawaban=='3'){
                $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.jawaban END) AS '.$d->slug.',';
                }
                else if($d->type_jawaban==5){
                    $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.jawaban END) AS '.$d->slug.',';
                }
                else{
                     $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
                }
                
                
            }
                $query2 .=" a.created_at FROM dasawisma_survey a";
                $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
                $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
                $query2 .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
                $query2 .=" WHERE a.no_survey='".$key->no_survey."' ";
                $val = $this->db->query($query2)->row();
                //print_r($val->status_laporan);die;
                foreach ($get_survey as $t) {
                    $slug = $t->slug;
                    $row[$slug] = $val->$slug;
                    $row['created_at'] = $this->tanggal->hariini($t->tgl_survey);
                }


            $col[]=$row;
        }
        //print("<pre>".print_r($col,true)."</pre>");   
        $data['buku3']=$col;

        $filename = 'buku3_'.$kader.'-'.date('His').'.pdf';
        //
        sleep(5);
        $this->load->library('buku3');
       // echo $filename;die;
        $hasil = $this->buku3->cetak($filename,$data);

        //echo json_encode(['link'=>base_url('report/'.$filename)]);


        if(!$hasil){
           $this->response(['link'=>base_url('report/'.$filename)], REST_Controller::HTTP_OK);
        }
        else{
             
              $this->response([
                    'error' => true,
                    'message' => 'Data tidak ditemukan '
            ], REST_Controller::HTTP_NOT_FOUND);
        }
       
       
    }

    

   

}
