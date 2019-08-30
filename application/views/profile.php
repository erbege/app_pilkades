<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/img/<?php echo $this->session->userdata('photo'); ?>" alt="User profile picture">

        <h3 class="profile-username text-center"><?php echo $this->session->userdata('first_name')." ".$this->session->userdata('last_name'); ?></h3>

        <p class="text-muted text-center"><?php echo  $this->session->userdata('nama_instansi'); ?></p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Username</b> <a class="pull-right"><?php echo  $this->session->userdata('username'); ?></a>
          </li>
          <li class="list-group-item">
            <b>Tgl dibuat</b> <a class="pull-right"><?php echo  $this->session->userdata('created_on'); ?></a>
          </li>
          <li class="list-group-item">
            <b>Terakhir login</b> <a class="pull-right"><?php echo  $this->session->userdata('last_login'); ?></a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
        <li><a href="#password" data-toggle="tab">Ubah Password</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="settings">
          <form class="form-horizontal" action="<?php echo base_url('Profile/update') ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="inputUsername" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id= placeholder="Username" name="username" value="<?php echo $this->session->userdata('username'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama" class="col-sm-2 control-label">Nama Depan</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Name" name="first_name" value="<?php echo $this->session->userdata('first_name'); ?>">
              </div>
            </div>
			<div class="form-group">
              <label for="inputNama" class="col-sm-2 control-label">Nama Belakang</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?php echo $this->session->userdata('last_name'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputFoto" class="col-sm-2 control-label">Foto</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" placeholder="Foto" name="photo">
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane" id="password">
          <form class="form-horizontal" action="<?php echo base_url('Profile/ubah_password') ?>" method="POST">
            <div class="form-group">
              <label for="passLama" class="col-sm-2 control-label">Password Lama</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="Password Lama" name="passLama">
              </div>
            </div>
            <div class="form-group">
              <label for="passBaru" class="col-sm-2 control-label">Password Baru</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="Password Baru" name="passBaru">
              </div>
            </div>
            <div class="form-group">
              <label for="passKonf" class="col-sm-2 control-label">Konfirmasi Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="Konfirmasi Password" name="passKonf">
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="msg" style="display:none;">
      <?php echo $this->session->flashdata('msg'); ?>
    </div>
  </div>
</div>