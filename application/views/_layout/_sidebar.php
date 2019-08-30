<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url(); ?>assets/img/<?php echo $this->session->userdata('photo'); ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $this->session->userdata('first_name')." ".$this->session->userdata('last_name'); ?></p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <!-- <li class="header">LIST MENU</li> -->
      <!-- Optionally, you can add icons to the links -->
      <li <?php if ($page == 'home') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('Home'); ?>">
          <i class="fa fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="header">MENU UTAMA</li>
      
      <li <?php if ($page == 'Data Pokok') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('penyelenggara'); ?>">
          <i class="fa fa-map-marker"></i>
          <span>Data Pokok </span>
        </a>
      </li>

      <li <?php if ($page == 'calon') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('calon'); ?>">
          <i class="fa fa-male"></i>
          <span>Daftar Calon</span>
        </a>
      </li> 
      

      <li class="header">HASIL PEMILIHAN</li>
      
      <!-- Kecamatan Only -->
      <li <?php if ($page == 'Hasil Pemilihan') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('hasil'); ?>">
          <i class="fa fa-pie-chart"></i>
          <span>Input Hasil Pemilihan</span>
        </a>
      </li>         
      
      <!-- Semua role -->
      <li class="header">REKAPITULASI</li>
      <li <?php if ($page == 'Rekapitulasi') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('rekap'); ?>">
          <i class="fa fa-table"></i>
          <span>Rekap Suara Masuk</span>
        </a>
      </li>      
      
      <li <?php if ($page == 'Rekap Hasil') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('rekaphasil'); ?>">
          <i class="fa fa-table"></i>
          <span>Rekap Perolehan</span>
        </a>
      </li>  
	     
      
      <!-- This links only appear to admin user(s)-->
      <li class="header">LAPORAN</li>
      <li <?php if ($page == 'Laporan Hasil Pilkades') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('laporan'); ?>">
          <i class="fa fa-table"></i>
          <span>Laporan Hasil Pilkades</span>
        </a>
      </li>
        <?php
      if (($this->session->userdata('id_role') == 1) or ($this->session->userdata('id_role') == 2)) {
        ?>

      <li class="header">PENGATURAN</li>
      <li <?php if ($page == 'pengguna') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('Pengguna'); ?>">
          <i class="fa fa-users"></i>
          <span>Pengguna </span>
        </a>
      </li>

      <li <?php if ($page == 'tahapan') {echo 'class="active"';} ?>>
        <a href="<?php echo base_url('tahapan'); ?>">
          <i class="fa fa-toggle-on"></i>
          <span>On/Off Tahapan </span>
        </a>
      </li>
      
      <?php
      }
      ?>

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>