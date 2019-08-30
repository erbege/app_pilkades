<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>E-SAKIP</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>assets/publik/img/favicon.png" rel="icon">
  <link href="<?php echo base_url(); ?>assets/publik/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic|Raleway:400,300,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="<?php echo base_url(); ?>assets/publik/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="<?php echo base_url(); ?>assets/publik/css/style.css" rel="stylesheet">

</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">

  <!-- Fixed navbar -->
  <div id="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand smothscroll" href="#home"><b>E-SAKIP</b></a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#home" class="smothscroll">Beranda</a></li>
          <li><a href="#tentang" class="smothscroll">Tentang</a></li>
          <li><a href="#" class="smothscroll">Akses Publik</a></li>
          <li><a href="<?php echo base_url('Auth'); ?>">Login E-SAKIP</a></li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </div>

  <section id="home" name="home">
    <div id="headerwrap">
      <div class="container">
        <div class="row centered">
          
		  <img src="<?php echo base_url(); ?>assets/publik/img/logokab.png" alt=""><br/>
            <h1><b>E-SAKIP</b></h1>
            <h3>Pemerintah  Kabupaten Majalengka</h3>
            <br>
          </div>
        </div>
      </div>
      <!--/ .container -->
    </div>
    <!--/ #headerwrap -->
  </section>


  <section id="tentang" name="tentang">
    <!-- INTRO WRAP -->
    <div id="intro">
      <div class="container">
        <div class="row centered">
          <h1>Tentang E-SAKIP</h1>
		  <p>
		  E-Sakip adalah aplikasi Sistem Akuntabilitas Kinerja Instansi Pemerintah secara elektronik (E-SAKIP) yang bertujuan untuk memudahkan proses pemantauan dan pengendalian kinerja Satuan Kerja Perangkat Daerah (SKPD) di lingkungan Pemerintah Kabuoaten Majalengka dalam rangka untuk meningkatkan akuntabilitas dan kinerja SKPD pada khususnya dan kinerja Pemerintah Kabupaten Majalengka pada umumnya.
		  </p>
          <br>
          <br>
          <div class="col-lg-6">
            <img src="<?php echo base_url(); ?>assets/publik/img/intro01.png" alt="">
            <h3><a href="#">Akses Publik</a></h3>
            <p>&nbsp;</p>
          </div>
          <div class="col-lg-6">
            <img src="<?php echo base_url(); ?>assets/publik/img/intro02.png" alt="">
            <h3><a href="<?php echo base_url('Auth'); ?>">Login E-SAKIP</a></h3>
            <p>&nbsp;</p>
          </div>
        </div>
        <br>
        <hr>
      </div>
      <!--/ .container -->
    </div>
    <!--/ #introwrap -->
  </section>

  <div id="copyrights">
    <div class="container">
      <p>
        &copy; 2018, <strong>Bappelitbangda Kabupaten Majalengka</strong>. 
      </p>
      
    </div>
  </div>

  <!-- JavaScript Libraries -->
  <script src="<?php echo base_url(); ?>assets/publik/lib/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/publik/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/publik/lib/php-mail-form/validate.js"></script>
  <script src="<?php echo base_url(); ?>assets/publik/lib/easing/easing.min.js"></script>

  <!-- Template Main Javascript File -->
  <script src="<?php echo base_url(); ?>assets/publik/js/main.js"></script>

</body>
</html>