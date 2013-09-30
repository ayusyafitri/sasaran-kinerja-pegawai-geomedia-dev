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
        <div><div style="display: inline; float:left;" class="center"><h3>PENILAIAN PRESTASI KERJA PEGAWAI NEGERI SIPIL</h3></div><div class="pull-right"><a class="btn btn-small btn-primary" id="print"><i class="icon-print"></i> Cetak Laporan</a></div>
            <div class="span12"><div class="span6" style="display:inline; float:left;"><h4><?php echo $kotakab?></h4></div><div ><h4>JANGKA PENILAIAN WAKTU BULAN ...... s.d ..... <?php echo date('Y');?></h4></div></div>
            <table class="tabl" style="width:100%"></div>
    <tbody >
        <tr>
            <td class="tabl-bo" style="width:1%;" rowspan="6">1.</td>
            <td class="tabl-bo" style="width:99%;" colspan="5">YANG DINILAI</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">a. Nama</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtPeg['nama'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">b. NIP</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtPeg['nip'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">c. Pangkat, golongan ruang</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtPeg['pangkatGol'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">d. Jabatan/Pekerjaan</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtPeg['namajab'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">e. Unit Organisasi</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtPeg['namaUnit'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:1%;" rowspan="6">2.</td>
            <td class="tabl-bo" style="width:99%;" colspan="5">PEJABAT PENILAI</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">a. Nama</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtaAtasan['nama'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">b. NIP</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtaAtasan['nip'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">c. Pangkat, golongan ruang</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtaAtasan['pangkatGol'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">d. Jabatan/Pekerjaan</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtaAtasan['namajab'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">e. Unit Organisasi</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtaAtasan['namaUnit'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:1%;" rowspan="6">3.</td>
            <td class="tabl-bo" style="width:99%;" colspan="5">ATASAN PEJABAT PENILAI</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">a. Nama</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtpalingAtas['nama'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">b. NIP</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtpalingAtas['nip'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">c. Pangkat, golongan ruang</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtpalingAtas['pangkatGol'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">d. Jabatan/Pekerjaan</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtpalingAtas['namajab'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:39%">e. Unit Organisasi</td>
            <td class="tabl-bo" style="width:60%" colspan="4"><?php echo ucfirst(stripIfEmpty($dtpalingAtas['namaUnit'])); ?></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:1%;" rowspan="11">4.</td>
            <td class="tabl-bo" style="width:79%;" colspan="4">UNSUR YANG DINILAI</td>
            <td class="tabl-bo center" style="width:20%;">JUMLAH</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:49%;" colspan="2">a. Sasaran Kerja Pegawai (SKP)/ Nilai Prestasi Akademik</td>
            <td class="tabl-bo" style="width:30%; text-align: right;" colspan="2">.............x 60%</td>
            <td class="tabl-bo center" style="width:20%;">.......</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:20%;" rowspan="9" align="middle">b. Perilaku Kerja</td>
            <td class="tabl-bo" style="width:29%">1. Orientasi Pelayanan</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo center" style="width:20%;" rowspan="8"></td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">2. Integritas</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">3. Komitmen</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">4. Disiplin</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">5. Kerjasama</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">6. Kepemimpinan</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">Jumlah</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">Nilai rata-rata</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
            <td class="tabl-bo" style="width:15%;" >-</td>
        </tr>
        <tr>
            <td class="tabl-bo" style="width:29%">Nilai Perilaku Kerja</td>
            <td class="tabl-bo" style="width:30%;  text-align: right;" colspan="2" >............. x 40%</td>
            <td class="tabl-bo center">.......</td>
        </tr >
        <tr>
            <td class="tabl-bo" colspan="6">5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI (APABILA ADA)<div style="text-align: right;"><br/><br/><br/><br/><br/><br/>Tanggal, <?php echo date('d-m-Y'); ?></div></td>
        </tr>
        <tr>
            <td class="tabl-bo" colspan="6">6. TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN<div style="text-align: right;"><br/><br/><br/><br/><br/><br/>Tanggal, <?php echo date('d-m-Y'); ?></div></td>
        </tr>
        <tr>
            <td class="tabl-bo" colspan="6">7. KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN<div style="text-align: right;"><br/><br/><br/><br/><br/><br/>Tanggal, <?php echo date('d-m-Y'); ?></div></td>
        </tr>
        <tr>
            <td class="tabl-bo" colspan="6">8. REKOMENDASI<div style="text-align: right;"><br/><br/><br/><br/><br/><br/>Tanggal, <?php echo date('d-m-Y'); ?></div></td>
        </tr>
        <tr>
            <td class="tabel-bo" colspan="2"></td>
            <td class="tabel-bo"></td>
            <td class="tabel-bo center" colspan="3" >9. DIBUAT TANGGAL, <?php echo date('d-m-Y'); ?><br/>PEJABAT PENILAI<br/><br/><br/><u><?php echo ucfirst(stripIfEmpty($dtaAtasan['nama'])); ?></u><br/>NIP. <?php echo ucfirst(stripIfEmpty($dtaAtasan['nip'])); ?></td>
        </tr>
        <tr>
            <td class="tabel-bo center" colspan="2">10. DITERIMA TANGGAL, <?php echo date('d-m-Y'); ?><br/>PEGAWAI NEGERI SIPIL YANG DINILAI<br/><br/><br/><u><?php echo ucfirst(stripIfEmpty($dtPeg['nama'])); ?></u><br/>NIP. <?php echo ucfirst(stripIfEmpty($dtPeg['nama'])); ?></td>
            <td class="tabel-bo"></td>
            <td class="tabel-bo " colspan="3" ></td>
        </tr>
        <tr>
            <td class="tabel-bo" colspan="2"></td>
            <td class="tabel-bo"></td>
            <td class="tabel-bo center" colspan="3" >11. DITERIMA TANGGAL, <?php echo date('d-m-Y'); ?><br/>ATASAN PEJABAT YANG MENILAI<br/><br/><br/><u><?php echo ucfirst(stripIfEmpty($dtpalingAtas['nama'])); ?></u><br/>NIP. <?php echo ucfirst(stripIfEmpty($dtpalingAtas['nama'])); ?></td>
        </tr>
    </tbody>
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