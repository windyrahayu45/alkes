
<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Modul</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
     
          <div class="form-group">
            <label>Nama Modul</label>
            <input type="text" name="modul" id="modul2" class="form-control " required >
            <div id="msg"></div>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label>Instansi</label>
            <select class="form-control select2" name="instansi" id="instansi">
              <?php  foreach ($instansi as $key ) { ?>
                  <option value="<?=$key->id_instansi?>"><?=$key->nama_instansi?></option>
              <?php } ?>
              
              
            </select>
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
  $(".select2").select2();
  
</script>


