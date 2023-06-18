<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
          <div class="section-header">
            <h1>Kartu Pemeliharaan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?=base_url('Pemeliharaan')?>">Components</a></div>
              <div class="breadcrumb-item">Kartu Pemeliharaan</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Detail Pemeliharaan</h2>
           

           <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Kartu Pemeliharaan</h4>
                  </div>
                  
                  <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered table-md" id="table-module">
                          <tr><td colspan="2" style="text-align:center;font-size:16px"><b>Data Barang</b></td></tr>
                          <tr>
                            <td>Kode Barang</td>
                            <td><?=$barang->id_barang?></td>
                          </tr>
                          <tr>
                            <td>Nama Barang</td>
                            <td><?=$barang->nama?></td>
                          </tr>
                          <tr>
                            <td>Merk</td>
                            <td><?=$barang->merk?></td>
                          </tr>
                          <tr>
                            <td>Tipe</td>
                            <td><?=$barang->type?></td>
                          </tr>
                          <tr>
                            <td>SN</td>
                            <td><?=$barang->SN?></td>
                          </tr>
                          <tr>
                            <td>Tahun</td>
                            <td><?=$barang->tahun?></td>
                          </tr>
                          <tr>
                            <td>Harga</td>
                            <td>Rp. <?=$barang->harga?></td>
                          </tr>
                           <tr>
                            <td>Lokasi</td>
                            <td><?=$barang->nama_ruangan?></td>
                          </tr>
                           <tr>
                            <td>Kondisi</td>
                            <td><?=$barang->status_barang?></td>
                          </tr>
                       </table>

                       <table class="table table-bordered table-md" id="table-module">
                          
                          <thead>
                            <tr><td colspan="6" style="text-align:center;font-size:16px"><b>Pemeliharaan Berkala</b></td></tr>
                          <tr>
                            <th>No</th>
                            <th>Tgl Tindakan</th>
                            <th>Tgl Selesai</th>
                            <th>Kondisi Sebelum Tindakan</th>
                            <th>Kondisi Setelah Tindakan</th>
                            <th>Ket</th>
                            <th>Teknisi</th>
                          </tr>
                          </thead>
                          <tbody>

                            <?php foreach ($berkala as $key ) { $no=1; ?>
                              <tr>
                              <td><?=$no++?></td>
                              <td><?=$key->tgl_tindakan?></td>
                              <td><?=$key->tgl_selesai?></td>
                              <td>
                                <?php

                                  if($key->kondisi_sebelum == 1){ echo "Baik"; }
                                  else if($key->kondisi_sebelum == 2){ echo "Rusak Berat"; }
                                  else{
                                    echo "Afkir";
                                  }
                                ?>
                              </td>

                              <td>
                                <?php

                                  if($key->kondisi_sesudah == 1){ echo "Baik"; }
                                  else if($key->kondisi_sesudah == 2){ echo "Rusak Berat"; }
                                  else if($key->kondisi_sesudah == 3){
                                    echo "Afkir";
                                  
                                  }
                                  else{
                                    echo "Sedang Proses";
                                  }
                                ?>
                              </td>

                              <td><?=$key->ket?></td>
                              <td><?=$key->petugas?></td>
                              </tr>
                            <?php } ?>
                          
                          </tbody>
                       </table>

                       <table class="table table-bordered table-md" id="table-module">
                          
                          <thead>
                            <tr><td colspan="6" style="text-align:center;font-size:16px"><b>Perbaikan</b></td></tr>
                          <tr>
                            <th>No</th>
                            <th>Tgl Tindakan</th>
                            <th>Tgl Selesai</th>
                            <th>Kondisi Sebelum Tindakan</th>
                            <th>Kondisi Setelah Tindakan</th>
                            <th>Ket</th>
                            <th>Teknisi</th>
                          </tr>
                          </thead>
                          <tbody>

                            <?php foreach ($perbaikan as $key ) { $no=1; ?>
                              <tr>
                              <td><?=$no++?></td>
                              <td><?=$key->tgl_tindakan?></td>
                              <td><?=$key->tgl_selesai?></td>
                              <td>
                                <?php

                                  if($key->kondisi_sebelum == 1){ echo "Baik"; }
                                  else if($key->kondisi_sebelum == 2){ echo "Rusak Berat"; }
                                  else{
                                    echo "Afkir";
                                  }
                                ?>
                              </td>

                              <td>
                                <?php

                                  if($key->kondisi_sesudah == 1){ echo "Baik"; }
                                  else if($key->kondisi_sesudah == 2){ echo "Rusak Berat"; }
                                  else if($key->kondisi_sesudah == 3){
                                    echo "Afkir";
                                  
                                  }
                                  else{
                                    echo "Sedang Proses";
                                  }
                                ?>
                              </td>

                              <td><?=$key->ket?></td>
                              <td><?=$key->petugas?></td>
                              </tr>
                            <?php } ?>
                          
                          </tbody>
                       </table>

                        <table class="table table-bordered table-md" id="table-module">
                          
                          <thead>
                            <tr><td colspan="6" style="text-align:center;font-size:16px"><b>Kalibrasi</b></td></tr>
                          <tr>
                            <th>No</th>
                            <th>Tgl </th>
                            <th>Pelaksana</th>
                            <th>Kondisi</th>
                            <th>Teknisi</th>
                          </tr>
                          </thead>
                          <tbody>

                            <?php foreach ($kalibrasi as $key ) { $no=1; ?>
                              <tr>
                              <td><?=$no++?></td>
                              <td><?=$key->tgl?></td>
                              <td><?=$key->pelaksana?></td>
                              

                              <td><?=$key->kondisi?></td>
                              <td><?=$key->petugas?></td>
                              </tr>
                            <?php } ?>
                          
                          </tbody>
                       </table>


                      </div>

                   
                    
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


