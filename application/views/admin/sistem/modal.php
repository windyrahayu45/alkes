<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Sistem</h5>
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
            <button id="progress" class="btn btn-sm disabled btn-primary btn-progress" style="float: right;">Progress</button>
          </div>

          <div class="form-group">
            <label>Sistem Survey</label>
            <select class="form-control select2" name="sistem" id="sistem" required="">
              <option value="0">Pilih Sistem Survey</option>
              <option value="1">Tahunan</option>
              <option value="2">Semester</option>
              <option value="3">triwulan</option>
              <option value="4">bulanan</option>
            </select>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          

          <div id="bagianx" >
            <div class="form-group">
              <label><p id="judul"></p></label>
              <input type="number" name="bagian" id="bagian" class="form-control"  maxlength="00" >
            </div>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          <div class="form-group">
            <label>Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control" required="" maxlength="0000" >
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
  $('#bagianx').hide();

</script>