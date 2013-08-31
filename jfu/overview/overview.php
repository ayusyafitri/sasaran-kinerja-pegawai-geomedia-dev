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
        <div class="span12 pull-right">
            <div class="infobox btn infobox-small infobox-dark">
                <div class="infobox-progress">
                    <div class="easy-pie-chart percentage easyPieChart" data-size="39" data-percent="61" style="width: 39px; height: 39px; line-height: 39px;">
                        <span class="percent">61</span>
                        %
                        <canvas height="39" width="39"></canvas>
                    </div>
                </div>
                <div class="infobox-data">
                    <div class="infobox-content">Target</div>
                    <div class="infobox-content">Confirmed</div>
                </div>
            </div>
            <div class="infobox btn-primary infobox-small infobox-dark">
                <div class="infobox-progress">
                    <div class="easy-pie-chart percentage easyPieChart" data-size="39" data-percent="61" style="width: 39px; height: 39px; line-height: 39px;">
                        <span class="percent">61</span>
                        %
                        <canvas height="39" width="39"></canvas>
                    </div>
                </div>
                <div class="infobox-data">
                    <div class="infobox-content">Realisasi</div>
                    <div class="infobox-content">Approved</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12 widget-container-span ui-sortable">
            <div class="widget-box transparent">
                <div class="widget-header widget-header-flat"><h5 >Badan Kepegawaian Daerah</h5>
                    <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                            <i class="icon-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div style="height:300px;">bagan </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hr hr32 hr-dotted"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span7 widget-container-span ui-sortable">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                            <i class="icon-signal icon-large" ></i><h5 class="pull-left">&nbsp;Realisasi Tahun 2013</h5>
                        </div>
                        <div class="widget-body">
                            <div style="height:300px;">Chart</div>

                        </div>
                    </div>
                </div>
                <div class="span5 widget-container-span ui-sortable">
                    adfaf
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
