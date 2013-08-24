<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Target Kerja Per Tahun</h5>
</div>
<div class="row-fluid clearfix" >
    <div id="page-content">
    <button class="btn btn-small btn-info no-radius">Load Uraian</button>
        <table class="table table-bordered geo-table table-hover" width="100%">
            <thead>
                <tr>
                    <td width="3%">No</td>
                    <td width="30%">Uraian</td> 
                    <td width="7%">AK</td>
                    <td width="15%">Output</td>
                    <td width="15%">Mutu</td>
                    <td width="15%">Waktu</td>
                    <td width="15%">Biaya</td>
                </tr>
            </thead>
            <tbody >

            </tbody>
        </table>    
    </div>
</div>
</div>
