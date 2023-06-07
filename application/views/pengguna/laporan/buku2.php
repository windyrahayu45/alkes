
<div class="row">
  <div class="table-responsive">
    <table class="table table-bordered table-md" id="table-module2" border=1 cellspacing=0 cellpadding=0 
       style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;'>
        <thead>
            <tr> 
                <th rowspan="3" style="vertical-align : middle;text-align:center;">NO</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">NAMA KEPALA RUMAH TANGGA</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">JUMLAH KK</th>
                <th colspan="11"  style="vertical-align : middle;text-align:center;">JUMLAH ANGGOTA KELUARGA</th>
                <th colspan="6"  style="vertical-align : middle;text-align:center;">KRITERIA RUMAH</th>
                <th colspan="3"  style="vertical-align : middle;text-align:center;">SUMBER AIR KELUARGA</th>
                <th colspan="2"  style="vertical-align : middle;text-align:center;">MAKANAN POKOK</th>
                <th colspan="4"  style="vertical-align : middle;text-align:center;">WARGA MENGIKUTI KEGIATAN</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">KET</th>
                
            </tr>
            <tr>
                <th colspan="2" style="vertical-align : middle;text-align:center;">TOTAL</th>
                <th colspan="2" style="vertical-align : middle;text-align:center;">BALITA</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">PUS</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">WUS</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">IBU HAMIL</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">IBU MENYUSUI</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">LANSIA</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">3 BUTA</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">BERKEBUTUHAN KHUSUS</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">SEHAT LAYAH HUNI</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">TIDAK SEHAT LAYAK HUNI</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">MEMILIKI TEMPAT PEMBUANGAN SAMPAH</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">MEMILIKI SPAL</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">MEMILIKI JAMBAN KELUARGA</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">MENEMPEL STIKER P4K</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">PDAM</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">SUMUR</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">DLL</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">BERAS</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">NON BERAS</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">UP2K</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">PEMANFAATAN TANAH PEKARANGAN</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">INDUSTRI RUMAH TANGGA</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">KERJA BAKTI</th>
            </tr>
            <tr>
              <th  style="vertical-align : middle;text-align:center;">L</th>
              <th  style="vertical-align : middle;text-align:center;">P</th>
               <th  style="vertical-align : middle;text-align:center;">L</th>
              <th  style="vertical-align : middle;text-align:center;">P</th>

            </tr>
        </thead>
        <tbody >
        </tbody>
        <tfoot>

        </tfoot>
    </table>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function(){
     openSolution();
  })
  
  function openSolution(){
    let id_sistem = '<?=$id_sistem?>';
    let id_rumah = '<?=$id_rumah?>';
    let kader = '<?= $kader?>';
     $.ajax({
        url: '<?php echo site_url('laporan/rumah'); ?>',
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
          $('#table-module tbody').empty();
        

            var trHTML = '';
            var tfHTML = '';
            let jumlah_kk=0;
            let jenis_kelamin_L=0;
            let jenis_kelamin_P=0;
            let balita_l=0;
            let balita_p=0;
            let pus=0;
            let wus=0;
            let ibu_hamil=0;
            let menyusui=0;
            let lansia=0;
            let buta=0;
            let abk=0;
            let kriteria_rumah_Sehat=0;
            let kriteria_rumah_Tidak=0;
            let sampah=0;
            let spal=0;
            let jamban=0;
            let stiker_p4k=0;
            let PDAM=0;
            let Sumur=0;
            let Dll=0;
            let Beras=0;
            let non_beras=0;
            let up2k=0;
            let pekarangan=0;
            let industri=0;
            let kerja_bakti=0;

            $.each(response['rumah'], function (i, item) {
              jumlah_kk += parseInt(item.jumlah_kk);
              jenis_kelamin_L += parseInt(item.jenis_kelamin_L);
              jenis_kelamin_P += parseInt(item.jenis_kelamin_P);
              balita_l += parseInt(item.balita_l);
              balita_p += parseInt(item.balita_p);
              pus += parseInt(item.pus);
              wus += parseInt(item.wus);
              ibu_hamil += parseInt(item.ibu_hamil);
              menyusui += parseInt(item.menyusui);
              lansia += parseInt(item.lansia);
              buta += parseInt(item.buta);
              abk += parseInt(item.abk);
              kriteria_rumah_Sehat += parseInt(item.kriteria_rumah_Sehat);
              kriteria_rumah_Tidak += parseInt(item.kriteria_rumah_Tidak);
              sampah += parseInt(item.sampah);
              spal += parseInt(item.spal);
              jamban += parseInt(item.jamban);
              stiker_p4k += parseInt(item.stiker_p4k);
              PDAM += parseInt(item.PDAM);
              Sumur += parseInt(item.Sumur);
              Dll += parseInt(item.Dll);
              Beras += parseInt(item.Beras);
              non_beras += parseInt(item.non_beras);
              up2k += parseInt(item.up2k);
              pekarangan += parseInt(item.pekarangan);
              industri += parseInt(item.industri);
              kerja_bakti += parseInt(item.kerja_bakti);
              

              trHTML += '<tr><td>' + (i+1) + '</td>';
              trHTML +='<td>' + item.nama_rt + '</td>';
              trHTML +='<td>' + item.jumlah_kk + '</td>';
              trHTML +='<td>' + item.jenis_kelamin_L + '</td>';
              trHTML +='<td>' + item.jenis_kelamin_P + '</td>';
              trHTML +='<td>' + item.balita_l + '</td>';
              trHTML +='<td>' + item.balita_p + '</td>';
              trHTML +='<td>' + item.pus + '</td>';
              trHTML +='<td>' + item.wus + '</td>';
              trHTML +='<td>' + item.ibu_hamil + '</td>';
              trHTML +='<td>' + item.menyusui + '</td>';
              trHTML +='<td>' + item.lansia + '</td>';
              trHTML +='<td>' + item.buta + '</td>';
              trHTML +='<td>' + item.abk + '</td>';
              trHTML +='<td>' + item.kriteria_rumah_Sehat + '</td>';
              trHTML +='<td>' + item.kriteria_rumah_Tidak + '</td>';
              trHTML +='<td>' + item.sampah + '</td>';
              trHTML +='<td>' + item.spal + '</td>';
              trHTML +='<td>' + item.jamban + '</td>';
              trHTML +='<td>' + item.stiker_p4k + '</td>';
              trHTML +='<td>' + item.PDAM + '</td>';
              trHTML +='<td>' + item.Sumur + '</td>';
              trHTML +='<td>' + item.Dll + '</td>';
              trHTML +='<td>' + item.Beras + '</td>';
              trHTML +='<td>' + item.non_beras + '</td>';
              trHTML +='<td>' + item.up2k + '</td>';
              trHTML +='<td>' + item.pekarangan + '</td>';
              trHTML +='<td>' + item.industri + '</td>';
              trHTML +='<td>' + item.kerja_bakti + '</td>';
              
              //return false;
              trHTML +='</tr>';


            });

           // console.log(response['result']);
            

              tfHTML += '<tr><td colspan="2">Jumlah</td>';
              tfHTML +='<td>' + jumlah_kk + '</td>';
              tfHTML +='<td>' + jenis_kelamin_L + '</td>';
              tfHTML +='<td>' + jenis_kelamin_P + '</td>';
              tfHTML +='<td>' + balita_l + '</td>';
              tfHTML +='<td>' + balita_p + '</td>';
              tfHTML +='<td>' + pus + '</td>';
              tfHTML +='<td>' + wus + '</td>';
              tfHTML +='<td>' + ibu_hamil + '</td>';
              tfHTML +='<td>' + menyusui + '</td>';
              tfHTML +='<td>' + lansia + '</td>';
              tfHTML +='<td>' + buta + '</td>';
              tfHTML +='<td>' + abk + '</td>';
              tfHTML +='<td>' + kriteria_rumah_Sehat + '</td>';
              tfHTML +='<td>' + kriteria_rumah_Tidak + '</td>';
              tfHTML +='<td>' + sampah + '</td>';
              tfHTML +='<td>' + spal + '</td>';
              tfHTML +='<td>' + jamban + '</td>';
              tfHTML +='<td>' + stiker_p4k + '</td>';
              tfHTML +='<td>' + PDAM + '</td>';
              tfHTML +='<td>' + Sumur + '</td>';
              tfHTML +='<td>' + Dll + '</td>';
              tfHTML +='<td>' + Beras + '</td>';
              tfHTML +='<td>' + non_beras + '</td>';
              tfHTML +='<td>' + up2k + '</td>';
              tfHTML +='<td>' + pekarangan + '</td>';
              tfHTML +='<td>' + industri + '</td>';
              tfHTML +='<td>' + kerja_bakti + '</td>';
              
              //return false;
              tfHTML +='</tr>';

            $('#table-module2  > tbody').append(trHTML);
            $('#table-module2  > tfoot').append(tfHTML);
            
        }
      });
  }

  
</script>