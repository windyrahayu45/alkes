<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Pengguna</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          <input type="hidden" name="id_petugas" id="id_petugas">

          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required="">
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
            <label >Password</label><br>
            <span style="color: red" id="lab_pass"></span>
            <input type="Password" name="password" id="password" class="form-control" required="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label>Telepon</label>
            <input type="tel" maxlength="13" name="telp" id="telp" class="form-control" required="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          <div class="form-group">
            <label>NIK</label>
            <input type="tel" maxlength="16" name="nik" id="nik" class="form-control" required="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          <div class="form-group">
            <label>Foto (Jika Ada)</label><br>
             <span style="color: red" id="lab_foto"></span>
            <input type="file"  name="foto" id="foto" class="form-control"><br>
            <span style="color: blue" id="ket_foto"></span>
          </div>


          <div class="form-group">
            <label>Level</label>
            <select class="form-control select2" name="level" id="level" required="">
              <option value="">---Pilih Level---</option>
              <option value="Petugas Logistik">Petugas Logistik</option>
              <option value="Teknisi">Teknisi</option>
              <option value="Pimpinan">Pimpinan</option>
              <option value="Admin Prasarana">Admin Prasarana</option>
            
            </select>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>


          <div class="form-group" id="lay_lokasi">
            <label>Lokasi</label>
            <select class="form-control select2" name="id_ruangan" id="id_ruangan" >
              <option value="">---Pilih Lokasi ruangan---</option>
              <?php  foreach ($ruangan as $key ) { ?>
                  <option value="<?=$key->id_ruangan?>"><?=$key->nama_ruangan?></option>
              <?php } ?>
            </select>
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
<script src="<?=base_url('file')?>/js/check.js"></script>
<script src="<?=base_url('file')?>/js/custom.js"></script>
<script type="text/javascript">
  $('#lay_lokasi').hide();
  $(".select2").select2();

  $('#level').on("change", function(){
       var level = $(this).val();

       if(level == 'Petugas Logistik'){
          $('#lay_lokasi').show();
          $("#id_ruangan").prop('required',true);
       }
       else{
          $('#lay_lokasi').hide();
          $("#id_ruangan").prop('required',false);
       }


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
     
      if(username != ''){
         $.ajax({
            url: '<?=site_url('pengguna/cekUsername');?>',
            type: 'post',
            dataType: 'json',
            data: {username: username},
            success: function(response){
                
                $('.response').html(response['pesan']);
                if(response['kode']==0){
                  $('.response').css('color','red');
                  $('.btn-key').prop('disabled', true);
                }
                else{
                  $('.response').css('color','green');
                  $('.btn-key').prop('disabled', false);
                }
                

             }
         });
      }else{
         $("#uname_response").html("");
         $('#save-button').prop('disabled', false);
      }

    });



<?php if(isset($petugas)){ ?>
  $(document).ready(function(){
    $('#id_petugas').val('<?=$petugas->id_petugas; ?>');
    $('#username').prop("readonly", true);
    $('#lab_pass').html("Isikan password baru jika ingin ganti");
    $('#lab_foto').html("upload foto yg baru untuk update");
    $('#nama').val('<?=$petugas->nama?>');
    $('#username').val('<?=$petugas->username?>');
    $('#telp').val('<?=$petugas->telp?>');
    $('#nik').val('<?=$petugas->nik?>');

    var foto = '<?=$petugas->foto?>';
    
    if(foto != ''){
      $('#ket_foto').html('<a href="<?=base_url('upload/'.$petugas->foto)?>" target="_blank" >Lihat Foto Sebelumnya</a>')
    }

    $('#level').val('<?=$petugas->level?>').change();
     var level = '<?=$petugas->level?>';
     if(level === "Petugas Logistik"){
       $('#id_ruangan').val('<?=$petugas->id_ruangan?>').change();
     }

  });
<?php } ?>
</script>