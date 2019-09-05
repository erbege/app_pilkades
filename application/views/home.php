<!-- Tampilkan pesan selamat datang -->

<?php
  // echo '<pre>';
  // print_r($this->session->userdata());
  // echo '</pre>';
?>
<div class="row">

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
      <div class="inner">
        <h3><?php echo number_format_short($jmldesa->jmldesa); ?></h3>
        <p>Desa</p>
      </div>
      <div class="icon">
        <i class="ion ion-map"></i>
      </div>
      <a href="<?php echo base_url('penyelenggara'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo number_format_short($jmlcalon->jmlcalon); ?></h3>
        <p>Calon Kades</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-people"></i>
      </div>
      <a href="<?php echo base_url('calon'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo number_format_short($jmlpemilih->jmlpilih); ?></h3>
        <p>Data Pemilih</p>
      </div>
      <div class="icon">
        <i class="ion ion-document-text "></i>
      </div>
      <a href="<?php echo base_url('penyelenggara'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo number_format_short($jmlpemilih->jmlss); ?></h3>
        <p>Surat Suara</p>
      </div>
      <div class="icon">
        <i class="ion ion-social-buffer"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div> <!-- ./col -->
  
</div><!-- ./row -->

<div class="row">
  
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <?php
        if (($jmlcalon->jmlsuara > 0) || ($jmlpemilih->jmlpilih > 0)) {
          $persen = ($jmlcalon->jmlsuara / $jmlpemilih->jmlpilih) * 100;
        } else {
          $persen = 0;
        }
        ?>
        <h3><?php echo number_format($persen).'%'; ?></h3>
        <p>Tingkat Partisipasi</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="<?php echo base_url('rekap'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

</div><!-- ./row -->

<!-- FLASH MESSAGE -->
<div class="msg" style="display:none;">
  <?php echo $this->session->flashdata('msg'); ?>
</div>

