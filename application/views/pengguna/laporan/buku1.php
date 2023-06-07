<ul class="nav nav-tabs" id="myTab2" role="tablist">

  <?php $id=1;foreach ($kk as $key ) : ?>

  <?php if($id == 1){ $selected ="true"; $status="active";} else { $selected="false"; $status=''; }?>

    <li class="nav-item">
      <a class="nav-link <?=$status?>" data-id="<?=$key->no_kk?>" id="home-tab2" data-toggle="tab" href="#" onClick = "openSolution('<?=$key->no_kk?>');" role="tab" aria-controls="home" aria-selected="<?=$selected?>"><?=$key->nama_kk?></a>
    </li>

   
    
  <?php $id++;  endforeach; ?>
 
  
</ul>
<div class="tab-content tab-bordered"   id="content_buku1"><br><br>
  <input type="button" class="btn btn-icon icon-left btn-primary" onclick="printDiv('content_buku1','buku1')" value="Excel" style="float: right;" />
   <input type="button" class="btn btn-icon icon-left btn-primary" onclick="printPDF('<?=$key->id_rumah?>')" value="PDF" style="float: right;" />
  <div class="row justify-content-center align-items-center">
     <h6><b>Catatan Keluarga</b></h6>
  </div><br>
  <div class="row">
   
    <div class="col-lg-6" style="float: left;">
      <table border=0 cellspacing=0 cellpadding=0 
       style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;' >
        <tr>
          <td width="50%" style="text-align: left;">CATATAN KELUARGA DARI</td>
          <td width="5%"> : </td>
          <td width="45%" style="text-align: left;" id="nama_kk"></td>
        </tr>
        <tr>
          <td style="text-align: left;">ANGGOTA KELOMPOK DASAWISMA</td>
          <td> : </td>
          <td style="text-align: left;" id="nama_dasawisma"></td>
        </tr>
         <tr>
          <td style="text-align: left;">TAHUN</td>
          <td> : </td>
          <td style="text-align: left;"  id="tahun"></td>
        </tr>
      </table>
    </div>
    <div class="col-lg-6" style="float: right;">
      <table  border=0 cellspacing=0 cellpadding=0 
       style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;' >

        <?php foreach ($syarat as $key) : ?>
        <tr>
          <td width="50%" style="text-align: left;"><?=$key->pertanyaan?></td>
          <td width="5%"> : </td>
          <td width="45%" style="text-align: left;" id="<?=$key->slug?>"></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-md" id="table-module"  border=1 cellspacing=0 cellpadding=0 
       style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;'>
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
          <tbody >

           <!--  <?php foreach ($result as $key ) : ?>
              <tr>
                <td id="no">1</td>
                <?php foreach($buku1 as $u): ?>
                  <td id="<?= $key[$u->slug]?>"></td>
                <?php endforeach;  ?>
              </tr>
             
            <?php endforeach; ?> -->
           
          </tbody>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  var nomor_kk;
  $(document).ready(function(){
    //alert('<?=$kk[0]->no_kk?>');
    openSolution('<?=$kk[0]->no_kk?>');
    nomor_kk = '<?=$kk[0]->no_kk?>';
  })
  
  function openSolution(no_kk){
    nomor_kk = no_kk;
    let id_sistem = '<?=$id_sistem?>';
    let id_rumah = '<?=$id_rumah?>';
     $.ajax({
        url: '<?php echo site_url('pengguna/Verifikasi/kk'); ?>',
        type: 'post',
        data: {no_kk:no_kk,id_sistem:id_sistem,id_rumah:id_rumah},
        dataType: 'json',
        beforeSend: function(){
            // $('#save-button').text('Loading...');
            // $('#save-button').attr('disabled',true);
        },
        success: function(response){
          $('#table-module tbody').empty();
          $('#nama_kk').text(response['kk']['nama_kk']);
          $('#tahun').text(response['tahun']);
          $('#nama_dasawisma').text(response['dasawisma']);
          //console.log(response['syarat'].length);
          //console.log(response['hasil']);
            a = 0;
            while(a<response['syarat'].length){
              $('#'+response['syarat'][a]['slug']).text(response['hasil'][response['syarat'][a]['slug']])
              //alert(response['hasil'][response['syarat'][a]['slug']]);
              a++;
            }

            var trHTML = '';
            $.each(response['result'], function (i, item) {
              

              trHTML += '<tr><td>' + (i+1) + '</td>';
              //console.log(response['buku1'].length);
              for (let i = 0; i < response['buku1'].length; i++) {
                let slug = response['buku1'][i]['slug'];
                // console.log(slug);
                // console.log(item[slug]);
                // return false;
                 trHTML +='<td>' + item[slug] + '</td>';
              }
              //return false;
                trHTML +='</tr>';
            });

            //console.log(response['result']);
            $('#table-module').append(trHTML);


            
        }
      });
  }

  function printPDF(){
    let id_sistem = '<?=$id_sistem?>';
    let id_rumah = '<?=$id_rumah?>';
    $.ajax({
            url: '<?=site_url('laporan/cetak_buku1');?>',
            data: {no_kk:nomor_kk,id_sistem:id_sistem,id_rumah:id_rumah},
            type: 'post',
            dataType: 'json',
            beforeSend: function(){
                Swal.fire({
                    title: 'Wait ...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false
                })
            },
            success: function(data){
              Swal.close();
              console.log(data['link']);
              window.open(data['link'], '_blank');
             
            }
    })
  }


  
</script>