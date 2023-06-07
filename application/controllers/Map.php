<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Map extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		

		$this->session->set_flashdata(array('parent' => 'dashboard'));
	}
	function index()
	{
		$this->db->select("a.lat, a.long, a.nama_rt, a.alamat");
		$this->db->from("dasawisma_rumah a");
		
		$this->db->where('a.status_verifikasi','1');
		//$this->db->where('d.tahun','2023');
		$this->db->where("a.`lat` <> 'null'");
		$this->db->where("a.`long` <> 'null'");
		$this->db->group_by('a.`nama_rt`');
		
		$query = $this->db->get();
		$data['rumah'] = $query->result();
		

		$this->load->library('googlemaps');
        $config=array();
        $config['center']='-0.789768, 100.655293';
        $config['zoom']='auto';
        $config['map_height']="1200px";
        $this->googlemaps->initialize($config);

        for($i=0;$i<count($data['rumah']);$i++){
        	$alamat =  trim(preg_replace('/\s\s+/', ' ', $data['rumah'][$i]->alamat));


        	$marker = array();
            $marker['animation']='DROP';
            $marker['position']=$data['rumah'][$i]->lat.",". $data['rumah'][$i]->long;
            $marker['infowindow_content'] = '<h4>'.$data['rumah'][$i]->nama_rt.'</h4><h6> Lokasi : '.$alamat.'</h6>';
            $this->googlemaps->add_marker($marker);
        }

        $polygon = array();
		$polygon['points'] = array('-0.73344,100.62','-0.72294,100.63246','-0.71236,100.64092','-0.70398,100.66523','-0.70591,100.66963','-0.71236,100.67738','-0.71874,100.67948','-0.73335,100.6833','-0.74324,100.69276','-0.74783,100.69011','-0.75168,100.68673','-0.76364,100.68461','-0.77074,100.67934','-0.80141,100.67654','-0.80576,100.67616','-0.81342,100.66903','-0.814,100.66683','-0.81102,100.65269','-0.80272,100.63682','-0.80201,100.62807','-0.79959,100.61957','-0.78825,100.60915','-0.78516,100.60256','-0.78722,100.59102','-0.79133,100.58327','-0.79455,100.57504','-0.7929,100.55874','-0.79359,100.54958','-0.79737,100.53588','-0.79823,100.52713','-0.80021,100.51932','-0.79222,100.50739','-0.78573,100.50434','-0.77976,100.50832','-0.7733,100.51662','-0.76725,100.52809','-0.76751,100.53659','-0.77197,100.54288','-0.77575,100.54626','-0.77611,100.55197','-0.76104,100.56201','-0.7511,100.58586');
		$polygon['strokeColor'] = '#000099';
		$polygon['fillColor'] = '#000099';
		$this->googlemaps->add_polygon($polygon);
       
        $data['map']=$this->googlemaps->create_map();

       
        $this->load->view('admin/map',$data);
        
      }
}