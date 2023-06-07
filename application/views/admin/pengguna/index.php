<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="<?=base_url('file')?>/js/custom.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
  <div class="section-header">
    <h1>Data Pengguna</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('pengguna')?>">Components</a></div>
      <div class="breadcrumb-item">Data Pengguna</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Data Pengguna</h2>
    <p class="section-lead">Pengguna / User aplikasi</p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Data Pengguna</h4>
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
                  <th>Level</th>
                  <th>Lokasi</th>
                  <th>Telp</th>
                  <th>NIK</th>
                  <th>Foto</th>
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
      table = $('#table-module').DataTable({ 
      
        "processing": true, 
        "serverSide": true, 
        "ajax": {
          "url": "<?php echo site_url('pengguna/get_data')?>",
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
          url: '<?php echo site_url('pengguna/modal'); ?>',
          type: 'post',
          success: function(response){
            $('#form-input').html(response);
            $('#myModal').modal('show');
          }
        });
    });

    function edit_bidang(id){
       $.ajax({
          url: '<?php echo site_url('pengguna/modal'); ?>',
          type: 'post',
          data: {id:id},
          success: function(response){
            $('#form-input').html(response);
            $('#myModal').modal('show');
          }
      });
    }

    function list_bidang(id,judul){

      $.ajax({
          url: '<?php echo site_url('bidang/get_list'); ?>',
          type: 'post',
          data: {id:id,judul:judul},
          success: function(response){
            $('#form-list').html(response);
            $('#listModal').modal('show');
          }
      });
    }

    $(document).on("submit", "#form-save", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '<?=site_url('pengguna/save');?>',
            type: 'post',
            dataType: 'json',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
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
          confirmButtonText: 'Yes, Change it!'
        }).then((result) => {
      if (result.isConfirmed) {
            $.ajax({
                url: '<?=site_url('bidang/change');?>',
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
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: '<?=site_url('pengguna/delete');?>',
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
        } else  {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }

    $(document).on('click',"#save-pertanyaan",function(){
        $.ajax({
            url: '<?=site_url('Bidang/save_pertanyaan');?>',
            data: $('#form-pertanyaan').serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#save-pertanyaan').text('Loading...');
                $('#save-pertanyaan').attr('disabled',true);
            },
            success: function(data){
                $('#AturModal').modal('toggle');
                Swal.fire({
                  icon: data['type'],
                  title: data['title'],
                  text: data['msg'],
                  showConfirmButton: false,
                  timer: 1500
                })
                reload_table();
                $('#save-pertanyaan').text('Save changes');
                $('#save-pertanyaan').attr('disabled',false);
                $("#form-pertanyaan").trigger("reset");
                $("#modul_id").val("").change();
            }
        })
    });

    

    function set_bidang(id,judul){
      $('#nameTag').html("Pertanyaan pada " + judul);
      $('#id_bidang').val(id);

      $.ajax({
          url: '<?=site_url('bidang/get_pertanyaan');?>/'+id,
          dataType: 'json',
            
            success: function(data){
                if(data['result'] != 0){
                   var len = data.length;
                  //  for(a=0;a<len;a++){
                  //   $('#pertanyaan_id').val(data[a]['pertanyaan_id']).change();
                  // }

                   $('#pertanyaan_id').val(data).change();
                 
                }  
                 $('#AturModal').modal('show');
            }
        });
    }

    
</script>