<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<?php
    foreach($rekapsatu as $data){
        $merk[] = $data->nama_desa;
        if (($data->B > 0 ) || ($data->A+$data->B+$data->C+$data->D+$data->E) ) {
            $hasil1[] = (float) ($data->A / ($data->A+$data->B+$data->C+$data->D+$data->E) * 100);
        } else {
            $hasil1[] = 0;
        }
        if (($data->B > 0 ) || ($data->A+$data->B+$data->C+$data->D+$data->E) ) {
            $hasil2[] = (float) ($data->B / ($data->A+$data->B+$data->C+$data->D+$data->E) * 100);
        } else {
            $hasil2[] = 0;
        }
        if (($data->C > 0 ) || ($data->A+$data->B+$data->C+$data->D+$data->E) ) {
            $hasil3[] = (float) ($data->C / ($data->A+$data->B+$data->C+$data->D+$data->E) * 100);
        } else {
            $hasil3[] = 0;
        }
        if (($data->D > 0 ) || ($data->A+$data->B+$data->C+$data->D+$data->E) ) {
            $hasil4[] = (float) ($data->D / ($data->A+$data->B+$data->C+$data->D+$data->E) * 100);
        } else {
            $hasil4[] = 0;
        }
        if (($data->E > 0 ) || ($data->A+$data->B+$data->C+$data->D+$data->E) ) {
            $hasil5[] = (float) ($data->E / ($data->A+$data->B+$data->C+$data->D+$data->E) * 100);
        } else {
            $hasil5[] = 0;
        }
        // $hasil2[] = (float) $data->B;
        // $hasil3[] = (float) $data->C;
        // $hasil4[] = (float) $data->D;
        // $hasil5[] = (float) $data->E;
        // if ($data->SUARA > 0) {
        //     $stok[] = (float) ($data->SUARA /($data->DPTL+$data->DPTP))*100;
        // } else { $stok[] = 0;}
    }
?>
<!-- Default box -->
<div class="box">

    <div class="box-body">
        <div class="panel panel-primary">
            <div class="panel-body">
                <span class="pull-right">
                <button class="btn btn-default" onclick="document.location.reload(true);"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                </span>
                <?php 
                echo '<h4 class="text-muted"><b>Rekapitulasi Hasil Pemilihan Kepala Desa Tahun '.$this->session->userdata('thn_data').'</b></h4>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>Grafik Persentase Perolehan Suara</h3>
                <span>Per Desa Per Calon</span>
                <div>
                    <canvas id="canvassatu" ></canvas>
                </div>
            </div>
    
    	</div>
        <div class="row">
            <div class="table-responsive">
                <div class="col-md-12">
                <h3>Tabel Perolehan Suara</h3>
                <span>Per Desa Per Calon</span>
                    <legend>Kecamatan <?php //echo $nama_kec; ?></legend>
                    <center>
                    <table class="table-condensed" border="1px">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center bg-blue" style="width: 250px">Desa</th>
                                <th colspan="5" class="text-center bg-blue" style="width: 150px">Angka</th>
                                <th colspan="5" class="text-center bg-blue" style="width: 150px">Persentase</th>
                            </tr>
                            <tr>
                                <th class="text-center bg-blue" style="width: 150px">Calon 1</th>
                                <th class="text-center bg-blue" style="width: 150px">Calon 2</th>
                                <th class="text-center bg-blue" style="width: 100px">Calon 3</th>
                                <th class="text-center bg-blue" style="width: 150px">Calon 4</th>
                                <th class="text-center bg-blue" style="width: 150px">Calon 5</th>

                                <th class="text-center bg-blue" style="width: 150px">Calon 1</th>
                                <th class="text-center bg-blue" style="width: 150px">Calon 2</th>
                                <th class="text-center bg-blue" style="width: 100px">Calon 3</th>
                                <th class="text-center bg-blue" style="width: 150px">Calon 4</th>
                                <th class="text-center bg-blue" style="width: 150px">Calon 5</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rekapsatu as $satu) {
                            echo "<tr>";
                            echo "<td><a href='".base_url()."rekap/detaildesa/".$satu->kddesa."'>".$satu->nama_desa."</a></td>";
                            echo "<td class='text-right'>".number_format($satu->A)."</td>";
                            echo "<td class='text-right'>".number_format($satu->B)."</td>";
                            echo "<td class='text-right'>".number_format($satu->C)."</td>";
                            echo "<td class='text-right'>".number_format($satu->D)."</td>";
                            echo "<td class='text-right'>".number_format($satu->E)."</td>";

                            //Persentase
                            if ($satu->A > 0) {
                                echo "<td class='text-right'>".number_format($satu->A /($satu->A+$satu->B+$satu->C+$satu->D+$satu->E)*100,2 )."</td>";    
                            } else {
                                echo "<td class='text-right'>".number_format(0)."</td>";
                            }
                            if ($satu->B > 0) {
                                echo "<td class='text-right'>".number_format($satu->B /($satu->A+$satu->B+$satu->C+$satu->D+$satu->E)*100,2 )."</td>";    
                            } else {
                                echo "<td class='text-right'>".number_format(0)."</td>";
                            }
                            if ($satu->C > 0) {
                                echo "<td class='text-right'>".number_format($satu->C /($satu->A+$satu->B+$satu->C+$satu->D+$satu->E)*100,2 )."</td>";    
                            } else {
                                echo "<td class='text-right'>".number_format(0)."</td>";
                            }
                            if ($satu->D > 0) {
                                echo "<td class='text-right'>".number_format($satu->D /($satu->A+$satu->B+$satu->C+$satu->D+$satu->E)*100,2 )."</td>";    
                            } else {
                                echo "<td class='text-right'>".number_format(0)."</td>";
                            }
                            if ($satu->E > 0) {
                                echo "<td class='text-right'>".number_format($satu->E /($satu->A+$satu->B+$satu->C+$satu->D+$satu->E)*100,2 )."</td>";    
                            } else {
                                echo "<td class='text-right'>".number_format(0)."</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </center>
                </div>
            </div><!-- /.table-responsive -->
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div><!-- /.box-footer-->
</div><!-- /.box -->


<!--Load chart js-->
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/Chart.min.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/utils.js'?>"></script>
<script>
    var color = Chart.helpers.color;
    var ctx = document.getElementById("canvassatu").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($merk);?>,
            datasets: [{
                label: 'Calon No 1',
                data: <?php echo json_encode($hasil1);?>,
                    backgroundColor: color(window.chartColors.red).alpha(0.8).rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1
                },
                {
                    label: 'Calon No 2',
                    data: <?php echo json_encode($hasil2);?>,
                    backgroundColor: color(window.chartColors.orange).alpha(0.8).rgbString(),
                    borderColor: window.chartColors.orange,
                    borderWidth: 1
                },
                {
                    label: 'Calon No 3',
                    data: <?php echo json_encode($hasil3);?>,
                    backgroundColor: color(window.chartColors.purple).alpha(0.8).rgbString(),
                    borderColor: window.chartColors.purple,
                    borderWidth: 1
                },
                {
                    label: 'Calon No 4',
                    data: <?php echo json_encode($hasil4);?>,
                    backgroundColor: color(window.chartColors.blue).alpha(0.8).rgbString(),
                    borderColor: window.chartColors.blue,
                    borderWidth: 1
                },
                {
                    label: 'Calon No 5',
                    data: <?php echo json_encode($hasil5);?>,
                    backgroundColor: color(window.chartColors.grey).alpha(1.0).rgbString(),
                    borderColor: window.chartColors.grey,
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            

        }
    });

</script>