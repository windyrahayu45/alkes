
<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Pilih Kepala Keluarga yang diverifikasi</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          <div class="form-group">
            <label>Pilih Kartu keluarga yang diverifikasi di rumah ini</label>
            <select class="form-control select2" name="no_kk[]" id="no_kk" multiple="">
              <?php  foreach ($kk as $key ) { ?>
                  <option value="<?=$key->no_kk?>"><?=$key->nama_kk?></option>
              <?php } ?>
            </select>
          </div>

          <input type="hidden" name="id_rumah" id="id_rumah" class="form-control" required="" value="<?=$id_rumah?>">
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" id="save-button" class="btn btn-primary">Verifikasi</button>
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