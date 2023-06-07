<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
  <div class="section-header">
    <h1>Level</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('aplikasi_modul/level')?>">Components</a></div>
      <div class="breadcrumb-item">Level</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Level</h2>
    <p class="section-lead">Level akses untuk aplikasi <?=$title?></p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Level</h4>
                 <?php  if($this->session->userdata('level')=='admin'){?>
                <button type="button" id="add-button" class="btn btn-primary">Tambah Data</button>
              <?php } ?>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md" id="table-module">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Modul</th>
                  <th>Level</th>
                  <th>Keterangan</th>
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
    let bidang_edit;
    $(document).ready( function () {
      table = $('#table-module').DataTable({ 
        
        "processing": true, 
        "serverSide": true, 
        "ajax": {
          "url": "<?php echo site_url('aplikasi_modul/level/get_data')?>",
          "type": "POST"
        },
        "columnDefs": [
        { 
          "targets": [ -1 ], 
          "orderable": false, 
        },
        ],
      });
    });



    function reload_table(){
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    $(document).on('click',"#add-button",function(){
        $.ajax({
          url: '<?php echo site_url('aplikasi_modul/level/modal'); ?>',
          type: 'post',
          success: function(response){
            $('#form-input').html(response);
            $('#myModal').modal('show');
          }
        });
      
    });

     $(document).on("submit", "#form-save", function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?=site_url('aplikasi_modul/level/save');?>',
            data: $(this).serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#save-button').text('Loading...');
                $('#save-button').attr('disabled',true);
            },
            success: function(data){
                $('#myModal').modal('toggle');
                Swal.fire({
                  icon: data['type'],
                  title: data['title'],
                  text: data['msg'],
                  showConfirmButton: false,
                  timer: 1500
                })
                reload_table();
                $('#save-button').text('Save changes');
                $('#save-button').attr('disabled',false);
                $("#form-save").trigger("reset");
                $("#modul_id").val("").change();
            }
        })
    });

     $(document).on('click',"#edit-button",function(){
        $.ajax({
            url: '<?=site_url('pertanyaan/proses_edit');?>',
            data: $('#form-edit').serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#edit-button').text('Loading...');
                $('#edit-button').attr('disabled',true);
            },
            success: function(data){
                $('#editModal').modal('toggle');
                swal({ title: data['title'],text: data['msg'],icon: data['type'],confirmButtonText: "OK"});
                reload_table();
                $('#edit-button').text('Save changes');
                $('#edit-button').attr('disabled',false);
                $("#form-edit").trigger("reset");
                $("#modul_id_edit").val("").change();
            }
        })
    });

    function change_state(id,status){
        let text;
        if(status==1){
            text='You will not activate account';
        }
        else{
            text='You will activate account';
        }

        
        Swal.fire({
          title: 'Are you sure?',
          text: text,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, change it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: '<?=site_url('pertanyaan/change');?>',
                data: {id:id,status:status},
                dataType: 'json',
                type: 'post',
               
                success: function(data){
                    Swal.fire({
                    icon: data['type'],
                    title: data['title'],
                    text: data['msg'],
                    showConfirmButton: false,
                    timer: 1500
                    })
                    reload_table();
                }
            })
        } else {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }

     function delete_level(id){
        
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
                url: '<?=site_url('aplikasi_modul/level/delete');?>',
                data: {id:id},
                dataType: 'json',
                type: 'post',
               
                success: function(data){
                    Swal.fire({
                    icon: data['type'],
                    title: data['title'],
                    text: data['msg'],
                    showConfirmButton: false,
                    timer: 1500
                    })
                    reload_table();
                }
            })
        } else {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }

    $(document).on('change','#id_instansi',function(){
      var id_instansi = $(this).val();
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
    });

    function edit_bidang(id){
      $.ajax({
        url: '<?php echo site_url('pertanyaan/edit'); ?>',
        type: 'post',
        data: {id:id},
        dataType: 'json',
        success: function(response){
          $('#modul_id_edit').val(response['detail']['modul_id']).change();
          //bidang_edit=response['detail']['bidang_id'];
          $('#bidang_id_edit').val(response['detail']['bidang_id']);
          $('#type_jawaban_edit').val(response['detail']['type_jawaban']).change();
          $('#pertanyaan_edit').val(response['detail']['pertanyaan']);
          $('#point_edit').val(response['detail']['point']);
          $('#urutan_edit').val(response['detail']['urutan']);
          $('#wajib_edit').val(response['detail']['wajib']).change();
          $('#id_edit').val(response['detail']['id']);
          $('#editModal').modal('show');
        }
      });
    }

    $(document).on('change','#modul_id',function(){
      var modul_id = $(this).val();
      if(modul_id != ''){
        $.ajax({
          url: '<?=site_url('pertanyaan/get_bidang');?>/'+modul_id,
          dataType: 'json',
            beforeSend: function(){
                $('#progress').show();
            },
            success: function(data){
                if(data['result'] != 0){
                  $('#bidang_id').html('');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#bidang_id').append('<option value="'+data[a]['id_bidang']+'">'+data[a]['bidang']+'</option>');
                  }
                }
                 $('#progress').hide();
          }
        });
      }
      else{
        $('#bidang_id').html('');
        $('#bidang_id').append('<option value=""> --- Pilih Bidang --- </option>');
        $('#bidang_id').val('');
      }
    });

    $(document).on('change','#modul_id_edit',function(){
      loadBidang($(this).val());
     
      
    });
</script>