<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 

class Tanggal{

	function hariini($date)
	{	
		$tahunnya= date('Y', strtotime($date));

		$bulannya= date('m', strtotime($date));

		$harinya= date('d', strtotime($date));



		switch ($bulannya){

					case 1 : $bulan="Januari";

						break;

					case 2 : $bulan="Februari";

						break;

					case 3 : $bulan="Maret";

						break;

					case 4 : $bulan="April";

						break;

					case 5 : $bulan="Mei";

						break;

					case 6 : $bulan="Juni";

						break;

					case 7 : $bulan="Juli";

						break;

					case 8 : $bulan="Agustus";

						break;

					case 9 : $bulan="September";

						break;

					case 10 : $bulan="Oktober";

						break;

					case 11 : $bulan="November";

						break;

					case 12 : $bulan="Desember";

						break;

		}

 

			

		 

		$tanggalcetak="$bulan";

		return $tanggalcetak;

	}
 
}