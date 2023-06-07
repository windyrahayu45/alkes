<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
  <div class="section-header">
    <h1>Pertanyaan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('pertanyaan')?>">Components</a></div>
      <div class="breadcrumb-item">Pertanyaan</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Pertanyaan</h2>
    <p class="section-lead">Daftar pertanyaan per bagian modul</p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Pertanyaan</h4>
                <button type="button" id="add-button" class="btn btn-primary">Tambah Data</button>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md" id="table-module">
                <thead>
                <tr>
                  <th>No</th>
                  
                  <th>Pertanyaan</th>
                  <th>Tipe Data</th>
                 <!--  <th>Wajib</th> -->
                  <th>Status</th>
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

<div class="modal fade"  role="dialog" id="editModal">
  <form id="form-edit" class="needs-validation" novalidate >
    <div class="modal-dialog  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tipe Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
             <div class="form-group">
                <label>Modul</label>
                <select class="form-control select2" name="modul_id_edit" id="modul_id_edit" required="">
                  <option value="">Pilih Modul</option>
                  <?php  foreach ($modul as $key ) { ?>
                      <option value="<?=$key->id?>"><?=$key->modul?></option>
                  <?php } ?>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
                <button id="progress_edit" class="btn btn-sm disabled btn-primary btn-progress" style="float: right;">Progress</button>
              </div>

              <div class="form-group">
                <label>Bidang</label>
                <select class="form-control select2" name="bidang_id_edit" id="bidang_id_edit" required="">
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>

              <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan_edit" id="urutan_edit" class="form-control" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
                <input type="hidden" name="id" id="id_edit" class="form-control">
              </div>

              <div class="form-group">
                <label>Pertanyaan</label>
                <textarea name="pertanyaan_edit" id="pertanyaan_edit"  class="form-control" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>

              <div class="form-group">
                <label>Tipe Data </label>
                <select class="form-control select2" name="type_jawaban_edit" id="type_jawaban_edit" required="">
                  <?php  foreach ($tipe as $key ) { ?>
                      <option value="<?=$key->id_type?>"><?=$key->type_jawaban?></option>
                  <?php } ?>
                </select>
              </div>


              <div class="form-group">
                <label>Apakah pertanyaan ini berkaitan dengan instansi lain (Jika ada)</label>
                <select class="form-control select2" name="instansi_edit[]" id="instansi_edit"  multiple="">
                  <option value="">Pilih Instansi</option>
                  <?php  foreach ($instansi as $key ) { ?>
                      <option value="<?=$key->id_instansi?>"><?=$key->nama_instansi?></option>
                  <?php } ?>
                </select>
              </div>


              <div class="form-group">
                <label>Pilih urusan pertanyaan sesuai SPBE (Jika Ada)</label>
                <select class="form-control select2" name="urusan_edit" id="urusan_edit" >
                  <option value="0">Pilih urusan</option>
                  <?php  foreach ($urusan as $key ) { ?>
                      <option value="<?=$key->id?>"><?=$key->urusan?></option>
                  <?php } ?>
                </select>
              </div>


              <div class="form-group" id="pokja_dasawisma">
                <label>Pertanyaan ini berkaitan dengan pokja (Jika Ada)</label>
                <select class="form-control select2" name="pokja_edit" id="pokja_edit" >
                  <option value="">Pilih pokja</option>
                  <option value="1">Pokja I</option>
                  <option value="2">Pokja II</option>
                  <option value="3">Pokja III</option>
                  <option value="4">Pokja IV</option>
                  
                </select>
              </div>

              <div class="form-group">
                <label>Point</label>
                <input type="number" name="point_edit" id="point_edit" class="form-control">
              </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="edit-button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
    var table;
    let bidang_edit;

    $(document).ready( function () {
      $(".select2").select2();
      table = $('#table-module').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('pertanyaan/get_data')?>",
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


    function loadBidang(modul_id){

      //var modul_id = $(this).val();
      if(modul_id != ''){
        $.ajax({
          url: '<?=site_url('pertanyaan/get_bidang');?>/'+modul_id,
          dataType: 'json',
            beforeSend: function(){
                //$('#progress').show();
            },
            success: function(data){
                if(data['result'] != 0){
                  $('#bidang_id_edit').html('');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#bidang_id_edit').append('<option value="'+data[a]['id_bidang']+'">'+data[a]['bidang']+'</option>');
                  }
                }
                 //$('#progress').hide();
          }
        });
      }
      else{
        $('#bidang_id_edit').html('');
        $('#bidang_id_edit').append('<option value=""> --- Pilih Bidang --- </option>');
        $('#bidang_id_edit').val('');
      }
    }

    function reload_table(){
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    $(document).on('click',"#add-button",function(){
         $.ajax({
          url: '<?php echo site_url('pertanyaan/modal'); ?>',
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
            url: '<?=site_url('pertanyaan/save');?>',
            data: $('#form-save').serialize(),
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
                $("#type_jawaban").val("").change();


            }
        })
    });

    $(document).on("submit", "#form-edit", function(e) {
        e.preventDefault();
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
               Swal.fire({
                  icon: data['type'],
                  title: data['title'],
                  text: data['msg'],
                  showConfirmButton: false,
                  timer: 1500
                })
                reload_table();
                $('#edit-button').text('Save changes');
                $('#edit-button').attr('disabled',false);
                $("#form-edit").trigger("reset");
                $("#modul_id_edit").val("").change();
                $("#type_jawaban_edit").val("").change();
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
          confirmButtonText: 'Yes, delete it!'
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

    function delete_bidang(id){
        
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
                url: '<?=site_url('pertanyaan/delete');?>',
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
          //alert(response['set_pertanyaan']['bidang_id']);
          $('#modul_id_edit').val(response['modul_id']).change();
          //bidang_edit=response['detail']['bidang_id'];
          $('#progress_edit').hide();
          setTimeout(
          function() {
             $('#bidang_id_edit').val(response['set_pertanyaan']['bidang_id']).change();
          }, 1000);
         
          $('#type_jawaban_edit').val(response['detail']['type_jawaban']).change();
          $('#pertanyaan_edit').val(response['detail']['pertanyaan']);
          $('#point_edit').val(response['detail']['point']);
          $('#urutan_edit').val(response['detail']['urutan']);
          $('#instansi_edit').val(response['instansi']).change();
          $('#id_edit').val(response['detail']['id']);
          $('#urusan_edit').val(response['set_pertanyaan']['id_urusan']).change();
          $('#pokja_edit').val(response['set_pertanyaan']['pokja']).change();
          $('#editModal').modal('show');
        }
      });
    }

    $(document).on('change','#modul_id',function(){
      var modul_id = $(this).val();
      if(modul_id==8){
        $('#pokja_dasawisma').show();
      }
      else{
       $('#pokja_dasawisma').hide();
      }
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