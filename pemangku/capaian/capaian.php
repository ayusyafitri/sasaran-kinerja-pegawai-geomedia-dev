<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Capaian Kerja Per Tahun</h5>
</div>
<div class="row-fluid clearfix" >

    <div id="page-content">
        <table class="table table-bordered geo-table table-hover" width="100%">
            <thead>
                <tr>
                    <td align="center" valign="middle"rowspan="2" width="3%">No</td>
                    <td align="center" rowspan="2" width="50%">Uraian</td> 
                    <td align="center" rowspan="2" width="7%">AK</td>
                    <td colspan="4" width="40%">Realisasi</td>
                    <td rowspan="4" width="40%">Perhitungan</td>
                    <td rowspan="4" width="40%">Nilai Capaian</td>
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
    </div>
</div>
</div>
