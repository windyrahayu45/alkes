 <form id="form-save" class="needs-validation" novalidate >
 <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Level</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          <div class="form-group">
            <label>Modul</label>
            <select class="form-control select2" name="modul_id" id="modul_id" required="">
              <option value="">Pilih Modul</option>
              <?php  foreach ($modul as $key ) { ?>
                  <option value="<?=$key->id?>"><?=$key->modul?></option>
              <?php } ?>
            </select>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
            
          </div>

          <div class="form-group">
            <label>Jenis Level</label>
            <input type="text" class="form-control" name="level" id="jenis_level" required="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label>Keterangan Level</label>
            <textarea class="form-control" name="ket" id="ket" required=""></textarea>
            <div class="valid-feedback">Valid.</div>
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