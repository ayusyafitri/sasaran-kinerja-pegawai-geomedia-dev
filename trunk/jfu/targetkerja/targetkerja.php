<?php
@session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$tkerja = get_datas("SELECT * FROM skp_t_kerja where tahun = '" . date('Y') . "' and kode_jabatan = '" . SKP_KODEJAB . "'");
$nmJabatan = get_data("SELECT nama_jabatan FROM skp_jabatan where kode_jabatan = '" . SKP_KODEJAB . "'");
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Target Kerja Per Tahun</h5>
</div>
<div class="page-header position-relative" id="page-content">
    <div id="msgAll" class="pull-right"></div>
    <?php
    echo SKP_KODEJAB . " // " . SKP_ID;
    if (count($tkerja) > 0) {
        if (SKP_JNSJAB == 'Jabatan Struktural') {
            ?>
            <button class="btn btn-small btn-info no-radius" id="loadUraian"><i class="icon-upload-alt"></i>Load Uraian</button>
            <?php
        } else {
            $kinerjaJfu_awal = get_datas("SELECT u.uraian,u.no_uraian,u.tupoksi,k.angka_kredit,k.output, k.mutu,k.waktu,k.biaya,k.id_tkerja FROM skp_t_kerja k, skp_uraian u 
where k.id_uraian = u.id_uraian and k.tahun = '" . date('Y') . "' and k.id_pns = '" . SKP_ID . "' and k.kode_jabatan = '" . SKP_KODEJAB . "' order by u.no_uraian ASC");
        }
    } else {
        if (SKP_JNSJAB == 'Jabatan Struktural') {
            ?>
            <button class="btn btn-small btn-info no-radius" id="plusUraian"><i class="icon-plus-sign"></i>Tambah Uraian</button>
            <?php
        } else {
            $kinerjaJfu_awal = get_datas("SELECT u.uraian, u.no_uraian,u.tupoksi FROM skp_bkn_uraian u, skp_bkn_jabatan j 
   where j.nama_jabatan LIKE '%" . $nmJabatan['nama_jabatan'] . "%' and u.kode_jabatan = j.kode_jabatan order by u.no_uraian ASC");
        }
    }
    ?>
    &nbsp;<span id="load">&nbsp;</span>
</div>
<div class="row-fluid clearfix" >
    <div id="page-content">
        <form id="foTargetKerja">
           <input type="hidden" name="act" value="saveTgt" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" rowspan="2" style="width:3%;">No</th>
                        <th class="center" rowspan="2" style="width:50%">Uraian</th> 
                        <?php if (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') { ?>
                            <th class="center" rowspan="2" style="width:7%">AK</th>
                        <?php } ?>
                        <th class="center" colspan="4" style="width:32%">Target</th>
                        <?php if (count($tkerja) > 0) { ?>
                            <th class="center" rowspan="2" style="width:8%">aksi</th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th style="width:8%">Output</th>
                        <th style="width:8%">Mutu</th>
                        <th style="width:8%">Waktu</th>
                        <th style="width:8%">Biaya</th> 
                    </tr>
                    <?php
                    if (count($kinerjaJfu_awal) > 0) {
                        $no = 1;
                        foreach ($kinerjaJfu_awal as $isiData) {
                            ?>
                            <tr id="tr<?php echo $no; ?>"><td align="center" valign="middle" style="width:3%;"><?php echo $no; ?> </td>
                                <td align="center" style="width:58%;"><textarea style="width: 100%;" id="uraian_<?php echo $no; ?>"name="uraian[]"><?php echo ucfirst($isiData['uraian']); ?></textarea></td> 
                                <?php if (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') { ?>
                                    <td style="width:8%;"><input class="input-small" type="text" id="ak_<?php echo $no; ?>"name="ak[]" value="<?php echo $isiData['angka_kredit'] ?>" /></td>
                                <?php } ?>
                                <td style="width:8%;"><input id="output_<?php echo $no; ?>" class="input-small" type="text" name="output[]" value="<?php echo $isiData['output']; ?>" /></td>
                                <td style="width:8%;"><input id="mutu_<?php echo $no; ?>" class="input-small" type="text" name="mutu[]" value="<?php echo $isiData['mutu']; ?>" /></td>
                                <td style="width:8%;"><input id="waktu_<?php echo $no; ?>" class="input-small" type="text" name="waktu[]" value="<?php echo $isiData['waktu']; ?>" /></td>
                                <td style="width:8%;"><input id="biaya_<?php echo $no; ?>" class="input-small" type="text" name="biaya[]" value="<?php echo $isiData['biaya']; ?>" />
                                    <input type="hidden" id="tupoksi_<?php echo $no; ?>" name="tupoksi[]" value="<?php echo $isiData['tupoksi']; ?>" />
                                    <input type="hidden" id="nouraian_<?php echo $no; ?>"name="nouraian[]" value="<?php echo $isiData['no_uraian']; ?>" />
                                </td>
                                <?php if (count($tkerja) > 0) { ?>
                                    <td style="text-align:center;">                                   
                                        <span id="msgEd_<?php echo $no; ?>"></span><span style='cursor:pointer;' class='badge badge-user center' onclick="edtRow(this)" title="ubah" id="ed_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-pencil"></i></span>
                                        <!--<span style='cursor:pointer;' class='badge badge-important remRow center' name='r<?php echo $no; ?>' title='Hapus' ><i class='icon-remove'></i></span>-->
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                            $no++;
                        }
                    }
                    ?>
                </thead>
                <tbody id="rlTabel">                 
                </tbody>
            </table>
        </form>
    </div>
    <?php if (count($tkerja) <= 0) { ?>
        <div class=" position-relative pull-right" id="page-content">
            <span id="loadS"></span><span id="msgS"></span><button class="btn btn-small btn-primary no-radius" id="tgtSave"><i class="icon-save"></i>Simpan</button>
            &nbsp;<span id="load" ></span>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">

    var urls = 'jfu/targetkerja/targetKerja__.php';

    function edtRow(a) {
        var d = a.id.split('_');
        var ms = $('#msgAll');
        var msL = $('#msgEd_' + d[1]);                
        msL.addClass('icon-spinner icon-spin');
        if (d[0] === 'ed') {
            var post = $.post(urls, {act: 'rbTgt', ur: $('#uraian_' + d[1]).html(), ak: $('#ak_' + d[1]).val(), out: $('#output_' + d[1]).val(),
                mt: $('#mutu_' + d[1]).val(), di: d[2], wkt: $('#waktu_' + d[1]).val(), by: $('#biaya_' + d[1]).val(), tpk: $('#tupoksi_' + d[1]).val(), nour: $('#nouraian_' + d[1]).val()
            });
            post.done(function(res) {
                var sp = res.split('___');
                if (sp[0] == '3') {
                    ms.html("<font color='green'>" + sp[1] + "</font>");
                } else if (sp[0] == '1') {
                    ms.html("<font color='red'>" + sp[1] + "</font>");
                } else {
                    ms.html("<font color='red' >Eror in system !!</font>");
                }
            });
        } else {
            ms.addClass('alert alert-error');
            ms.html('Terdapat Kesalahan merubah data !!');
        }
        setTimeout(function() {
            ms.removeClass();
            ms.html('');
            msL.removeClass('icon-spinner icon-spin');
        }, 2000);
    }
    
    $('#loadUraian').click(function() {
        var ld = $('#load');
        ld.addClass('icon-spinner icon-spin');
        var tbl = $('#rlTabel');
        var post = $.post(urls, {act: 'LdUraian'});
        post.done(function(ser) {
            setTimeout(function() {
                ld.removeClass('icon-spinner');
                ld.removeClass('icon-spin');
                tbl.html(ser);
            }, 1500);
        });
    });
    
    $('#plusUraian').click(function() {
        var tbl = $('#rlTabel');
        var lenth = tbl.children().length;
        console.log(lenth);
        lenth = lenth + 1;
        tbl.append("<tr id='tr" + lenth + "'><td style='text-align:center;'>#</td><td><textarea style='width:100%;'></textarea></td><td style='width:8%;'><input class='input-small' type='text' name='ak[]' /></td><td style='width:8%;'><input class='input-small' type='text' name='output[]' /></td><td style='width:8%;'><input class='input-small' type='text' name='mutu[]' /></td><td style='width:8%;'><input class='input-small' type='text' name='waktu[]' /></td><td style='width:8%;'><input class='input-small' type='text' name='biaya[]' /></td><td style='text-align:center;'><span style='cursor:pointer;' class='badge badge-important remRow center' name='r" + lenth + "' title='Hapus' ><i class='icon-remove'></i></span></td></tr>");
        removeR();
    });

    $('#tgtSave').click(function() {
        var ms = $('#msgS');
        var form = $('#foTargetKerja');
        $('#loadS').addClass("icon-spinner icon-spin");
        ms.html("&nbsp;&nbsp;<font color='green'>Meyimpan...</font>&nbsp;&nbsp;");
        var dt = form.serializeArray();
        var post = $.post(urls, dt);
        post.done(function(srr) {
            $('#loadS').removeClass('icon-spinner icon-spin');
            var dto = srr.split('___');
            if (dto[0] == '2') {
                ms.html("<font color='green' >" + dto[1] + "&nbsp;&nbsp;&nbsp;&nbsp;</font>")
            } else if (dto[0] == '5') {
                ms.html("<font color='red' >" + dto[1] + "&nbsp;&nbsp;&nbsp;&nbsp;</font>")
            } else {
                ms.html("<font color='red' >No data Found... Error cek paramater&nbsp;&nbsp;&nbsp;&nbsp;</font>")
            }
            setTimeout(function() {
                ms.html('');
            }, 2000);
        });
    });
    $('#tgsTambahan').click(function() {
        var ld = $('#load');
        ld.addClass('icon-spinner');
        ld.addClass('icon-spin');
    });
    removeR();
    function removeR() {
        $('.remRow').click(function() {
            var nm = ($(this).attr('name'));
            var di = nm.replace('r', '');
            console.log(di);
            $('#tr' + di).remove();
        });
    }
</script>
