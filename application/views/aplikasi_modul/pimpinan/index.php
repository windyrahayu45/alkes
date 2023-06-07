<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
  <div class="section-header">
    <h1>Akses Pimpinan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('aplikasi_modul/pimpinan')?>">Components</a></div>
      <div class="breadcrumb-item">Akses Pimpinan</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Akses Pimpinan</h2>
    <p class="section-lead">atur akun pimpinan</p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Akses Pimpinan</h4>
                <button type="button" id="add-button" class="btn btn-primary">Tambah Data</button>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md" id="table-module">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Telp</th>
                  <th>Alamat</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach ($manual as $key ): ?>

                   <tr>
                    <td><?=$no++?></td>
                    <td><?=$key->nama?></td>
                    <td><?=$key->username?></td>
                    <td><?=$key->telp?></td>
                    <td><?=$key->alamat?></td>
                    <td>
                       <a class="btn btn-danger" href="javascript:void()" title="Hapus" onclick="delete_level('<?=$key->id?>')"><i class="fas fa-trash"></i>
                       </a>
                       <a class="btn  btn-primary" href="javascript:void()" title="Edit" onclick="reset_pass('<?=$key->id?>')"><i class="fas fa-pencil-alt"></i>
                       </a>
                    </td>
                  </tr>
                    
                  <?php endforeach ?>

                  <?php  foreach ($auto as $key ): ?>

                   <tr>
                    <td><?=$no++?></td>
                    <td><?=$key['nama']?></td>
                    <td><?=$key['username']?></td>
                    <td><?=$key['telp']?></td>
                    <td><?=$key['alamat']?></td>
                    <td></td>
                  </tr>
                    
                  <?php endforeach ?>
                </tbody>
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
          <h5 class="modal-title">Tambah Akun Pimpinan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group" >
                <label>Status</label>
                <select class="form-control select2" name="kode_level" id="kode_level" required="">
                  <option value="">Pilih Status</option>
                  <option value="1">Pegawai Kota Solok</option>
                  <option value="2">Non Pegawai</option>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="row">

              <div class="col-lg-12" id="non-pegawai">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" required="">
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
                <div class="form-group">
                  <label>Password</label>
                  <input type="Password" name="password" id="password" class="form-control" required="">
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

              <div class="col-lg-12" id="pegawai">
                <div class="form-group">
                  <label>Instansi</label>
                  <select class="form-control select2" name="id_instansi" id="id_instansi" required="">
                    <option value="">--pilih instansi--</option>
                    <?php  foreach ($instansi as $key ) { ?>
                        <option value="<?=$key->id_instansi?>"><?=$key->nama_instansi?></option>
                    <?php } ?>
                  </select>
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                  <button id="progress" class="btn btn-sm disabled btn-primary btn-progress" style="float: right;">Progress</button>
                </div>

                <div class="form-group">
                  <label>Pegawai</label>
                  <select class="form-control select2" name="id_pegawai" id="id_pegawai" required="">
                  </select>
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

<div class="modal fade"  role="dialog" id="resetModal">
  <form id="form-reset" class="needs-validation" novalidate >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reset Akun Pimpinan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id" class="form-control" required="">
          <div class="form-group">
              <label>Password</label>
              <input type="Password" name="password" id="password" class="form-control" required="">
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
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



<script type="text/javascript">
    var table;
    let bidang_edit;
    $('#progress').hide();
    $('#pegawai').hide();
    $('#non-pegawai').hide();
    $(".select2").select2();
    $(document).ready( function () {
      
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
        //alert('112');
        $.ajax({
            url: '<?=site_url('aplikasi_modul/pimpinan/save');?>',
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
                location.reload();
                $('#save-button').text('Save changes');
                $('#save-button').attr('disabled',false);
                $("#form-save").trigger("reset");
                $(".select2").val([]).trigger("change");
                $('#progress').hide();
            }
        })
    });

    $(document).on("submit", "#form-reset", function(e) {
        e.preventDefault();
        //alert('112');
        $.ajax({
            url: '<?=site_url('aplikasi_modul/pimpinan/reset');?>',
            data: $(this).serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#save-button').text('Loading...');
                $('#save-button').attr('disabled',true);
            },
            success: function(data){
                $('#resetModal').modal('toggle');
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
                    location.reload();
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


    function cekKode(kode){

      //alert(kode);
      if(kode == 1){
        $('#pegawai').show();
        $('#non-pegawai').hide();
        $('#nama').removeAttr('required');
        $('#username').removeAttr('required');
        $('#telp').removeAttr('required');
        $('#password').removeAttr('required');
        $('#alamat').removeAttr('required');
      }
      else{
        $('#pegawai').hide();
        $('#non-pegawai').show();
        $('#id_instansi').removeAttr('required');
        $('#id_pegawai').removeAttr('required');
      }
    }
    
    $(document).on('change','#id_instansi',function(){
      var id_instansi = $(this).val();
      if(id_instansi != ''){
        $.ajax({
          url: '<?=site_url('aplikasi_modul/pimpinan/get_pegawai');?>/'+id_instansi,
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

    function reset_pass(id){
      $('#id').val(id);
      $('#resetModal').modal('show');
    }

   
</script>