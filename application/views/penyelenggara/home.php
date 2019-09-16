<div class="msg" style="display:none;">
	<?php echo @$this->session->flashdata('msg'); ?>
</div>

<!-- Default box -->
<div class="box">
	<div class="alert alert-warning alert-dismissible" id="peringatan">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
		Mohon berhati-hati saat menghapus data desa, karena akan berpengaruh pada data calon.
	</div>
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
	        		echo '<h4 class="text-muted"><b>Data Penyelenggaraan Pilkades Serentak Tahun '.$this->session->userdata('thn_data').'</b></h4>';
	        		?>
	        	</div>
	        	<div class="col-md-2 col-xs-12">
				<?php
					if ($this->session->userdata('id_role') == 3) {
		                if (getStatusTransaksi('Pengelolaan Data Pokok/DPT')) {

							echo '<button class="btn btn-success btn-block" onclick="add_desa()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>';
						} else {
							echo '<button class="btn btn-success btn-block" onclick="add_desa()" disabled><i class="glyphicon glyphicon-plus"></i> Tambah</button>';
						}
					} else {
						echo '<button class="btn btn-success btn-block" onclick="add_desa()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>';
					}
				?>
				</div>
				<div class="col-md-2 col-xs-12">
        			<button class="btn btn-default btn-block" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        		</div>
        		<div class="col-md-2 col-xs-12">
        			<a href="<?php echo base_url('penyelenggara/export'); ?>" class="btn btn-default btn-block"><i class="fa fa-file-excel-o"></i> Export Excel</a>
        		</div>
			</div>
		</div>
		<div class="table-responsive">

			<div class="col-md-12">
				<table id="table" class="table table-condensed table-bordere table-hover" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th width= "30px" rowspan="2">No</th>
							<th rowspan="2">Kecamatan</th>
							<th rowspan="2">Desa</th>
							<th colspan="3" class="text-center">DPT</th>
							<th rowspan="2">Surat Suara</th>
							<th width= "130px" rowspan="2">Aksi</th>
						</tr>
						<tr>
							<th>Laki-laki</th>
							<th>Perempuan</th>
							<th>Jumlah</th>
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
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div><!-- /.tabel-responsive -->
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		&nbsp;
	</div><!-- /.box-footer-->
</div><!-- /.box -->

<script type="text/javascript">
	var table;
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
            var dptlTotal = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            var dptpTotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            var jmlTotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ); 
            
            var suratTotal = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );    

            // Update footer by showing the total with the reference of the column index 
            $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 3 ).footer() ).html(dptlTotal);
            $( api.column( 4 ).footer() ).html(dptpTotal);
            $( api.column( 5 ).footer() ).html(jmlTotal);
            $( api.column( 6 ).footer() ).html(suratTotal);
            $( api.column( 7 ).footer() ).html('');
        },
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			// Load data for the table's content from an Ajax source
			"ajax": {
			"url": "<?php echo site_url('penyelenggara/ajax_list')?>",
			"type": "POST",
			"data": function ( data ) {
				data.nama_kec = $('#nama_kec').val();
				data.nama_desa = $('#nama_desa').val();
			}
			},
			//Set column definition initialisation properties.
			"columnDefs": [
					{
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
					},
				],
			aLengthMenu: [
		        [10, 25, 50, 100, 200, -1],
		        [10, 25, 50, 100, 200, "All"]
		    ],
		    iDisplayLength: 10
		});

		
	var input1 = document.getElementById('dpt_l');
	var input2 = document.getElementById('dpt_p');
	var input3 = document.getElementById('dpt_jml');
	//var input4 = document.getElementById('suratsuara');

	input1.addEventListener('change', function() {
	input3.value = parseInt(input1.value)+parseInt(input2.value);
	//input4.value = parseInt(input3.value)+parseInt((input3.value*2.5)/100);
	});

	input2.addEventListener('change', function() {
	input3.value = parseInt(input1.value)+parseInt(input2.value);
	//input4.value = parseInt(input3.value)+parseInt((input3.value*2.5)/100);
	});

	// btn filter
	$('#btn-filter').click(function(){ //button filter event click
		table.ajax.reload();  //just reload table
	});

	$('#btn-reset').click(function(){ //button reset event click
		$('#form-filter')[0].reset();
		table.ajax.reload();  //just reload table
	});

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
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
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

	$("#peringatan").fadeTo(2000, 500).slideUp(500, function(){
		$("#peringatan").slideUp(500);
	});

	function myChangeFunction(input1) {
		var input2 = document.getElementById('dpt_p');
		input2.value = input1.value;
	}

	function add_desa()
	{
	    save_method = 'add';
	    $('#form')[0].reset(); // reset form on modals
	    $('.form-group').removeClass('has-error'); // clear error class
	    $('.help-block').empty(); // clear error string
	    $('#modal_form').modal('show'); // show bootstrap modal
	    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
	}

	function edit_desa(id)
	{
	    save_method = 'update';
	    $('#form')[0].reset(); // reset form on modals
	    $('.form-group').removeClass('has-error'); // clear error class
	    $('.help-block').empty(); // clear error string


	    //Ajax Load data from ajax
	    $.ajax({
	        url : "<?php echo site_url('penyelenggara/ajax_edit')?>/" + id,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data)
	        {
	        	
	            $('[name="id"]').val(data.id);
	            $('[name="kdkab"]').val(data.kdkab);
	            $('[name="kdkec"]').val(data.kdkec);
	            $('[name="kddesa"]').val(data.kddesa);
	            $('[name="dpt_l"]').val(data.dpt_l);
	            $('[name="dpt_p"]').val(data.dpt_p);
	            $('[name="dpt_jml"]').val(data.dpt_jml);
	            $('[name="suratsuara"]').val(data.suratsuara);
	            $('[name="ketua"]').val(data.ketua);
	            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
	            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error get data from ajax');
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
	        url = "<?php echo site_url('penyelenggara/ajax_add')?>";
	    } else {
	        url = "<?php echo site_url('penyelenggara/ajax_update')?>";
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
	            $('#btnSave').text('save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable 

	        }
	    });
	}

	function xdelete_desa(id)
	{
	    if(confirm('Menghapus data desa akan mengakibatkan daftar nama calon pada desaikut  tersebut terhapus. <br/>Are you sure delete this data? '))

	    {
	        // ajax delete data to database
	        $.ajax({
	            url : "<?php echo site_url('penyelenggara/ajax_delete')?>/"+id,
	            type: "POST",
	            dataType: "JSON",
	            success: function(data)
	            {
	                //if success reload ajax table
	                $('#modal_form').modal('hide');
	                reload_table();
	            },
	            error: function (jqXHR, textStatus, errorThrown)
	            {
	                alert('Error deleting data');
	            }
	        });

	    }
	}

	function delete_desa(id)
	{
		swal({
			title: "Anda yakin?",
			text: "Menghapus data desa akan mengakibatkan DAFTAR CALON pada desa tersebut ikut TERHAPUS.",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya, hapus!",
			cancelButtonText: "Tidak",
			closeOnConfirm: false,
			closeOnCancel: false
		},

		function(isConfirm) {

		if (isConfirm) {

			$.ajax({
				url : "<?php echo site_url('penyelenggara/ajax_delete')?>/"+id,
				type: "POST",
				dataType: "JSON",
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				},

				success: function(data) {
					$('#modal_form').modal('hide');
	                reload_table();
					swal("Terhapus!", "Data berhasil dihapus.", "success");
				}
			});
		} else {
			swal("Dibatalkan", "Data batal dihapus :)", "error");
		}

	});

	}
</script>

<!-- Bootstrap modal -->
<div class="modal" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="3210" name="kdkab"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kecamatan</label>
                            <div class="col-md-9">
                                <select id="kdkec" name="kdkec" class="form-control" >
						           <option>-- Pilih Kecamatan --</option>
						           <?php
						           foreach($kecamatan as $city){
						             echo "<option value='".$city['id_kec']."'>".$city['nama_kec']."</option>";
						           }
						           ?>
						        </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Desa</label>
                            <div class="col-md-9">
                                <select id="kddesa" name="kddesa" class="form-control">
						          <option>-- Pilih Desa --</option>
						          <?php
                                   foreach($dataDesanya as $desaku){
                                     echo "<option value='".$desaku->id_desa."'>".$desaku->nama_desa."</option>";
                                   }
                                   ?>
						        </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah DPT</label>
                            <div class="col-md-3">
                                <input name="dpt_l" id="dpt_l" class="form-control" type="number" step="1" min="0">
                                <span class="text-muted"><small>Laki-laki</small></span>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="dpt_p" id="dpt_p" class="form-control" type="number" step="1" min="0">
                                <span class="text-muted"><small>Perempuan</small></span>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="dpt_jml" id="dpt_jml" class="form-control" type="text" readonly="readonly">
                                <span class="text-muted"><small>Jumlah</small></span>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah Surat Suara</label>
                            <div class="col-md-3">
                                <input name="suratsuara" id="suratsuara" placeholder="Surat Suara" class="form-control" type="number" step="1" min="0">
                                
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Ketua Panitia</label>
                            <div class="col-md-9">
                                <input name="ketua" placeholder="Ketua Panitia Pilkades" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->