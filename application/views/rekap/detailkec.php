<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>

<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<?php
    foreach($rekapkec as $data){
        $merk[] = $data->nama_desa;
        //$stok[] = (float) $data->SUARA;
        if ($data->SUARA > 0) {
            $stok[] = (float) ($data->SUARA /($data->DPTL+$data->DPTP))*100;
        } else { $stok[] = 0;}

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
        <div class="col-md-12 text-center">
            <h3>GRAFIK PERSENTASE SUARA MASUK</h3>
            <span>Grafik Suara Masuk Per Desa</span>
            <div>
                <canvas id="canvas" ></canvas>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
        <div class="tabel-responsive">
            <legend>Kecamatan <?php echo $nama_kec; ?></legend>
            <center>
            <table class="table-condensed" border="1px">
                <tr>
                    <th class="text-center bg-blue">Desa</th>
                    <th class="text-center bg-blue" style="width: 150px">Jml Suara Masuk</th>
                    <th class="text-center bg-blue" style="width: 150px">Jml Pemilih</th>
                    <th class="text-center bg-blue" style="width: 100px">Persentase</th>
                    <th class="text-center bg-blue" style="width: 150px">Jumlah Surat Suara</th>
                    <th class="text-center bg-blue" style="width: 150px">Surat Suara Belum/Tidak Terpakai</th>
                </tr>
                <?php
                foreach ($rekapkec as $kec) {
                    echo "<tr>";
                    echo "<td><a href='".base_url()."rekap/detaildesa/".$kec->kddesa."' >".$kec->nama_desa."</a></td>";
                    echo "<td class='text-right'>".number_format($kec->SUARA)."</td>";
                    echo "<td class='text-right'>".number_format($kec->DPTL+$kec->DPTP)."</td>";
                    if ($kec->SUARA > 0) {
                        echo "<td class='text-right'>".number_format(($kec->SUARA /($kec->DPTL+$kec->DPTP))*100,2)."%</td>";
                    } else { echo "<td class='text-right'>".number_format(0,2)."%</td>";}
                    echo "<td class='text-right'>".number_format($kec->suratsuara)."</td>";
                    echo "<td class='text-right'>".number_format($kec->suratsuara-$kec->SUARA)."</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            </center>
        </div>
    	</div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div><!-- /.box-footer-->
</div><!-- /.box -->



<!--Load chart js-->
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/Chart.min.js'?>"></script>
<script>

    var ctx = document.getElementById("canvas").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
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
            }
        }
    });

    //var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);    

</script>

