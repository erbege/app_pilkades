<!-- Default box -->
<div class="box">
    <div class="box-body">
        <?php
            if (($this->session->userdata('id_role') == 1) || ($this->session->userdata('id_role') == 2)){
        ?>
        <div class="panel panel-default no-print">
            <div class="panel-heading">
                <h3 class="panel-title">Filter</h3>
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down" data-toggle="tooltip" title="Collapse"></i></span>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="nama_kec" class="col-sm-2 control-label">Kecamatan</label>
                        <div class="col-sm-4">
                            <?php echo $form_kec; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" id="btn-filter" class="btn btn-primary">Tampilkan</button>
                    </div>
                    </div>
                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
        <?php
            }
        ?>
        <?php
        echo "<h3 class='text-center'>Daftar Calon Terpilih</h3>";
        if ($this->session->userdata('id_role') == 3) {
            echo "<h4 class='text-center'>Kecamatan ".$this->session->userdata('nama_kec')."</h4><br />";
        } else {
            if($pst != '') {
                echo "<h4 class='text-center'>Kecamatan ".$pst."</h4><br />";
            }
        }
        ?>
    	<div class="table-responsive">
            <div class="col-md-12">
            <center>
    		<!-- <table class="table table-bordered table-hovered table-condensed" id="table_id">  -->
            <table class="table-hover table-condensed" border="1px">
        		<thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Desa</th>
                        <th class="text-center">Nama Calon</th>
                        <th class="text-center">No. Urut</th>
            			<th class="text-center">Perolehan Suara</th>
            		</tr>
        		</thead>
        		<tbody>
                    <?php
                    $no = 0;
                    $totalSuara = 0;

                    foreach ($dataterpilih as $dtlap) {
                        $no++;
                        echo '<tr>';
                        echo "<td align='center'>".$no."</td>";
                        echo "<td>".$dtlap->nama_kec."</td>";
                        echo "<td>".$dtlap->nama_desa."</td>";
                        echo "<td>".$dtlap->nama."</td>";
                        echo "<td align='center'>".$dtlap->nourut."</td>";
                        echo "<td align='right'>".number_format($dtlap->perolehan)."</td>";
                        
                        echo '<tr>';

                        $totalSuara      = $totalSuara+$dtlap->perolehan;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" colspan="5"></th>
                        <th class="text-right"><?php echo number_format($totalSuara); ?></th>
                    </tr>
                </tfoot>
	        </table>
            </center>
        </div><!-- /.col-md-12 -->
    	</div><!-- /.table-responsive -->
    </div><!-- /.box-body -->
    <div class="box-footer">
        <a href="<?php echo base_url('laporan/export'); ?>" class="btn btn-primary" target="_blank">Ekspor XLS</a>
        <a href="<?php echo base_url('laporan/cetakPDF'); ?>" class="btn btn-primary" target="_blank">Cetak PDF</a>
    </div><!-- /.box-footer-->
</div><!-- /.box -->




<script type="text/javascript">
$(document).ready(function() {

    // panel collapse
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

</script>
