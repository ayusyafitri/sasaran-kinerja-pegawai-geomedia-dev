<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Laporan</h5>
</div>
<div class=" position-relative" id="page-content">
    <!--<button class="btn btn-small btn-primary no-radius" id=""><i class="icon-print"></i>Cetak</button>-->
    <button class="btn btn-small btn-danger no-radius" id=""><i class="icon-eject"></i>Pengajuan Keberatan Penilaian</button>
    &nbsp;<span id="load" class="spinner"></span>
</div>
<div class="row-fluid clearfix" >
    <div id="page-content">
        <form id="foTargetKerja">
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:2%;">NO</th>
                        <th class="center" valign="middle" style="width:20%;">NAMA</th>
                        <th class="center" valign="middle" style="width:60%;">KETERANGAN</th>
                        <th class="center" valign="middle" style="width:18%;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td valign="middle" align="center">1</td>
                        <td align="center">Lampiran I-a</td>
                        <td>Formulir Sasaran Kinerja Pegawai Negeri Sipil</td>
                        <td class="center"><a href="jfu/laporan/Ia.php" target="_blank" class="btn btn-small btn-primary"><i class="icon-print"></i>Lihat Laporan</a></td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">2</td>
                        <td align="center">Lampiran I-c</td>
                        <td>Formulir Surat Keterangan Melaksanakan Tugas Tambahan</td>
                        <td class="center"><a href="jfu/laporan/Ic.php" target="_blank" class="btn btn-small btn-primary"><i class="icon-print"></i>Lihat Laporan</a></td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">3</td>
                        <td align="center">Lampiran I-d</td>
                        <td>Formulir Surat Keterangan Melakukan Sesuatu Yang Baru</td>
                        <td class="center"><a href="jfu/laporan/Id.php" target="_blank" class="btn btn-small btn-primary"><i class="icon-print"></i>Lihat Laporan</a></td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">4</td>
                        <td align="center">Lampiran I-e</td>
                        <td>Formulir Penilaian Sasaran Kinerja Pegawai Negeri Sipil</td>
                       <td class="center"><a href="jfu/laporan/Ie.php" target="_blank" class="btn btn-small btn-primary"><i class="icon-print"></i>Lihat Laporan</a></td>
                    </tr>
                    <tr>
                        <td valign="middle" align="center">4</td>
                        <td align="center">Lampiran I-g</td>
                        <td>Formulir Penilaian Prestasi Kerja Pegawai Negeri Sipil</td>
                        <td class="center"><a href="jfu/laporan/Ig.php" target="_blank" class="btn btn-small btn-primary"><i class="icon-print"></i>Lihat Laporan</a></td>
                    </tr>
                     <tr>
                        <td valign="middle" align="center">5</td>
                        <td align="center">Lampiran I-i</td>
                        <td>Buku Penilaian Perilaku Kerja Pegawai Negeri Sipil</td>
                        <td class="center"><a href="jfu/laporan/Ii.php" target="_blank" class="btn btn-small btn-primary"><i class="icon-print"></i>Lihat Laporan</a></td>
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
