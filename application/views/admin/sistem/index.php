<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
  <div class="section-header">
    <h1>Sistem Survey</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('sistem')?>">Components</a></div>
      <div class="breadcrumb-item">Sistem Survey</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Sistem Survey</h2>
    <p class="section-lead">Atur sistem survey aplikasi</p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Sistem Survey</h4>
                <button type="button" id="add-button" class="btn btn-primary">Tambah Data</button>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md" id="table-module">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Modul</th>
                  <th>Sistem</th>
                  <th>Bagian</th>
                  <th>Tahun</th>
                  <th>Status Aktif</th>
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

<div class="modal fade" id="myModal"  role="dialog" aria-hidden="true">
  <div id="form-input"></div> 
</div>
<script type="text/javascript">
    var table;
    
    $(document).ready( function () {
       
     // get_pegawai();
     table = $('#table-module').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('sistem/get_data')?>",
          "type": "POST"
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

    $('input[type=number][maxlength]:not([maxlength=""])').on('input', function(ev) {
      var $this = $(this);
      var maxlength = $this.attr('maxlength').length;
      var value = $this.val();
      if (value && value.length >= maxlength) {
        $this.val(value.substr(0, maxlength));
      }
    });

    function reload_table(){
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    $(document).on('change','#sistem',function(){
      var sistem = $(this).val();
    
      if(sistem==2 || sistem==3 || sistem==4){
        $('#bagianx').show();
        if(sistem==2){
          $('#judul').html('Semester ke');
          $("#bagian").attr('max','2');
        }
        else if(sistem==3){
          $('#judul').html('triwulan ke');
           $("#bagian").attr('max','4');
        }
        else{
           $('#judul').html('Bulan ke');
            $("#bagian").attr('max','12');
        }
        
      }
      else{
         $('#bagianx').hide();
      }
    });

    $(document).on('click',"#add-button",function(){
         $.ajax({
          url: '<?php echo site_url('sistem/modal'); ?>',
          type: 'post',
          success: function(response){
            $('#form-input').html(response);
            $('#myModal').modal('show');
          }
        });
    });

     $(document).on("submit", "#form-save", function(e) {
        e.preventDefault();

        var sistem = $('select[name=sistem] option').filter(':selected').val();
        if(sistem == 0){ Swal.fire('Perhatian!','Pilih Sistem terlebih dahulu','warning'); return false; }
        if(sistem >=2){
          var bagian = $('#bagian').val();
          if(bagian == ''){ Swal.fire('Perhatian!','Isikan  bagian  ke- dahulu','warning'); return false; }

          var maksimal = $('#bagian').attr('max');
          console.log(bagian);
          console.log(maksimal);

          if(bagian > maksimal){
            Swal.fire('Perhatian!','Maksimal '+$('#judul').text()+' anda saat ini adalah '+maksimal,'warning'); return false; 
          }
          else{
            var tahun = $('#tahun').val();
            if(tahun == ''){ Swal.fire('Perhatian!','Isi tahun terlebih dahulu','warning'); return false; }
          }
         
        }
        else{
          var tahun = $('#tahun').val();
          if(tahun == ''){ swal('Perhatian!','Isi tahun terlebih dahulu','warning'); return false; }
        }

        


        $.ajax({
            url: '<?=site_url('sistem/save');?>',
            data: $(this).serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#save-button').text('Loading...');
                $('#save-button').attr('disabled',true);
            },
            success: function(data){
                $('#myModal').modal('toggle');
                Swal.fire({ title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton: false,timer: 1500});
                $('#save-button').text('Save changes');
                $('#save-button').attr('disabled',false);
                $("#form-save").trigger("reset");
                $("#modul_id").val("").change();
                $('select[name=sistem] option').filter(':selected').val("0").change();
                reload_table();
            }
        })
    });

    function change_state(id,status){


        Swal.fire({
          title: 'Are you sure?',
          text: "You will not activate account",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, change it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: '<?=site_url('sistem/change');?>',
                data: {id:id,status:status},
                dataType: 'json',
                type: 'post',
               
                success: function(data){
                    Swal.fire({title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton: false,timer: 1500});
                    reload_table();
                }
            })
        } else {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }

   function get_pegawai(){
    var id_instansi = 'P00000182';
      if(id_instansi != ''){
        $.ajax({
          url: '<?=site_url('operator/get_pegawai');?>/'+id_instansi,
          dataType: 'json',
            beforeSend: function(){
                $('#progress').show();
            },
            success: function(data){
                if(data['result'] != 0){
                  $('#id_pegawai').html('');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#id_pegawai').append('<option value="'+data[a]['id_pegawai']+'">'+data[a]['nama']+'</option>');
                  }
                }
                 $('#progress').hide();
          }
        });
      }
      else{
        $('#id_pegawai').html('');
        $('#id_pegawai').append('<option value=""> --- Pilih Pegawai --- </option>');
        $('#id_pegawai').val('');
      }
   }

    


    function delete_bidang(id){
        
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: '<?=site_url('sistem/delete');?>',
                data: {id:id},
                dataType: 'json',
                type: 'post',
               
                success: function(data){
                    Swal.fire({title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton: false,timer:1500});
                    reload_table();
                }
            })
        } else {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }
</script>