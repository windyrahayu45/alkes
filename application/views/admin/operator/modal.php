<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Admin</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          <div class="form-group">
            <label>Modul</label>
            <select class="form-control select2" name="modul_id" id="modul_id" required="">
              <?php  foreach ($modul as $key ) { ?>
                  <option value="<?=$key->id?>"><?=$key->modul?></option>
              <?php } ?>
            <div class="invalid-feedback">Please fill out this field.</div> 
              
            </select>
          </div>

          
          <div class="form-group">
            <label>Instansi</label>
            <select class="form-control select2" name="id_instansi" id="id_instansi" required="">
              <option value="0">Pilih Instansi</option>
              <?php  foreach ($instansi as $key ) { ?>
                  <option value="<?=$key->id_instansi?>"><?=$key->nama_instansi?></option>
              <?php } ?>
            <div class="invalid-feedback">Please fill out this field.</div>  
              
            </select>
            <button id="progress" class="btn btn-sm disabled btn-primary btn-progress" style="float: right;">Progress</button>
          </div>

          <div class="form-group">
            <label>Pegawai</label>
            <select class="form-control select2" name="id_pegawai" id="id_pegawai" required="">
            </select>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" id="save-button" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</div>
</form>
<script src="<?=base_url('file')?>/js/check.js"></script>
<script src="<?=base_url('file')?>/js/custom.js"></script>
<script type="text/javascript">
  $('#progress').hide();
  $(".select2").select2();
</script>

