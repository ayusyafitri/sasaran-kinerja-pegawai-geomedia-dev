<?php
session_start();
include_once('../../php/include_all.php');
if (!isset($_SESSION['_idpns'])) {
    echo "<h2>Page Not Found</h2>";
    exit();
}
$dtaAtasan = getDataAtasan(SKP_ID);
$dtPeg = getDataPNS(SKP_ID);
$dtpalingAtas = getDataAtasan($dtaAtasan['id']);
?>
<!DOCTIYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Formulir SKP PNS <?php echo SKP_NIP; ?></title>
        <meta name="descritption" content="This is page header(.page-header &gt; h1)"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="../../themes/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="../../themes/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../../themes/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="../../themes/css/prettify.css"/>
        <link rel="stylesheet" href="../../themes/css/skp.css"/>
        <link rel="stylesheet" href="../../themes/css/w8.min.css" />
        <link rel="stylesheet" href="../../themes/css/css.css" />
        <link rel="stylesheet" href="../../themes/css/w8-responsive.min.css" />
        <link rel="stylesheet" href="../../themes/css/w8-skins.min.css" />
        <script src="../../themes/js/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" charset="utf-8" language="javascript" src="../../themes/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" language="javascript" src="../../themes/js/DT_bootstrap.js"></script>

<!--        <script>
            window.print();
            //window.close();
        </script>-->
    </head>
    <body style=" font-family:'Open Sans' ;" >
        <div><div style="display: inline; float:left;" class="center"><h3>SASARAN KINERJA PEGAWAI</h3></div><div class="pull-right"><a class="btn btn-small btn-primary" id="print"><i class="icon-print"></i> Cetak Laporan</a></div>
            <table class="tabl" style="width:100%"></div>
    <tbody >
        <tr>
            <td class="center tabl-bord" valign="middle" rowspan="2" style="width:2%;">No</td>
            <td class="center tabl-bord" rowspan="2" style="width:30%">Uraian</td> 
            <td class="center tabl-bord" rowspan="2" style="width:6%">AK</td>
            <td class="center tabl-bord" colspan="4" style="width:21%">Target</td>
            <td class="center tabl-bord" rowspan="2" style="width:6%">AK</td>
            <td class="center tabl-bord" colspan="4" style="width:21%">Realisasi</td>
            <td class="center tabl-bord" rowspan="2" style="width:7%">Penghitungan</td>
            <td class="center tabl-bord" rowspan="2" style="width:7%">Nilai Capaian SKP</td>
        </tr>
        <tr>
            <td class="center tabl-bord" style="width:7%">Output</td>
            <td class="center tabl-bord" style="width:7%">Mutu</td>
            <td class="center tabl-bord"style="width:7%">Waktu</td>
            <td class="center tabl-bord"style="width:7%">Biaya</td> 
            <td class="center tabl-bord"style="width:7%">Output</td>
            <td class="center tabl-bord"style="width:7%">Mutu</td>
            <td class="center tabl-bord"style="width:7%">Waktu</td> 
            <td class="center tabl-bord"style="width:7%">Biaya</td>
        </tr>
        <?php
//        $target = get_datas("SELECT t.id_skp,t.id_tkerja,t.output, t.mutu, t.waktu, t.biaya, u.id_uraian, u.uraian, t.angka_kredit, r.id_realisasi, r.r_output ,r.r_mutu,r.r_waktu,r.r_biaya FROM skp_t_kerja t 
//INNER JOIN skp_uraian u  ON t.id_uraian = u.id_uraian and t.tahun = '" . date('Y') . "' and t.id_pns = '" . SKP_ID . "' and t.kode_jabatan = '" . SKP_KODEJAB . "'
//LEFT OUTER JOIN skp_r_kerja r ON t.id_tkerja = r.id_tkerja");
        $DataSKP = hitungSkp(SKP_ID, date('Y'), date('n'));     
        $skpData = $DataSKP['dataSKP'];
        if (count($skpData) > 0) {
            $no = 1;
            foreach ($skpData as $isiRealisasi) {
                ?>
                <tr>
                    <td class = "tabl-bo" valign = "middle" align = "center"><?php echo $no; ?></td>
                    <td class = "tabl-bo" style="text-align: justify;"><?php echo ucfirst($isiRealisasi['uraian']); ?></td>
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['angka_kredit']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['output']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['mutu']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['waktu']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty(number_format($isiRealisasi['biaya'], 2, '.', '.'), 'Rp',',-'); ?></td>
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['angka_kredit']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['r_output']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['r_mutu']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty($isiRealisasi['r_waktu']); ?> </td> 
                    <td class="center tabl-bo"> <?php echo stripIfEmpty(number_format($isiRealisasi['r_biaya'], 2, '.', '.'), 'Rp',',-'); ?> </td>
                    <td class = "tabl-bo right"><?php echo number_format($isiRealisasi['penghitungan'], 2); ?></td>
                    <td class = "tabl-bo right"><?php echo number_format($isiRealisasi['capaian'], 2); ?></td>
                </tr>
                <?php
                $no++;
            }
        }
        ?>
        <tr>
            <td class="tabl-bord" valign="middle" align="center">-</td>
            <td class="tabl-bord" align="center" >II. Tugas Tambahan dan Kreativitas/Unsur Penunjang :</td>

            <td class="tabl-bord" colspan="10">

            </td>
            <td class="tabl-bo"></td>
            <td class="tabl-bo"></td>
        </tr>
        <tr>
            <td class="tabl-bord" valign="middle" align="center" >10.00</td>
            <td class="tabl-bord" align="center" >Tugas Tambahan</td>
            <td class="tabl-bo" colspan="10">
                <?php
                $tugasTam = $DataSKP['uraianTam'];
                $n = 1;
                foreach ($tugasTam as $value) {
                    echo $n;
                    ?>.&nbsp<?php echo stripIfEmpty($value);
                    ?><br/>
                    <?php
                    $n++;
                }
                ?>
            </td>
            <td class="tabl-bo"></td>
            <td class="tabl-bo center"><?php echo $DataSKP['NilaiTgsTam'];?></td>
        </tr>
        <tr>
            <td class="tabl-bord" valign="middle" align="center" >30.00</td>
            <td class="tabl-bord" align="center" >Kreativitas</td>
            <td class="tabl-bo" colspan="10">
                <?php
                $target = get_data("SELECT k.id_skp FROM skp_t_kerja k where k.tahun = '" . date('Y') . "' and k.id_pns = '" . SKP_ID . "' and k.kode_jabatan = '" . SKP_KODEJAB . "' limit 1");
                $tgstambah = get_datas("select * from skp_r_kreatifitas where idskp =" . $target['id_skp']);
                $no = 1;
                foreach ($tgstambah as $value) {
                    echo $no;
                    ?>.&nbsp<?php echo stripIfEmpty($value['uraiankreatifitas']);
                    ?><br/>
                    <?php
                    $no++;
                }
                ?>
            </td>
            <td class="tabl-bo"></td>
            <td class="tabl-boc center"><?php echo $DataSKP['perilaku'];?></td>
        </tr>
        <tr>
            <td colspan="13" class='center tabl-bo'><strong>NILAI CAPAIAN SKP</strong></td>
            <td class="tabl-bo center" style="border-top: solid 1px;"> <?php echo $DataSKP['capaian'];?> </td>
        </tr>
    </tbody>
</table>
</body><p id='brbr'><br /><br /></p>
<script type="text/javascript">
    $('#print').click(function() {
        var pr = $(this).parent();
        var thb = $(this);
        pr.addClass('hide');
        $('#brbr').insertAfter(pr);
        var a = window.print();
        console.log(a);
        if (!a) {
            pr.removeClass('hide');
            var br = pr.next('#brbr');
            br.remove();
            //    console.log('print');
        } else {
            $('#brbr').insertAfter(pr);
            //   console.log('gagal');
            //window.close();
        }
    });
</script>
</html>