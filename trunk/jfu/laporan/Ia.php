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
    <thead >
        <tr>
            <th class="center tabl-bord" valign="middle"  style="width:5%;">NO</th>
            <th class="center tabl-bord" colspan="2" style="width:45%">PEJABAT PENILAI</th> 
            <th class="center tabl-bord" valign="middle" style="width:5%;">NO</th>
            <th class="center tabl-bord" colspan="4" style="width:45%">PEJABAT YANG DI NILAI</th>

        </tr>

    </thead>
    <tbody>
        <tr>
            <td class='center tabl-bo'>1</td><td class="tabl-bo" style="width: 15%;">Nama</td><td class="tabl-bo"> <?php echo stripIfEmpty($dtaAtasan['nama']); ?> </td><td class='center tabl-bo'>1</td><td class="tabl-bo" style="width: 15%" colspan="2">Nama</td><td class="tabl-bo" style="" colspan="2"><?php echo SKP_NAMA; ?></td> 
        </tr>
        <tr>
            <td class='center tabl-bo'>2</td><td class="tabl-bo">NIP</td><td class="tabl-bo"> <?php echo stripIfEmpty($dtaAtasan['nip']); ?> </td><td class='center tabl-bo'>2</td><td class="tabl-bo" colspan="2">NIP</td><td class="tabl-bo" colspan="2"><?php echo SKP_NIP; ?></td> 
        </tr>
        <tr>
            <td class='center tabl-bo'>3</td><td class="tabl-bo">Pangkat/Gol. Ruang</td><td class="tabl-bo"> <?php echo stripIfEmpty($dtaAtasan['pangkatGol']); ?> </td><td class='center tabl-bo'>3</td><td class="tabl-bo" colspan="2">Pangkat/Gol. Ruang</td><td class="tabl-bo" colspan="2"><?php echo stripIfEmpty($dtPeg['pangkatGol']) ?></td> 
        </tr>
        <tr>
            <td class='center tabl-bo'>4</td><td class="tabl-bo">Jabatan</td><td class="tabl-bo"> <?php echo stripIfEmpty($dtaAtasan['namajab']); ?> </td><td class='center tabl-bo'>4</td><td class="tabl-bo" colspan="2">Jabatan</td><td class="tabl-bo" colspan="2"> <?php echo stripIfEmpty($dtPeg['namajab']); ?> </td> 
        </tr>
        <tr>
            <td class='center tabl-bo'>5</td><td class="tabl-bo">Unit Kerja</td><td class="tabl-bo"> <?php echo stripIfEmpty($dtaAtasan['namaUnit']); ?> </td><td class='center tabl-bo'>5</td><td class="tabl-bo" colspan="2">Unit Kerja</td><td class="tabl-bo" colspan="2"> <?php echo stripIfEmpty($dtPeg['namaUnit']); ?> </td> 
        </tr>
        <!--<tr colspan="10">-->
<!--    <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
        <thead >-->
        <tr>
            <th class="center tabl-bord" valign="middle" rowspan="2" style="">No</th>
            <th class="center tabl-bord" rowspan="2" style="" colspan="2">Uraian</th> 
            <th class="center tabl-bord" rowspan="2" style="">AK</th>
            <th class="center tabl-bord" colspan="4" >Target</th>
        </tr>
        <tr>
            <th class="center tabl-bord">Output</th>
            <th class="center tabl-bord">Mutu</th>
            <th class="center tabl-bord">Waktu</th>
            <th class="center tabl-bord">Biaya</th> 
        </tr>

        <?php
        $target = getDataTarget(SKP_ID, date('Y'), SKP_KODEJAB);
        $no = 1;
        foreach ($target as $value) {
            ?>
            <tr>
                <td valign="middle" class="center tabl-bo" ><?php echo $no; ?></td>
                <td class="tabl-bo" style="text-align: justify; width: 200px;" colspan="2" ><?php echo ucfirst($value['uraian']); ?></td>
                <td class="center tabl-bo"> <?php echo stripIfEmpty($value['angka_kredit']); ?> </td> 
                <td class="center tabl-bo"> <?php echo stripIfEmpty($value['output']); ?> </td> 
                <td class="center tabl-bo"> <?php echo stripIfEmpty($value['mutu']); ?> </td> 
                <td class="center tabl-bo"> <?php echo stripIfEmpty($value['waktu']); ?> </td> 
                <td class="center tabl-bo"> Rp <?php echo stripIfEmpty(number_format($value['biaya'], 2, '.', '.'),'Rp',',-'); ?>,- </td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
</table>
<table width="100%" class='tabel'>
    <tr>
        <td><div class="center"><br/>
                Pejabat penilai,<br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <u><?php echo dotIfEmpty($dtaAtasan['nama']); ?> </u><br/>
                NIP. <?php echo dotIfEmpty($dtaAtasan['nip']); ?> <br/>
            </div></td>
        <td></td>
        <td><div class="center"><?php echo $kotakab; ?>,&nbsp;<?php echo date('d-m-Y') ?><br/>
                PNS yang dinilai,<br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <u><?php echo SKP_NAMA; ?></u><br/>
                NIP. <?php echo SKP_NIP; ?><br/>
            </div></td>
    </tr>
    <tr>
        <td></td>
        <td><div class="center"><br/>
                Atasan pejabat penilai,<br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <u><?php echo ucfirst(stripIfEmpty($dtpalingAtas['nama'])); ?></u><br/>
                NIP. <?php echo ucfirst(stripIfEmpty($dtpalingAtas['nip'])); ?><br/>
            </div></td>
        <td></td>
    </tr>
</table>
</body>
<p id='brbr'><br /><br /></p>
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