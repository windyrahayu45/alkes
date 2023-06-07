<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>

 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>

<section class="section">
  <div class="section-header">
    <h1>Modul</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="<?=base_url('modul')?>">Components</a></div>
      <div class="breadcrumb-item">Modul</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">Modul</h2>
    <p class="section-lead">Daftar modul yang digunakan pada aplikasi</p>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Modul</h4>
                <button type="button" id="add-button" class="btn btn-primary">Tambah Modul</button>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md" id="table-module">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Modul</th>
                  <th>Instansi</th>
                  <th>Created_at</th>
                  <th>Action</th>
                </tr>
                </thead>
                
              </table>
            </div>
          </div>
          <!-- <div class="card-footer text-right">
            <nav class="d-inline-block">
              <ul class="pagination mb-0">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
              </ul>
            </nav>
          </div> -->
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
      //$(".select2").select2();
      table = $('#table-module').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "ajax": {
          "url": "<?php echo site_url('modul/get_data')?>",
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
      table.ajax.reload(null,false); 
    }

    $(document).on('click',"#add-button",function(){
      $.ajax({
        url: '<?php echo site_url('modul/modal'); ?>',
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
          url: '<?=site_url('modul/save');?>',
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
            
            // swal({
            //   title: data['title'],
            //   text: data['msg'],
            //   icon: data['type'],
            //   confirmButtonText: "OK"
            // });
            $('#save-button').text('Save changes');
            $('#save-button').attr('disabled',false);
            $("#form-save").trigger("reset");
            reload_table();
          }
        })
        
    });

     function delete_module(id){
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
                url: '<?=site_url('modul/delete');?>',
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
                });
                  reload_table();
                }
            })
          } else  {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })
    }
</script>