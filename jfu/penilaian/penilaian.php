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

</div>
<div class="row-fluid clearfix" >
    <div id="page-content">
        <select>
            <option>-Nama Pegawai-</option>
        </select>
        <form id="foTargetKerja">
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" rowspan="2" style="width:3%;">No</th>
                        <th class="center" rowspan="2" style="width:50%">Uraian</th> 
                        <th class="center" rowspan="2" style="width:7%">AK</th>
                        <th class="center" colspan="4" style="width:32%">Target</th>
                        <th class="center" rowspan="2" style="width:8%">aksi</th>
                    </tr>
                    <tr>
                        <th style="width:8%">Output</th>
                        <th style="width:8%">Mutu</th>
                        <th style="width:8%">Waktu</th>
                        <th style="width:8%">Biaya</th> 
                    </tr>
                </thead>
                <tbody >
                    <tr>
                        <td valign="middle" align="center" style="width:3%;">1 </td>
                        <td align="center" style="width:58%;">Membantu instansi lain untuk teknis pertanian, perkebunan dan kehutanan</td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        
                    </tr>
                    <tr>
                        <td valign="middle" align="center" style="width:3%;">2 </td>
                        <td align="center" style="width:58%;">Merekap hasil perkembangan data dalam bentuk laporan</td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        
                    </tr>
                    <tr>
                        <td valign="middle" align="center" style="width:3%;">3 </td>
                        <td align="center" style="width:58%;">Melakukan pembinaan teknis ke petani</td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        
                    </tr>
                    <tr>
                        <td valign="middle" align="center" style="width:3%;">4 </td>
                        <td align="center" style="width:58%;">Mendata perkembangan luas tanam, luas panen, produktvitas,produksi, harga jual petani untuk komoditi tanaman pangan dan holtikultura</td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        <td>
                            <input type="text" class="input-small"></input>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class=" position-relative pull-right" id="page-content">
        <button class="btn btn-small btn-primary no-radius" id=""><i class="icon-save"></i>Simpan</button>
        &nbsp;<span id="load" class="spinner"></span>
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
