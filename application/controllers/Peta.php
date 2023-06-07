<?php
class Peta extends CI_Controller{
    function __construct(){
        parent::__construct();
 
    }
    function index(){
        $this->load->library('googlemaps');
        $config=array();
        $config['center']='-0.789768, 100.655293';
        $config['zoom']='auto';
        $config['map_height']="400px";
        $this->googlemaps->initialize($config);
        $data_hasil = $this->general2->lihatisitabel("dasawisma_rumah",null)->result();

        foreach ($data_hasil as $value ) {
            $marker = array();
            $marker['animation']='DROP';
            $marker['position']="$value->lat, $value->long";
            $marker['infowindow_content'] = '<h1>'.$value->nama_rt.'</h1><h3> Lokasi : '.$value->alamat.'</h3>';
            $this->googlemaps->add_marker($marker);
        }
        $data['map']=$this->googlemaps->create_map();
        $this->load->view('main_page/peta',$data);
    }
}