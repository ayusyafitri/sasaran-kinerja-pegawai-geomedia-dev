<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Laporan Hasil Perhitungan</h5>
</div>
<div class=" position-relative" id="page-content">
    <button class="btn btn-small btn-primary no-radius" id=""><i class="icon-print"></i>Cetak</button>
    <button class="btn btn-small btn-danger no-radius" id=""><i class="icon-eject"></i>Menggugat</button>
    &nbsp;<span id="load" class="spinner"></span>
</div>
<div class="row-fluid clearfix" >
  <div id="page-content">
        <form id="foTargetKerja">
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" rowspan="2" style="width:2%;">No</th>
                        <th class="center" rowspan="2" style="width:30%">Uraian</th> 
                        <th class="center" rowspan="2" style="width:6%">AK</th>
                        <th class="center" colspan="4" style="width:28%">Target</th>
                        <th class="center" rowspan="2" style="width:6%">AK</th>
                        <th class="center" colspan="4" style="width:28%">Realisasi</th>
                    </tr>
                    <tr>
                        <th style="width:7%">Output</th>
                        <th style="width:7%">Mutu</th>
                        <th style="width:7%">Waktu</th>
                        <th style="width:7%">Biaya</th> 
                        <th style="width:7%">Output</th>
                        <th style="width:7%">Mutu</th>
                        <th style="width:7%">Biaya</th> 
                        <th style="width:7%">Waktu</th>
                    </tr>
                </thead>
                <tbody id="rlTabel">

                </tbody>
            </table>
        </form>
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
</script>
