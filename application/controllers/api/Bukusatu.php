<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bukusatu extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

   
    public function index_post(){

        $no_kk = $this->post('no_kk');
        $id_sistem = $this->post('id_sistem');
        $id_rumah = $this->post('id_rumah');

        $data['kk'] = $this->general2->lihatisitabel('dasawisma_kk',['no_kk'=>$no_kk])->row();
        $data['tahun'] = $this->general2->lihatisitabel('sistem',['id_sistem'=>$id_sistem])->row()->tahun;

        $this->db->select('*');
        $this->db->from("dasawisma_rumah a");
        $this->db->join("kader_dasawisma b","a.created_by=b.username");
        $this->db->where('a.id_rumah',$id_rumah);
        $data['dasawisma']=$this->db->get()->row()->dasawisma;

        $syarat = $this->db->from('pertanyaan a');
        $syarat = $this->db->where(['a.note_buku1' => 1]);;
        $data['syarat'] = $this->db->get()->result();

        $query = 'SELECT no_survey,';

        foreach($data['syarat'] as $d) {
            if($d->type_jawaban=='3'){
                $query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.jawaban END) AS '.$d->slug.',';
            }
            else if($d->type_jawaban==5){
                $query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.jawaban END) AS '.$d->slug.',';
            }
            else{
                 $query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
            }
        }

        $query .=" no_kk FROM dasawisma_survey a";
        $query .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
        $query .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
        $query .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
        $query .=" WHERE id_rumah='".$id_rumah."' AND (a.no_kk IS NULL OR a.no_kk='null') AND a.buku3='0'  GROUP BY no_survey";
        $val = $this->db->query($query)->row();
        //echo $this->db->last_query();die;
        $data['hasil']  = $val;


        $this->db->from('pertanyaan a');
        $this->db->where(['a.buku1' => 1]);
        $this->db->order_by('a.urutan','asc');
        $data['buku1'] = $this->db->get()->result();

        $base = 'SELECT ';
        foreach($data['buku1'] as $d) {
            $base .= 'MAX(CASE WHEN a.id = "'.$d->id.'" THEN a.slug END) AS '.$d->slug.',';
        }
        $base .=" id FROM pertanyaan a";
        $res_base = $this->db->query($base)->result();

        $data['base'] = $res_base;

        $query2 = 'SELECT ';

        foreach($data['buku1'] as $d) {
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
        $query2 .=" no_kk FROM dasawisma_survey a";
        $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
        $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
        $query2 .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
        $query2 .=" WHERE no_kk='".$no_kk."' AND id_rumah='".$id_rumah."' GROUP BY no_survey";
        $res_buku1 = $this->db->query($query2)->result();
        $data['result'] = $res_buku1;

        $filename = 'buku1_'.$data['kk']->nama_kk.'-'.date('His').'.pdf';
        //$this->load->library('pdfgenerator');
        sleep(5);
        $this->load->library('buku1');
        $hasil = $this->buku1->cetak($filename,$data);
        //$this->load->view('pengguna/laporan/cetak_buku1',$data);
        //$html = $this->load->view('pengguna/laporan/cetak_buku1',$data,true);
        //die;     
        //$this->pdfgenerator->generate($html,$filename);

        //$this->load->view('pengguna/laporan/cetak_buku1',$data);

       // echo json_encode(['link'=>base_url('report/'.$filename)]);
        


     
        if($hasil){
            $this->response([
                    'error' => true,
                    'message' => 'Data tidak ditemukan '
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        else{
             $this->response(['link'=>base_url('report/'.$filename)], REST_Controller::HTTP_OK);
        }
       
       
    }

    

   

}
