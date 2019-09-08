<!-- Default box -->
<div class="box">
    <div class="box-body">
        <?php
            if (($this->session->userdata('id_role') == 1) || ($this->session->userdata('id_role') == 2)){
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Filter</h3>
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up" data-toggle="tooltip" title="Collapse"></i></span>
            </div>
            <div class="panel-body">
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
                <div class="col-md-6 col-xs-12">
                    <?php 
                    echo '<h4 class="text-muted"><b>Hasil Pemilihan Kepala Desa Tahun '.$this->session->userdata('thn_data').'</b></h4>';
                    ?>
                </div>
                <div class="col-md-2 col-xs-12">
                    <button class="btn btn-default btn-block" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                </div>
                <div class="col-md-2 col-xs-12">
                    <a href="#" class="btn btn-default btn-block"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                </div>
                
            </div>
        </div>
    	<div class="table-responsive">
            <div class="col-md-12">
            <table class="table table-hover table-condensed" id="table">
        		<thead>
                    <tr>
                        <th rowspan="2">No</th>
            			<th rowspan="2">Desa</th>
                        <th rowspan="2">DPT</th>
                        <th colspan="4" class="text-center">Surat Suara</th>
                        <th rowspan="2">Partisipasi (%)</th>
            			<th rowspan="2" style="width:50px;">Aksi</th>
            		</tr>
                    <tr>
                        <th>Sah</th>
                        <th>Tidak Sah</th>
                        <th>Tidak Digunakan</th>
                        <th>Jumlah</th> 
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
var kodes = '';

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
            var totalDPT = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var totalSah = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var totalTdkSah = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var totalTdkDipakai = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var totalJumlah = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            $( api.column( 1 ).footer() ).html('Total');
            $( api.column( 2 ).footer() ).html(totalDPT);
            $( api.column( 3 ).footer() ).html(totalSah);
            $( api.column( 4 ).footer() ).html(totalTdkSah);
            $( api.column( 5 ).footer() ).html(totalTdkDipakai);
            $( api.column( 6 ).footer() ).html(totalJumlah);
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
                "targets": [ -3 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
            {
                className: "dt-right","targets": [ 2, 3, 4, 5, 6, 7],
            }

        ],

    });

    // hitung otomatis jumlah surat suara tidak terpakai
    var input1 = document.getElementById('suratsuara');
    var input2 = document.getElementById('sssah');
    var input3 = document.getElementById('sstdksah');
    var input4 = document.getElementById('sstidakterpakai');

    input1.addEventListener('change', function() {
    input4.value = parseInt(input1.value)-(parseInt(input2.value)+parseInt(input3.value));
    });

    input2.addEventListener('change', function() {
    input4.value = parseInt(input1.value)-(parseInt(input2.value)+parseInt(input3.value));
    });

    input3.addEventListener('change', function() {
    input4.value = parseInt(input1.value)-(parseInt(input2.value)+parseInt(input3.value));
    });

    // hitung otomatis jumlah perolehan suara semua calon
    var isi1 = 


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
            $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    })  
});

function load_data_calon(kode)
    {
    $.ajax({
      url:"<?php echo base_url(); ?>hasil/load_data/" + kode,
      dataType:"JSON",
      success:function(data){
        var jumlah = 0;
        var html = '';

        var inputss = document.getElementById('sssah');

        for(var count = 0; count < data.length; count++)
        {
          html += '<tr>';
          html += '<th class="table_data" data-row_id="'+data[count].id+'" data-column_name="nourut" width="40px">'+data[count].nourut+'</th>';
          html += '<th class="table_data" data-row_id="'+data[count].id+'" data-column_name="nama">'+data[count].nama+'</th>';
          //html += '<td align="right" class="table_data" data-row_id="'+data[count].id+'" data-column_name="s_hasil" contenteditable style="background-color: #eee">'+data[count].s_hasil+'</td>';
          html += '<td><input id="angka" type="number" min="0" step="1" style="width: 80px" class="table_data pull-right" data-row_id="'+data[count].id+'" data-column_name="s_hasil" value="'+data[count].s_hasil+'"></td>';
          html += '</tr>';
          jumlah = jumlah + parseInt(data[count].s_hasil);
        }
        html += '<tr>';
        html += '<td></td>';
        html += '<td align="right"><b>Jumlah</b></td>';
        if (parseInt(inputss.value) == jumlah ) {
            //html += '<td align="right" id="jmlSuaraCalon" class="text-success"><b>'+jumlah+'</b></td>';
            html += '<td><input type="text" id="jmlSuaraCalon" class="jmlSuaraCalon text-success pull-right" value="'+jumlah+'" readonly="true" style="width: 80px" ></td>';
        } else {
            //html += '<td align="right" id="jmlSuaraCalon" class="text-danger"><b>'+jumlah+'</b>';
            html += '<td><input type="text" id="jmlSuaraCalon" class="jmlSuaraCalon text-danger pull-right " value="'+jumlah+'" readonly="true" style="width: 80px" ></td>';
        }

        html += '</tr>';
        $('#table_calon tbody').html(html);
      }
    });
  }

$(document).on('blur', '.table_data', function(){
var id = $(this).data('row_id');
var table_column = $(this).data('column_name');
//var value = $(this).text();
var value = $(this).val();
$.ajax({
  url:"<?php echo base_url(); ?>hasil/update_hasil",
  method:"POST",
  data:{id:id, table_column:table_column, value:value},
  success:function(data)
  {
    load_data_calon(kodes);
    //alert('sukses coyyy ' + kodes);
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
            $('[name="suratsuara"]').val(data.suratsuara);
            
            $('[name="sssah"]').val(data.sssah);
            $('[name="sstdksah"]').val(data.sstdksah);
            $('[name="sstidakterpakai"]').val(data.sstidakterpakai);

            $('[name="nama_desa"]').val(data.nama_desa);
            $('[name="nama_kec"]').val(data.nama_kec);
            $('[name="thn_pemilihan"]').val(data.thn_pemilihan);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Input Hasil Pilkades'); // Set title to Bootstrap modal title

            // simpan kode desa ke variabel global
            kodes = data.kddesa;

            load_data_calon(data.kddesa);
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
    $('#btnSave').text('Meyimpan...'); //change button text
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_kec">Kecamatan</label>
                                <input type="email" class="form-control" id="nama_kec" name="nama_kec" readonly="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_desa">Desa</label>
                                <input type="text" class="form-control" id="nama_desa" name="nama_desa" readonly="true">
                            </div>
                        </div>
                        <div class="clearfix"><hr /></div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="suratsuara">Jml Surat Suara</label>
                                <input type="number" step="1" min="0" class="form-control" id="suratsuara" name="suratsuara">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sssah">Sah</label>
                                <input type="number" step="1" min="0" class="form-control" id="sssah" name="sssah">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sstdksah">Tidak Sah</label>
                                <input type="number" step="1" min="0" class="form-control" id="sstdksah" name="sstdksah">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sstidakterpakai">Tidak Terpakai</label>
                                <input type="number" step="1" min="0" class="form-control" id="sstidakterpakai" name="sstidakterpakai">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 well well-sm">
                            <p class="text-muted">Klik pada area abu-abu di sebelah kanan nama masing-masing calon di bawah ini untuk mengisi perolehan suara</p>
                        </div> -->

                        <div class="col-sm-12">
                            <p class="lead">Perolehan Suara Calon</p>
                            <div class="table-responsive">
                                <table id="table_calon" class="table table-condensed">
                                    <thead>
                                    
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div> <!-- /.table-reponsive -->
                        </div>

                    </div> <!-- /.form-body -->
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
