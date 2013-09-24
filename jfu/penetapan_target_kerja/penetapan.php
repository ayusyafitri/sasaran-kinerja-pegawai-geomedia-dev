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
<div class="page-header position-relative" id="page-content">

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
        <select id="pilihPeg">
            <option value="0">-Pilih Pegawai-</option>
            <?php
            foreach ($jabStaf as $staf) {
                $dtPeg = get_data("SELECT * FROM skp_pns where kode_jabatan = '" . $staf['kode_jabatan'] . "'");
                echo "<option value='" . $dtPeg['id_pns'] . "'>" . $dtPeg['nama'] . "</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary btn-small" style='margin-top: -10px;'id="findPeg"><i class="icon-search"></i>&nbsp;Cari</button>&nbsp;&nbsp;<span id='loadSc' class=''></span>
        <div id='msgTbl' class='pull-right' ></div>
        <form id="foTargetKerja">
            <input type='hidden' name='act' id="act" value ='confirmed' />
            <table class="table table-striped table-bordered table-hover geo-table" id='tblKerja'style="width:100%">
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
                <tbody id="tKerja">

                </tbody>
            </table>
        </form>
    </div>
    <div class=" position-relative pull-right" id="page-content">
        <span id="loadSave"></span>&nbsp;&nbsp;<span id='msgAl'></span>
        <button class="btn btn-small btn-primary no-radius btn-danger" id="reconfirm"><i class="icon-refresh"></i>Batal Konfirmasi</button>
        <button class="btn btn-small btn-primary no-radius" id="confirm"><i class="icon-save"></i>Konfirmasi Target</button>
    </div>
</div>

<script type="text/javascript">    
    var urls = 'jfu/penetapan_target_kerja/penetapan_.php';
    function edtRow(a) {
        var d = a.id.split('_');
        $('.row_edt').each(function() {
            var a = $(this).attr('id');
            var on = a.replace('tr', '');
            cancel(on);
        });
        $('#uraian_' + d[1]).replaceWith(function() {
            return $('<textarea />', {html: $(this).html(), id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#output_' + d[1]).replaceWith(function() {
            return $('<input>', {type: 'text', value: $(this).html(), class: 'input-small', id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });

        $('#ak_' + d[1]).replaceWith(function() {
            return $('<input>', {type: 'text', value: $(this).html(), class: 'input-small', id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });

        $('#mutu_' + d[1]).replaceWith(function() {
            return $('<input>', {type: 'text', value: $(this).html(), class: 'input-small', id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#waktu_' + d[1]).replaceWith(function() {
            return $('<input>', {type: 'text', value: $(this).html(), class: 'input-small', id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#biaya_' + d[1]).replaceWith(function() {
            return $('<input>', {type: 'text', value: $(this).html(), class: 'input-small', id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $(a).addClass('hide');
        $('#btn-act_' + d[1]).removeClass('hide');
        $('#tr' + d[1]).addClass('row_edt');
    }

    function cancel(a) {
        console.log('tes : ' + a);
        $('#uraian_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).html(), id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#ak_' + a).replaceWith(function() {
            return $('<label />', {type: 'text', value: $(this).html(), class: 'input-small', id: $(this).attr('id'), name: $(this).attr('name'), style: $(this).attr('style')});
        });
        $('#output_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).val(), id: $(this).attr('id'), name: $(this).attr('name')});
        });
        $('#mutu_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).val(), id: $(this).attr('id'), name: $(this).attr('name')});
        });
        $('#waktu_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).val(), id: $(this).attr('id'), name: $(this).attr('name')});
        });
        $('#biaya_' + a).replaceWith(function() {
            return $('<label />', {html: $(this).val(), id: $(this).attr('id'), name: $(this).attr('name')});
        });
        $("[name='ed_" + a + "']").removeClass('hide');
        console.log('#btn-act_' + a);
        $('#btn-act_' + a).addClass('hide');
        $('#tr' + a).removeClass('row_edt');
    }

    function edtRow1(a) {
        var d = a.id.split('_');
        var ms = $('#msgTbl');
        var msL = $('#msgEd_' + d[1]);
        msL.addClass('icon-spinner icon-spin');
        if (d[0] === 'sm') {
            var post = $.post(urls, {act: 'edtData', ur: $('#uraian_' + d[1]).val(), ak: $('#ak_' + d[1]).val(), out: $('#output_' + d[1]).val(),
                mt: $('#mutu_' + d[1]).val(), di: d[2], wkt: $('#waktu_' + d[1]).val(), by: $('#biaya_' + d[1]).val(), tpk: $('#tupoksi_' + d[1]).val(), nour: $('#nouraian_' + d[1]).val()
            });
            post.done(function(res) {
                var sp = res.split('___');
                if (sp[0] == '3') {
                    ms.addClass('alert alert-success');
                    ms.html("<font color='green'>" + sp[1] + "</font>");
                    setTimeout(function() {
                        console.log('ok : ' + d[1]);
                        cancel(d[1]);
                        var dt = sp[2].split('|||');
                        $('#uraian_' + d[1]).html(dt[0]);
                        $('#ak_' + d[1]).html(dt[1]);
                        $('#output_' + d[1]).html(dt[2]);
                        $('#mutu_' + d[1]).html(dt[3]);
                        $('#waktu_' + d[1]).html(dt[4]);
                        $('#biaya_' + d[1]).html(dt[5]);
                    }, 1350);
                } else if (sp[0] == '1') {
                    ms.addClass('alert alert-error');
                    ms.html("<font color='red'>" + sp[1] + "</font>");
                } else {
                    ms.addClass('alert alert-error');
                    ms.html("<font color='red' >Erorr in system !!</font>");
                }
            });
        } else {
            ms.addClass('alert alert-error');
            ms.html('Terdapat Kesalahan merubah data !!');
        }
        setTimeout(function() {
            ms.removeClass();
            ms.addClass('pull-right')
            ms.html('');
            msL.removeClass('icon-spinner icon-spin');
        }, 1650);
    }

    $('#confirm').click(function() {
        $('#act').val('confirmed');
        var f = $('#foTargetKerja');
        var d = f.serializeArray();
        var thn = {'name': 'thn', 'value': $('#tahun').val()};
        var peg = {'name': 'idPeg', 'value': $('#pilihPeg').val()};
        d.push(thn);
        d.push(peg);
        console.log(d);
        var pst = $.post(urls, d);
        var ld = $('#loadSave');
        var ms = $('#msgAl');
        ld.addClass('icon-spin icon-spinner');
        pst.done(function(ser) {
            var sp = ser.split('___');
            if (sp[0] == '2') {
                ms.html(sp[1] + "&nbsp;&nbsp;");
                $('#tblKerja').html(sp[2]);
            } else if (sp[0] == '5') {
                ms.html(sp[1] + "&nbsp;&nbsp;");
            } else {
                ms.html("<font color='red'>Error in parameter !!!</font>")
            }

            setTimeout(function() {
                ld.removeClass('icon-spin icon-spinner');
                ms.html('');
            }, 1700);
        });
    });

    $('#reconfirm').click(function() {
        $('#act').val('reconfirm');
        var f = $('#foTargetKerja');
        var dt = f.serializeArray();
        var thn = {'name': 'thn', 'value': $('#tahun').val()};
        var peg = {'name': 'idPeg', 'value': $('#pilihPeg').val()};
        dt.push(thn);
        dt.push(peg);
        console.log(dt);
        var pst = $.post(urls, dt);
        var ld = $('#loadSave');
        var ms = $('#msgAl');
        ld.addClass('icon-spin icon-spinner');
        pst.done(function(ser) {
            var sp = ser.split('___');
            if (sp[0] == '2') {
                ms.html(sp[1] + "&nbsp;&nbsp;");
                $('#tblKerja').html(sp[2]);
            } else if (sp[0] == '5') {
                ms.html(sp[1] + "&nbsp;&nbsp;");
            } else {
                ms.html("<font color='red'>Error in parameter !!!</font>")
            }

            setTimeout(function() {
                ld.removeClass('icon-spin icon-spinner');
                ms.html('');
            }, 1700);
        });
    });

    $('#findPeg').click(function() {
        var ld = $('#loadSc');
        var y = $('#tahun').val();
        var peg = $('#pilihPeg').val();
        if (y !== '0' && peg !== '0') {
            ld.addClass('icon-spin icon-spinner');
            var pst = $.post(urls, {act: 'ldTarget', th: y, pg: peg});
            pst.done(function(sre) {
                $('#tblKerja').html(sre);
            });
        } else {
            ld.html("<font color='red'>Pilih Tahun dan Pegawai terlebih dahulu !!</font>");
        }
        setTimeout(function() {
            ld.removeClass('icon-spin icon-spinner');
            ld.html('');
        }, 1300);
    });
    $('#loadUraian').click(function() {
        var ld = $('#load');
        ld.addClass('loading');
        var tbl = $('#rlTabel');
        var post = $.post(urls, {act: 'LdUraian'});
        post.done(function(ser) {
            tbl.html(ser);
        });
    });
    $('#tgsTambahan').click(function() {
        var ld = $('#load');
        ld.addClass('spinner');
    });
</script>
