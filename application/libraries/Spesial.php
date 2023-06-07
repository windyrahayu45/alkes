<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Spesial{
 
	function cek($string){

        $output = preg_match("/^[a-zA-Z0-9]+$/i", $string);
        return $output;
    
    } 
     
}

	 

 