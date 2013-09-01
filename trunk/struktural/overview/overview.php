<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
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
        <div class="span12 center">
            <div class="infobox infobox-green infobox-small infobox-dark">
                <div class="infobox-progress">
                    <div class="easy-pie-chart percentage easyPieChart" data-size="39" data-percent="61" style="width: 39px; height: 39px; line-height: 39px;">
                        <span class="percent">100</span>
                        %
                        <canvas height="39" width="39">dfvdc</canvas>
                    </div>
                </div>
                <div class="infobox-data">
                    <div class="infobox-content">Target</div>
                    <div class="infobox-content">konfirmasi</div>
                </div>
            </div>
           <div class="infobox infobox-grey infobox-small infobox-dark">
                <div class="infobox-progress">
                    <div class="easy-pie-chart percentage easyPieChart" data-size="39" data-percent="61" style="width: 39px; height: 39px; line-height: 39px;">
                        <span class="percent">0</span>
                        %
                        <canvas height="39" width="39">dfvdc</canvas>
                    </div>
                </div>
                <div class="infobox-data">
                    <div class="infobox-content">Realisasi</div>
                    <div class="infobox-content">-</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12 widget-container-span ui-sortable">
            <div class="widget-box transparent">
                <div class="widget-header widget-header-flat"><h5 >SUB BAGIAN PERENCANAAN PROGRAM</h5>
                    <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                            <i class="icon-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div style="height:300px;"><img src="img/bagan2.png" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="hr hr32 hr-dotted"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span6 widget-container-span ui-sortable">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                            <i class="icon-signal icon-large" ></i><h5 class="pull-left">&nbsp;Realisasi Tahun 2013</h5>
                        </div>
                        <div class="widget-body">
                            <div style="height:300px;"><img src="img/chart1.png" /></div>

                        </div>
                    </div>
                </div>
                <div class="span6 widget-container-span ui-sortable">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-flat">
                            <h4 class="lighter">Status Konfirmasi Target Kerja Bawahan</h4>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main no-padding">

                                <div  style="overflow:scroll; width: auto; height: 300px;">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th><th>Jabatan</th><th>Nama</th><th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td><td>PENGOLAH DATA PERTANIAN</td><td>DYAH RAHMAWATI KHOTIMAH, SP</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td><td>PENGOLAH DATA KEHUTANAN</td><td>MOHAMMAD FACHMIE, S.HUT</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>3</td><td>PENGOLAH DATA RENSTRA</td><td>EUIS NURFARIDAH, SP</td><td><span class="label label-important arrowed-right arrowed-in">belum dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>4</td><td>PENGOLAH DATA/LAPORAN RENJA DAN LAKIP</td><td>IRMA SARASWATI, SP</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>5</td><td>PENGOLAH DATA/LAPORAN RENJA DAN LAKIP</td><td>ARIES NORWANDY, SP</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>6</td><td>PENGADMINISTRASI KEGIATAN</td><td>RUSNAWATY, S.Hut</td><td><span class="label label-important arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>7</td><td>PENGADMINISTRASI DATA PERKEMBANGAN KEGIATAN DINAS</td><td>SILVIA SARI,SP</td><td><span class="label label-important arrowed-right arrowed-in">belum dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>8</td><td>MANTRI PERTANIAN</td><td>RIMAN, SP</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>9</td><td>MANTRI PERTANIAN</td><td>MISRAN, SP</td><td><span class="label label-important arrowed-right arrowed-in">belum dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>10</td><td>MANTRI PERTANIAN</td><td>SUKARMAN, A.MD</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>11</td><td>MANTRI PERTANIAN</td><td>INDRIYANI, SP</td><td><span class="label label-success arrowed-right arrowed-in">sudah dikonfirmasi</span></td>
                                            </tr>
                                            <tr>
                                                <td>12</td><td>MANTRI PERTANIAN</td><td>BUDI SUSANTO</td><td><span class="label label-important arrowed-right arrowed-in">belum dikonfirmasi</span></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    var urls = 'jfu/targetkerja/targetKerja__.php';
    $('#loadUraian').click(function() {
        var ld = $('#load');
        ld.addClass('loading');
        var tbl = $('#rlTabel');
        var post = $.post(urls,{act : 'LdUraian'});
        post.done(function(ser){
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
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>'+
            '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>'; 
        $('#username').editable({
            type: 'text',
            name: 'username'
        }); 
</script>
