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
                    echo '<h4 class="text-muted"><b>Daftar Calon Kepala Desa Tahun '.$this->session->userdata('thn_data').'</b></h4>';
                    ?>
                    </div>
                    <div class="col-md-2 col-xs-12">
                    <?php

                    if ($this->session->userdata('id_role') == 3) {
                        if (getStatusTransaksi('Pengelolaan Data Calon Kepala Desa')) {
                         echo '<button class="btn btn-success btn-block" onclick="add_person()" ><i class="glyphicon glyphicon-plus" ></i> Tambah</button>';
                        } else {
                            echo '<button class="btn btn-success btn-block" onclick="add_person()" disabled><i class="glyphicon glyphicon-plus" ></i> Tambah</button>';
                        }
                    } else {
                        echo '<button class="btn btn-success btn-block" onclick="add_person()"><i class="glyphicon glyphicon-plus" ></i> Tambah</button>';
                    }
                    ?>
                    </div>
                    <div class="col-md-2 col-xs-12">
                <button class="btn btn-default btn-block" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>
            <div class="col-lg-2 col-xs-12">
                <a href="<?php echo base_url('calon/export'); ?>" class="btn btn-default  btn-block"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                
                </div>
            </div>
        </div>
    	<div class="table-responsive">
            <div class="col-md-12">
            <table class="table table-hover table-condensed" id="table">
        		<thead>
                    <tr>
                        <th>No Urut</th>
            			<th>Nama</th>
            			<th>TTL</th>
            	        <th>Agama</th>
                        <th>L/P</th>
            			<th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Desa</th>
                        <th style="width:100px;">Photo</th>
            			<th style="width:80px;">Aksi</th>
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


<!-- Bootstrap modal -->
<div class="modal" id="modal_form" role="dialog" tabindex="-1" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="<?php echo $this->session->userdata('thn_data'); ?>" name="thn_pemilihan"/> 

                    <div class="form-body">
                        <!-- Desa -->
                        <div class="form-group">
                            <label class="control-label col-md-3">Kecamatan/Desa</label>
                            <div class="col-md-4">
                                <select id="kdkec" name="kdkec" class="form-control" style="width: 100%" >
                                   <option>-- Pilih Kecamatan --</option>
                                   <?php
                                   foreach($kecamatan as $city){
                                     echo "<option value='".$city['id_kec']."'>".$city['nama_kec']."</option>";
                                   }
                                   ?>
                                </select>
                                <span class="help-block"></span>

                            </div>
                            <div class="col-sm-5">
                                <select id="kddesa" name="kddesa" class="form-control" style="width: 100%">
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
                            <label class="control-label col-md-3">No urut Calon</label>
                            <div class="col-md-2">
                                <select name="nourut" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Calon Kepala Desa <small class="text-muted">(lengkap dengan gelar)</small></label>
                            <div class="col-md-9">

                                <input name="nama" placeholder="Nama Lengkap" class="form-control" type="text">
                                <span class="help-block"></span>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">N.I.K</label>
                            <div class="col-md-4">
                                <input name="nik" placeholder="NIK" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tempat/Tanggal Lahir</label>
                            <div class="col-md-6">
                                <input name="tmp_lahir" placeholder="Tempat Lahir" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="tgl_lahir" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Kelamin</label>
                            <div class="col-md-3">
                                <select name="kelamin" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Agama</label>
                            <div class="col-md-3">
                                <select name="agama" class="form-control" style="width: 100%;">
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katholik">Katholik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Penghayat Kepercayaan">Penghayat Kepercayaan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat1" rows = "2" placeholder="Alamat" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pendidikan Terakhir</label>
                            <div class="col-md-6">
                                <select name="id_pendidikan" class="form-control" style="width: 100%;">
                                    <?php foreach($dataPendidikan as $dtDidik){
                                        ?>
                                        <option value="<?php echo $dtDidik->id_pendidikan; ?>"><?php echo $dtDidik->nama_pendidikan; ?></option>
                                    <?php
                                    } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pekerjaan</label>
                            <div class="col-md-6">
                                <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" style="width: 100%;">
                                        <?php foreach($dataPekerjaan as $dpk){
                                        ?>
                                        <option value="<?php echo $dpk->id_pekerjaan; ?>"><?php echo $dpk->nama_pekerjaan; ?></option>
                                    <?php
                                    } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pengalaman Organisasi</label>
                            <div class="col-md-9">
                                <textarea name="organisasi" placeholder="Pengalaman Organisai" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan Tambahan</label>
                            <div class="col-md-9">
                                <textarea name="keterangan" placeholder="Keterangan tambahan" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="photo-preview">
                            <label class="control-label col-md-3">Photo</label>
                            <div class="col-md-4">
                                (No photo)
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo">Upload Photo</label> 
                            <div class="col-md-9">
                                <input name="photo" type="file" accept="image/png, image/gif, image/jpg, image/bmp">
                                <span class="help-block"></span>
                                <small><em>Berkas photo harus berekstensi *.JPG/*.JPEG/*.PNG/*.GIF/*.BMP dengan ukuran maksimal 2 MB (2048 KByte)</em></small>
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


<!-- Bootstrap modal -->
<div class="modal" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Lihat Detail Calon</h3>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="numberCircle" id="nourut">
                            -
                            </div>
                            <div class="calon-img-frame">
                                <div id="photo-calon">
                                    <div>(No photo)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 detailCalon">
                        <legend id="mydaerah">Daerah Pemilihan </legend>
                        <div class="row">
                            <div class="col-sm-4">Nama Calon</div>
                            <div class="col-sm-8 namaCalon" id="mynama">nama</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">N.I.K</div>
                            <div class="col-sm-8 detailCalonText" id="mynik">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">TTL</div>
                            <div class="col-sm-8 detailCalonText" id="myttl">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Jenis Kelamin</div>
                            <div class="col-sm-8 detailCalonText" id="mykelamin">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Agama</div>
                            <div class="col-sm-8 detailCalonText" id="myagama">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Alamat</div>
                            <div class="col-sm-8 detailCalonText" id="myalamat">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Pendidikan Terakhir</div>
                            <div class="col-sm-8 detailCalonText" id="mypendidikan">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Pekerjaan</div>
                            <div class="col-sm-8 detailCalonText" id="mypekerjaan">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Pengalaman Organisasi</div>
                            <div class="col-sm-8 detailCalonText" id="myorganisasi">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Keterangan Tambahan</div>
                            <div class="col-sm-8 detailCalonText" id="myketerangan">-</div>
                        </div>
                    </div>
                    <div class="box-body">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('calon/ajax_list')?>",
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
        aLengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 10
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

    $('textarea').keypress(function(event) {
  if (event.which == 13) {
    event.preventDefault();
      var s = $(this).val();
      $(this).val(s+"\n");
  }
});
    $("select").change(function(){
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

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Calon'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal

    $('#label-photo').text('Upload Photo'); // label photo upload
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('calon/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="nourut"]').val(data.nourut);
            $('[name="nama"]').val(data.nama);
            $('[name="nik"]').val(data.nik);
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
            
            //$('[name="id_kab"]').val(data.kdkab);
            $('[name="kdkec"]').val(data.kdkec);
            $('[name="kddesa"]').val(data.kddesa);
            $('[name="thn_pemilihan"]').val(data.thn_pemilihan);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Calon'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.photo)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/medium/'+data.photo+'" class="img-responsive">'); // show photo
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

function view_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('calon/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var date = new Date(data.tgl_lahir);
            var day = date.getDate(data.tgl_lahir);
            var month = date.getMonth(data.tgl_lahir);
            var yy = date.getYear();
            var year = (yy < 1000) ? yy + 1900 : yy;

            $('[name="id"]').val(data.id);
            
            $('#nourut').text(data.nourut);
            $('#mynama').text(data.nama.toUpperCase());
            $('#mynik').text(data.nik);
            $('#myttl').text(data.tmp_lahir+', '+ day + ' ' + months[month] + ' ' + year);
            if((data.kelamin) == 'L')
            {
                $('#mykelamin').text('Laki-laki');
            }
            else
            {
                $('#mykelamin').text('Perempuan');
            }
            $('#myagama').text(data.agama);
            $("#myalamat").html(nl2br(data.alamat1));
            $('#mypendidikan').text(data.nama_pendidikan);
            $('#mypekerjaan').text(data.nama_pekerjaan);
            $("#myorganisasi").html(nl2br(data.organisasi));
            $("#myketerangan").html(nl2br(data.keterangan));
            
            $('#mydaerah').text(data.nama_desa+', '+data.nama_kec);

            $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detail Calon'); // Set title to Bootstrap modal title

            $('#photo-calon').show(); // show photo preview modal

            if(data.photo)
            {
                $('#photo-calon div').html('<img src="'+base_url+'upload/medium/'+data.photo+'" class="img-responsive calon-img">'); // show photo
            }
            else
            {
                $('#photo-calon div').html('<img src="'+base_url+'assets/img/no-photo.jpg" class="img-responsive calon-img">'); // show no-photo
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
        url = "<?php echo site_url('calon/ajax_add')?>";
    } else {
        url = "<?php echo site_url('calon/ajax_update')?>";
    }

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
            //alert('Error adding / update data');
			alert("Error requesting " + errorThrown.url + ": " + jqXHR.status + " " + jqXHR.statusText);
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function xdelete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('calon/ajax_delete')?>/"+id,
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

function delete_person(id)
    {
        swal({
            title: "Anda yakin?",
            text: "Data yang sudah terhapus tidak akan bisa dikembalikan.",
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
                url : "<?php echo site_url('calon/ajax_delete')?>/"+id,
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