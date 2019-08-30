  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 style="display:block; text-align:center;">Tambah Data Hasil Audit</h3>                        
  </div> <!-- modal header -->
  <div class="modal-body form">

  <div class="form-msg"></div>
  <form action="#" id="form" class="form-horizontal">
    <div class="form-body">
      <div class="form-group">
        <label for="varchar" class="control-label col-md-2" >Tahun PKPT :</label>
        <div class="col-md-2">
          <select class="form-control" name="tahun_pkpt" id="tahun_pkpt" placeholder="Tahun PKPT">
            <option value=""></option>
            <option <?=(date("Y")=='2015')?'selected="selected"':''; ?> value="2015">2015</option>
              <option <?=(date("Y")=='2016')?'selected="selected"':''; ?> value="2016">2016</option>
              <option <?=(date("Y")=='2017')?'selected="selected"':''; ?> value="2017">2017</option>
              <option <?=(date("Y")=='2018')?'selected="selected"':''; ?> value="2018">2018</option>
              <option <?=(date("Y")=='2019')?'selected="selected"':''; ?> value="2019">2019</option>
              <option <?=(date("Y")=='2020')?'selected="selected"':''; ?> value="2020">2020</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="date" class="col-md-2 control-label" >Tanggal Audit</label>
        <div class="col-md-3">
          <input type="date" class="form-control" name="tgl_audit" id="" placeholder="Tanggal Audit" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>"/>
        </div>
      </div>
      <div class="form-group">
        <label for="varchar" class="col-md-2 control-label" >Auditi </label>
        <div class="col-md-9">
          <select class="form-control select2" name="id_auditi" id="id_auditi" placeholder="Auditi" style="width:100%" >
            <option value=""></option>
            
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="varchar" class="col-md-2 control-label" >Jenis Audit </label>
        <div class="col-md-9">
          <select class="form-control select2" name="jenis_audit" id="jenis_audit" placeholder="Jenis Audit" style="width:100%" >
            <option value=""></option>
            <option value="Reguler (Desa)" >Reguler (Desa)</option>
            <option value="Kecamatan/OPD" >Kecamatan/OPD</option>
            <option value="Audit Investigatif" >Audit Investigatif</option>
            <option value="Audit Kinerja" >Audit Kinerja</option>
            <option value="Evaluasi LAKIP" >Evaluasi LAKIP</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="keterangan" class="col-md-2 control-label" >Keterangan </label>
        <div class="col-md-9">
          <textarea class="form-control textarea" name="keterangan" id="editor1"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="varchar" class="col-md-2 control-label" >Lampiran </label>
        <div class="col-md-9">
          <input type="file" class="form-control" name="namafile1" id="namafile1" placeholder="Namafile"/>
        </div>
      </div>
      <div class="form-group">
        <label for="varchar" class="col-md-2 control-label" > </label>
        <div class="col-md-9">
          <input type="file" class="form-control" name="namafile2" id="namafile2" placeholder="Namafile" />
        </div>
      </div>
      <div class="form-group">
        <label for="varchar" class="col-md-2 control-label" > </label>
        <div class="col-md-9">
          <input type="file" class="form-control" name="namafile3" id="namafile3" placeholder="Namafile" />
        </div>
      </div>

      <input type="hidden" name="id" /> 
      
    </div> <!-- form body -->
  </form>
</div> <!-- modal body -->
<div class="modal-footer">
  <div class="form-group">
      <div>
          <button type="submit" class="form-control btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
      </div>
    </div>
</div>

<script type="text/javascript">
$(function () {
    $(".select2").select2();

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
});
</script>