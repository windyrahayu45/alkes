<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


<!-- <script src="<?=base_url('file')?>/js/page/components-table.js"></script> -->
<section class="section">
           <div class="section-header">
            <h1>Data Peralatan Medis</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?=base_url('alat')?>">Components</a></div>
              <div class="breadcrumb-item">Data Peralatan Medis</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Data Peralatan Medis</h2>
            <p class="section-lead">Rekapan semua peralatan medis</p>


           <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Peralatan Medis</h4>
                  </div>

                  <form id="form-save" class="needs-validation" novalidate>
                  <div class="card-body">

                     <input type="hidden" name="id_barang" id="id_barang">
                    
                    <div class="form-group">
                      <label>Nama</label>
                      <input type="text" name="nama" id="nama" class="form-control" required="">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <div class="form-group">
                      <label>Merk</label>
                      <input type="text" name="merk" id="merk" class="form-control" required="">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <div class="form-group">
                      <label>Type</label>
                      <input type="text" name="type" id="type" class="form-control" required="">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <div class="form-group">
                      <label>SN</label>
                      <input type="text" name="sn" id="sn" class="form-control" required="">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <div class="form-group">
                      <label>Tahun</label>
                      <input type="number" name="tahun" id="tahun" class="form-control" required="" maxlength="4">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <div class="form-group">
                      <label>Harga / pcs</label>
                      <input type="text" name="harga" id="harga" class="form-control" required="">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <div class="form-group">
                      <label>Lokasi</label>
                      <select class="form-control select2" name="id_ruangan" id="id_ruangan" required="">
                        <option value="">---Pilih Lokasi ruangan---</option>
                        <?php  foreach ($ruangan as $key ) { ?>
                            <option value="<?=$key->id_ruangan?>"><?=$key->nama_ruangan?></option>
                        <?php } ?>
                      </select>
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <div class="form-group">
                      <label>Link Tutorial Barang</label>
                      <input type="text" name="link" id="link" class="form-control" >
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <div class="form-group">
                      <label>Kondisi Barang</label>
                      <select class="form-control select2" name="id_status" id="id_status" required="">
                        <option value="">---Pilih Kondisi Barang---</option>
                        <?php  foreach ($status as $key ) { ?>
                            <option value="<?=$key->id_status?>"><?=$key->status_barang?></option>
                        <?php } ?>
                      </select>
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <div class="form-group" id="layout_stok">
                      <label>Banyak Barang (Stok)</label>
                      <input type="number" name="stok" id="stok" class="form-control" required="" onKeyDown="if(this.value.length==4) return false;">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please fill out this field.</div>
                    </div>


                    <button type="submit" id="save-button" class="btn btn-primary">Simpan Data</button>

                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>

<script type="text/javascript">
    $('#layout_stok').show();
    var harga = document.getElementById('harga');
    harga.addEventListener('keyup', function(e){
      
      harga.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah        = split[0].substr(0, sisa),
      ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
 
      
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
 
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $("#tahun").keypress(function (e) {
     
       var maxlengthNumber = parseInt($('#tahun').attr('maxlength'));
       var inputValueLength = $('#tahun').val().length + 1;
       if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        
        return false;
      }
      if(maxlengthNumber < inputValueLength) {
        return false;
      }
    });

    $(document).on("submit", "#form-save", function(e) {
        e.preventDefault();

        $.ajax({
            url: '<?=site_url('alat/save');?>',
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
                    window.location.href="<?=base_url('alat')?>";
                  }
                });


            }
        })
    });


    <?php if(isset($id_barang)){ ?>
  $(document).ready(function(){
    $('#id_barang').val('<?=$id_barang->id_barang; ?>');
    $('#nama').val('<?=$id_barang->nama?>');
    $('#merk').val('<?=$id_barang->merk?>');
    $('#type').val('<?=$id_barang->type?>');
    $('#sn').val('<?=$id_barang->SN?>');
    $('#tahun').val('<?=$id_barang->tahun?>');
    $('#harga').val('<?=$id_barang->harga?>');
    $('#id_ruangan').val('<?=$id_barang->id_ruangan?>').change();
    $('#id_status').val('<?=$id_barang->id_status?>').change();
    $('#link').val('<?=$id_barang->link?>');
    $('#layout_stok').hide();
    $('#stok').hide();
    $("#stok input").attr("type","hidden"); 
    $('#stok').removeAttr('required');


  });
<?php } ?>   
     
</script>


