<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get(){
      
        $id_petugas = $this->get('id_petugas');
        $id_ruangan = $this->get('id_ruangan');

        //mutasi bulan ini
        $this->db->SELECT('a.*');
        $this->db->from('mutasi a');
        $this->db->where('a.id_petugas',$id_petugas);
        $this->db->where('a.id_ruangan', $id_ruangan);
        $this->db->where('a.jenis_mutasi', 'Mutasi');
        $this->db->where('MONTH(a.tgl_dipinjam)', date('m'));
        $this->db->where('YEAR(a.tgl_dipinjam)', date('Y'));
        $data['mutasi'] = $this->db->get()->num_rows();


         //peminjaman bulan ini
        $this->db->SELECT('a.*');
        $this->db->from('mutasi a');
        $this->db->where('a.id_petugas',$id_petugas);
        $this->db->where('a.id_ruangan', $id_ruangan);
        $this->db->where('a.jenis_mutasi', 'Peminjaman');
        $this->db->where('MONTH(a.tgl_dipinjam)', date('m'));
        $this->db->where('YEAR(a.tgl_dipinjam)', date('Y'));
        $data['peminjaman'] = $this->db->get()->num_rows();


        $this->response(["grafik"=>$data], REST_Controller::HTTP_OK);   
       

    }

    

   

}
