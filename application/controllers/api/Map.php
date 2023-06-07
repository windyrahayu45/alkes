<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get()
    {
    
        $this->db->select("a.*");
        $this->db->from("dasawisma_rumah a");
        $this->db->join("kader_dasawisma b","a.created_by=b.username");
        $this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
        $this->db->join("sistem d","a.`id_sistem`=d.`id_sistem`","LEFT");
        $this->db->where('a.status_verifikasi','1');
        $this->db->where("a.`lat` <> 'null'");
        $this->db->where("a.`long` <> 'null'");
        $this->db->group_by('a.`nama_rt`');
        $query = $this->db->get();

        $data['dasawisma'] = $jawaban = $this->general2->lihatisitabel('kader_dasawisma',['kode_level'=>1])->num_rows();

        $data['total_rumah'] =  $this->general2->lihatisitabel('dasawisma_rumah',null)->num_rows();

        $this->db->select("a.*");
        $this->db->from('dasawisma_rumah a');
        $this->db->where('a.status_verifikasi','0');
        $data['rumah_belumverifikasi']=$this->db->get()->num_rows();

        $this->db->select("a.*");
        $this->db->from("dasawisma_rumah a");
        $this->db->where('a.status_verifikasi','1');
        $data['rumah_verifikasi']=$this->db->get()->num_rows();


        $this->db->select("a.*");
        $this->db->from('dasawisma_kk a');
        $this->db->join("dasawisma_rumah b","a.`id_rumah`=b.`id_rumah`");
        
        $data['total_kk']=$this->db->get()->num_rows();
        //$data['total_kk'] =  $this->general2->lihatisitabel('dasawisma_kk',null)->num_rows();

        $this->db->select("a.*");
        $this->db->from('dasawisma_kk a');
        $this->db->join("dasawisma_rumah b","a.`id_rumah`=b.`id_rumah`");
        $this->db->where('b.status_verifikasi','0');
        $data['kk_belumverifikasi']=$this->db->get()->num_rows();

        $this->db->select("a.*");
        $this->db->from('dasawisma_kk a');
        $this->db->join("dasawisma_rumah b","a.`id_rumah`=b.`id_rumah`");
        $this->db->where('b.status_verifikasi','1');
        $data['kk_verifikasi']=$this->db->get()->num_rows();

        $kel_mati ='SELECT SUM(a.jawaban = "221") AS "Kelahiran",
        SUM(a.jawaban = "222") AS "Kematian"
        FROM dasawisma_survey a
        LEFT JOIN dasawisma_rumah b ON a.`id_rumah` = b.`id_rumah`
        LEFT JOIN sistem c ON b.`id_sistem`=c.`id_sistem`
        WHERE (a.id_pertanyaan="69" AND a.buku3="1" AND b.`status_verifikasi`="1")';

        $data['kelahiran'] = $this->db->query($kel_mati)->row()->Kelahiran;
        $data['kematian'] = $this->db->query($kel_mati)->row()->Kematian;


        $lan_bal = "SELECT SUM(IF(age < 6, 1, 0)) AS 'balita',SUM(IF(age >= 65, 1, 0)) AS 'lansia'
        FROM(SELECT TIMESTAMPDIFF(YEAR, a.jawaban, CURDATE()) AS age
        FROM dasawisma_survey a 
        LEFT JOIN dasawisma_rumah b ON a.`id_rumah` = b.`id_rumah`
        LEFT JOIN sistem c ON b.`id_sistem`=c.`id_sistem`
        WHERE a.id_pertanyaan = '35' AND a.`buku3`='0' AND b.`status_verifikasi`='1') AS derived";

        $data['lansia'] = $this->db->query($lan_bal)->row()->lansia;
        $data['balita'] = $this->db->query($lan_bal)->row()->balita;


        $laki = "SELECT b.* FROM dasawisma_rumah a JOIN dasawisma_survey b ON a.`id_rumah` = b.`id_rumah` WHERE a.`status_verifikasi`='1' AND b.`id_pertanyaan`='33' AND b.`jawaban`='155' AND b.`buku3`='0'";

        $perempuan = "SELECT b.* FROM dasawisma_rumah a JOIN dasawisma_survey b ON a.`id_rumah` = b.`id_rumah` WHERE a.`status_verifikasi`='1' AND b.`id_pertanyaan`='33' AND b.`jawaban`='156' AND b.`buku3`='0'";


        $data['L'] = $this->db->query($laki)->num_rows();
        $data['P'] = $this->db->query($perempuan)->num_rows();


        if ($query->num_rows()>0){
                // Set the response and exit
            
            $this->response(['error' => False,"location"=>$query->result(),'total'=>$data], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
                // Set the response and exit
            $this->response([
                    'error' => TRUE,
                    'message' => 'Lokasi tidak ditemukan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   

    

   

}
