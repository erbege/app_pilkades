<!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
<div class="msg" style="display:none;">
    <?php echo @$this->session->flashdata('msg'); ?>
</div>
<?php
    /*echo '<pre>';
        print_r($this->session->userdata());
echo '</pre>';*/
?>
<?php
    foreach($transaksi as $dttran){
        $thp_lalu[] = $dttran->tahap;
        $thp_stat[] = $dttran->stat;
        $tgl_awal[] = $dttran->tgl_awal;
        $jam_awal[] = $dttran->jam_awal;
        $tgl_akhir[] = $dttran->tgl_akhir;
        $jam_akhir[] = $dttran->jam_akhir;
    }
?>
<!-- Default box -->
<div class="box">
    <!-- <div class="box-header with-border">
        <h3 class="box-title"><?php echo $judul ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div> -->
    <div class="box-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tahapan Pelaksanaan Pilkades</h3>
            </div>
            <div class="panel-body">
                <form id="form-tahapan" class="form-horizontal" method="POST">
                    <table class="">
                        <!-- Tahap 1 -->
                        <tr>
                            <td>Pengelolaan Data Desa Penyelenggara Pilkades (input/edit/delete)</td>
                            <td>
                                
                                <?php
                                if ($thp_stat[0] == '1') {
                                echo '<input name="cek1" type="checkbox" data-toggle="toggle" data-size="small" checked>';
                                } else {
                                echo '<input name="cek1" type="checkbox" data-toggle="toggle" data-size="small">';
                                }
                                ?>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <input placeholder="Tanggal Awal" type="text" class="form-control datepicker" name="tgl_awal1" value="<?php echo $tgl_awal[0]; ?>">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <input placeholder="Tanggal Akhir" type="text" class="form-control datepicker" name="tgl_akhir1" value="<?php echo $tgl_akhir[0]; ?>">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                        </tr>
                        <!-- Tahap 2 -->
                        <tr>
                            <td>Pengelolaan Data Calon Kepala Desa (input/edit/delete)</td>
                            <td>
                                <input name="cek2" type="checkbox" checked data-toggle="toggle" data-size="small">
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <input placeholder="Tanggal Awal" type="text" class="form-control datepicker" name="tgl_awal2" value="<?php echo $tgl_awal[1]; ?>">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <input placeholder="Tanggal Akhir" type="text" class="form-control datepicker" name="tgl_akhir2" value="<?php echo $tgl_akhir[1]; ?>">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                        </tr>
                        <!--  Tahap 3 -->
                        <tr>
                            <td>Pengelolaan Hasil Pilkades</td>
                            <td>
                                <input name="cek3" type="checkbox" checked data-toggle="toggle" data-size="small" >
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <input placeholder="Tanggal Awal" type="text" class="form-control datepicker" name="tgl_awal3" value="<?php echo $tgl_awal[2]; ?>">
                                    </div>
                                    
                                </div>
                                <span class="help-block"></span>
                            </td>
                            <td>
                                <div class="bootstrap-timepicker">
                
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control timepicker" id="jamawal3" name="jamawal3">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <input placeholder="Tanggal Akhir" type="text" class="form-control datepicker" name="tgl_akhir3" value="<?php echo $tgl_akhir[2]; ?>">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                            <td>
                                <div class="bootstrap-timepicker">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control timepicker" id="jamakhir3" name="jamakhir3">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </td>
                        </tr>
                        <!--    <tr>
                            <td colspan="4">
                                        <button class="btn btn-primary" id="btnSave" onclick="save()" >Simpan</button>
                                        <button class="btn btn-danger" id="btn-reset"">Reset</button>
                            </td>
                        </tr> -->
                        
                    </table>

                </form>
            </div> <!-- panel-body -->
            <div class="panel-footer">
                <button class="btn btn-primary" id="btnSave" onclick="save()" >Simpan</button>
                <button class="btn btn-danger" id="btn-reset"">Reset</button>
            </div>
        </div> <!-- panel -->
    </div><!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div><!-- /.box-footer-->
</div><!-- /.box -->
<!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script>
    
$(document).ready(function(){

    //iCheck
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
    });
    //Datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: false,
        todayHighlight: true,
        language: "id",
        locale: "id",
    });
    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });

});

$("#racode_alert").fadeTo(2000, 500).slideUp(500, function(){
$("#racode_alert").slideUp(500);
    //
});

$('#btn-reset').click(function(){ //button reset event click
$('#form-tahapan')[0].reset();
//alert('disini'+<?php echo $thp_stat[0];?>);
//if ('#cek1').val()=
if ($('cek1').val() == '1') { $('#cek1').bootstrapToggle('on') } else {$('#cek1').bootstrapToggle('off')};
//if (<?php $thp_stat[0];?> = '0') { $('#cek1').bootstrapToggle('off') };
});
function save()
{
$('#btnSave').text('saving...'); //change button text
$('#btnSave').attr('disabled',true); //set button disable

var url;
    url = "<?php echo site_url('tahapan/ajax_update')?>";
    // ajax adding data to database
    var formData = new FormData($('#form-tahapan')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                alert('success');
            }
            else
            {
                alert('error');
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
        },
    error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
        }
    });
}
</script>