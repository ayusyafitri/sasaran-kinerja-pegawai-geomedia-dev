<?php
if (@$_POST['open'] != 'please') {
    exit;
}
@session_start();
include_once('../../php/include_all.php');
?>
<script src="themes/js/highcharts.js"></script>
<script src="themes/js/exporting.js"></script>
<?php
$id_pns = (isset($_POST['id'])) ? abs($_POST['id']) : SKP_ID;
$dataRealisasi = hitungSkp($id_pns, date('Y'), date('m'));
$dataPns = getDataPNS($id_pns);
$dataAtasan = getDataAtasan($id_pns);
$last = get_data("select to_char(log_datetime, 'Day, DD/MM/YYYY at HH12:MI:SS') as 
    last from skp_logs where log_user='" . $id_pns . "' order by log_datetime desc limit 1");
$no = 0;
$tOutput = 0;
$tMutu = 0;
$tWaktu = 0;
$tBiaya = 0;
$totOutput = 0;
$totMutu = 0;
$totWaktu = 0;
$totBiaya = 0;
foreach ($dataRealisasi['dataSKP'] as $data) {
    $nOutput = (empty($data['output']) OR ($data['output'] <= 0)) ? 0 : ($data['r_output'] / $data['output']) * 100;
    $nMutu = (empty($data['mutu']) OR ($data['mutu'] <= 0)) ? 0 : ($data['r_mutu'] / $data['mutu']) * 100;
    $asWaktu = (empty($data['waktu']) OR ($data['waktu'] <= 0)) ? 0 : ($data['r_waktu'] / $data['waktu'] * 100);
    $asBiaya = (empty($data['biaya']) OR ($data['biaya'] <= 0)) ? 0 : ($data['r_biaya'] / $data['biaya'] * 100);
    $tOutput = $tOutput + $data['output'];
    $tMutu = $tMutu + $data['mutu'];
    $tWaktu = $tWaktu + $data['waktu'];
    $tBiaya = $tBiaya + $data['biaya'];
    $totOutput = $totOutput + $nOutput;
    $totMutu = $totMutu + $nMutu;
    $totWaktu = $totWaktu + $asWaktu;
    $totBiaya = $totBiaya + $asBiaya;
    $no++;
}
@$tOutputt = $tOutput / $no;
@$tMutuu = $tMutu / $no;
@$tWaktuu = $tWaktu / $no;
@$tBiayaa = $tBiaya / $no;
$tOutputt = (empty($tOutputt))? '0':$tOutputt;
$tMutuu = (empty($tMutuu))? '0':$tMutuu;
$tWaktuu = (empty($tWaktuu))? '0':$tWaktuu;
$tBiayaa = (empty($tBiayaa))? '0':$tBiayaa;
@$outpunP = number_format(($totOutput / $no), 1) + 0;
@$mutuP = number_format(($totMutu / $no), 1) + 0;
@$waktuP = number_format(($totWaktu / $no), 1) + 0;
@$biayaP = number_format(($totBiaya / $no), 1) + 0;
//echo "$tOutputt , $tMutuu, $tWaktuu, $tBiayaa<br/>$outpunP, $mutuP, $waktuP, $biayaP";
// ============= untuk PIE
$sumPP = ($outpunP + $mutuP + $waktuP + $biayaP) / 4;
$sumP = number_format($sumPP, 1) + 0;
$sumTT = ($tOutput + $tWaktu + $tMutu + $tBiaya) / 4;
$sumT = number_format($sumTT, 1) + 0;
//echo "$outpunP,$mutuP,$waktuP,$biayaP";
?>

<div id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="#">Home</a>

            <span class="divider">
                <i class="icon-angle-right"></i>
            </span>
        </li>
        <li class="active">Overview</li>
    </ul>

</div>
<div id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon-user-md"></i>&nbsp;Overview</h1>
    </div>
    <div class="row-fluid">
        <?php if ($_POST['c'] == 'back' OR !isset($_POST['c'])) { ?>
            <div class="span11">
                <h4><font color="#999">Welcome</font>  <?php echo SKP_USER; ?>!</h3>
                    <h5><font color="#999">Last Login, <?php echo $last['last']; ?></font></h4>            

            </div>
        <?php } else { ?>
        <div class='span10'><button class='btn-primary btn-default' onclick="openDetail(this,<?php echo $dataAtasan['id']; ?>, 'back')"><i class='icon-backward'></i>&nbsp;Kembali</button></div>
        <?php unset($_POST['id']);} ?>
    </div>
    <div id='showChart'></div>
    <div class="hr hr32 hr-dotted"></div>    
    <div class="row-fluid">
        <div class="widget-container-span ui-sortable">
            <div class="span6 widget-box transparent" style="display: inline;float: left;">
                <div class="widget-container-span ui-sortable">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                            <h5>&nbsp;<?php echo strtoupper($dataPns['namajab']); ?></h5>
                        </div>
                        <?php
                        $parentI = get_data("SELECT p.nama,j.parent,j.unit_kerja,p.id_pns,j.idjab FROM skp_pns p,skp_jabatan j where j.kode_jabatan = p.kode_jabatan and j.idjab = '" . $dataPns['idJab'] . "'");
                        $parentII = get_data("SELECT p.nama, j.parent,j.unit_kerja,p.id_pns FROM skp_pns p,skp_jabatan j where j.kode_jabatan = p.kode_jabatan and j.idjab = '" . $parentI['parent'] . "'");
                        global $explv, $explc;
                        $explc = -1;
                        explore($parentII['unit_kerja'], $parentII['parent'], 0);
                        ?>
                        <div class="widget-body">                            
                            <div class="trees">
                                <ul>
                                    <?php
                                    $base = 0;
//                                    print_r($explv);
                                    $ulul = '';
                                    for ($a = 0; $a < $explc; $a++) {
                                        if ($base == 0 AND ($explv[$a][1] == $parentI['parent'])) {
                                            $base = $explv[$a][11];
                                            continue;
                                        }
                                        $dtaJab = get_data("SELECT p.id_pns,p.nama,j.idjab, j.nama_jabatan,j.parent FROM skp_pns p, skp_jabatan j where p.kode_jabatan = j.kode_jabatan and j.kode_jabatan = '" . $explv[$a][2] . "' ");
                                        $clsBadge = ($dtaJab['id_pns'] == $dataPns['id']) ? 'badge-success' : 'badge-default';
                                        $onClick = ($dtaJab['parent'] == $dataPns['idJab']) ? "onclick='openDetail(this," . $dtaJab['id_pns'] . ",1);' style='cursor:pointer;'" : '';
                                        if (empty($dtaJab['nama_jabatan']))
                                            continue;
                                        if ($explv[$a][11] > $base) {
                                            $ulul .= "<ul><li><span class='badge $clsBadge' $onClick>" . $dtaJab['nama_jabatan'] . "<br/>" . $dtaJab['nama'] . "/" . $dtaJab['idjab'] . "</span>";
                                        } elseif ($explv[$a][11] == $base) {
                                            $ulul .= "</li><li><span class='badge $clsBadge' $onClick>" . $dtaJab['nama_jabatan'] . "<br/>" . $dtaJab['nama'] . "/" . $dtaJab['idjab'] . "</span></li>";
                                        } else {
                                            $ck = TRUE;
                                            for ($u = $base; $u > $explv[$a][11]; $u--) {
                                                if ($ck) {
                                                    $ulul .= '</li>';
                                                    $ck = FALSE;
                                                } else {
                                                    $ck = TRUE;
                                                    $ulul .='</ul>';
                                                }
                                            }
                                            $ulul .="<li><span class='badge $clsBadge' $onClick>" . $dtaJab['nama_jabatan'] . "<br/>" . $dtaJab['nama'] . "</span></li>";
                                        }
                                        $base = $explv[$a][11];
                                    }
                                    echo $ulul;
                                    unset($explc);
                                    unset($explv);
                                    ?>                                
                                </ul>
                            </div>
                            <script type='text/javascript'>
                                $(function() {
                                    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
                                    $('.tree li.parent_li > span').on('click', function(e) {
                                        var children = $(this).parent('li.parent_li').find(' > ul > li');
                                        if (children.is(":visible")) {
                                            children.hide('fast');
                                            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
                                        } else {
                                            children.show('fast');
                                            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
                                        }
                                        e.stopPropagation();
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat">
                        <h5>&nbsp;Realisasi Tahun <?php echo date('Y'); ?></h5>
                        <button class="btn btn-primary btn-info btn-mini" style="cursor: pointer; padding: 4px; margin: 6px; border-radius: 14px 14px 14px 14px;">
                            <i class="icon-zoom-in"></i>
                        </button>
                    </div>
                    <div class="widget-body">
                        <!--<div style="height:300px;"><img src="themes/img/chart1.png" /></div>-->
                        <div id="chartRealisasi" ></div>
                    </div>
                </div>                
                <div class="widget-box">
                    <div class="widget-header widget-header-flat">
                        <h5>&nbsp;Realisasi Tahun <?php echo date('Y'); ?></h5>
                    </div>
                    <div class="widget-body">
                        <!--<div style="height:300px;"><img src="themes/img/chart1.png" /></div>-->
                        <div id="chartPieRealisasi" ></div>
                    </div>
                </div>                
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    var column = $('#chartRealisasi'), pie = $('#chartPieRealisasi');
    column.highcharts({
        chart: {
            type: 'column',
            width: 500,
            height: 320
        },
        title: {
            text: "Realisasi Tahun <?php echo date('Y'); ?>"
        },
        xAxis: {
            categories: ['Output', 'Mutu', 'Waktu', 'Biaya']
        },
        yAxis: {
            min: 0,
            labels: {
                formatter: function() {
                    return this.value + ' %';
                }
            },
            title: {
                text: 'Prosenatase (%)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="font-size:10px">Target</td><td style="font-size:10px">{point.tgt}</td></tr><tr><td style="color:{series.color};font-size:10px">{series.name}: </td>' +
                    '<td style=";font-size:10px"><b>{point.y:.1f}%</b></td></tr>',
            footerFormat: '</table>',
            //shared: true,
            useHTML: true
        },
        series: [{
                name: 'Realisasi',
                data: [{
                        y: <?php echo $outpunP; ?>,
                        tgt: <?php echo $tOutputt; ?>
                    }, {
                        y: <?php echo $mutuP; ?>,
                        tgt: <?php echo $tMutuu; ?>
                    }, {
                        y:<?php echo $waktuP; ?>,
                        tgt: <?php echo $tWaktuu; ?>
                    }, {
                        y: <?php echo $biayaP; ?>,
                        tgt: <?php echo $tBiayaa; ?>
                    }],
                dataLabels: {
                    enabled: true,
                    color: '#0D233A',
                    style: {
                        fontWeight: 'bold'
                    },
                    formatter: function() {
                        return this.y + '%';
                    }
                }
            }]
    });

    var warna = Highcharts.getOptions().colors,
            categori = ['Realisasi', 'Belum Terealisasi'],
            name = 'Realisasi Tahun <?php echo date('Y'); ?> ',
            data = [{
            y: <?php echo $sumP; ?>,
            color: warna[0],
            drildown: {
                name: 'Realisasi Tahun <?php echo date('Y'); ?>',
                categories: ['Output', 'Mutu', 'Waktu', 'Biaya'],
                data: [<?php echo "$outpunP,$mutuP,$waktuP,$biayaP" ?>],
                color: warna[0]
            }
        }, {
            y: <?php echo ($sumT - $sumP); ?>,
            color: warna[1],
            drilldown: {
                name: 'Belum Terealisasi <?php echo date('Y'); ?>',
                categories: ['Output', 'Mutu', 'Waktu', 'Biaya'],
                data: [<?php echo ($tOutput - $outpunP) . "," . ($tMutu - $mutuP) . "," . ($tWaktu - $waktuP) . "," . ($tBiaya - $biayaP); ?>],
                color: warna[1]
            }
        }];

    function setChart(name, categories, data, color) {
        console.log(pie);
        pie.xAxis[0].setCategories(categories, false);
        pie.series[0].remove(false);
        pie.addSeries({
            name: name,
            data: data,
            color: color || 'white'
        }, false);
        pie.redraw();
    }

    pie.highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            width: 500,
            height: 320
        },
        title: {
            text: 'Realisasi Tahun <?php echo date('Y'); ?> '
        },
        tooltip: {
            pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                shadow: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }, point: {
                    event: {
                        click: function() {
                            var drilldown = this.drilldown;
                            if (drilldown) { // drill down
                                setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                            } else { // restore
                                setChart(name, categories, data);
                            }
                        }
                    }
                }
            }
        },
        series: [{
                type: 'pie',
                name: '',
                colorByPoint: true,
                data: [{
                        name: 'Realisasi',
                        y: <?php echo $sumP; ?>,
                        sliced: true,
                        selected: true
                    }, ['Belum Realisasi', <?php echo ($sumT - $sumP); ?>]
                ]
            }],
        exporting: {
            enabled: false
        }
    });
    var urls = 'jfu/targetkerja/targetKerja__.php';
    $('#loadUraian').click(function() {
        var ld = $('#load');
        ld.addClass('loading');
        var tbl = $('#rlTabel');
        var post = $.post(urls, {act: 'LdUraian'});
        post.done(function(ser) {
            tbl.html(ser);
        });
    });
    $('#tgsTambahan').click(function() {
        var ld = $('#load');
        ld.addClass('spinner');
    });
    jQuery(function($) {
//editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>' +
                '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';
        $('#username').editable({
            type: 'text',
            name: 'username'
        });
    });
    $('tspan').each(function() {
        if ($(this).html() === 'Highcharts.com') {
            $(this).remove();
        }
    });

   function openDetail(next, a, b) {     
        $(next).after("&nbsp;&nbsp;<i class='icon-spin icon-spinner icon-2x'></i>");
        var urls = "jfu/overview/overview.php";
        var post = $.post(urls, {id: a,open: 'please', c:b});
        post.done(function(response) {
            $('#main-content').html(response);
        });
    }
</script>
