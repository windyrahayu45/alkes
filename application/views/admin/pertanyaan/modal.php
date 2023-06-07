<form id="form-save" class="needs-validation" novalidate >
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Tambah Pertanyaan</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">    
          <div class="form-group">
            <input type="hidden" name="id" id="id">
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
            <label>Bidang</label>
            <select class="form-control select2" name="bidang_id" id="bidang_id" required>
            </select>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label>Urutan</label>
            <input type="number" name="urutan" id="urutan" class="form-control" required>
            <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label>Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan_input"  class="form-control" required=""></textarea>
            <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label>Tipe Data </label>
            <select class="form-control select2" name="type_jawaban" id="type_jawaban" required="">
              <?php  foreach ($tipe as $key ) { ?>
                  <option value="<?=$key->id_type?>"><?=$key->type_jawaban?></option>
              <?php } ?>
            </select>
            <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          <div class="form-group">
            <label>Apakah pertanyaan ini berkaitan dengan instansi lain (Jika ada)</label>
            <select class="form-control select2" name="instansi[]" id="instansi"  multiple="">
              <option value="">Pilih Instansi</option>
              <?php  foreach ($instansi as $key ) { ?>
                  <option value="<?=$key->id_instansi?>"><?=$key->nama_instansi?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label>Pilih urusan pertanyaan sesuai SPBE (Jika Ada)</label>
            <select class="form-control select2" name="urusan" id="urusan" >
              <option value="">Pilih urusan</option>
              <?php  foreach ($urusan as $key ) { ?>
                  <option value="<?=$key->id?>"><?=$key->urusan?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group" id="pokja_dasawisma">
            <label>Pertanyaan ini berkaitan dengan pokja (Jika Ada)</label>
            <select class="form-control select2" name="pokja" id="pokja" >
              <option value="">Pilih pokja</option>
              <option value="1">Pokja I</option>
              <option value="2">Pokja II</option>
              <option value="3">Pokja III</option>
              <option value="4">Pokja IV</option>
            </select>
          </div>
          <div class="form-group">
            <label>Point</label>
            <input type="number" name="point" id="point" class="form-control">
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