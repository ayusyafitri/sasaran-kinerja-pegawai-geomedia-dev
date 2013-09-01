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
    <button class="btn btn-small btn-danger no-radius" id=""><i class="icon-eject"></i>Pengajuan Keberatan Penilaian</button>
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
                    <tr>
                        <td valign="middle" align="center">1 </td>
                        <td align="center">Melaksanakan kegiatan pemberdayaan masyarakat, pelayanan umum terhadap masyarakat dan menyelenggarakan ketentraman umum, pemeliharaan prasarana dan fasilitas pelayanan umum serta pembinaan lembaga kemasyarakatan.</td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">2 </td>
                        <td align="center">Melaksanakan pelaporan kegiatan tugas secara periodik dan tepat waktu kepada Kepala Daerah melalui Camat.</td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">3 </td>
                        <td align="center">Melaksanakan Koordinasi terhadap jalannya Pemerintahan Kelurahan dan Pelaksanaan Pembangunan</td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">4 </td>
                        <td align="center">Melaksanakan kegiatan pemerintahan kelurahan dan melakukan koordinasi dengan Camat dan instansi vertikal yang berada di wilayah kerjanya.</td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>

                    </tr>
                    <tr>
                        <td valign="middle" align="center">-</td>
                        <td align="center" >II. Tugas Tambahan dan Kreativitas/Unsur Penunjang :</td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>

                    </tr>
                    <tr>
                        <td valign="middle" align="center" >10.00</td>
                        <td align="center" >Tugas Tambahan</td>
                        <td>
                            -
                        </td>
                        <td colspan="4" class="center">
                            -
                        </td>
                        
                        <td>
                            -
                        </td>
                        <td colspan="4" class="center">
                            -
                        </td>
                        

                    </tr>
                     <tr>
                        <td valign="middle" align="center" >30.00</td>
                        <td align="center" >Kreativitas</td>
                        <td>
                            -
                        </td>
                        <td colspan="4" class="center">
                            -
                        </td>
                        
                        <td>
                            -
                        </td>
                        <td colspan="4" class="center">
                            -
                        </td>
                        

                    </tr>
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
