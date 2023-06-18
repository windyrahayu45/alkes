<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notif_pemeliharaan extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }
	

    public function index_get(){
       
        $val = $this->general2->lihatisitabel('history_pemeliharaan',null)->row();

        $tgl_awal_pemeliharaan = $val->tgl;

        $tgl_awal =  date('Y-m-d', strtotime('+6 month' , strtotime(date($tgl_awal_pemeliharaan))));

        $tgl_akhir =  date('Y-m-d', strtotime('+30 days' , strtotime(date($tgl_awal))));

        $date1= date('Y-m-d');
        if((strtotime($date1) <= strtotime($tgl_akhir)) && (strtotime($date1) >= strtotime($tgl_awal))){
            
            $this->response([
                    'error' => false,
                    'message' => 'Segera lakukan Pemeliharaan Berkala Sebulan Sejak Tgl '. $tgl_awal
            ], REST_Controller::HTTP_OK);  

        }else { 

            //jika tgl sekarang besar dari settiing awal pemeliharaan 
            //tgl baru pemeliharaan selanjutnya
            // $tgl_selanjutnya =  date('Y-m-d', strtotime('+6 month' , strtotime(date($tgl_awal))));

            // //jika hari ini kecil dari tgl selanjutnya update sesuai tgl selanjutnya
            // if(strtotime($date1) < strtotime($tgl_selanjutnya)){
            //     $where['id_history'] = 1;
            //     $data['tgl'] = $tgl_awal;
            //     $update = $this->general2->update_data($where,$data,'history_pemeliharaan');
            // }

            

            // $date1= date('Y-m-d');

            $this->db->where('id_barang not in (select id_barang from afkir)');
            $val = $this->general2->lihatisitabel('data_barang',['id_status'=>2]);

            if ($val->num_rows()>0){
                 $this->response([
                    'error' => false,
                    'message' => 'Segera lakukan Perbaikan Alat '
                ], REST_Controller::HTTP_OK);  
            }
            else{
                 $this->response([
                    'error' => TRUE,
                    'message' => 'Data tidak ditemukan'
                ], REST_Controller::HTTP_NOT_FOUND);
            }

          
        }
    }

    

   

}
