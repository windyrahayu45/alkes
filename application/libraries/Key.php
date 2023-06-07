<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Key{
 
	function Enkripsi($string){

        $secret_key = 'D4S4W15M41372';
        $secret_iv = 'D4S4W15M41372';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);        
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        return $output;
    
    } 
    function Deskripsi($string){
        $secret_key = 'D4S4W15M41372';
        $secret_iv = 'D4S4W15M41372';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        
        return $output;
    
    }  
}

	 

 