<!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
<div class="msg" style="display:none;">
    <?php echo @$this->session->flashdata('msg'); ?>
</div>

<!-- Default box -->
<div class="box">

    <div class="box-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tahapan Pelaksanaan Pilkades
                    <small><?php echo " - Hari ini " . date("Y-m-d H:i:s"); ?></small>
                </h3>
                
            </div>
            <div class="panel-body">
                
                <div class="table-responsive">
                    <div class="col-md-12">
                    <table class="table table-hover table-condensed" id="table">
                        <thead>
                            <tr>
                                <th>Tahapan</th>
                                <th>Status</th>
                                <th>Tgl Awal</th>
                                <th>Tgl Akhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
            </div>

                
            </div> <!-- panel-body -->
            <!-- <div class="panel-footer">
                &nbsp;
            </div> -->
        </div> <!-- panel -->
    </div><!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div><!-- /.box-footer-->
</div><!-- /.box -->

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "paging": false,
        "ordering": false,
        "searching": false,
        "info": false,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('tahapan/ajax_list')?>",
            "type": "POST",
            "data": function ( data )  {
                data.tahap = $('#tahap').val();
            },
        },

        
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -2 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },

        ],

    });

    //datepicker
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

    //Date range picker with time picker
    $('#reservasi').daterangepicker({
        timePicker: true, 
        timePickerIncrement: 15, 
        format: 'YYYY/MM/DD HH:mm:ss',
        locale: {
            fromat: 'YYYY/M/DD HH:mm:ss'
        }
    });

    $('#reservasi2').daterangepicker({
        timePicker: false, 
        format: 'YYYY/MM/DD',
        locale: {
            fromat: 'YYYY/M/DD',
        }
    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select2").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});


function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('tahapan/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="tahap"]').val(data.tahap);
            //$('[name="stat"]').val(data.stat);
            if ((data.stat) == '1') { $('#stat').bootstrapToggle('on') } else {$('#stat').bootstrapToggle('off')};
            $('#reservasi').data('daterangepicker').setStartDate(data.tgl_awal)
            $('#reservasi').data('daterangepicker').setEndDate(data.tgl_akhir)
            $('[name="ket"]').val(data.ket);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Jadwal Tahapan'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax yeuh!!!');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('tahapan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('tahapan/ajax_update')?>";
    }

    // ajax adding data to database

    //var formData = new FormData($('#form')[0]);

    var tgl_awal = $('#reservasi').data('daterangepicker').startDate.format('YYYY-MM-DD H:m:s');
    var tgl_akhir = $('#reservasi').data('daterangepicker').endDate.format('YYYY-MM-DD H:m:s');
    var id = $('[name="id"]').val();
    var status = $('#stat').prop('checked')
    var ket = $('[name="ket"]').val();

    if (status) {stat = '1';} else {stat = '0';}

    $.ajax({
        type: "POST",
        url : url,
        dataType: "JSON",
        data: {id:id, stat:stat, tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, ket:ket},
        //contentType: false,
        //processData: false,

        success: function(data)
        {
            //alert('ID:'+id+', Status: '+stat+', Tgl Awal: '+tgl_awal+', Tgl Akhir: '+tgl_akhir+', Ket: '+ket);

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

</script>

<!-- Bootstrap modal -->
<div class="modal" id="modal_form" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                
                <input type="hidden" value="" name="id"/> 
                
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tahapan:</label>
                        <!-- <textarea class="form-control" name="tahap" id="tahap" readonly="true"></textarea> -->
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="tahap" id="tahap" readonly="true">
                        </div>
                    </div> <!-- /.form group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Status tahapan :
                        </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="stat" id="stat" type="checkbox" data-toggle="toggle" data-size="small">
                        </div>
                    </div>

                    <!-- Date and time range -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jadwal tahapan:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="reservasi" name="reservasi">
                            </div> <!-- /.input group -->
                        </div>
                    </div><!-- /.form group -->
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Keterangan:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="ket" id="ket""></textarea>
                        </div>
                    </div> <!-- /.form group -->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
