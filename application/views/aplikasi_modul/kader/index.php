<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
          <div class="section-header">
            <h1>Kader Dasawisma</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?=base_url('aplikasi_modul/kader')?>">Components</a></div>
              <div class="breadcrumb-item">Kader</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Kader</h2>
            <p class="section-lead">atur kader yang akan turun survey</p>

            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Kader</h4>
                        <button type="button" id="add-button" class="btn btn-primary">Tambah Data</button>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md" id="table-module">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Dasawisma</th>
                          <th>Telp</th>
                          <th>Alamat</th>
                          <th>Status</th>
                          <th>Level</th>
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
<div class="modal fade"  role="dialog" id="exampleModal">
  <form id="form-save" class="needs-validation" novalidate >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kader</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">

                <div class="form-group" >
                    <label>Status</label>
                    <select class="form-control select2" name="kode_level" id="kode_level" required="">
                      <option value="">Pilih Status</option>
                      <option value="1">Kader Dasawisma</option>
                      <option value="2">Ketua RT</option>
                      <option value="3">Ketua RW</option>
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                <div class="form-group dasawisma" id="dasawisma-level">
                  <label>Dasawisma</label>
                  <input type="text" name="dasawisma" id="dasawisma" class="form-control" >
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                <div class="form-group">
                  <label>Telepon</label>
                  <input type="number" maxlength="13" name="telp" id="telp" class="form-control" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" id="username" class="form-control username" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                  <span id="uname_response" class="response"></span>
                </div>

                

              </div>
              <div class="col-lg-6">

                <div class="form-group">
                  <label>Password</label>
                  <input type="Password" name="password" id="password" class="form-control" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                 <div class="form-group">
                    <label>Kelurahan</label>
                    <select class="form-control select2" name="kelurahan" id="kelurahan" required="">
                      <option value="">--pilih kelurahan--</option>
                      <?php  foreach ($kelurahan as $key ) { ?>
                          <option value="<?=$key->id?>"><?=$key->kelurahan?></option>
                      <?php } ?>
                      
                      
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                    <button id="progress" class="btn btn-sm disabled btn-primary btn-progress" style="float: right;">Progress</button>
                  </div>

                  <div class="form-group">
                    <label>RW</label>
                    <select class="form-control select2" name="rw" id="rw" required="">
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                  <div class="form-group dasawisma-rt" id="dasawisma-rt">
                    <label>RT</label>
                    <select class="form-control select2" name="rt" id="rt">
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                   <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" id="alamat"  class="form-control" required=""></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                  


              </div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="save-button" class="btn btn-primary btn-key">Save changes</button>
        </div>
      </div>
    </div>
  </form>
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
            <div class="row">
              <div class="col-lg-6">

                <div class="form-group" >
                    <label>Status</label>
                    <select class="form-control select2" name="kode_level_edit" id="kode_level_edit" required="">
                      <option value="">Pilih Status</option>
                      <option value="1">Kader Dasawisma</option>
                      <option value="2">Ketua RT</option>
                      <option value="3">Ketua RW</option>
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama_edit" id="nama_edit" class="form-control" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                <div class="form-group" id="dasawisma-level2">
                  <label>Dasawisma</label>
                  <input type="text" name="dasawisma_edit" id="dasawisma_edit" class="form-control" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                <div class="form-group">
                  <label>Telepon</label>
                  <input type="number" maxlength="13" name="telp_edit" id="telp_edit" class="form-control" required="">
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username_edit" id="username_edit" class="form-control username" required="" readonly="">
                  <span id="uname_response_edit" class="response"></span>
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

               

              </div>
              <div class="col-lg-6">

                 <div class="form-group">
                  <label>Password </label>
                  <input type="Password" name="password_edit" id="password_edit" class="form-control" >
                  <p style="color: red">isi password baru jika ingin mengubah, jika tidak biarkan kosong</p>
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>

                 <div class="form-group">
                    <label>Kelurahan</label>
                    <select class="form-control select2" name="kelurahan_edit" id="kelurahan_edit" required="">
                      <option value="">--pilih kelurahan--</option>
                      <?php  foreach ($kelurahan as $key ) { ?>
                          <option value="<?=$key->id?>"><?=$key->kelurahan?></option>
                      <?php } ?>
                      
                      
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                    <button id="progress_edit" class="btn btn-sm disabled btn-primary btn-progress" style="float: right;">Progress</button>
                  </div>

                  <div class="form-group">
                    <label>RW</label>
                    <select class="form-control select2" name="rw_edit" id="rw_edit" required="">
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                  <div class="form-group" id="dasawisma-rt2">
                    <label>RT</label>
                    <select class="form-control select2" name="rt_edit" id="rt_edit" required="">
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                   <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat_edit" id="alamat_edit"  class="form-control" required=""></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                  


              </div>
            </div>

            <input type="hidden" name="id_edit" id="id_edit" class="form-control">

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="edit-button" class="btn btn-primary btn-key">Save changes</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
    var table;
    let bidang_edit;
    $('#progress').hide();

    $(document).ready( function () {
      $(".select2").select2();
      table = $('#table-module').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('aplikasi_modul/kader/get_data')?>",
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



    function reload_table(){
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    $(document).on('click',"#add-button",function(){
        $('#exampleModal').modal('show');
    });

    $('.username').bind('input', function() {
      var c = this.selectionStart,
          r = /[^a-zA-Z0-9 .]/gi,
          v = $(this).val();
      if(r.test(v)) {
        $(this).val(v.replace(r, ''));
        c--;
      }
      this.setSelectionRange(c, c);
    });

    $(".username").keyup(function(){
      var username = $(this).val().trim();
      var id = $('#id_edit').val();
      if(username != ''){

       
        // var specialChars = /[^a-zA-Z0-9 ]/g;
        // if (username.match(specialChars)) {
        //     swal('Perhatian!','Anda menggunakan spesial karakter','warning');
        //     $('.username').focus();
        //     return false;
        // }
      
     

         $.ajax({
            url: '<?=site_url('aplikasi_modul/kader/change');?>',
            type: 'post',
            dataType: 'json',
            data: {username: username,id:id},
            success: function(response){
                
                $('.response').html(response['pesan']);
                if(response['kode']==0){
                  $('.response').css('color','red');
                  $('.btn-key').prop('disabled', true);
                }
                else{
                  $('.response').css('color','black');
                  $('.btn-key').prop('disabled', false);
                }
                

             }
         });
      }else{
         $("#uname_response").html("");
         $('#save-button').prop('disabled', false);
      }

    });

      $(document).on("submit", "#form-save", function(e) {
        e.preventDefault();


        $.ajax({
            url: '<?=site_url('aplikasi_modul/kader/save');?>',
            data: $(this).serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#save-button').text('Loading...');
                $('#save-button').attr('disabled',true);
            },
            success: function(data){
                $('#exampleModal').modal('toggle');
                Swal.fire({ title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton: false,timer: 1500});
                reload_table();
                $('#save-button').text('Save changes');
                $('#save-button').attr('disabled',false);
                $("#form-save").trigger("reset");
                $(".select2").val([]).trigger("change");
                $('#progress').hide();
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
                url: '<?=site_url('aplikasi_modul/kader/change_status');?>',
                data: {id:id,status:status},
                dataType: 'json',
                type: 'post',
               
                success: function(data){
                    swal({title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton:false,timer:1500});
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
                url: '<?=site_url('aplikasi_modul/kader/delete');?>',
                data: {id:id},
                dataType: 'json',
                type: 'post',
               
                success: function(data){
                    Swal.fire({title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton:false,timer:1500});
                    reload_table();
                }
            })
        } else {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }

    $(document).on('change','#kode_level',function(){

      cekKode($(this).val());

    });

    $(document).on('change','#kode_level_edit',function(){
      cekKode2($(this).val());
    });

    function cekKode(kode){

      //alert(kode);
      if(kode == 1){
        $('#dasawisma-level').show();
        $('#dasawisma-rt').show();
      }
      else if(kode == 2){
        $('#dasawisma-level').hide();
        $('#dasawisma-rt').show();
      }
      else if(kode == 3){
        $('#dasawisma-level').hide();
        $('#dasawisma-rt').hide();
      }
    }
    function cekKode2(kode){

      //alert(kode);
      if(kode == 1){
        $('#dasawisma-level2').show();
        $('#dasawisma-rt2').show();
      }
      else if(kode == 2){
        $('#dasawisma-level2').hide();
        $('#dasawisma-rt2').show();
      }
      else if(kode == 3){
        $('#dasawisma-level2').hide();
        $('#dasawisma-rt2').hide();
      }
    }

    $(document).on('change','#rw',function(){
      var kelurahan = $('#kelurahan').val();
      var rw = $(this).val();
      get_RT(rw,kelurahan);
    })

     $(document).on('change','#rw_edit',function(){
      var kelurahan = $('#kelurahan_edit').val();
      var rw = $(this).val();
      get_RT2(rw,kelurahan);
    })

    $(document).on('change','#kelurahan',function(){
      var kelurahan = $(this).val();
      loadKelurahan(kelurahan);
    });

    $(document).on('change','#kelurahan_edit',function(){
      var kelurahan = $(this).val();
      loadKelurahan2(kelurahan);
    });

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
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#rw').append('<option value="'+data[a]['rw']+'">'+data[a]['rw']+'</option>');
                  }

                  get_RT(data[0]['rw'],kelurahan);
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

    function loadKelurahan2(kelurahan){
      if(kelurahan != ''){
        $.ajax({
          url: '<?=site_url('aplikasi_modul/kader/get_rw');?>/'+kelurahan,
          dataType: 'json',
            beforeSend: function(){
                $('#progress').show();
            },
            success: function(data){
                if(data['result'] != 0){
                  $('#rw_edit').html('');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#rw_edit').append('<option value="'+data[a]['rw']+'">'+data[a]['rw']+'</option>');
                  }

                  get_RT2(data[0]['rw'],kelurahan);
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
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#rt').append('<option value="'+data[a]['rt']+'">'+data[a]['rt']+'</option>');
                  }

                 
                }
                $('#progress').hide();
          }
        });

    }

     function get_RT2(rw,kelurahan){

      $.ajax({
          url: '<?=site_url('aplikasi_modul/kader/get_rt');?>/'+rw+'/'+kelurahan,
          dataType: 'json',
           
            success: function(data){
                if(data['result'] != 0){
                  $('#rt_edit').html('');
                  var len = data.length;
                  for(a=0;a<len;a++){
                    $('#rt_edit').append('<option value="'+data[a]['rt']+'">'+data[a]['rt']+'</option>');
                  }

                 
                }
                $('#progress').hide();
          }
        });

    }

    function edit_bidang(id){
      $.ajax({
        url: '<?php echo site_url('aplikasi_modul/kader/edit'); ?>',
        type: 'post',
        data: {id:id},
        dataType: 'json',
        success: function(response){
          $('#nama_edit').val(response['detail']['nama']);
          $('#dasawisma_edit').val(response['detail']['dasawisma']);
          $('#telp_edit').val(response['detail']['telp']);
          $('#username_edit').val(response['detail']['username']);
          $('#alamat_edit').val(response['detail']['alamat']);
          //$('#urutan_edit').val(response['detail']['urutan']);
          $('#kelurahan_edit').val(response['detail']['kelurahan']).change();
          window.setTimeout(function () {
            $('#rw_edit').val(response['detail']['rw']).change();
          }, 500 );
          window.setTimeout(function(){
            $('#rt_edit').val(response['detail']['rt']).change();
            
          }, 1000);
          $('#kode_level_edit').val(response['detail']['kode_level']).change();
          cekKode2(response['detail']['kode_level']);
          $('#id_edit').val(id);
          $('#progress_edit').hide();
          $('#editModal').modal('show');
        }
      });
    }

     $(document).on("submit", "#form-edit", function(e) {
        e.preventDefault();

        $.ajax({
            url: '<?=site_url('aplikasi_modul/kader/proses_edit');?>',
            data: $(this).serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#edit-button').text('Loading...');
                $('#edit-button').attr('disabled',true);
            },
            success: function(data){
                $('#editModal').modal('toggle');
                Swal.fire({ title: data['title'],text: data['msg'],icon: data['type'],showConfirmButton:false,timer:1500});
                reload_table();
                $('#edit-button').text('Save changes');
                $('#edit-button').attr('disabled',false);
                $("#form-edit").trigger("reset");
            }
        })
    });

   
</script>