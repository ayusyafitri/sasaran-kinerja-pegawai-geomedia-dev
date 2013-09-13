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
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%" id="allTable">
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
            <th style="width:8%;text-align: center;">Output</th>
            <th style="width:8%;text-align: center;">Mutu</th>
            <th style="width:8%;text-align: center;">Waktu</th>
            <th style="width:8%;text-align: center;">Biaya</th> 
        </tr>
    </thead>
    <tbody id="rlTabel"> 
        <?php
        if (count($kinerjaJfu_awal) > 0) {
            $no = 1;
            foreach ($kinerjaJfu_awal as $isiData) {
                ?>
                <tr id="tr<?php echo $no; ?>"><td valign="middle" style="width:3%;text-align: center;"><?php echo $no; ?> </td>
                    <td style="width:58%;"><label style="width: 100%;" id="uraian_<?php echo $no; ?>"name="uraian[]"><?php echo ucfirst($isiData['uraian']); ?></label></td> 
                    <?php if (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') { ?>
                        <td style="width:8%;text-align: center;"><label id="ak_<?php echo $no; ?>" name="ak[]" ><?php echo $isiData['angka_kredit']; ?></label></td>
                    <?php } ?>
                    <td style="width:8%;text-align: center;"><label id="output_<?php echo $no; ?>" name="output[]" ><?php echo $isiData['output']; ?></label></td>
                    <td style="width:8%;text-align: center;"><label id="mutu_<?php echo $no; ?>" name="mutu[]" ><?php echo $isiData['mutu']; ?></label></td>
                    <td style="width:8%;text-align: center;"><label id="waktu_<?php echo $no; ?>" name="waktu[]" ><?php echo $isiData['waktu']; ?></label></td>
                    <td style="width:8%;text-align: center;"><label id="biaya_<?php echo $no; ?>" name="biaya[]" ><?php echo $isiData['biaya']; ?></label>
                        <input type="hidden" name="idtkerja[]" value="<?php echo $isiData['id_tkerja']; ?>" />
                        <input type="hidden" id="tupoksi_<?php echo $no; ?>" name="tupoksi[]" value="<?php echo $isiData['tupoksi']; ?>" />
                        <input type="hidden" id="nouraian_<?php echo $no; ?>"name="nouraian[]" value="<?php echo $isiData['no_uraian']; ?>" />
                    </td>
                    <?php if (count($tkerja) > 0) { ?>
                        <td style="text-align:center;">                                   
                            <span style='cursor:pointer;' class='badge badge-user center' onclick="edtRow(this)" title="Ubah" name ="ed_<?php echo $no; ?>" id="ed_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-pencil"></i></span>
                            <div id="btn-act_<?php echo  $no; ?>" style="width:75px;" class="hide">
                            <span id="msgEd_<?php echo $no; ?>"></span>
                            <span style='cursor:pointer;' class='badge badge-info center' onclick="edtRow1(this)" title="Simpan" id="sm_<?php echo $no."_".$isiData['id_tkerja']; ?>"><i class="icon-save"></i></span>
                            <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $no;?>)" title="Cancel" id="ca_<?php echo $no."_".$isiData['id_tkerja']; ?>"><i class="icon-remove"></i></span>
                            </div>
                            
                            <!--<span style='cursor:pointer;' class='badge badge-important remRow center' name='r<?php echo $no; ?>' title='Hapus' ><i class='icon-remove'></i></span>-->
                        </td>
                    <?php } ?>
                </tr>
                <?php
                $no++;
            }
        }
        ?>                       
    </tbody>
            </table>
        </form>
    </div>
    <?php if (count($tkerja) <= 0) { ?>
        <div class=" position-relative pull-right" id="page-content-bottom">
            <span id="loadS"></span><span id="msgS"></span><button class="btn btn-small btn-primary no-radius" id="tgtSave"><i class="icon-save"></i>Simpan</button>
            &nbsp;<span id="load" ></span>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    var urls = 'jfu/targetkerja/targetKerja__.php';

    function edtRow(a){
        var d = a.id.split('_');            
        $('.row_edt').each(function(){
            var a = $(this).attr('id');
            var on = a.replace('tr','');
            cancel(on);
        });
        $('#uraian_'+d[1]).replaceWith(function(){
            return $('<textarea />',{html:$(this).html(), id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        $('#output_'+d[1]).replaceWith(function(){
            return $('<input>',{type:'text', value:$(this).html(), class:'input-small',id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        
        $('#ak_'+d[1]).replaceWith(function(){
            return $('<input>',{type:'text', value:$(this).html(), class:'input-small',id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        
        $('#mutu_'+d[1]).replaceWith(function(){
            return $('<input>',{type:'text', value:$(this).html(), class:'input-small',id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        $('#waktu_'+d[1]).replaceWith(function(){
            return $('<input>',{type:'text', value:$(this).html(), class:'input-small',id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        $('#biaya_'+d[1]).replaceWith(function(){
            return $('<input>',{type:'text', value:$(this).html(), class:'input-small',id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        $(a).addClass('hide');
        $('#btn-act_'+d[1]).removeClass('hide');
        $('#tr'+d[1]).addClass('row_edt');
    }
    
    function cancel(a){
        console.log('tes : '+a);       
        $('#uraian_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).html(), id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        $('#ak_'+a).replaceWith(function(){
            return $('<label />',{type:'text', value:$(this).html(), class:'input-small',id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });
        $('#output_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).val(), id:$(this).attr('id'),name:$(this).attr('name')});
        });
        $('#mutu_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).val(), id:$(this).attr('id'),name:$(this).attr('name')});
        });
        $('#waktu_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).val(), id:$(this).attr('id'),name:$(this).attr('name')});
        });
        $('#biaya_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).val(), id:$(this).attr('id'),name:$(this).attr('name')});
        });
        $("[name='ed_"+a+"']").removeClass('hide');
        console.log('#btn-act_'+a);
        $('#btn-act_'+a).addClass('hide');
        $('#tr'+a).removeClass('row_edt');
    }
    
    function edtRow1(a) {
        var d = a.id.split('_');
        var ms = $('#msgAll');
        var msL = $('#msgEd_' + d[1]);                
        msL.addClass('icon-spinner icon-spin');
        if (d[0] === 'sm') {
            var post = $.post(urls, {act: 'rbTgt', ur: $('#uraian_' + d[1]).val(), ak: $('#ak_' + d[1]).val(), out: $('#output_' + d[1]).val(),
                mt: $('#mutu_' + d[1]).val(), di: d[2], wkt: $('#waktu_' + d[1]).val(), by: $('#biaya_' + d[1]).val(), tpk: $('#tupoksi_' + d[1]).val(), nour: $('#nouraian_' + d[1]).val()
            });
            post.done(function(res) {
                var sp = res.split('___');                
                if (sp[0] == '3') {
                    ms.addClass('alert alert-success');
                    ms.html("<font color='green'>" + sp[1] + "</font>");
                    setTimeout(function(){  
                        console.log('ok : '+d[1]);
                        cancel(d[1]);
                        var dt = sp[2].split('|||');
                        $('#uraian_'+d[1]).html(dt[0]);$('#ak_'+d[1]).html(dt[1]);$('#output_'+d[1]).html(dt[2]);$('#mutu_'+d[1]).html(dt[3]);$('#waktu_'+d[1]).html(dt[4]);$('#biaya_'+d[1]).html(dt[5]);
                    },1350);
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
                $('#allTable').html(dto[2]);
                setTimeout(function() {
                      ms.html('');
                      $('#page-content-bottom').remove();
                }, 2000);                
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