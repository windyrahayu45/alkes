<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Laporan extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		isLogin();
		
		$this->load->model('pengguna/mv_laporan','laporan');
		$this->session->set_flashdata(array('parent' => 'laporan'));
	}
	function index()
	{
		
		

		$data['page']='pengguna/laporan/index';
		
		$this->load->view('main_page/main',$data);
		
		
	}

	function cth(){
		$this->load->view('pengguna/laporan/cetak_buku1');
	}

	function cetak_buku1()
	{
		
		$no_kk = $this->input->post('no_kk');
		$id_sistem = $this->input->post('id_sistem');
		$id_rumah = $this->input->post('id_rumah');

		$data['kk'] = $this->general2->lihatisitabel('dasawisma_kk',['no_kk'=>$no_kk])->row();
		$data['tahun'] = $this->general2->lihatisitabel('sistem',['id_sistem'=>$id_sistem])->row()->tahun;

		$this->db->select('*');
		$this->db->from("dasawisma_rumah a");
		$this->db->join("kader_dasawisma b","a.created_by=b.username");
		$this->db->where('a.id_rumah',$id_rumah);
		$data['dasawisma']=$this->db->get()->row()->dasawisma;



		$syarat = $this->db->from('pertanyaan a');
        $syarat = $this->db->where(['a.note_buku1' => 1]);;
        $data['syarat'] = $this->db->get()->result();

        $query = 'SELECT no_survey,';

        foreach($data['syarat'] as $d) {
        	if($d->type_jawaban=='3'){
            	$query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.jawaban END) AS '.$d->slug.',';
        	}
        	else if($d->type_jawaban==5){
            	$query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.jawaban END) AS '.$d->slug.',';
        	}
        	else{
        		 $query .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
        	}
        }

        $query .=" no_kk FROM dasawisma_survey a";
        $query .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
        $query .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
        $query .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
        $query .=" WHERE id_rumah='".$id_rumah."' AND (a.no_kk IS NULL OR a.no_kk='null') AND a.buku3='0'  GROUP BY no_survey";
        $val = $this->db->query($query)->row();
        //echo $this->db->last_query();die;
        $data['hasil']  = $val;


        $this->db->from('pertanyaan a');
        $this->db->where(['a.buku1' => 1]);
        $this->db->order_by('a.urutan','asc');
        $data['buku1'] = $this->db->get()->result();

        $base = 'SELECT ';
        foreach($data['buku1'] as $d) {
        	$base .= 'MAX(CASE WHEN a.id = "'.$d->id.'" THEN a.slug END) AS '.$d->slug.',';
        }
        $base .=" id FROM pertanyaan a";
        $res_base = $this->db->query($base)->result();

        $data['base'] = $res_base;

        $query2 = 'SELECT ';

        foreach($data['buku1'] as $d) {
        	if($d->type_jawaban=='3'){
            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.jawaban END) AS '.$d->slug.',';
        	}
        	else if($d->type_jawaban==5){
            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.jawaban END) AS '.$d->slug.',';
        	}
        	else{
        		 $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
        	}
        }
        $query2 .=" no_kk FROM dasawisma_survey a";
        $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
        $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
        $query2 .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
        $query2 .=" WHERE no_kk='".$no_kk."' AND id_rumah='".$id_rumah."' GROUP BY no_survey";
        $res_buku1 = $this->db->query($query2)->result();
        $data['result'] = $res_buku1;

        $filename = 'buku1_'.$data['kk']->nama_kk.'-'.date('His').'.pdf';
        //$this->load->library('pdfgenerator');
        sleep(5);
		$this->load->library('buku1');
		$this->buku1->cetak($filename,$data);
        //$this->load->view('pengguna/laporan/cetak_buku1',$data);
		//$html = $this->load->view('pengguna/laporan/cetak_buku1',$data,true);
		//die;	   
        //$this->pdfgenerator->generate($html,$filename);

        //$this->load->view('pengguna/laporan/cetak_buku1',$data);

        echo json_encode(['link'=>base_url('report/'.$filename)]);
		
	}

	function cetak_buku2(){
		$id_sistem = $this->input->post('id_sistem');
		$kader = $this->input->post('kader');
		$id_rumah = $this->input->post('id_rumah');

		$this->db->select('b.*,c.kelurahan as nama_kelurahan');
		$this->db->from('kader_dasawisma b');
		$this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
		$this->db->where('b.username',$kader);
		$data['kader'] = $this->db->get()->row();

		$fetch = $this->general2->lihatisitabel('sistem',array('id_sistem'=>$id_sistem))->row();

		$data['tahun'] = $fetch->tahun;

		$rumah = $this->general2->lihatisitabel('dasawisma_rumah',['id_sistem'=>$id_sistem,'created_by'=>$kader,'status_verifikasi'=>'1'])->result();

		$this->db->from('pertanyaan a');
        $this->db->where(['a.buku2' => 1]);;
        $syarat = $this->db->get()->result();

		$col = array();
		foreach ($rumah as $key) {
			$row = array();
			$row['nama_rt'] = $key->nama_rt;
			foreach ($syarat as $value) {

				//jumlah_kk

				$this->db->group_by('no_kk');
				$survey = $this->general2->lihatisitabel('dasawisma_survey',['id_pertanyaan'=>$value->id,'id_rumah'=>$key->id_rumah]);

				$row['jumlah_kk'] = $survey->num_rows();

				if($value->slug == 'jenis_kelamin' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$value->slug.'_'.$jwb->kode] = $val[0][$jwb->kode];
					}	
				}

				if($value->slug == 'apakah_anda_sedang_hamil'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['ibu_hamil'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_anda_sedang_menyusui'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['menyusui'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_anda__buta_aksara'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['buta'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_berkebutuhan_khusus'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['abk'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'kriteria_rumah' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$value->slug.'_'.$jwb->kode] = $val[0][$jwb->kode];
					}
				}

				if($value->slug == 'memiliki_tempat_pembuangan_sampah'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['sampah'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'memiliki_spal'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['spal'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'memiliki_jamban_keluarga'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['jamban'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'menempel_stiker_p4k'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['stiker_p4k'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'sumber_air_keluarga' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$jwb->jawaban] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'makanan_pokok' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$jwb->kode] = $val[0][$jwb->kode];
					}
				}

				if($value->slug == 'apakah_mengikuti_up2k'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['up2k'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_adanya_pemanfaatan_tanah_pekarangan'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['pekarangan'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_rumah_ini_menjadi_industri_rumah_tangga'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['industri'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_mengikuti_kerja_bakti'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['kerja_bakti'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'tanggal_lahir'){

					
					$this->db->from('pertanyaan a');
			        $this->db->where(['a.slug' => 'jenis_kelamin']);
			        $this->db->or_where(['a.slug' => 'status_perkawinan']);
			        $this->db->or_where(['a.slug' => 'tanggal_lahir']);
			        $hitung = $this->db->get()->result();

			        $query2 = 'SELECT ';
			        foreach($hitung as $d) {
			        	
			            if($d->type_jawaban=='3'){
			            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.id END) AS '.$d->slug.',';
			        	}
			        	else if($d->type_jawaban==5){
			            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.id END) AS '.$d->slug.',';
			        	}
			        	else{
			        		 $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
			        	}
			        	
			        }
			        $query2 .=" b.`type_jawaban` FROM dasawisma_survey a";
			        $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
			        $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
			        $query2 .=" WHERE a.no_kk IS NOT NULL  AND a.id_rumah='".$key->id_rumah."' and buku3='0' GROUP BY a.no_survey";
			        $res_hitung = $this->db->query($query2)->result();
			        $lansia=0 ;
			        $pus=0;
			        $balita_l=0;
			        $balita_p=0;
			        $wus=0;
			        foreach ($res_hitung as $count_data) {
			        	
			        	$d1 = new DateTime(date('Y-m-d'));
						$d2 = new DateTime($count_data->tanggal_lahir);
						$diff = $d1->diff($d2);
						$umur=$diff->y;



						if($umur>=65){
							$lansia = $lansia+1;
						}

						if($umur<=5){

							$jwb = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->jenis_kelamin])->row();
							
							if($jwb->kode == 'L'){
								$balita_l = $balita_l+1;
							}
							else{
								$balita_p = $balita_p+1;
							}
						}

						if($umur >=15 && $umur<=49){
							$jwb = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->jenis_kelamin])->row();
							
							if($jwb->kode == 'P'){
								$wus = $wus+1;
								$stat = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->status_perkawinan])->row();
							
								if($stat->kode == 'menikah'){
									$pus = $pus+1;
								}
							}
							else{
								$stat = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->status_perkawinan])->row();
							
								if($stat->kode == 'menikah'){
									$pus = $pus+1;
								}
							}

						}

						$row['lansia'] = $lansia;
						$row['balita_l'] = $balita_l;
			        	$row['balita_p'] = $balita_p;
			        	$row['pus'] = $pus;
			        	$row['wus'] =$wus;
			        }
			        
				}
				
			}


			$col[] = $row;

		}
			
		$data['rumah']=$col;

		$filename = 'buku2_'.$kader.'-'.date('His').'.pdf';
        //$this->load->library('pdfgenerator');
        sleep(5);
		$this->load->library('buku2');
		$this->buku2->cetak($filename,$data);
		echo json_encode(['link'=>base_url('report/'.$filename)]);
	}

	function cetak_buku3(){
		$id_sistem = $this->input->post('id_sistem');
		$kader = $this->input->post('kader');
		$id_rumah = $this->input->post('id_rumah');

		$this->db->select('b.*,c.kelurahan as nama_kelurahan');
		$this->db->from('kader_dasawisma b');
		$this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
		$this->db->where('b.username',$kader);
		$data['kader'] = $this->db->get()->row();

		$fetch = $this->general2->lihatisitabel('sistem',array('id_sistem'=>$id_sistem))->row();

		$data['tahun'] = $fetch->tahun;

		$this->db->select('a.kecamatan');
		$this->db->from('kecamatan a');
		$this->db->join("kelurahan c","a.`id`=c.`kecamatan_id`","LEFT");
		$this->db->where('c.id',$data['kader']->kelurahan);
		$data['kecamatan'] = $this->db->get()->row()->kecamatan;


		$this->db->from('pertanyaan a');
        $this->db->where(['a.buku3_stat' => 1]);;
        $syarat = $this->db->get()->result();

        $rumah = $this->general2->lihatisitabel('dasawisma_rumah',['id_sistem'=>$id_sistem,'created_by'=>$kader,'status_verifikasi'=>'1'])->result();
        $rumah_kader = "";
        foreach ($rumah as $key) {
        	
        	$rumah_kader .= $key->id_rumah.',';

        }
         $rumah_kader = rtrim($rumah_kader, ',');
        // echo $rumah_kader;die;
        $query = "SELECT * FROM dasawisma_survey a WHERE a.`id_rumah` IN ($rumah_kader) AND buku3='1' GROUP BY no_survey";
        $rumah_yg_memiliki_laporan= $this->db->query($query)->result();
        

		$col = array();
		foreach ($rumah_yg_memiliki_laporan as $key) {
			$row = array();

			$this->db->select('*,a.created_at as tgl_survey');
			$this->db->from('dasawisma_survey a');
			$this->db->join("pertanyaan b","a.id_pertanyaan=b.id");
			$this->db->where('a.`no_survey`',$key->no_survey);
			$get_survey = $this->db->get()->result();
		
		
			$query2 = 'SELECT ';
			foreach ($get_survey as $d) {
				if($d->type_jawaban=='3'){
            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.jawaban END) AS '.$d->slug.',';
	        	}
	        	else if($d->type_jawaban==5){
	            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.jawaban END) AS '.$d->slug.',';
	        	}
	        	else{
	        		 $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
	        	}
	        	
		        
			}
				$query2 .=" a.created_at FROM dasawisma_survey a";
		        $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
		        $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
		        $query2 .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
		        $query2 .=" WHERE a.no_survey='".$key->no_survey."' ";
		        $val = $this->db->query($query2)->row();
		    	//print_r($val->status_laporan);die;
			    foreach ($get_survey as $t) {
			    	$slug = $t->slug;
			    	$row[$slug] = $val->$slug;
			    	$row['created_at'] = $this->tanggal->hariini($t->tgl_survey);
			    }


			$col[]=$row;
		}
		//print("<pre>".print_r($col,true)."</pre>");	
		$data['buku3']=$col;

		$filename = 'buku3_'.$kader.'-'.date('His').'.pdf';
        //$this->load->library('pdfgenerator');
        sleep(5);
		$this->load->library('buku3');
		$this->buku3->cetak($filename,$data);

		echo json_encode(['link'=>base_url('report/'.$filename)]);

	}

	function get_form(){
		$level = $this->session->userdata('level');


		//rt
		if($this->session->userdata('level')=='2'){
			$user_name = $this->session->userdata('user_name');

			$data_login = $this->general2->lihatisitabel('kader_dasawisma',array('username'=>$user_name))->row();

			$data_kel = $this->general2->lihatisitabel('kelurahan',array('id'=>$data_login->kelurahan))->row();

			$data['kelurahan'] = $this->general2->lihatisitabel('kelurahan',array('id'=>$data_login->kelurahan))->result();

			$data['rw'] = $data_login->rw;

			$data['rt'] = $data_login->rt;

			$this->load->view('pengguna/laporan/rt',$data);
		}
		//RW
		else if($this->session->userdata('level')=='3'){
			$user_name = $this->session->userdata('user_name');
			$data_login = $this->general2->lihatisitabel('kader_dasawisma',array('username'=>$user_name))->row();
			$data_kel = $this->general2->lihatisitabel('kelurahan',array('id'=>$data_login->kelurahan))->row();
			$data['kelurahan'] = $this->general2->lihatisitabel('kelurahan',array('id'=>$data_login->kelurahan))->result();
			$data['rw'] = $data_login->rw;
			$data['rt'] =  $this->general2->lihatisitabel('zona',["id_kel"=>$data_login->kelurahan,"rw"=>$data_login->rw])->result();

			//print_r($data['rt']);
			$this->load->view('pengguna/laporan/rw',$data);
		}
		//Kelurahan
		else if($this->session->userdata('level')=='Kelurahan'){
			$id_pegawai = $this->session->userdata('id_pegawai');
			$token=$this->session->userdata('token');
			$hasil=$this->api->detail_pegawai($id_pegawai,$token);
			$datax=json_decode($hasil);
			$id_kel = $datax[0]->instansi_uptd;
			//print_r($datax[0]->instansi_uptd);die;
			$data['kelurahan'] = $this->general2->lihatisitabel('kelurahan',array('id'=>$id_kel))->result();

			//$data['form'] = $this->load->view('pengguna/laporan/kelurahan',$data);
			//print_r($data);die;
			$this->load->view('pengguna/laporan/kelurahan',$data);


		}

		//Kecamatan
		else if($this->session->userdata('level')=='Kecamatan'){
			$id_pegawai = $this->session->userdata('id_pegawai');
			$token=$this->session->userdata('token');
			$hasil=$this->api->detail_pegawai($id_pegawai,$token);
			$datax=json_decode($hasil);
			$id_kec = $datax[0]->instansi_uptd;

			$data['kecamatan'] = $this->general2->lihatisitabel('kecamatan',array('id'=>$id_kec))->result();
			$this->load->view('pengguna/laporan/kecamatan',$data);
		}
		else{
			$data['kecamatan'] = $this->general2->lihatisitabel('kecamatan',null)->result();
			$this->load->view('pengguna/laporan/kecamatan',$data);
		}
	}

	function get_lurah($kecamatan){
		
		
		$result = $this->general2->lihatisitabel('kelurahan',["kecamatan_id"=>$kecamatan])->result();
		//echo $this->db->last_query();die;
		$row = array();
		foreach($result as $fetch){
			$data = array();
			$data['id'] = $fetch->id;
			$data['kelurahan'] = $fetch->kelurahan;
			
			$row[] = $data;
		}
		
		
		echo json_encode($row);
	}

	function data_filter(){
		$list = $this->laporan->get_datatables();
		//echo $this->db->last_query();die;
		$data = array();
		$no = $_POST['start'];
		$a = 1;
		foreach ($list as $fetch) {
			$no++;
			$row = array();
			$row[] = $a;
			// $row[] = $fetch->modul;
			// $row[] = $fetch->judul;
			$row[] = $fetch->nama;
			$row[] = $fetch->nama_kelurahan;
			$row[] = $fetch->rw.'/'.$fetch->rt;
			$row[] = $fetch->sudah_verifikasi;
			if($fetch->sistem==1){
				$row[] = 'Tahunan '. $fetch->tahun;
			}
			else if($fetch->sistem==2){
				$row[] = 'Semester '. $fetch->bagian.' / '. $fetch->tahun;
			}
			else if($fetch->sistem==3){
				$row[] = 'triwulan '. $fetch->bagian.' /  '. $fetch->tahun;
			}
			else{
				$row[] = 'bulanan '. $fetch->bagian.' /  '. $fetch->tahun;
			}

			
			$row[] = '<a type="button"  class="btn btn-sm btn-primary" href="'.base_url("laporan/detail/".$fetch->created_by."/".$fetch->id_sistem).'">Detail</a>
				   ';
			$data[] = $row;
			$a++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->laporan->count_all(),
						"recordsFiltered" => $this->laporan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function get_data(){
		$data = $_POST;

		$this->db->select("a.created_by,b.`nama`,c.`kelurahan` as nama_kelurahan,b.`kelurahan` ,b.`rw`,b.rt,d.sistem,d.`id_sistem`,COUNT(a.`id_rumah`) AS sudah_verifikasi,d.`bagian`,d.`tahun`");
		$this->db->from("dasawisma_rumah a");
		$this->db->join("kader_dasawisma b","a.created_by=b.username");
		$this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
		$this->db->join("sistem d","a.`id_sistem`=d.`id_sistem`","LEFT");
		$this->db->where('a.status_verifikasi','1');
		$this->db->group_by('a.`id_sistem`');
		$this->db->having('sudah_verifikasi > 0');


		if(isset($data['kecamatan']) && $data['kecamatan'] != ""){
			$this->db->join("kecamatan e","c.`kecamatan_id`=e.`id`","LEFT");
			$this->db->where("e.id",$data['kecamatan']);
		}
		if(isset($data['kelurahan']) && $data['kelurahan'] != ""){
			
			$this->db->where("b.kelurahan",$data['kelurahan']);
		}

		if(isset($data['rw']) && $data['rw'] != ""){
			
			$this->db->where("b.rw",$data['rw']);
		}

		if(isset($data['rt']) && $data['rt'] != ""){
			
			$this->db->where("b.rt",$data['rt']);
		}

		if($data['sistem'] != ""){
			
			$this->db->where("d.`id_sistem`",$data['sistem']);
		}

		if($data['tahun'] != ""){
			
			$this->db->where("d.`tahun`",$data['tahun']);
		}

		
		$query = $this->db->get();

		$list = $query->result();
		$hasil = array();
		$a = 1;
		foreach ($list as $fetch) {
			$row = array();
			$row[] = $a;
			// $row[] = $fetch->modul;
			// $row[] = $fetch->judul;
			$row[] = $fetch->nama;
			$row[] = $fetch->nama_kelurahan;
			$row[] = $fetch->rw.'/'.$fetch->rt;
			$row[] = $fetch->sudah_verifikasi;
			if($fetch->sistem==1){
				$row[] = 'Tahunan '. $fetch->tahun;
			}
			else if($fetch->sistem==2){
				$row[] = 'Semester '. $fetch->bagian.' / '. $fetch->tahun;
			}
			else if($fetch->sistem==3){
				$row[] = 'triwulan '. $fetch->bagian.' /  '. $fetch->tahun;
			}
			else{
				$row[] = 'bulanan '. $fetch->bagian.' /  '. $fetch->tahun;
			}

			
			$row[] = '<a type="button"  class="btn btn-sm btn-primary" href="'.base_url("pengguna/verifikasi/detail/".$fetch->created_by."/".$fetch->id_sistem).'">Verifikasi</a>
				   ';
			$hasil[] = $row;
			$a++;
		}

		$output = array(
						
						"data" => $hasil,
				);
		//output to json format
		echo json_encode($output);
	}

	function detail($kader,$id_sistem){
		
		$this->db->select('b.*,c.kelurahan as nama_kelurahan');
		$this->db->from('kader_dasawisma b');
		$this->db->join("kelurahan c","b.`kelurahan`=c.`id`","LEFT");
		$this->db->where('b.username',$kader);
		$data['kader'] = $this->db->get()->row();

		$this->db->select('a.kecamatan');
		$this->db->from('kecamatan a');
		$this->db->join("kelurahan c","a.`id`=c.`kecamatan_id`","LEFT");
		$this->db->where('c.id',$data['kader']->kelurahan);
		$data['kecamatan'] = $this->db->get()->row()->kecamatan;

		////echo $this->db->last_query();die;

		
		$fetch = $this->general2->lihatisitabel('sistem',array('id_sistem'=>$id_sistem))->row();

		if($fetch->sistem==1){
			$data['sistem'] = 'Tahunan '. $fetch->tahun;
		}
		else if($fetch->sistem==2){
			$data['sistem'] = 'Semester '. $fetch->bagian.' / '. $fetch->tahun;
		}
		else if($fetch->sistem==3){
			$data['sistem'] = 'triwulan '. $fetch->bagian.' /  '. $fetch->tahun;
		}
		else{
			$data['sistem'] = 'bulanan '. $fetch->bagian.' /  '. $fetch->tahun;
		}

		$data['tahun'] = $fetch->tahun;

		$data['id_sistem']=$id_sistem;
		$data['rumah'] = $this->general2->lihatisitabel('dasawisma_rumah',['created_by'=>$kader,'id_sistem'=>$id_sistem,'status_verifikasi'=>'1'])->result();
		
		//$data['sistem']=$this->db->query("select * from pertanyaan where id='".$id_pertanyaan."'")->result();
		
		$data['page']='pengguna/laporan/detail';
		$this->load->view('main_page/main',$data);		
	}

	function buku2(){
		$id_rumah = $this->input->post('id_rumah');
		$data['id_sistem'] = $this->input->post('id_sistem');
		$data['kader'] = $this->input->post('kader');
		$data['id_rumah'] = $id_rumah;
		$this->load->view('pengguna/laporan/buku2',$data);
	}

	function buku3(){
		$id_rumah = $this->input->post('id_rumah');
		$data['id_sistem'] = $this->input->post('id_sistem');
		$data['kader'] = $this->input->post('kader');
		$data['id_rumah'] = $id_rumah;
		$this->load->view('pengguna/laporan/buku3',$data);
	}

	function buku1(){

		$id_rumah = $this->input->post('id_rumah');
		$data['id_sistem'] = $this->input->post('id_sistem');
		$data['id_rumah'] = $id_rumah;
		$data['kk'] = $this->general2->lihatisitabel('dasawisma_kk',['id_rumah'=>$id_rumah])->result();
		$syarat = $this->db->from('pertanyaan a');
        $syarat = $this->db->where(['a.note_buku1' => 1]);;
        $data['syarat'] = $this->db->get()->result();

        $this->db->from('pertanyaan a');
        $this->db->where(['a.buku1' => 1]);
        $this->db->order_by('a.urutan','asc');
        $kode = $this->db->get();
        $data['buku1'] = $kode->result();

        $base = 'SELECT ';
        foreach($data['buku1'] as $d) {
        	$base .= 'MAX(CASE WHEN a.id = "'.$d->id.'" THEN a.slug END) AS '.$d->slug.',';
        }
        $base .=" id FROM pertanyaan a";
        $data['result'] = $this->db->query($base)->result_array();

        //echo $this->db->last_query();die;
       


		$this->load->view('pengguna/laporan/buku1',$data);
	}

	function rumah(){
		$id_sistem = $this->input->post('id_sistem');
		$id_rumah = $this->input->post('id_rumah');
		$kader = $this->input->post('kader');

		$rumah = $this->general2->lihatisitabel('dasawisma_rumah',['id_sistem'=>$id_sistem,'created_by'=>$kader,'status_verifikasi'=>'1'])->result();

		$this->db->from('pertanyaan a');
        $this->db->where(['a.buku2' => 1]);;
        $syarat = $this->db->get()->result();

		$col = array();
		foreach ($rumah as $key) {
			$row = array();
			$row['nama_rt'] = $key->nama_rt;
			foreach ($syarat as $value) {

				//jumlah_kk

				$this->db->group_by('no_kk');
				$survey = $this->general2->lihatisitabel('dasawisma_survey',['id_pertanyaan'=>$value->id,'id_rumah'=>$key->id_rumah]);

				$row['jumlah_kk'] = $survey->num_rows();

				if($value->slug == 'jenis_kelamin' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$value->slug.'_'.$jwb->kode] = $val[0][$jwb->kode];
					}	
				}

				if($value->slug == 'apakah_anda_sedang_hamil'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['ibu_hamil'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_anda_sedang_menyusui'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['menyusui'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_anda__buta_aksara'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['buta'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_berkebutuhan_khusus'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['abk'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'kriteria_rumah' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$value->slug.'_'.$jwb->kode] = $val[0][$jwb->kode];
					}
				}

				if($value->slug == 'memiliki_tempat_pembuangan_sampah'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['sampah'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'memiliki_spal'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['spal'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'memiliki_jamban_keluarga'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['jamban'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'menempel_stiker_p4k'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['stiker_p4k'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'sumber_air_keluarga' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$jwb->jawaban] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'makanan_pokok' ){

					$jawaban = $this->general2->lihatisitabel('jawaban',['pertanyaan_id'=>$value->id]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->kode;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row[$jwb->kode] = $val[0][$jwb->kode];
					}
				}

				if($value->slug == 'apakah_mengikuti_up2k'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['up2k'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_adanya_pemanfaatan_tanah_pekarangan'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['pekarangan'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_rumah_ini_menjadi_industri_rumah_tangga'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['industri'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'apakah_mengikuti_kerja_bakti'){

					$jawaban = $this->general2->lihatisitabel('jawaban_ya',['id'=>1]);
					foreach ($jawaban->result() as $jwb) {
						$query = "SELECT ";
        				$query .= 'SUM(CASE WHEN a.`jawaban` = '.$jwb->id.' THEN 1 ELSE 0 END) AS '.$jwb->jawaban;
        				$query .= " FROM dasawisma_survey a LEFT JOIN jawaban_ya c ON a.`jawaban`=c.`id` WHERE a.`id_pertanyaan`='$value->id' AND id_rumah='$key->id_rumah' AND buku3='0'";
						$val = $this->db->query($query)->result_array();
						//print_r($val[0][$jwb->kode]);die;
						$row['kerja_bakti'] = $val[0][$jwb->jawaban];
					}
				}

				if($value->slug == 'tanggal_lahir'){

					
					$this->db->from('pertanyaan a');
			        $this->db->where(['a.slug' => 'jenis_kelamin']);
			        $this->db->or_where(['a.slug' => 'status_perkawinan']);
			        $this->db->or_where(['a.slug' => 'tanggal_lahir']);
			        $hitung = $this->db->get()->result();

			        $query2 = 'SELECT ';
			        foreach($hitung as $d) {
			        	
			            if($d->type_jawaban=='3'){
			            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.id END) AS '.$d->slug.',';
			        	}
			        	else if($d->type_jawaban==5){
			            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.id END) AS '.$d->slug.',';
			        	}
			        	else{
			        		 $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
			        	}
			        	
			        }
			        $query2 .=" b.`type_jawaban` FROM dasawisma_survey a";
			        $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
			        $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
			        $query2 .=" WHERE a.no_kk IS NOT NULL  AND a.id_rumah='".$key->id_rumah."' and buku3='0' GROUP BY a.no_survey";
			        $res_hitung = $this->db->query($query2)->result();
			        $lansia=0 ;
			        $pus=0;
			        $balita_l=0;
			        $balita_p=0;
			        $wus=0;
			        foreach ($res_hitung as $count_data) {
			        	
			        	$d1 = new DateTime(date('Y-m-d'));
						$d2 = new DateTime($count_data->tanggal_lahir);
						$diff = $d1->diff($d2);
						$umur=$diff->y;



						if($umur>=65){
							$lansia = $lansia+1;
						}

						if($umur<=5){

							$jwb = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->jenis_kelamin])->row();
							
							if($jwb->kode == 'L'){
								$balita_l = $balita_l+1;
							}
							else{
								$balita_p = $balita_p+1;
							}
						}

						if($umur >=15 && $umur<=49){
							$jwb = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->jenis_kelamin])->row();
							
							if($jwb->kode == 'P'){
								$wus = $wus+1;
								$stat = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->status_perkawinan])->row();
							
								if($stat->kode == 'menikah'){
									$pus = $pus+1;
								}
							}
							else{
								$stat = $this->general2->lihatisitabel('jawaban',['id'=>$count_data->status_perkawinan])->row();
							
								if($stat->kode == 'menikah'){
									$pus = $pus+1;
								}
							}

						}

						$row['lansia'] = $lansia;
						$row['balita_l'] = $balita_l;
			        	$row['balita_p'] = $balita_p;
			        	$row['pus'] = $pus;
			        	$row['wus'] =$wus;
			        }
			        
				}
				
			}


			$col[] = $row;

		}
			
		$data['rumah']=$col;
		echo json_encode($data);

		//print("<pre>".print_r($col,true)."</pre>");	
	}

	function get_laporan(){
		$id_sistem = $this->input->post('id_sistem');
		$kader = $this->input->post('kader');
		$this->db->from('pertanyaan a');
        $this->db->where(['a.buku3_stat' => 1]);;
        $syarat = $this->db->get()->result();

        $rumah = $this->general2->lihatisitabel('dasawisma_rumah',['id_sistem'=>$id_sistem,'created_by'=>$kader,'status_verifikasi'=>'1'])->result();
        $rumah_kader = "";
        foreach ($rumah as $key) {
        	
        	$rumah_kader .= $key->id_rumah.',';

        }
         $rumah_kader = rtrim($rumah_kader, ',');
        // echo $rumah_kader;die;
        $query = "SELECT * FROM dasawisma_survey a WHERE a.`id_rumah` IN ($rumah_kader) AND buku3='1' GROUP BY no_survey";
        $rumah_yg_memiliki_laporan= $this->db->query($query)->result();
        

		$col = array();
		foreach ($rumah_yg_memiliki_laporan as $key) {
			$row = array();

			$this->db->select('*,a.created_at as tgl_survey');
			$this->db->from('dasawisma_survey a');
			$this->db->join("pertanyaan b","a.id_pertanyaan=b.id");
			$this->db->where('a.`no_survey`',$key->no_survey);
			$get_survey = $this->db->get()->result();
		
		
			$query2 = 'SELECT ';
			foreach ($get_survey as $d) {
				if($d->type_jawaban=='3'){
            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN c.jawaban END) AS '.$d->slug.',';
	        	}
	        	else if($d->type_jawaban==5){
	            	$query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN d.jawaban END) AS '.$d->slug.',';
	        	}
	        	else{
	        		 $query2 .= 'MAX(CASE WHEN a.id_pertanyaan = "'.$d->id.'" THEN a.jawaban END) AS '.$d->slug.',';
	        	}
	        	
		        
			}
				$query2 .=" a.created_at FROM dasawisma_survey a";
		        $query2 .=" JOIN pertanyaan b ON a.`id_pertanyaan`=b.`id`"; 
		        $query2 .=" LEFT JOIN jawaban c ON a.`jawaban`=c.`id` ";
		        $query2 .=" LEFT JOIN jawaban_ya d ON a.`jawaban`=d.`id`";
		        $query2 .=" WHERE a.no_survey='".$key->no_survey."' ";
		        $val = $this->db->query($query2)->row();
		    	//print_r($val->status_laporan);die;
			    foreach ($get_survey as $t) {
			    	$slug = $t->slug;
			    	$row[$slug] = $val->$slug;
			    	$row['created_at'] = $this->tanggal->hariini($t->tgl_survey);
			    }


			$col[]=$row;
		}
		//print("<pre>".print_r($col,true)."</pre>");	
		$data['buku3']=$col;
		echo json_encode($data);
	}

	

	
	
}