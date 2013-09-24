<?php
@session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$jabPeg = get_data("SELECT kode_jabatan,parent,unit_organisasi,idjab FROM skp_jabatan where kode_jabatan = '" . SKP_KODEJAB . "'");
$jabStaf = get_datas("SELECT * FROM skp_jabatan where parent = '" . $jabPeg['idjab'] . "'");
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Target Kerja Per Tahun</h5>
</div>
<div class="row-fluid clearfix" >
    <div id="page-content">
        <select class="input-medium" id="tahun">
            <option value="0">--Pilih Tahun--</option>
            <?php
            $y = date('Y');
            while ($y >= 2012) {
                $sel = ($y == date('Y')) ? 'selected' : '';
                echo "<option value='$y' $sel>$y</option>";
                $y--;
            }
            ?>
        </select>        
        <select id="pilihPeg" name="pilihPeg" title='Pilih Pegawai untuk mencari'>
            <option value="0">-Pilih Pegawai-</option>
            <?php
            foreach ($jabStaf as $staf) {
                $dtPeg = get_data("SELECT * FROM skp_pns where kode_jabatan = '" . $staf['kode_jabatan'] . "'");
                echo "<option value='" . $dtPeg['id_pns'] . "'>" . $dtPeg['nama'] . "</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary btn-small" style='margin-top: -10px;' id="findP"><i class="icon-search"></i>&nbsp;Cari</button>&nbsp;&nbsp;<span id='loadSc' class=''></span>
    </div>
    <div class="page-header position-relative" id="page-content">
        <div class="span12">I. Tugas Pokok</div>
    </div>
    <div id="page-content">            
        <form id="foRealisasi">
            <input type="hidden" name="act" value="realss" />            
            <table class="table table-bordered geo-table table-hover" width="100%">
                <thead>
                    <tr>
                        <th class="center"  valign="middle"rowspan="2" width="3%">No</th>
                        <th class="center" rowspan="2" width="48%">Uraian</th> 
                        <th class="center" rowspan="2" width="4%">AK</th>
                        <th colspan="4" class="center"  width="40%">Realisasi</th>
                        <th rowspan="2" class="center" width="4%">Perhitungan</th>
                        <th rowspan="2" class="center" width="4%">Nilai Capaian</th>
                        <th class="center" rowspan="2" width="8%">Aksi</th>
                    </tr>
                    <tr>
                        <th class="center">Output</th>
                        <th class="center">Mutu</th>
                        <th class="center">Waktu</th>
                        <th class="center">Biaya</th> 
                    </tr>                    
                </thead>
                <tbody id="tblRealisasi">
                    <!--Isi table realisasi-->
                </tbody>
            </table>                
        </form>
        <div class="position-relative pull-right">
            <span id="loadtgs" class=""></span>&nbsp;&nbsp;&nbsp;<span id="msgtgs"></span>&nbsp;&nbsp;
            <button class="btn btn-small btn-primary no-radius" id="b-smpantgs"><i class="icon-save"></i>Simpan</button>
        </div>
    </div><br />

    <!--tugas tambahan-->
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> II. Tugas Tambahan</div>

    </div>
    <div id="page-content">
        <form id="foTambahan">
            <input type="hidden" name="act" value="tmbhn" />
            <input type="hidden" id="skp_d" name="skp_d" value="<?php echo $idSkp['id_skp']; ?>" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:4%;">NO</th>
                        <th class="center" style="width:76%">URAIAN TAMBAHAN</th> 

                        <th class="center" style="width:20%">AKSI</th> 
                    </tr>
                </thead>
                <tbody id="isitgsTmbhn">
                    <!--                    Isi table tugas tambahana-->
                </tbody>
            </table>
        </form>
<!--        <div class="position-relative pull-right">
            <span id="loadtm" class=""></span>&nbsp;&nbsp;&nbsp;<span id="msgtm"></span>&nbsp;&nbsp;
            <button class="btn btn-small btn-primary no-radius" id="b-smpantm"><i class="icon-save"></i>Simpan</button>
        </div>-->
    </div><br />
    <!--kreatifitas-->
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> III. KREATIVITAS</div>
<!--        <button class="btn btn-small btn-primary no-radius" id="btn-tgsKreatf"><i class="icon-plus-sign-alt"></i>Tambah Kreatifitas</button>
        &nbsp;<span id="loadT" class="spinner"></span>-->
    </div>
    <div id="page-content">
        <form id="foKreativitas">
            <input type="hidden" name="act" value="krea" />
            <input type="hidden" id="skpIdKre" name="skpIdKre" value="<?php echo $idSkp['id_skp']; ?>" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:4%;">No</th>
                        <th class="center" style="width:76%">URAIAN KREATIFITAS</th> 

                        <th class="center" style="width:20%">AKSI</th> 
                    </tr>
                </thead>
                <tbody id="isikreatif">
                    <!--                    Isi table penilaian kreatif-->
                </tbody>
            </table>
        </form>
    </div>   
    <div class=" position-relative pull-right" id="page-content">
        <span id="loadkre" class=""></span>&nbsp;&nbsp;&nbsp;<span id="msgkre"></span>&nbsp;&nbsp;
        <button class="btn btn-small btn-primary no-radius" id="b-smpankre"><i class="icon-save"></i>Simpan</button>       
    </div>
</div>
<script  type="text/javascript">
    (function($) {
        $.fn.attributesToArray = function(attrs) {
            var t = $(this);
            if (attrs) {
                t.each(function(i, e) { // set Attributes
                    var j = $(e);
                    for (var attr in attrs) {
                        j.attr(attr, attrs[attr]);
                    }
                    ;
                });
                return t;
            } else {//Get attributes
                var a = {}, r = t.get(0);
                if (r) {
                    r = r.attributes;
                    for (var i in r) {
                        var p = r[i];
                        if (typeof p.nodeValue !== 'undefined')
                            a[p.nodeName] = p.nodeValue;
                    }
                }
                return a;
            }
        };
    })(jQuery);
    var rls = 'jfu/penilaian/penilaian_.php';

    function sveTP(a) {
        var ar = {};
        ar['out'] = $('#outputTP_' + a).val(), ar['mut'] = $('#mutuTP_' + a).val();
        ar['wkt'] = $('#waktuTP_' + a).val(), ar['ak'] = $('#ak_' + a).val();
        ar['bya'] = $('#biayaTP_' + a).val(), ar['act'] = 'saveTP', ar['idtgt'] = $('#trgtid_' + a).val(), ar['realsid'] = $('#realssid_' + a).val();
        console.log(ar);
        var ms = $('#msgEd_' + a);
        ms.addClass('icon-spin icon-spinner');
        var pst = $.post(rls, ar);
        var row = $('#rTP_' + a);
        pst.done(function(rs) {
            var spt = rs.split('___');
            if (spt[0] === '5') {
                var nl = spt[1].split('|||');
                ms.removeClass('icon-spin icon-spinner');
                ms.html("<i class='icon-ok'></i>");
                setTimeout(function(){cancelTP (a);
                $('#ouputTP_' + a).html(nl[0]);
                $('#mutuTP_' + a).html(nl[1]);
                $('#waktuTP_' + a).html(nl[2]);
                $('#biayaTP_' + a).html(nl[3]);},1200);
            } else if (spt[0] === '2') {
                ms.removeClass('icon-spin icon-spinner');
                ms.html("<i class='icon-exclamation'></i>'");
            }
            setTimeout(function() {
                ms.removeClass('');
                ms.html('');               
            },1700);
        });
    }

    function cancelTP(a) {
        $('#outputTP_' + a).replaceWith(function() {
            var arCom = $(this).attributesToArray();
            arCom['html'] = $(this).val();
            return $('<label />', arCom);
        });
        $('#mutuTP_' + a).replaceWith(function() {
            var arCom = $(this).attributesToArray();
            arCom['html'] = $(this).val();
            return $('<label />', arCom);
        });
        $('#waktuTP_' + a).replaceWith(function() {
            var arCom = $(this).attributesToArray();
            arCom['html'] = $(this).val();
            return $('<label />', arCom);
        });
        $('#biayaTP_' + a).replaceWith(function() {
            var arCom = $(this).attributesToArray();
            arCom['html'] = $(this).val();
            return $('<label />', arCom);
        });
        $("#btn-actTP_" + a).addClass('hide');
        $('#edTP_' + a).removeClass('hide');
        $('#rTP_' + a).removeClass('rTP_edt');
    }

    function edtRowTP(a) {
        var dt = a.id.split('_');
        if (dt[0] == 'edTP') {
            $('.rTP_edt').each(function() {
                var a = $(this).attr('id');
                var on = a.split('_');
                cancelTP(on[1]);
            });
            $('#outputTP_' + dt[1]).replaceWith(function() {
                var arCom = $(this).attributesToArray();
                arCom['type'] = 'text';
                arCom['value'] = $(this).html();
                return $('<input />', arCom);
            });
            $('#mutuTP_' + dt[1]).replaceWith(function() {
                var arCom = $(this).attributesToArray();
                arCom['type'] = 'text';
                arCom['value'] = $(this).html();
                return $('<input />', arCom);
            });
            $('#waktuTP_' + dt[1]).replaceWith(function() {
                var arCom = $(this).attributesToArray();
                arCom['type'] = 'text';
                arCom['value'] = $(this).html();
                return $('<input />', arCom);
            });
            $('#biayaTP_' + dt[1]).replaceWith(function() {
                var arCom = $(this).attributesToArray();
                arCom['type'] = 'text';
                arCom['value'] = $(this).html();
                return $('<input />', arCom);
            });
            $("#btn-actTP_" + dt[1]).removeClass('hide');
            $('#edTP_' + dt[1]).addClass('hide');
            $('#rTP_' + dt[1]).addClass('rTP_edt');
        }
    }

    $('#findP').click(function() {
        var p = $('#pilihPeg').val();
        var y = $('#tahun').val();
        var ld = $('#loadSc');
        if (p === '0' || y === '0') {
            ld.html("<font color='red'>Pilih Tahun dan Pegawai terlebih dahulu !!</font>");
        } else {
            ld.addClass('icon-spin icon-spinner');
            var pst = $.post(rls, {act: 'ldUraian', th: y, pg: p});
            pst.done(function(sre) {
                var dt = sre.split('___');
                if (dt[0] === '2') {
                    $('#tblRealisasi').html(dt[1]);
                    $('#isitgsTmbhn').html(dt[2]);
                    $('#isikreatif').html(dt[3]);
                } else if (dt[0] === '5') {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html(dt[1]);
                } else {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html("<font color='red'>Error In Paramater !!</font>");
                }
            });
        }
        setTimeout(function() {
            ld.removeClass('icon-spin icon-spinner');
            ld.html('');
        }, 1500);
    });
</script>
