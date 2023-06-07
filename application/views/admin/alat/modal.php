
<form id="form-afkir" class="needs-validation" novalidate >
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Afkir Barang</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
           <input type="hidden" name="id_barang" id="id_barang">
          <div class="form-group">
            <label>Keterangan Afkir</label>
            <input type="text" name="ket" id="ket" class="form-control " required >
            <div id="msg"></div>
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
  $(".select2").select2();
  $('#id_barang').val('<?=$id_barang?>');
  
</script>


