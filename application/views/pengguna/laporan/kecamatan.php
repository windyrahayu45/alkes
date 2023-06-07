<div class="form-group">
                    <label>Kecamatan</label>
                    <select class="form-control select2" name="kecamatan" id="kecamatan" >
                      <?php if($this->session->userdata('level')!='Kecamatan'): ?>
                      <option value="">--pilih Kecamatan--</option>
                    <?php endif; ?>
                      <?php  foreach ($kecamatan as $key ) { ?>
                          <option value="<?=$key->id?>"><?=$key->kecamatan?></option>
                      <?php } ?>
                    </select>
</div>

<div class="form-group">
  <label>Kelurahan</label>
  <select class="form-control select2" name="kelurahan" id="kelurahan" >
     
  </select>
</div>

<div class="form-group">
  <label>RW</label>
  <select class="form-control select2" name="rw" id="rw" >
  </select>
</div>

<div class="form-group ">
  <label>RT</label>
  <select class="form-control select2" name="rt" id="rt">
  </select>
</div>