<?php
session_start();
include_once('../../php/include_all.php');
if (!isset($_SESSION['_id'])) {
    echo "<h2>Page Not Found</h2>";
    exit();
}
$idPns = (isset($_GET['d']))?abs($_GET['d']):SKP_ID;
$dtaAtasan = getDataAtasan($idPns);
$dtPeg = getDataPNS($idPns);
$dtpalingAtas = getDataAtasan($dtaAtasan['id']);
?>
<!DOCTIYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Formulir SKP PNS <?php echo $dtPeg['nip']; ?></title>
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
            <div class="span12"><div class="span6" style="display:inline; float:left;"><h5>Nama: <?php echo ucfirst(stripIfEmpty($dtPeg['nama'])); ?></h5></div><div class="span6"><h4>NIP : <?php echo ucfirst(stripIfEmpty($dtPeg['nip'])); ?></h5></div></div>
            <table class="tabl" style="width:100%"></div>
    <tbody >
        <tr>
            <td class="tabl-bord" style="width:2%">No</td>
            <td class="tabl-bord" style="width:18%">Tanggal</td>
            <td class="tabl-bord" style="width:50%">Uraian</td>
            <td class="tabl-bord" style="width:30%">Nama/NIP dan Paraf Pejabat Penilai</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:2%">-</td>
            <td class="tabl-bo" style="width:18%">-</td>
            <td class="tabl-bo" style="width:50%">-</td>
            <td class="tabl-bo" style="width:30%">-</td>
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