<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Target Kerja Per Tahun</h5>
</div>
<div class="page-header position-relative" id="page-content">
    <button class="btn btn-small btn-info no-radius" id="loadUraian"><i class="icon-upload-alt"></i>Load Uraian</button>
    <button class="btn btn-small btn-succes no-radius" id="tgsTambahan"><i class="icon-plus-sign-alt"></i>Tugas Tambahan</button>
    &nbsp;<span id="load" class="spinner"></span>
</div>
<div class="row-fluid clearfix" >
    <div id="page-content">
        <form id="foTargetKerja">
            <table class="table table-bordered geo-table table-hover " width="100%">
                <thead id="rlTabel">
                    <tr>
                        <td align="center" valign="middle"rowspan="2" width="3%">No</td>
                        <td align="center" rowspan="2" width="50%">Uraian</td> 
                        <td align="center" rowspan="2" width="7%">AK</td>
                        <td align="center" colspan="4" width="40%">Target</td>
                    </tr>
                    <tr>
                        <td width="10%">Output</td>
                        <td width="10%">Mutu</td>
                        <td width="10%">Waktu</td>
                        <td width="10%">Biaya</td> 
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    var urls = 'pemangku/targetkerja/targetKerja__.php';
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
