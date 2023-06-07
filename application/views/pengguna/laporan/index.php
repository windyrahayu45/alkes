<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
  <div class="section-header">
    <h1>Laporan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Laporan</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('laporan')?>">Components</a></div>
      <div class="breadcrumb-item">Laporan</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Laporan</h2>
    <p class="section-lead">Laporan Buku 1,Buku 2 dan Buku 3</p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Filter Laporan</h4>
            </div>
            <div class="card-body">
              <!-- <div class="row"> -->
              <form id="form-save">

                <div id="form-filter">
                </div>

                <div class="form-group">
                  <label>Sistem Survey</label>
                  <select class="form-control select2" name="sistem" id="sistem">
                    <option value="">Pilih Sistem Survey</option>
                    <option value="1">Tahunan</option>
                    <option value="2">Semester</option>
                    <option value="3">triwulan</option>
                    <option value="4">bulanan</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Tahun</label>
                  <input type="number" name="tahun" id="tahun" class="form-control"  maxlength="0000">
                </div>

                <div class="form-group">
                  <button type="button" id="add-button" class="btn btn-primary">Filter Data</button>
                </div>
              </form>

              <div class="table-responsive">
              <table class="table table-bordered table-md" id="table-module">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kader</th>
                  <th>Kelurahan</th>
                  <th>RW/RT</th>
                  <th>Total Rumah Diverifikasi</th>
                  <th>Sistem Survey</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
           
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
    let table;
    $(document).ready(function(){
      $('#table-module').hide();
      
      $('input[type=number][maxlength]:not([maxlength=""])').on('input', function(ev) {
          var $this = $(this);
          var maxlength = $this.attr('maxlength').length;
          var value = $this.val();
          if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
          }
      });
      let level = '<?= $this->session->userdata('level')?>';
      $.ajax({
          url: '<?php echo site_url('laporan/get_form'); ?>',
          type: 'post',
          success: function(response){
            $('#form-filter').html(response);
            if(level === 'Kelurahan'){
                var kelurahan = $('#kelurahan').val();
                //alert(kelurahan);
                loadKelurahan(kelurahan);  
            }

            if(level === 'Kecamatan'){
                var kecamatan = $('#kecamatan').val();
                //alert(kecamatan);
                loadKecamatan(kecamatan);  
            }

            if(level === '3'){
                var kelurahan = $('#kelurahan').val();
                var rw = $('#rw').val();
                get_RT(rw,kelurahan);
            }
          }
      });


      
    });


    $(document).on('change','#kelurahan',function(){
      var kelurahan = $(this).val();
      if(kelurahan == ""){
        $("#rw").empty();
      }
      loadKelurahan(kelurahan);
    });

    $(document).on('change','#kecamatan',function(){
      var kecamatan = $(this).val();
      loadKecamatan(kecamatan);
    });

    $(document).on('change','#rw',function(){

      var kelurahan = $('#kelurahan').val();
      var rw = $(this).val();
      if(rw == ""){
        $("#rt").empty();
      }
      get_RT(rw,kelurahan);
    });

    function loadKecamatan(kecamatan){
      if(kecamatan != ''){
        $.ajax({
          url: '<?=site_url('laporan/get_lurah');?>/'+kecamatan,
          dataType: 'json',
            beforeSend: function(){
                $('#progress').show();
            },
            success: function(data){
                if(data['result'] != 0){
                  $('#kelurahan').html('');
                  $('#kelurahan').append('<option value=""> --- Pilih kelurahan --- </option>');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#kelurahan').append('<option value="'+data[a]['id']+'">'+data[a]['kelurahan']+'</option>');
                  }

                  //loadKelurahan(data[0]['id']);
                }
                $('#progress').hide();
          }
        });
      }
      else{
        $('#rw').html('');
        $('#rw').append('<option value=""> --- Pilih RW --- </option>');
        $('#rw').val('');
      }
    }

    function loadKelurahan(kelurahan){
      if(kelurahan != ''){
        $.ajax({
          url: '<?=site_url('aplikasi_modul/kader/get_rw');?>/'+kelurahan,
          dataType: 'json',
            beforeSend: function(){
                $('#progress').show();
            },
            success: function(data){
                if(data['result'] != 0){
                  $('#rw').html('');
                   $('#rw').append('<option value=""> --- Pilih RW --- </option>');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#rw').append('<option value="'+data[a]['rw']+'">'+data[a]['rw']+'</option>');
                  }

                  //get_RT(data[0]['rw'],kelurahan);
                }
                $('#progress').hide();
          }
        });
      }
      else{
        $('#rw').html('');
        $('#rw').append('<option value=""> --- Pilih RW --- </option>');
        $('#rw').val('');
      }
    }

    function get_RT(rw,kelurahan){

      $.ajax({
          url: '<?=site_url('aplikasi_modul/kader/get_rt');?>/'+rw+'/'+kelurahan,
          dataType: 'json',
           
            success: function(data){
                if(data['result'] != 0){
                  $('#rt').html('');
                  $('#rt').append('<option value=""> --- Pilih RT --- </option>');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#rt').append('<option value="'+data[a]['rt']+'">'+data[a]['rt']+'</option>');
                  }

                 
                }
                $('#progress').hide();
          }
        });

    }

     $(document).on('click',"#add-button",function(){
        $("#table-module").dataTable().fnDestroy();
        //e.preventDefault();
        $('#table-module').show();
        // $.ajax({
        //     url: '<?=site_url('laporan/get_data');?>',
        //     data: $(this).serialize(),
        //     type: 'post',
        //     beforeSend: function(){
        //         $('#save-button').text('Loading...');
        //         $('#save-button').attr('disabled',true);
        //     },
        //     success: function(data){
                
        //         $('#table-module').show();
        //         var table_data = JSON.parse(data);
        //         var table = $('#table-module').DataTable( {
        //                data: table_data,
        //               searching : false
        //         });

                
        //     }
        // })

        $('#table-module').DataTable({ 
        
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            
            // Load data for the table's content from an Ajax source
            "ajax": {
              "url": "<?php echo site_url('laporan/data_filter')?>",
              "type": "POST",
                "data": function ( data ) {
                    data.kecamatan = $('#kecamatan').val();
                    data.kelurahan = $('#kelurahan').val();
                    data.rw = $('#rw').val();
                    data.rt = $('#rt').val();
                    data.sistem = $('#sistem').val();
                    data.tahun = $('#tahun').val();
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
              "targets": [ -1 ], //last column
              "orderable": false, //set not orderable
            },
            ],

        });
    });
</script>



