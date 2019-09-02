<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<?php

    /*echo '<pre>';
    print_r($this->session->userdata());
    echo '</pre>';*/

?>
<?php
    foreach($rekapdesa as $data){
        $merk[] = $data->nama;
        //$stok[] = (float) $data->SUARA;
        if (($data->s_hasil > 0) && ($data->jml_pemilih > 0)) {
            $stok[] = (float) ($data->s_hasil /($data->jml_pemilih))*100;
        } else { $stok[] = 0;}
        if ($data->s_hasil > 0) {
            //$naon[] = (float) ($data->s_hasil /($data->totalsuaramasuk))*100;
            $naon[] = (float) $data->s_hasil;
        } else { $naon[] = 0;}
    }
?>
<!-- Default box -->
<div class="box">

    <div class="box-body">
        <div class="panel panel-primary no-print">
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
            <div class="col-md-6 text-center">
                <h3>Grafik Perolehan Suara</h3>
                <span>Persentase Perolehan Suara Menurut Jumlah Pemilih</span>
                <div>
                    <canvas id="canvasdesa" ></canvas>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <h3>Grafik Perolehan Suara</h3>
                <span>Jumlah Perolehan Suara Menurut Total Suara Masuk</span>
                <div>
                    <canvas id="canvasdesa2" ></canvas>
                </div>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="table-responsive">
            <legend>Desa <?php echo $nama_desa; ?></legend>
            <center>
            <table class="table-condensed" border="1px">
                <tr>
                    <th class="text-center bg-blue" style="width: 50px">No Urut</th>
                    <th class="text-center bg-blue" style="width: 250px">Nama Calon</th>
                    <th class="text-center bg-blue" style="width: 80px">Perolehan Suara</th>
                    <th class="text-center bg-blue" style="width: 80px">Jml Suara Masuk</th>
                    <th class="text-center bg-blue" style="width: 80px">Jml Pemilih</th>
                    <th class="text-center bg-blue" style="width: 80px">Persentase dari jumlah pemilih (%)</th>
                    <th class="text-center bg-blue" style="width: 80px">Persentase dari suara masuk (%)</th>
                </tr>
                <?php
                foreach ($rekapdesa as $desa) {
                    echo "<tr>";
                    echo "<td class='text-center'>".$desa->nourut."</td>";
                    echo "<td><b>".$desa->nama."</b></td>";
                    echo "<td class='text-right'>".number_format($desa->s_hasil)."</td>";
                    echo "<td class='text-right'>".number_format($desa->totalsuaramasuk)."</td>";
                    echo "<td class='text-right'>".number_format($desa->jml_pemilih)."</td>";
                    if (($desa->s_hasil > 0) && ($desa->jml_pemilih > 0)){
                        echo "<td class='text-right'>".number_format(($desa->s_hasil /($desa->jml_pemilih))*100,2)."</td>";
                    } else { echo "<td class='text-right'>".number_format(0,2)."</td>";}
                    if (($desa->s_hasil > 0) && ($desa->totalsuaramasuk > 0)) {
                        echo "<td class='text-right'>".number_format(($desa->s_hasil /($desa->totalsuaramasuk))*100,2)."</td>";
                    } else { echo "<td class='text-right'>".number_format(0,2)."</td>";}
                    echo "</tr>";
                }
                ?>
            </table>
        </center>
        </div>
    	
    </div><!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div><!-- /.box-footer-->
</div><!-- /.box -->


<!--Load chart js-->
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/Chart.min.js'?>"></script>
<script>

    var ctx = document.getElementById("canvasdesa").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($merk);?>,
            datasets: [{
                label: '% Suara Masuk',
                data: <?php echo json_encode($stok);?>,
                backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
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

    var cty = document.getElementById("canvasdesa2").getContext('2d');
    var myChart = new Chart(cty, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($merk);?>,
            datasets: [{
                label: '% Suara Masuk',
                data: <?php echo json_encode($naon);?>,
                backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    //var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);
     

    
</script>

