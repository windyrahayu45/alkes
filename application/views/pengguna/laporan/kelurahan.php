<div class="form-group">
                    <label>Kelurahan</label>
                    <select class="form-control select2" name="kelurahan" id="kelurahan" >
                        <?php  foreach ($kelurahan as $key ) { ?>
                            <option value="<?=$key->id?>"><?=$key->kelurahan?></option>
                        <?php } ?>
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