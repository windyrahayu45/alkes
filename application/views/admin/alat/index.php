
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
 <link rel="stylesheet" href="<?=base_url('file')?>/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?=base_url('file')?>/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url('file')?>/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

  <script src="<?=base_url('file')?>/modules/datatables/datatables.min.js"></script>
  <script src="<?=base_url('file')?>/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url('file')?>/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
          <div class="section-header">
            <h1>Data Kelola Medis</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?=base_url('alat')?>">Components</a></div>
              <div class="breadcrumb-item">Data Peralatan Medis</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Data Kelola Medis</h2>
            <p class="section-lead">Rekapan semua peralatan medis</p>

            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Data Peralatan Medis</h4>
                        <a type="button"  class="btn btn-primary" href="<?=base_url('alat/tambah')?>">Tambah Data</a>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md" id="table-module">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Merk</th>
                          <th>Type</th>
                          <th>SN</th>
                          <th>Tahun</th>
                          <th>Lokasi</th>
                          <th>Harga</th>
                          <th>Kondisi</th>
                          <th>Qrcode</th>


                          
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
   
    $(document).ready( function () {
      $(".select2").select2();
      table = $('#table-module').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('alat/get_data')?>",
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

    function delete_bidang(id){

       $.ajax({
        url: '<?php echo site_url('alat/modal'); ?>',
        type: 'post',
        data: {id:id},
        success: function(response){
          $('#form-input').html(response);
          $('#myModal').modal('show');
        }
      });

    }

    $(document).on("submit", "#form-afkir", function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Alat ini dimasukan ke afkir?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: '<?=site_url('alat/delete');?>',
                data: $('#form-afkir').serialize(),
                dataType: 'json',
                type: 'post',
               
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
                     $("#form-afkir").trigger("reset");
                }
            })
        } else {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
        })

    });

   

    
</script>