<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

   
    public function index_post(){

        $kecamatan = $this->post('kecamatan');
        $kelurahan = $this->post('kelurahan');
        $rw = $this->post('rw');
        $rt = $this->post('rt');
        $tahun = $this->post('tahun');


        $this->db->select("a.created_by,b.`nama`,c.`kelurahan` as nama_kelurahan,b.`kelurahan` ,b.`rw`,b.rt,d.sistem,d.`id_sistem`,COUNT(a.`id_rumah`) AS sudah_verifikasi,d.`bagian`,d.`tahun`");
        $this->db->from("dasawisma_rumah a");
        $this->db->join("kader_dasawisma b","a.created_by=b.username");
        $this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
        $this->db->join("sistem d","a.`id_sistem`=d.`id_sistem`","LEFT");
        $this->db->where('a.status_verifikasi','1');
        $this->db->group_by('`a`.`created_by`');
        $this->db->having('sudah_verifikasi > 0');

        if( $kecamatan != ""){
            $this->db->join("kecamatan e","c.`kecamatan_id`=e.`id`","LEFT");
            $this->db->where("e.id",$kecamatan);
        }
        if( $kelurahan != ""){
            $this->db->where("b.kelurahan",$kelurahan);
        }
        if( $rw != ""){
            $this->db->where("b.rw",$rw);
        }
        if( $rt != ""){
            $this->db->where("b.rt",$rt);
        }
        if( $tahun != ""){
            $this->db->where("d.`tahun`",$tahun);
        }

        $query = $this->db->get();
        

        //echo $this->db->last_query();die;

     
        if($query->num_rows() == 0){
            $this->response([
                    'error' => true,
                    'message' => 'Data tidak ditemukan '
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        else{
             $this->response(["filter"=>$query->result()], REST_Controller::HTTP_OK);
        }
       
       
    }

    

   

}
