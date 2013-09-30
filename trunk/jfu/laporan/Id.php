<?php
session_start();
include_once('../../php/include_all.php');
if (!isset($_SESSION['_idpns'])) {
    echo "<h2>Page Not Found</h2>";
    exit();
}
$dtaAtasan = getDataAtasan(SKP_ID);
$dtPeg = getDataPNS(SKP_ID);
?>
<!DOCTIYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>KREATIVITAS <?php echo SKP_NAMA; ?></title>
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
    <body style=" font-family:'Open Sans';" >
        <div><div style="display: inline; float:left;" class="center"><h3>SURAT KETERANGAN MENEMUKAN SESUATU YANG BARU (KREATIVITAS)</h3></div><div class="pull-right"><a class="btn btn-small btn-primary" id="print"><i class="icon-print"></i> Cetak Laporan</a></div></div>
        <table class="tabel" style="width:100%">
            <thead >
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:1px;">1.</td>
                    <td colspan="4" style="width:99px;">Yang bertanda tangan di bawah ini:</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">a.</td>
                    <td style="width:28px;">Nama</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtaAtasan['nama'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">b.</td>
                    <td style="width:28px;">NIP</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtaAtasan['nip'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">c.</td>
                    <td style="width:28px;">Pangkat/GolonganRuang</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtaAtasan['pangkatGol'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">d.</td>
                    <td style="width:28px;">Jabatan</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtaAtasan['namajab'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">e.</td>
                    <td style="width:28px;">Unit Kerja</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtaAtasan['namaUnit'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">f.</td>
                    <td style="width:28px;">Instansi</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtaAtasan['UnitKerja'])); ?></td>
                </tr>
                <tr>
                    <td style="width:1px;">2.</td>
                    <td colspan="4" style="width:99px;">dengan ini menyatakan bahwa saudara:</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">a.</td>
                    <td style="width:28px;">Nama</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo SKP_NAMA; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">b.</td>
                    <td style="width:28px;">NIP</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo SKP_NIP; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">c.</td>
                    <td style="width:28px;">Pangkat/GolonganRuang</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtPeg['pangkatGol'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">d.</td>
                    <td style="width:28px;">Jabatan</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtPeg['namajab'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">e.</td>
                    <td style="width:28px;">Unit Kerja</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtPeg['namaUnit'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">f.</td>
                    <td style="width:28px;">Instansi</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;"><?php echo ucfirst(stripIfEmpty($dtPeg['UnitKerja'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">g.</td>
                    <td style="width:28px;">Jangka waktu penilaian</td>
                    <td style="width:1px;">:</td>
                    <td style="width:70px;">1 Januari <?php echo date('Y'); ?> - 31 Desember </td>
                </tr>
                <tr>
                    <td style="width:1px;">3.</td>
                    <td colspan="4" style="width:99px;">Telah menemukan sesuatu yang baru (kreativitas) yang bermanfaat bagi:</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">a.</td>
                    <td colspan="4">Unit kerja, diberikan nilai:</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">b.</td>
                    <td colspan="4">Organisasi, diberikan nilai:</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:1px;">c.</td>
                    <td colspan="4">Negara, diberikan nilai:</td>
                </tr>
                <tr>
                    <td colspan="9">Demikian surat keterangan ini dibuat dengan sebenar-benarnya untur dipergunakan sebagaimana semestinya</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" class='tabel'>
            <tr>
                <td width="35%"></td>
                <td width="35%"></td>
                <td width="30%"><div class="center"><?php echo $kotakab; ?>,&nbsp;<?php echo date('d-m-Y') ?><br/>
                        Pejabat yang membuat keterangan<br/>
                        Eselon <?php echo ucfirst(stripIfEmpty($dtaAtasan['eselon'])); ?><br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <u><?php echo ucfirst(stripIfEmpty($dtaAtasan['nama'])); ?></u><br/>
                        NIP. <?php echo ucfirst(stripIfEmpty($dtaAtasan['nip'])); ?><br/>
                    </div></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
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