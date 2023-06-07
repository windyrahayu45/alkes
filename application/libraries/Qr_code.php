<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/libraries/phpqrcode/qrlib.php';
class Qr_code extends qrcode
{

    function __construct()
    {
		$this->CI = &get_instance();
    }
    function generate($file_name,$link)
    {

    	$tempdir = APPPATH.'../qrcode/';
    	$isi_teks = $link;
		$namafile = str_replace('.pdf', '.png', $file_name);
    	if(!file_exists($tempdir.$namafile)){
			$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
			$ukuran = 7; //batasan 1 paling kecil, 10 paling besar
			$padding = 1;
			  ob_start(); 
			QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
			
		    $debugLog = ob_get_contents(); 
		    ob_clean(); 
		}
		else{
			echo "file already generated!";	  
   		}
	}
}