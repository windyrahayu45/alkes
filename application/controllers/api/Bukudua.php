<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bukudua extends BD_Controller {
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

        $rumah = $this->general2->lihatisitabel('dasawisma_rumah',['id_sistem'=>$id_sistem,'created_by'=>$kader,'status_verifikasi'=>'1'])->result();

        $this->db->from('pertanyaan a');
        $this->db->where(['a.buku2' => 1]);;
        $syarat = $this->db->get()->result();

        $col = array();
        foreach ($rumah as $key) {
            $row = array();
            $row['nama_rt'] = $key->nama_rt;
            foreach ($syarat as $value) {

                //jumlah_kk

                $this->db->group_by('no_kk');
                $survey = $this->general2->lihatisitabel('dasawisma_survey',['id_pertanyaan'=>$value->id,'id_rumah'=>$key->id_rumah]);

                $row['jumlah_kk'] = $survey->num_rows();

                if($value->slug == 'jenis_kelamin' ){

                    $jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row[$value->slug.'_'.$jwb->kode] = $val[0][$jwb->kode];
                    }   
                }

                if($value->slug == 'apakah_anda_sedang_hamil'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['ibu_hamil'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'apakah_anda_sedang_menyusui'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['menyusui'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'apakah_anda__buta_aksara'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['buta'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'apakah_berkebutuhan_khusus'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['abk'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'kriteria_rumah' ){

                    $jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row[$value->slug.'_'.$jwb->kode] = $val[0][$jwb->kode];
                    }
                }

                if($value->slug == 'memiliki_tempat_pembuangan_sampah'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['sampah'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'memiliki_spal'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['spal'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'memiliki_jamban_keluarga'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['jamban'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'menempel_stiker_p4k'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['stiker_p4k'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'sumber_air_keluarga' ){

                    $jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row[$jwb->jawaban] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'makanan_pokok' ){

                    $jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row[$jwb->kode] = $val[0][$jwb->kode];
                    }
                }

                if($value->slug == 'apakah_mengikuti_up2k'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['up2k'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'apakah_adanya_pemanfaatan_tanah_pekarangan'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['pekarangan'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'apakah_rumah_ini_menjadi_industri_rumah_tangga'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['industri'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'apakah_mengikuti_kerja_bakti'){

                    $jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
                    foreach ($jawaban->result() as $jwb) {
                        $query = "SELECT ";
                        $query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
                        $query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
                        $val = $this->db->query($query)->result_array();
                        //print_r($val[0][$jwb->kode]);die;
                        $row['kerja_bakti'] = $val[0][$jwb->jawaban];
                    }
                }

                if($value->slug == 'tanggal_lahir'){

                    
                    $this->db->from('pertanyaan a');
                    $this->db->where(['a.slug' => 'jenis_kelamin']);
                    $this->db->or_where(['a.slug' => 'status_perkawinan']);
                    $this->db->or_where(['a.slug' => 'tanggal_lahir']);
                    $hitung = $this->db->get()->result();

                    $query2 = 'SELECT ';
                    foreach($hitung as $d) {
                        
                        if($d->type_jawaban=='3'){
                            $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.id END) AS '.$d->slug.',';
                        }
                        else if($d->type_jawaban==5){
                            $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.id END) AS '.$d->slug.',';
                        }
                        else{
                             $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
                        }
                        
                    }
                    $query2 .=" b.`type_jawaban` FROM dasawisma_survey a";
                    $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
                    $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
                    $query2 .=" WHERE a.no_kk IS NOT NULL  AND a.id_rumah='".$key->id_rumah."' and buku3='0' GROUP BY a.no_survey";
                    $res_hitung = $this->db->query($query2)->result();
                    $lansia=0 ;
                    $pus=0;
                    $balita_l=0;
                    $balita_p=0;
                    $wus=0;
                    foreach ($res_hitung as $count_data) {
                        
                        $d1 = new DateTime(date('Y-m-d'));
                        $d2 = new DateTime($count_data->tanggal_lahir);
                        $diff = $d1->diff($d2);
                        $umur=$diff->y;



                        if($umur>=65){
                            $lansia = $lansia+1;
                        }

                        if($umur<=5){

                            $jwb = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->jenis_kelamin])->row();
                            
                            if($jwb->kode == 'L'){
                                $balita_l = $balita_l+1;
                            }
                            else{
                                $balita_p = $balita_p+1;
                            }
                        }

                        if($umur >=15 && $umur<=49){
                            $jwb = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->jenis_kelamin])->row();
                            
                            if($jwb->kode == 'P'){
                                $wus = $wus+1;
                                $stat = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->status_perkawinan])->row();
                            
                                if($stat->kode == 'menikah'){
                                    $pus = $pus+1;
                                }
                            }
                            else{
                                $stat = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->status_perkawinan])->row();
                            
                                if($stat->kode == 'menikah'){
                                    $pus = $pus+1;
                                }
                            }

                        }

                        $row['lansia'] = $lansia;
                        $row['balita_l'] = $balita_l;
                        $row['balita_p'] = $balita_p;
                        $row['pus'] = $pus;
                        $row['wus'] =$wus;
                    }
                    
                }
                
            }


            $col[] = $row;

        }
            
        $data['rumah']=$col;

        //print_r($data);die;

        $filename = 'buku2_'.$kader.'-'.date('His').'.pdf';
        //$this->load->library('pdfgenerator');
        //sleep(5);
        $this->load->library('buku2');
        $hasil = $this->buku2->cetak($filename,$data);
        //echo json_encode(['link'=>base_url('report/'.$filename)]);
        


     
       
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
