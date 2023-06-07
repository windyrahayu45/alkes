<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
          <div class="section-header">
            <h1>Verifikasi</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?=base_url('opsi')?>">Components</a></div>
              <div class="breadcrumb-item">Opsi Verifikasi</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Verifikasi </h2>
            <p class="section-lead">Hasil Survey <?=$kader->nama?> Kel.<?=$kader->nama_kelurahan?> RW.<?=$kader->rw?> RT.<?=$kader->rt?> pada sistem survey <?=$sistem?></p>

           <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Input Jawaban</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-module ">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Rumah /Bangunan</th>
                            <th>Alamat</th>
                            <th>Verifikasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no=1; foreach($rumah as $key): ?>
                          <tr>
                            <td><?=$no++?></td>
                            <td>

                              <a class="btn  btn-info" data-toggle="tooltip" data-placement="top" href="javascript:void()" title="Klik untuk Buku 1 dirumah ini" onclick='view_buku1("<?=$key->id_rumah?>","<?=$key->nama_rt?>","<?=$id_sistem?>")' ><i class="fas fa-info-circle"></i> <?=$key->nama_rt?></a>
                            </td>
                            <td><?=$key->alamat?></td>
                            <td>
                              <?php if($key->status_verifikasi == 0 ){ ?>
                              <a class="btn btn-icon icon-left btn-success" href="javascript:void()" title="Hapus" onclick="verifikasi('<?=$key->id_rumah?>')"><i class="fas fa-check"></i> Verifikasi Rumah ini</a>
                            <?php } else { ?>
                              Telah Diverifikasi
                            <?php } ?>
                            </td>
                          </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div id="buku1" >
                  <div class="card card-primary">
                  <div class="card-header">
                    <h4 id="nama_rumah"></h4>
                  </div>
                  <div class="card-body">
                    <div id="isi_buku1">
                    </div>
                  </div>
                </div>
                </div>

                <div id="buku2" >
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4>Buku 2</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-12" style="float: left;">
                          <table border="0" >
                            <tr>
                              <td style="text-align: left;">DASAWISMA</td>
                              <td> : </td>
                              <td style="text-align: left;"><?=$kader->dasawisma?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">RT</td>
                              <td> : </td>
                              <td style="text-align: left;" ><?=$kader->rt?></td>
                            </tr>
                             <tr>
                              <td style="text-align: left;">RW</td>
                              <td> : </td>
                              <td style="text-align: left;"  ><?=$kader->rw?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">DESA/KELURAHAN</td>
                              <td> : </td>
                              <td style="text-align: left;"  ><?=$kader->nama_kelurahan?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">TAHUN</td>
                              <td> : </td>
                              <td style="text-align: left;"><?=$tahun?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div id="isi_buku2">
                      </div>
                    </div>
                  </div>
                </div>


                <div id="buku3" >
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4>Buku 3</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-12" style="float: left;">
                          <table border="0" >
                            <tr>
                              <td style="text-align: left;">KELOMPOK DASAWISMA</td>
                              <td> : </td>
                              <td style="text-align: left;"><?=$kader->dasawisma?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">KELOMPOK PKK RT</td>
                              <td> : </td>
                              <td style="text-align: left;" ><?=$kader->rt?></td>
                            </tr>
                             <tr>
                              <td style="text-align: left;">KELOMPOK PKK RW</td>
                              <td> : </td>
                              <td style="text-align: left;"  ><?=$kader->rw?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">DESA/KELURAHAN</td>
                              <td> : </td>
                              <td style="text-align: left;"  ><?=$kader->nama_kelurahan?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">KECAMATAN</td>
                              <td> : </td>
                              <td style="text-align: left;"  ><?=$kecamatan?></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">KOTA</td>
                              <td> : </td>
                              <td style="text-align: left;"  >Solok</td>
                            </tr>
                             <tr>
                              <td style="text-align: left;">BULAN</td>
                              <td> : </td>
                              <td style="text-align: left;" id="bulan"></td>
                            </tr>
                            <tr>
                              <td style="text-align: left;">TAHUN</td>
                              <td> : </td>
                              <td style="text-align: left;"><?=$tahun?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div id="isi_buku3">
                      </div>
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
  $(document).ready(function(){
    $('#buku1').hide();

    let id_rumah ='<?=$key->id_rumah?>';
    let id_sistem ='<?=$id_sistem?>';
    let kader = '<?= $kader->username?>';

      $.ajax({
        url: '<?php echo site_url('pengguna/Verifikasi/buku2'); ?>',
        type: 'post',
        data: {id_rumah:id_rumah,id_sistem:id_sistem,kader:kader},
        beforeSend: function(){
            // $('#save-button').text('Loading...');
            // $('#save-button').attr('disabled',true);
        },
        success: function(response){
          $('#isi_buku2').html(response);
        }
      });

      $.ajax({
        url: '<?php echo site_url('pengguna/Verifikasi/buku3'); ?>',
        type: 'post',
        data: {id_rumah:id_rumah,id_sistem:id_sistem,kader:kader},
        beforeSend: function(){
            // $('#save-button').text('Loading...');
            // $('#save-button').attr('disabled',true);
        },
        success: function(response){
          $('#isi_buku3').html(response);
        }
      });
  });

  function view_buku1(id_rumah,nama_rt,id_sistem){
    //alert(nama_rt);
    $('#nama_rumah').html("Kepala Keluarga pada rumah " +nama_rt);
    

     $.ajax({
        url: '<?php echo site_url('pengguna/Verifikasi/buku1'); ?>',
        type: 'post',
        data: {id_rumah:id_rumah,id_sistem:id_sistem},
        beforeSend: function(){
          Swal.fire({
              title: 'Wait ...',
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: false,
              showConfirmButton: false
          })
        },
        success: function(response){
          Swal.close();
          $('#isi_buku1').html(response);
          $('#buku1').show();
        }
      });
  }

  function verifikasi(id_rumah){
    $.ajax({
          url: '<?php echo site_url('pengguna/verifikasi/modal'); ?>',
          type: 'post',
          data: {id_rumah:id_rumah},
          success: function(response){
            $('#form-input').html(response);
            $('#myModal').modal('show');
          }
    });
  }

  $(document).on("submit", "#form-save", function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?=site_url('pengguna/verifikasi/save');?>',
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
                window.location.reload();
                $('#save-button').text('Verifikasi');
                $('#save-button').attr('disabled',false);
                $("#form-save").trigger("reset");
            }
        })
  });
</script>


