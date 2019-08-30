<form id="form-update-pengguna" class="form-horizontal" method="POST">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 style="display:block; text-align:center;">Update Data Pengguna</h3>                   
  </div> <!-- modal header -->
  <div class="modal-body form">
    <div class="form-msg"></div>
    <input type="hidden" name="id" value="<?php echo $dataPengguna->id; ?>"> 
    <input name="id_kabupaten" class="form-control" type="hidden" value="3210">
    <div class="form-body well">
      <!-- Kecamatan -->
      <div class="form-group">
        <label class="control-label col-md-2">Kecamatan</label>
        <?php
  
          //echo '<pre>';
          //print_r($dataKecamatan);
          //echo '</pre>';
  
        ?>
        <div class="col-md-10">
          
          <select class="form-control" name="id_kecamatan" id="id_kecamatan" style="width: 100%">
            <?php
            foreach ($dataKecamatan as $dtkec2) {
            ?>
            <option <?=($dtkec2->id_kec==$dataPengguna->id_kec)?'selected="selected"':''; ?>
            value="<?php echo $dtkec2->id_kec; ?>"          ><?php echo $dtkec2->nama_kec; ?></option>
            <?php
            }
            ?>
          </select>
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Username</label>
        <div class="col-md-10">
          <input name="username" placeholder="Username" class="form-control" type="text" value="<?php echo $dataPengguna->username; ?>">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Password</label>
        <div class="col-md-10">
          <div class="input-group">
            <input id="password2" name="password" class="form-control" type="password" data-toggle="password">
            <span class="input-group-btn">
              <button type="button" class="btn btn-flat" onclick="myFunction2()"><i class="fa fa-eye"></i></button>
            </span>
            <span class="help-block"></span>
          </div>
          <small class="text-teal">kosongkan untuk tidak mengganti password</small>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Nama Depan</label>
        <div class="col-md-10">
          <input name="first_name" placeholder="Nama Depan" class="form-control" type="text" value="<?php echo $dataPengguna->first_name; ?>">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Nama Belakang</label>
        <div class="col-md-10">
          <input name="last_name" placeholder="Nama Belakang" class="form-control" type="text" value="<?php echo $dataPengguna->last_name; ?>">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Level Pengguna</label>
        <div class="col-md-10">
            <select class="form-control " name="id_role" id="id_role" placeholder="Role">
              <option <?=("4"==$dataPengguna->id_role)?'selected="selected"':''; ?> value="3" >Operator Desa</option>
              <option <?=("3"==$dataPengguna->id_role)?'selected="selected"':''; ?> value="3" >Operator Kecamatan</option>
              <option <?=("2"==$dataPengguna->id_role)?'selected="selected"':''; ?> value="2" >Operator Kabupaten</option>
			  <?php
			  if ($this->session->userdata('id_role') == 1){
			  ?>
              <option <?=("1"==$dataPengguna->id_role)?'selected="selected"':''; ?> value="1" >Adminisitrator</option>
			  <?php
			  }
			  ?>
            </select>
            <span class="help-block"></span>        
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Email</label>
        <div class="col-md-10">
          <input name="email" placeholder="Email" class="form-control" type="email">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Phone</label>
        <div class="col-md-10">
          <input name="phone" placeholder="Phone" class="form-control" type="text">
          <span class="help-block"></span>
        </div>
      </div>

	    <div class="form-group">
        <label class="control-label col-md-2">Aktif?</label>
        <div class="col-md-10">
            <select class="form-control " name="statuser" id="id_role" placeholder="Role">
              <option <?=("Y"==$dataPengguna->active)?'selected="selected"':''; ?> value="Y" >Ya</option>
              <option <?=("N"==$dataPengguna->active)?'selected="selected"':''; ?> value="N" >Tidak</option>
            </select>
            <span class="help-block"></span>        
        </div>
      </div>
    </div>
  </div> <!-- modal body -->

  <div class="modal-footer">
    <div>
      <button type="submit" class="form-control btn btn-primary"><i class="fa fa-check"></i> Update Data</button>

    </div>
  </div> <!-- modal footer -->
</form>
