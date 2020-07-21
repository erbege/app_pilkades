<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Laporan Hasil Pilkades</title>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />. 
        <style>
        table {
          border-collapse: collapse;

        }
        body {
            font-family: 'Arial', sans-serif; font-size: 10px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 12px;
        }

        table, td, th {
          border: 1px solid black;
          font-family: 'Arial', sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 21px;
        }
        </style>
    </head>
    <body>
        <center>
        <h2>Laporan Hasil Pilkades Tahun <?php echo $this->session->userdata('thn_data'); ?></h2>
        <?php
        if ($this->session->userdata('id_role') == 3) {
            echo "<h2 class='text-center'>Kecamatan ".$this->session->userdata('nama_kec')."</h2>";
        }
        ?>
        </center>
        <table class="table table-bordered table-striped" border="2px">
            
            <thead>
                <tr>
                    <th class="text-center" rowspan="3" style="width: 30px">No</th>
                    <th class="text-center" rowspan="3" style="width: 120px">Kecamatan</th>
                    <th class="text-center" rowspan="3" style="width: 120px">Desa</th>
                    <th class="text-center" rowspan="2" colspan="3">DPT</th>
                    <th class="text-center" colspan="4">Surat Suara</th>
                    <th class="text-center" colspan="12">Perolehan Suara</th>
                    <th class="text-center" rowspan="3">Partisipasi (%)</th>
                </tr>
                <tr>
                    <th class="text-center" rowspan="2" style="width: 40px">S</th>
                    <th class="text-center" rowspan="2" style="width: 40px">TS</th>
                    <th class="text-center" rowspan="2" style="width: 40px">TD</th>
                    <th class="text-center" rowspan="2" style="width: 40px">Jml</th>
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
                    <th class="text-center" style="width: 30px">1</th>
                    <th class="text-center" style="width: 120px">2</th>
                    <th class="text-center" style="width: 120px">3</th>
                    <th class="text-center" style="width: 40px">4</th>
                    <th class="text-center" style="width: 40px">5</th>
                    <th class="text-center" style="width: 40px">6</th>
                    <th class="text-center" style="width: 40px">7</th>
                    <th class="text-center" style="width: 40px">8</th>
                    <th class="text-center" style="width: 40px">9</th>
                    <th class="text-center" style="width: 40px">10</th>
                    <th class="text-center" style="width: 40px">11</th>
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
                        echo "<td align='right'>".number_format($dtlap->A)."</td>";
                        echo "<td align='right'>".number_format($persen1,2)."</td>";
                        //persen2
                        if (($dtlap->B > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen2 = $dtlap->B / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen2 = 0;
                        }
                        echo "<td align='right'>".number_format($dtlap->B)."</td>";
                        echo "<td align='right'>".number_format($persen2,2)."</td>";
                        //persen3
                        if (($dtlap->C > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen3 = $dtlap->C / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen3 = 0;
                        }
                        echo "<td align='right'>".number_format($dtlap->C)."</td>";
                        echo "<td align='right'>".number_format($persen3,2)."</td>";
                        //persen4
                        if (($dtlap->D > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen4 = $dtlap->D / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen4 = 0;
                        }
                        echo "<td align='right'>".number_format($dtlap->D)."</td>";
                        echo "<td align='right'>".number_format($persen4,2)."</td>";
                        //persen5
                        if (($dtlap->E > 0) && (($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E) > 0)) {
                            $persen5 = $dtlap->E / ($dtlap->A+$dtlap->B+$dtlap->C+$dtlap->D+$dtlap->E)*100;
                        } else {
                            $persen5 = 0;
                        }
                        echo "<td align='right'>".number_format($dtlap->E)."</td>";
                        echo "<td align='right'>".number_format($persen5,2)."</td>";
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
                        echo "<td align='right'>".number_format($partisipasi,2)."</td>";
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
        <p><b>Keterangan: </b><br/>
            S : Surat Suara Sah <br/>
            TS : Surat Suara Tidak Sah <br/>
            TD : Surat Suara Tidak Digunakan
        </p>
    </body>
</html>