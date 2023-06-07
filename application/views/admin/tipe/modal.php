
<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Tipe Data</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          <div class="form-group">
            <label>Jenis </label>
            <input type="hidden" name="id_type" id="id_type">
            
            <input type="text" name="type_jawaban" id="type_jawaban" class="form-control" required="">
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

<?php if(isset($tipe)){ ?>
  $(document).ready(function(){
    $('#id_type').val('<?=$tipe->id_type; ?>');
    $('#type_jawaban').val('<?=$tipe->type_jawaban; ?>');
  });
<?php } ?>
</script>