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
                      <option value="<?=$rw?>"><?=$rw?></option>
                    </select>
                  </div>

                  <div class="form-group ">
                    <label>RT</label>
                    <select class="form-control select2" name="rt" id="rt">
                      <option value="">--pilih rt--</option>
                      <?php  foreach ($rt as $key ) { ?>
                            <option value="<?=$key->rt?>"><?=$key->rt?></option>
                        <?php } ?>
                     
                    </select>
                  </div>