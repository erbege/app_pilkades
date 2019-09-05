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
                <form class="form-horizontal" action="#" method="POST">
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
        if ($this->session->userdata('id_role') == 3) {
            echo "<h3 class='text-center'>Kecamatan ".$this->session->userdata('nama_kec')."</h3>";
        } else {
            if($pst != '') {
                echo "<h3 class='text-center'>Kecamatan ".$pst."</h3>";
            }
        }
        ?>
    	<div class="table-responsive">
            <div class="col-md-12">
    		<!-- <table class="table table-bordered table-hovered table-condensed" id="table_id">  -->
            <table class="table-hover table-condensed" border="1px">
        		<thead>
                    <tr>
                        <th class="text-center" rowspan="3">No</th>
                        <th class="text-center" rowspan="3">Kecamatan</th>
                        <th class="text-center" rowspan="3">Desa</th>
                        <th class="text-center" rowspan="2" colspan="3">DPT</th>
                        <th class="text-center" colspan="4">Surat Suara</th>
            			<th class="text-center" colspan="12">Perolehan Suara</th>
                        <th class="text-center" rowspan="3">Partisipasi (%)</th>
            		</tr>
                    <tr>
                        <th class="text-center" rowspan="2">Sah</th>
                        <th class="text-center" rowspan="2">Tidak Sah</th>
                        <th class="text-center" rowspan="2">Tdk Digunakan</th>
                        <th class="text-center" rowspan="2">Jumlah</th>
                        <th class="text-center" colspan="2">Calon No Urut 1</th>
                        <th class="text-center" colspan="2">Calon No Urut 2</th>
                        <th class="text-center" colspan="2">Calon No Urut 3</th>
                        <th class="text-center" colspan="2">Calon No Urut 4</th>
                        <th class="text-center" colspan="2">Calon No Urut 5</th>
                        <th class="text-center" colspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th class="text-center">L</th>
                        <th class="text-center">P</th>
                        <th class="text-center">Jml</th>
                        <th class="text-center">Angka</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Angka</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Angka</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Angka</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Angka</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Angka</th>
                        <th class="text-center">%</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
                        <th class="text-center">7</th>
                        <th class="text-center">8</th>
                        <th class="text-center">9</th>
                        <th class="text-center">10</th>
                        <th class="text-center">11</th>
                        <th class="text-center">12</th>
                        <th class="text-center">13</th>
                        <th class="text-center">14</th>
                        <th class="text-center">15</th>
                        <th class="text-center">16</th>
                        <th class="text-center">17</th>
                        <th class="text-center">18</th>
                        <th class="text-center">19</th>
                        <th class="text-center">20</th>
                        <th class="text-center">21</th>
                        <th class="text-center">22</th>
                        <th class="text-center">23</th>
                    </tr>
        		</thead>
        		<tbody>
                    <?php
                    $no = 0;
                    $totalDPTL = 0;
                    $totalDPTP = 0;
                    $totalDPTJml = 0;
                    $totalSSS = 0;
                    $totalSSTS = 0;
                    $totalSSTD = 0;
                    $totalSSJml = 0;
                    $totalCalon1 = 0;
                    $totalCalon2 = 0;
                    $totalCalon3 = 0;
                    $totalCalon4 = 0;
                    $totalCalon5 = 0;
                    $totalCalonJml = 0;

                    foreach ($datalaporan as $dtlap) {
                        $no++;
                        echo '<tr>';
                        echo "<td align='center'>".$no."</td>";
                        echo "<td>".$dtlap->nama_kec."</td>";
                        echo "<td>".$dtlap->nama_desa."</td>";
                        echo "<td align='right'>".number_format($dtlap->dpt_l)."</td>";
                        echo "<td align='right'>".number_format($dtlap->dpt_p)."</td>";
                        $jml_dpt = $dtlap->dpt_l+$dtlap->dpt_p;
                        echo "<td align='right'>".number_format($jml_dpt)."</td>";
                        echo "<td align='right'>".number_format($dtlap->sssah)."</td>";
                        echo "<td align='right'>".number_format($dtlap->sstdksah)."</td>";
                        echo "<td align='right'>".number_format($dtlap->sstidakterpakai)."</td>";
                        $jml_ss = $dtlap->sssah+$dtlap->sstdksah+$dtlap->ssrusak+$dtlap->sstidakterpakai;
                        echo "<td align='right'>".number_format($jml_ss)."</td>";
                        
                        //persen1
                        if (($dtlap->A > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen1 = $dtlap->A / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen1 = 0;
                        }
                        if (($dtlap->A > $dtlap->B) && ($dtlap->A > $dtlap->C) && ($dtlap->A > $dtlap->D) && ($dtlap->A > $dtlap->E)) {
                            echo "<td class='bg-gray' align='right'>".number_format($dtlap->A)."</td>";
                            echo "<td class='bg-gray' align='right'>".number_format($persen1,2)."</td>";
                        } else {
                            echo "<td align='right'>".number_format($dtlap->A)."</td>";
                            echo "<td align='right'>".number_format($persen1,2)."</td>";
                        }

                        //persen2
                        if (($dtlap->B > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen2 = $dtlap->B / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen2 = 0;
                        }
                        if (($dtlap->B > $dtlap->A) && ($dtlap->B > $dtlap->C) && ($dtlap->B > $dtlap->D) && ($dtlap->B > $dtlap->E)) {
                            echo "<td class='bg-gray' align='right'>".number_format($dtlap->B)."</td>";
                            echo "<td class='bg-gray' align='right'>".number_format($persen2,2)."</td>";
                        } else {
                            echo "<td align='right'>".number_format($dtlap->B)."</td>";
                            echo "<td align='right'>".number_format($persen2,2)."</td>";
                        }

                        //persen3
                        if (($dtlap->C > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen3 = $dtlap->C / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen3 = 0;
                        }
                        if (($dtlap->C > $dtlap->A) && ($dtlap->C > $dtlap->B) && ($dtlap->C > $dtlap->D) && ($dtlap->C > $dtlap->E)) {
                            echo "<td class='bg-gray' align='right'>".number_format($dtlap->C)."</td>";
                            echo "<td class='bg-gray' align='right'>".number_format($persen3,2)."</td>";
                        } else {
                            echo "<td align='right'>".number_format($dtlap->C)."</td>";
                            echo "<td align='right'>".number_format($persen3,2)."</td>";
                        }

                        //persen4
                        if (($dtlap->D > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen4 = $dtlap->D / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen4 = 0;
                        }
                        if (($dtlap->D > $dtlap->A) && ($dtlap->D > $dtlap->B) && ($dtlap->D > $dtlap->C) && ($dtlap->D > $dtlap->E)) {
                            echo "<td class='bg-gray' align='right'>".number_format($dtlap->D)."</td>";
                            echo "<td class='bg-gray' align='right'>".number_format($persen4,2)."</td>";
                        } else {
                            echo "<td align='right'>".number_format($dtlap->D)."</td>";
                            echo "<td align='right'>".number_format($persen4,2)."</td>";
                        }

                        //persen5
                        if (($dtlap->E > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen5 = $dtlap->E / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen5 = 0;
                        }
                        if (($dtlap->E > $dtlap->A) && ($dtlap->E > $dtlap->B) && ($dtlap->E > $dtlap->C) && ($dtlap->E > $dtlap->D)) {
                            echo "<td class='bg-gray' align='right'>".number_format($dtlap->E)."</td>";
                            echo "<td class='bg-gray' align='right'>".number_format($persen5,2)."</td>";
                        } else {
                            echo "<td align='right'>".number_format($dtlap->E)."</td>";
                            echo "<td align='right'>".number_format($persen5,2)."</td>";
                        }

                        $jml_hasil = $dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E;
                        $jml_persen = $persen1+$persen2+$persen3+$persen4+$persen5;
                        echo "<td align='right'>".number_format($jml_hasil)."</td>";
                        echo "<td align='right'>".number_format($jml_persen,2)."</td>";

                        //angka partisipasi
                        if ((($dtlap->sssah+$dtlap->sstdksah) > 0) && ($jml_dpt > 0)){
                            $partisipasi = ($dtlap->sssah+$dtlap->sstdksah) / ($jml_dpt) * 100;
                        } else {
                            $partisipasi = 0;
                        } 
                        echo "<td align='right'><strong>".number_format($partisipasi,2)."</strong></td>";
                        echo '<tr>';

                        $totalDPTL      = $totalDPTL+$dtlap->dpt_l;
                        $totalDPTP      = $totalDPTP+$dtlap->dpt_p;
                        $totalDPTJml    = $totalDPTJml+$dtlap->dpt_jml;
                        $totalSSS       = $totalSSS+$dtlap->sssah;
                        $totalSSTS      = $totalSSTS+$dtlap->sstdksah;
                        $totalSSTD      = $totalSSTD+$dtlap->sstidakterpakai;
                        $totalSSJml     = $totalSSJml+$jml_ss;
                        $totalCalon1    = $totalCalon1+$dtlap->A;
                        $totalCalon2    = $totalCalon2+$dtlap->B;
                        $totalCalon3    = $totalCalon3+$dtlap->C;
                        $totalCalon4    = $totalCalon4+$dtlap->D;
                        $totalCalon5    = $totalCalon5+$dtlap->E;
                        $totalCalonJml  = $totalCalonJml+$jml_hasil;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" colspan="3"></th>
                        <th class="text-right"><?php echo number_format($totalDPTL); ?></th>
                        <th class="text-right"><?php echo number_format($totalDPTP); ?></th>
                        <th class="text-right"><?php echo number_format($totalDPTJml); ?></th>
                        <th class="text-right"><?php echo number_format($totalSSS); ?></th>
                        <th class="text-right"><?php echo number_format($totalSSTS); ?></th>
                        <th class="text-right"><?php echo number_format($totalSSTD); ?></th>
                        <th class="text-right"><?php echo number_format($totalSSJml); ?></th>

                        <th class="text-right"><?php echo number_format($totalCalon1); ?></th>
                        <th class="text-center"></th>
                        <th class="text-right"><?php echo number_format($totalCalon2); ?></th>
                        <th class="text-center"></th>
                        <th class="text-right"><?php echo number_format($totalCalon3); ?></th>
                        <th class="text-center"></th>
                        <th class="text-right"><?php echo number_format($totalCalon4); ?></th>
                        <th class="text-center"></th>
                        <th class="text-right"><?php echo number_format($totalCalon5); ?></th>
                        <th class="text-center"></th>
                        <th class="text-right"><?php echo number_format($totalCalonJml); ?></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </tfoot>
	        </table>
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
