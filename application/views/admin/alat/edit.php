<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
          <div class="section-header">
            <h1>Opsi Pertanyaan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?=base_url('opsi')?>">Components</a></div>
              <div class="breadcrumb-item">Opsi Pertanyaan</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Tambah Opsi Pertanyaan</h2>
            <p class="section-lead">Buat Jawaban Pertanyaan</p>

           <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Input Jawaban</h4>
                  </div>
                  <div class="card-body">
                    <form id="form-save">
                    <div class="form-group">
                      <label>Pertanyaan</label>
                      <select class="form-control select2" name="pertanyaan_id" id="pertanyaan_id" required="">
                        
                        <?php  foreach ($pertanyaan as $key ) { ?>
                            <option value="<?=$key->id?>"><?=$key->pertanyaan?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group" id="class_jawaban">
                      <label for="exampleInputEmail1">Jawaban</label>
                      <table class="table table-bordered" id="Jawaban">  
                        
                        <?php

                        $numItems = count($detail);
                        $i = 0;
                        foreach ($detail as $key) { ?>

                          <tr id="row<?=$key->id?>">  
                            <td><input type="text" name="jawaban[]" placeholder="Masukan Nama" class=" form-control name_list" value="<?=$key->jawaban?>" /></td> 
                            <td><input type="number" name="point[]" placeholder="Masukan Point" class="form-control point_list" value="<?=$key->point?>"/></td>  
                            <td>

                              <!-- <button type="button" name="remove" id="<?=$key->id?>" class="btn btn-danger btn_remove">X</button> -->
                              <?php if(++$i === $numItems) { ?> 
                                <button type="button" name="add" id="add" class="btn btn-primary">Tambah</button>
                              <?php } ?>
                            </td> 
                          </tr> 
                          
                        <?php } ?>
                         
                      </table> 
                    </div>
                    </form>
                    <button type="button" id="save-button" class="btn btn-primary">Save changes</button>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

<script type="text/javascript">
      var i=1;  
      $('#add').click(function(){  

           i++; 
           $('#Jawaban').append('<tr id="row'+i+'"><td><input type="text" name="jawaban[]" placeholder="Masukan Nama" class="form-control name_list" /></td><td><input type="number" name="point[]" placeholder="Masukan Point" class="form-control point_list" /></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });

      $(document).on('click','#save-button',function(){
        $.ajax({
            url: '<?=site_url('opsi/proses_edit');?>',
            data: $('#form-save').serialize(),
            dataType: 'json',
            type: 'post',
            beforeSend: function(){
                $('#save-button').text('Loading...');
                $('#save-button').attr('disabled',true);
            },
            success: function(data){
              
                Swal.fire({
                  title: data['title'],
                  text: data['msg'],
                  icon: data['type'],
                  showConfirmButton: "true",
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href="<?=base_url('opsi')?>";
                  }
                });
            }
      });
      });
</script>


