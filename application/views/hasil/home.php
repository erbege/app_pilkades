
<?php

    /*echo '<pre>';
    print_r($this->session->userdata());
    echo '</pre>';*/

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
        <?php
            if (($this->session->userdata('id_role') == 1) || ($this->session->userdata('id_role') == 2)){
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Filter</h3>
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down" data-toggle="tooltip" title="Collapse"></i></span>
            </div>
            <div class="panel-body">
                <?php
                // echo 'frmKec -> '.$this->input->post('frmKec');
                // echo '<br />';
                // echo 'frmDesa -> '.$this->input->post('frmDesa');
                ?>
                
                <form id="form-filter" class="form-horizontal">
                    <div class="form-group">
                        <label for="nama_kec" class="col-sm-2 control-label">Kecamatan</label>
                        <div class="col-sm-4">
                            <?php echo $form_kec; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_desa" class="col-sm-2 control-label">Desa</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nama_desa">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                    </div>
                    </div>
                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
        <?php
            }
        ?>
        <div class="panel panel-primary">
            <div class="panel-body">
                <span class="pull-right">
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                <a href="#" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                </span>
                <?php 
                echo '<h4 class="text-muted"><b>Hasil Pemilihan Kepala Desa Tahun '.$this->session->userdata('thn_data').'</b></h4>';
                ?>
            </div>
        </div>
    	<div class="table-responsive">
    		<!-- <table class="table table-bordered table-hovered table-condensed" id="table_id">  -->
            <div class="col-md-12">
            <table class="table table-hover table-condensed" id="table">
        		<thead>
                    <tr>
                        <th>No</th>
            			<th>Nama Calon</th>
                        <th>Desa Pemilihan</th>
                        <th>Perolehan Suara</th>
            			<th style="width:50px;">Aksi</th>
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
    	</div><!-- /.table-responsive -->
    </div><!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div><!-- /.box-footer-->
</div><!-- /.box -->




<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var suaraTotal = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            $( api.column( 2 ).footer() ).html('Total');
            $( api.column( 3 ).footer() ).html(suaraTotal);
        },
        "language": {
            "decimal": ",",
            "thousands": "."
        },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('hasil/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.nama_kec = $('#nama_kec').val();
                data.nama_desa = $('#nama_desa').val();
            }
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

    // nested
    $("#kdkec").change(function (){
        var url = "<?php echo site_url('Penyelenggara/add_ajax_des');?>/"+$(this).val();
        $('#kddesa').load(url);
        return false;
    })

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

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });

    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
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

    //nested combobox
    $("#id_kec").change(function (){
        var url = "<?php echo site_url('calon/add_ajax_desa');?>/"+$(this).val();
        $('#id_desa').load(url);
        return false;
    });

    $(document).on('click', '.panel-heading span.clickable', function(e){
        var $this = $(this);
        if(!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
    })  
});


function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('hasil/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="nama"]').val(data.nama);
            $('[name="tmp_lahir"]').val(data.tmp_lahir);
            $('[name="tgl_lahir"]').datepicker('update',data.tgl_lahir);
            $('[name="kelamin"]').val(data.kelamin);
            $('[name="agama"]').val(data.agama);
            $('[name="alamat1"]').val(data.alamat1);
            $('[name="id_pendidikan"]').val(data.id_pendidikan);
            $('[name="id_pekerjaan"]').val(data.id_pekerjaan);
            $('[name="id_pekerjaan"]').selectedIndex = data.id_pekerjaan;
            $('[name="organisasi"]').val(data.organisasi);
            $('[name="keterangan"]').val(data.keterangan);
            
            $('[name="id_kab"]').val(data.kdkab);
            $('[name="kdkec"]').val(data.kdkec);
            $('[name="kddesa"]').val(data.kddesa);
            $('[name="nama_desa"]').val(data.nama_desa);
            $('[name="nama_kec"]').val(data.nama_kec);
            $('[name="thn_pemilihan"]').val(data.thn_pemilihan);
            $('[name="s_hasil"]').val(data.s_hasil);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Hasil Perolehan Suara'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.photo)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" class="minimal" name="remove_photo" value="'+data.photo+'"/> Hapus photo saat menyimpan'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
            }


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
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('hasil/ajax_add')?>";
    } else {
        url = "<?php echo site_url('hasil/ajax_update')?>";
    }

    // ajax adding data to database

    var formData = new FormData($('#form')[0]);
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
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

</script>

<!-- Bootstrap modal -->
<div class="modal" id="modal_form" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    
                    <div class="form-body">
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Desa / Kecamatan</label>
                            <div class="col-md-4">
                                <input name="nama_desa" placeholder="Nama Desa" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-4">
                                <input name="nama_kec" placeholder="Nama Kec" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Calon Kepala Desa</label>
                            <div class="col-md-8">
                                <input name="nama" placeholder="Nama Lengkap" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Perolehan Suara</label>
                            <div class="col-md-3">
                                <input name="s_hasil" placeholder="Suara" class="form-control" type="number" min="0">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
