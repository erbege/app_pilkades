<form id="form-tambah-pengguna" class="form-horizontal" method="POST">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 style="display:block; text-align:center;">Tambah Data Pengguna</h3>                   
  </div> <!-- modal header -->
  <div class="modal-body form">
    <div class="form-msg"></div>
    <input type="hidden" value="" name="id"/> 
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
          
          <select class="form-control select2" name="id_kecamatan" id="id_kecamatan" style="width: 100%">
            <?php
            foreach ($dataKecamatan as $dtkec) {
            ?>
            <option value="<?php echo $dtkec->id_kec; ?>"><?php echo $dtkec->nama_kec; ?></option>
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
          <input name="username" placeholder="Username" class="form-control" type="text">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Password</label>
        <div class="col-md-10">
          <div class="input-group">
            <input id="password" name="password" placeholder="Password" class="form-control" type="password" data-toggle="password">
            <span class="input-group-btn">
              <button type="button" class="btn btn-flat" onclick="myFunction()"><i class="fa fa-eye"></i></button>
            </span>
            <span class="help-block"></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Nama Depan</label>
        <div class="col-md-10">
          <input name="first_name" placeholder="Nama Depan" class="form-control" type="text">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Nama Belakang</label>
        <div class="col-md-10">
          <input name="last_name" placeholder="Nama Belakang" class="form-control" type="text">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">Level Pengguna</label>
        <div class="col-md-10">
          <select class="form-control select2" name="id_role" id="id_role" placeholder="Role" style="width: 100%">
            <option value="4">Operator Desa</option>
            <option value="3">Operator Kecamatan</option>
            <option value="2">Operator Kabupaten</option>
			<?php
			if ($this->session->userdata('id_role') == 1){
			?>
            <option value="1">Administrator</option>
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
          <input name="phone" placeholder="Phone" class="form-control" type="text" ">
          <span class="help-block"></span>
        </div>
      </div>
    </div>
  </div> <!-- modal body -->

  <div class="modal-footer">
    <div>
      <button type="submit" class="form-control btn btn-primary"><i class="fa fa-check"></i> Tambah Data</button>

    </div>
  </div> <!-- modal footer -->
</form>
