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
                        <th class="center" width="2%" valign="middle" rowspan="2">No</th>
                        <th class="center" width="40%" rowspan="2">Uraian</th>
                        <th class="center" width="5%" rowspan="2">AK</th>
                        <th class="center" width="25%" colspan="4">Realisasi</th>
                        <th class="center" width="9%" rowspan="2">Perhitungan</th>
                        <th class="center" width="9%" rowspan="2">Nilai Capaian</th>
                        <th class="center" width="10%" rowspan="2">Aksi</th>
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
        <!--        <div class="position-relative pull-right">
                    <span id="loadtgs" class=""></span>&nbsp;&nbsp;&nbsp;<span id="msgtgs"></span>&nbsp;&nbsp;
                    <button class="btn btn-small btn-primary no-radius" id="b-smpantgs"><i class="icon-save"></i>Simpan</button>
                </div>-->
    </div><br />

    <!--tugas tambahan-->
    <div class="page-header position-relative" id="page-content">       
        <div class="span7"> II. Tugas Tambahan</div><div class="span5" id="msgtm" style="text-align:right"></div>
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
        <div class="span7"> III. KREATIVITAS</div><div class="span5" style="text-align:right">
            <div id="msgkre" style="display: inline;"></div><a data-placement="bottom" title="" class="help" href="#"><i class="icon-question-sign icon-large pull-right" style="color: blue;cursor:default;" ></i></a>
        </div>
    </div>
    <div id="page-content">
        <form id="foKreativitas">
            <input type="hidden" name="act" value="krea" />
            <input type="hidden" id="skpIdKre" name="skpIdKre" value="<?php echo $idSkp['id_skp']; ?>" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:4%;">No</th>
                        <th class="center" style="width:61%">URAIAN KREATIFITAS</th> 
                        <th class="center" style="width:15%">Nilai</th> 
                        <th class="center" style="width:20%">AKSI</th> 
                    </tr>
                </thead>
                <tbody id="isikreatif">
                    <!--                    Isi table penilaian kreatif-->
                </tbody>
            </table>
        </form>
    </div>   
    <div class="position-relative pull-right btnKonfirm hide" id="page-content">
        <span id="loadkre" class=""></span>&nbsp;
        <button class="btn btn-small btn-primary no-radius btn-danger btn-confirm" id="reconfirm"><i class="icon-refresh"></i>Batal Konfirmasi</button>     
        <button class="btn btn-small btn-primary no-radius btn-confirm"  id="confirm"><i class="icon-save"></i>Konfirmasi</button>       
    </div>
</div>

<div class="tooltip" style="display: none;">
    <table style="margin:0">
        <tr>
            <th>No</th>
            <th>Kreativitas</th>
            <th>Nilai</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Apabila hasil yang ditemukan merupakan sesuatu yang baru dan bermanfaat bagi unit kerjanya dan dibuktikan dengan surat keterangan yang ditandatangani oleh kepala unit kerja setingkat eselon II.</td>
            <td>3</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Apabila hasil yang ditemukan merupakan sesuatu yang baru dan bermanfaat bagi organisasinya serta dibuktikan dengan surat keterangan yang ditandatangani oleh PPK.</td>
            <td>6</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Apabila hasil yang ditemukan merupakan sesuatu yang baru dan bermanfaat bagi Negara dengan penghargaan yang diberikan oleh Presiden.</td>
            <td>12</td>
        </tr>
    </table></div>
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
    var nKreatif = [3, 6, 12];
    $('.help').tooltip();
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
                setTimeout(function() {
                    ms.removeClass('icon-spin icon-spinner');
                    ms.html("<i class='icon-ok'></i>");
                }, 2000);
                setTimeout(function() {
                    cancelTP(a);
                    $('#ouputTP_' + a).html(nl[0]);
                    $('#mutuTP_' + a).html(nl[1]);
                    $('#waktuTP_' + a).html(nl[2]);
                    $('#biayaTP_' + a).html(nl[3]);
                    $('#pr_' + a).html(nl[4]);
                    $('#cap_' + a).html(nl[5]);
                }, 1200);
            } else if (spt[0] === '2') {
                ms.removeClass('icon-spin icon-spinner');
                ms.html("<i class='icon-exclamation'></i>'");
            }
            setTimeout(function() {
                ms.removeClass('');
                ms.html('');
            }, 2000);
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

    function edtRow(a) {
        var d = a.id.split('_');
        $('.row_edt').each(function() {
            var a = $(this).attr('id');
            var on = a.split('_');
            cancel(on[2], on[1]);
        });
        $('#uraian_' + d[1] + '_' + d[2]).replaceWith(function() {
            return $('<textarea />', {html: $(this).html(), id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#id_' + d[1] + '_' + d[2]).replaceWith(function() {
            return $('<input />', {value: $(this).html(), type: 'hidden', id: $(this).attr('id'), name: $(this).attr('name')});
        });

        $('#nilai_' + d[1] + '_' + d[2]).replaceWith(function() {
            var nilai = $(this).html();
            var opt = "<option value='0'>--Pilih Nilai--</option>";
            $.each(nKreatif, function(indeks, nama) {
                var se = (nama === nilai) ? 'selected' : '';
                opt += "<option value='" + nama + "' " + se + ">" + nama + "</option>";
            });
            return $('<select />', {html: opt, class: 'input-medium', title: nilai, id: $(this).attr('id'), name: $(this).attr('name')});
        });
        $('#btn_' + d[1] + '_' + d[2]).addClass('hide');
        $('#btnh_' + d[1] + '_' + d[2]).removeClass('hide');
        $('#r_' + d[1] + '_' + d[2]).addClass('row_edt');
    }

    function cancel(a, on) {   //nomer, on =  text
        $('#uraian_' + on + '_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).val(), id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#id_' + on + '_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).val(), class: 'hide', id: $(this).attr('id'), name: $(this).attr('name')});
        });

        $('#nilai_' + on + '_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).attr('title'), class: $(this).attr('class'), id: $(this).attr('id'), name: $(this).attr('name')});
        });
        $("#btn_" + on + '_' + a).removeClass('hide');
        $('#btnh_' + on + '_' + a).addClass('hide');
        $('#r_' + on + '_' + a).removeClass('row_edt');
        console.log('cancel :' + a + '_' + on);
    }

    function simpan(a, on) { //nomer, on =  text
        var d = $('#id_' + on + '_' + a).val();
        var ur = $('#uraian_' + on + '_' + a).val();
        var ld = $('#msgh_' + on + '_' + a);
        var nilai = '';
        if (on === 'kre'){
            nilai = $('#nilai_' + on + '_' + a);
        }
        console.log('#msg_' + on + '_' + a);
        var msg = (on === 'tam') ? $('#msgtm') : $('#msgkre');
        ld.addClass('icon-spin icon-spinner');
        msg.html("<font color='#BFBF07'>Wating response...</font>")
        var dt = {act: 'edtRow', bgian: on, uraian: ur, id: d};
        if(on === 'kre'){
            dt['nlai'] = nilai.val();            
        }
        console.log(dt);
        var pst = $.post(rls, dt);
        pst.done(function(sr) {
            var d = sr.split('___');
            if (d[0] == '4') {
                msg.html(d[1]);                
                setTimeout(function() {
                    cancel(a, on);
                    msg.html('');
                    ld.removeClass('icon-spin icon-spinner');
                    $('#nilai_' + on + '_' + a).html(d[2]);
                }, 1230);
            } else if (d[0] == '1') {
                msg.html(d[1]);
                setTimeout(function() {
                    msg.html('');
                    ld.removeClass('icon-spin icon-spinner');
                }, 1230);
            }
            
        });
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
                    $('.btnKonfirm').removeClass('hide');
                    if (dt[4] === '0') {
                        $('#confirm').removeClass('disabled');
                        $('#reconfirm').addClass('disabled');
                    } else {
                        $('#confirm').addClass('disabled');
                        $('#reconfirm').removeClass('disabled');
                    }
                } else if (dt[0] === '5') {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html(dt[1]);
                    $('.btnKonfirm').addClass('hide');
                } else {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html("<font color='red'>Error In Paramater !!</font>");
                    $('.btnKonfirm').addClass('hide');
                }
            });
        }
        setTimeout(function() {
            ld.removeClass('icon-spin icon-spinner');
            ld.html('');
        }, 1500);
    });
    $('.btn-confirm').click(function() {
        if (!$(this).hasClass('disabled')) {
            var ld = $('#loadkre');
            var doi = ($(this).attr('id') === 'confirm') ? '1' : '0';
            ld.addClass('icon-spin icon-spinner');
            ld.after("&nbsp;&nbsp;<span class='alert' id='tempMsg' style=padding-top:3px;'>Please wait...</span>");
            var peg = $('#pilihPeg');
            var thn = $('#tahun');
            var msg = $('#tempMsg');
            var arryId = new Array();
            $("input[name='realssid[]']").each(function() {
                arryId.push({'name': $(this).attr('name'), 'value': $(this).val()});
            });
            var act = {'name': 'act', 'value': 'sveStatus'}, doii = {'name': 'do', 'value': doi}, peg = {'name': 'Peg', 'value': peg.val()}, th = {'name': 'y', 'value': thn.val()};
            arryId.push(act);
            arryId.push(doii);
            arryId.push(peg);
            arryId.push(th);
            var pst = $.post(rls, arryId);
            pst.done(function(rss) {
                msg.removeClass('alert');
                var news = rss.split('___');
                if (news[0] === '2') {
                    msg.html(news[1]);
                    $('#tblRealisasi').html(news[2]);
                    $('#isitgsTmbhn').html(news[3]);
                    $('#isikreatif').html(news[4]);
                    if (doi == '1') {
                        $('#confirm').addClass('disabled');
                        $('#reconfirm').removeClass('disabled');
                    } else {
                        $('#confirm').removeClass('disabled');
                        $('#reconfirm').addClass('disabled');
                    }
                    setTimeout(function() {
                        ld.removeClass('icon-spin icon-spinner')
                    }, 1200);
                } else if (news[0] === '5') {
                    msg.html(news[1]);
                    $('#confirm').removeClass('disabled');
                    $('#reconfirm').addClass('disabled');
                    setTimeout(function() {
                        ld.removeClass('icon-spin icon-spinner')
                    }, 1200);
                } else {
                    $('#confirm').removeClass('disabled');
                    $('#reconfirm').addClass('disabled');
                    msg.html('Error Paramater in System !!!');
                    setTimeout(function() {
                        ld.removeClass('icon-spin icon-spinner')
                    }, 1200);
                }
                setTimeout(function() {
                    msg.remove();
                }, 1500);
            });
        }
    });
</script>
