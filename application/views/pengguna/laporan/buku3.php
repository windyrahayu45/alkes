
<div class="row">
  
 
  <div class="table-responsive">
    <table class="table table-bordered table-md" id="table-buku3" border=1 cellspacing=0 cellpadding=0 
       style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;'>
        <thead>
            <tr> 
                <th rowspan="3" style="vertical-align : middle;text-align:center;">NO</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">NAMA IBU</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">NAMA SUAMI</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">STATUS (HAMIL/MELAHIRKAN/NIFAS)</th>
                <th colspan="6"  style="vertical-align : middle;text-align:center;">CATATAN KELAHIRAN</th>
                <th colspan="7"  style="vertical-align : middle;text-align:center;">CATATAN KEMATIAN</th>
                
            </tr>
            <tr>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA BAYI</th>
                <th colspan="2" style="vertical-align : middle;text-align:center;">JENIS KELAMIN</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">TGL LAHIR</th>
                <th colspan="2" style="vertical-align : middle;text-align:center;">AKTE KELAHIRAN</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA IBU/BALITA/BAYI</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">STATUS (IBU/BALITA/BAYI)</th>
                <th colspan="2" style="vertical-align : middle;text-align:center;">JENIS KELAMIN</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">TGL MENINGGAL</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">SEBAB MENINGGAL</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">KET</th>
            </tr>
            <tr>
              <th  style="vertical-align : middle;text-align:center;">L</th>
              <th  style="vertical-align : middle;text-align:center;">P</th>
               <th  style="vertical-align : middle;text-align:center;">ADA</th>
              <th  style="vertical-align : middle;text-align:center;">TIDAK</th>
              <th  style="vertical-align : middle;text-align:center;">L</th>
              <th  style="vertical-align : middle;text-align:center;">P</th>

            </tr>
        </thead>
        <tbody >
        </tbody>
        
    </table>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function(){
     openSolution2();
  })
  
  function openSolution2(){
    let id_sistem = '<?=$id_sistem?>';
    let id_rumah = '<?=$id_rumah?>';
    let kader = '<?= $kader?>';
     $.ajax({
        url: '<?php echo site_url('laporan/get_laporan'); ?>',
        type: 'post',
        data: {id_sistem:id_sistem,id_rumah:id_rumah,kader:kader},
        dataType: 'json',
        beforeSend: function() {
          Swal.fire({
              title: 'Wait ...',
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: false,
              showConfirmButton: false
          })
        },
        success: function(response){
          Swal.close();
            $('#table-buku3 tbody').empty();
            var trHTML = '';
            $.each(response['buku3'], function (i, item) {
              $('#bulan').text(item.created_at);

              trHTML += '<tr><td>' + (i+1) + '</td>';

              if(item.status_laporan == 'Hamil'){

                trHTML +='<td>' + item.nama_ibu + '</td>';
                trHTML +='<td>' + item.nama_suami + '</td>';
                trHTML +='<td>' + item.status_laporan + '</td>';

              }

              if(item.status_laporan == 'Nifas'){

                trHTML +='<td>' + item.nama_ibu + '</td>';
                trHTML +='<td>' + item.nama_suami + '</td>';
                trHTML +='<td>' + item.status_laporan + '</td>';

              }

              if(item.status_laporan == 'Kelahiran'){

                trHTML +='<td>' + item.nama_ibu + '</td>';
                trHTML +='<td>' + item.nama_suami + '</td>';
                trHTML +='<td>' + item.status_laporan + '</td>';

                trHTML +='<td>' + item.nama_bayi + '</td>';

                if(item.jenis_kelamin == 'Laki-laki'){
                  trHTML +='<td>1</td>';
                  trHTML +='<td></td>';
                }
                else{
                  trHTML +='<td></td>';
                  trHTML +='<td>1</td>';
                }
                trHTML +='<td>' + item.tanggal_lahir + '</td>';
                if(item.apakah_memilihi_akte_kelahiran == 'Ya'){
                  trHTML +='<td>1</td>';
                  trHTML +='<td></td>';
                }
                else{
                  trHTML +='<td></td>';
                  trHTML +='<td>1</td>';
                }
                

              }

               if(item.status_laporan == 'Kematian'){

                trHTML +='<td>' + item.nama_ibu + '</td>';
                trHTML +='<td>' + item.nama_suami + '</td>';
                trHTML +='<td>' + item.status_laporan + '</td>';

                trHTML +='<td></td>';
                trHTML +='<td></td>';
                trHTML +='<td></td>';
                trHTML +='<td></td>';
                trHTML +='<td></td>';
                trHTML +='<td></td>';

                trHTML +='<td>' + item.nama_yang_meninggal + '</td>';
                trHTML +='<td>' + item.status_yang_meninggal + '</td>';
                if(item.jenis_kelamin == 'Laki-laki'){
                  trHTML +='<td>1</td>';
                  trHTML +='<td></td>';
                }
                else{
                  trHTML +='<td></td>';
                  trHTML +='<td>1</td>';
                }
                trHTML +='<td>' + item.tanggal_kematian + '</td>';
                trHTML +='<td>' + item.sebab_meninggal + '</td>';
                
                

              }

              
              trHTML +='</tr>';


            });

             $('#table-buku3  > tbody').append(trHTML);
            // $('#table-module2  > tfoot').append(tfHTML);
            
        }
      });
  }

  
</script>