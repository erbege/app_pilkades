<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<!-- Select2 -->
<link href="<?php echo base_url('assets/AdminLTE/plugins/select2/select2.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/AdminLTE/dist/css/alt/AdminLTE-select2.css') ?>" rel="stylesheet" type="text/css" />
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tabulasi Laporan
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tabulasi Laporan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Filterisasi</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">

            <form action="<?php echo $action; ?>" method="post" class="form-horizontal">

            <!-- Urusan -->
            <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label" >Urusan </label>
                <div class="col-sm-4">
                    <select class="form-control select2" name="urusan" id="urusan" data-placeholder="Pilih Urusan" style="width: 100%;"  required="required">
                        <option></option>
                        <?php foreach($urusan_data as $urdat){
                            echo '<option value="'.$urdat->id.'">'.$urdat->nama.'</option>';
                        } ?>
                    </select>
                </div>
            </div>
            <!-- Urusan Bidang -->
            <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label" >Urusan Bidang</label>
                <div class="col-sm-6">
                    <select class="form-control select2" data-placeholder="Pilih Urusan Bidang" name="urbid" id="urbid" style="width: 100%;">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <!-- Tabel Data-->
            <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label" >Tabel</label>
                <div class="col-sm-6">
                    <select class="form-control select2" name="tabel" id="tabel" data-placeholder="Pilih Tabel" style="width: 100%;" required="required">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <span class="col-sm-2" ></span>
                <div class="col-sm-4">
                    <input type="submit" name="submit" value="Tampilkan" class="btn btn-primary" >
                    <a href="<?php echo site_url('report') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
            </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $judul; ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?php 
            echo "Urusan: ".$urusan;
            echo "<br />";
            echo "Urusan Bidang: ".$urbid;
            echo "<br />";
            echo "Judul Tabel: <strong>".$namatabel."</strong>";
            echo "<br />";
            echo "<br />";
            echo $tab_tabel;
            ?>
        </div><!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div><!-- /.box-footer-->
    </div><!-- /.box -->

</section><!-- /.content -->

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<!-- Select2 -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/select2/select2.full.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //nested combobox
        $("#urusan").change(function (){
            var url = "<?php echo site_url('report/add_ajax_urbid');?>/"+$(this).val();
            $('#urbid').load(url);
            return false;
        })
        
        $("#urbid").change(function (){
            var url = "<?php echo site_url('report/add_ajax_tabel');?>/"+$(this).val();
            $('#tabel').load(url);
            return false;
        })
        $(".select2").select2();
        //Date picker

    });
</script>
<?php
$this->load->view('template/foot');
?>