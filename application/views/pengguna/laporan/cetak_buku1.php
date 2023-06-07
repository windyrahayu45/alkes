<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<style>
		* {
		  box-sizing: border-box;
		}

		
		.row {
		  display: flex;
		  margin-left:-5px;
		  margin-right:-5px;
		}

		.column {
		  flex: 50%;
		  padding: 5px;
		}

		/*table {
		  border-collapse: collapse;
		  border-spacing: 0;
		  width: 100%;
		  border: 1px solid #ddd;
		}*/

		
		</style>
	
	<body>
		<div class="section">
		<h6 style="text-align: center; font-size: 15px"><b>Catatan Keluarga</b></h6>
		<div style="display: flex;margin-left:-5px;margin-right:-5px;font-size: 10px">
		    <div  style="float: left; flex: 50%;padding: 5px;">
		     	<table width="100%" border="1" cellpadding="0" cellspacing="0" >
		        <tr>
		          <td width="20%" style="text-align: left;">CATATAN KELUARGA DARI</td>
		          <td width="5%" style="text-align: center;"> : </td>
		          <td width="25%" style="text-align: left;" ><?=$kk->nama_kk?></td>

		        </tr>
		        <tr>
		          <td  width="20%" style="text-align: left;">ANGGOTA KELOMPOK DASAWISMA</td>
		          <td width="5%" style="text-align: center;"> : </td>
		          <td width="25%"  style="text-align: left;" ><?=$dasawisma?></td>
		        </tr>
		         <tr>
		          <td style="text-align: left;">TAHUN</td>
		          <td style="text-align: center;"> : </td>
		          <td style="text-align: left;"  ><?=$tahun?></td>
		        </tr>
		      </table>
		    </div>
		    <div style="float: right; flex: 50%;padding: 5px;">
		      <!-- <table  border=1 cellspacing=0 cellpadding=0 
		       style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;' > -->

		       <table width="100%" border="1" cellpadding="0" cellspacing="0" >
		        	<?php foreach ($syarat as $key ):  $slug = $key->slug; ?>

		        		<tr>
				          <td style="text-align: left;"><?=$key->pertanyaan?></td>
				          <td style="text-align: center;"> : </td>
				          <td style="text-align: left;" ><?=$hasil->$slug?></td>
				        </tr>
		        		
		        	<?php endforeach; ?>
		      </table>
			
		     <!--  </table> -->
		    </div>
		</div>
		<div style="padding-top: 120px">
		
		<table width="100%" border="2" cellpadding="3" cellspacing="0" style="border-bottom:3px solid #000000; font-size: 10px">
          <thead>
              <tr> 
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">NO</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA ANGGOTA KELUARGA</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">STATUS PERKAWINAN</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">L/P</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">TEMPAT LAHIR</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">TGL LAHIR/UMUR</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">AGAMA</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">PENDIDIKAN</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">PEKERJAAN</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">BERKEBUTUHAN KHUSUS</th>
                  <th colspan="8" style="text-align: center;">KEGIATAN PKK YANG DIIKUTI</th>
                  <th rowspan="2">KET</th>
              </tr>
              <tr>
                  <th>PENGHAYATAN DAN PENGAMALAN PANCASILA</th>
                  <th>GORO</th>
                  <th>PENDIDIKAN DAN KETERAMPILAN</th>
                  <th>PENGEMBANGAN KEHIDUPAN BERKOPERASI</th>
                  <th>PANGAN</th>
                  <th>SANDANG</th>
                  <th>KESEHATAN</th>
                  <th>PERENCANAAN SEHAT</th>
              </tr>
          </thead>
          <tbody>
          	<?php $no=1; foreach ($result as $key ) : ?>
          		<tr>
          			<td align="left"> <?=$no++?> </td>
          			<?php foreach ($buku1 as  $value) : $slug= $value->slug;?>
          				<td align="left"> <?=$key->$slug?> </td>
          			<?php endforeach; ?>
          			<td align="left"> </td>
          		</tr>

          		
          	<?php endforeach; ?>
          </tbody>
          
      	</table>

      	</div>
		
		
      </div>
	</body>
</html>