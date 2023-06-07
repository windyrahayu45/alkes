<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->auth->cek();

		$this->session->set_flashdata(array('parent' => 'dashboard'));
	}
	function index()
	{
		
		$data['baik'] = $this->general2->lihatisitabel('data_barang',['id_status'=>1])->num_rows();
         //peminjaman bulan ini
        $data['rusak'] = $this->general2->lihatisitabel('data_barang',['id_status'=>2])->num_rows();


        $data['total'] = $this->general2->lihatisitabel('data_barang',null)->num_rows();

        $data['afkir'] = $this->general2->lihatisitabel('afkir',null)->num_rows();

        for ($i=1; $i <= 12 ; $i++) { 

        	$this->db->SELECT('a.*');
	        $this->db->from('data_barang a');
	        $this->db->where('MONTH(a.tgl)', $i);
	        $this->db->where('YEAR(a.tgl)', date('Y'));
        	$data["bulan".$i] = $this->db->get()->num_rows();
        }
       
		$data['page']='admin/page';
		$this->load->view('main_page/main',$data);
		
		
	}

	
	
}