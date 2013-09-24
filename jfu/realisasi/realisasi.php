<?php
@session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$idSkp = get_data("SELECT DISTINCT(id_skp) as id_skp FROM skp_t_kerja where kode_jabatan = '" . SKP_KODEJAB . "' and tahun = '" . date('Y') . "'");
$dtaRealisasi = get_datas("SELECT t.id_skp,t.id_tkerja,t.output, t.mutu, t.waktu, t.biaya, u.id_uraian, u.uraian, t.angka_kredit, r.id_realisasi, r.r_output,r.r_mutu,r.r_waktu,r.r_biaya FROM skp_t_kerja t 
INNER JOIN skp_uraian u  ON t.id_uraian = u.id_uraian and t.tahun = '" . date('Y') . "' and t.id_pns = '" . SKP_ID . "' and t.kode_jabatan = '" . SKP_KODEJAB . "'
LEFT OUTER JOIN skp_r_kerja r ON t.id_tkerja = r.id_tkerja order by u.no_uraian ASC");
if (!empty($idSkp['id_skp'])) {
    $dtTmbhan = get_datas("SELECT * FROM skp_r_tambahan where id_skp = '" . $idSkp['id_skp'] . "' order by id_uraian_tambahan asc");
    $krf = get_datas("SELECT * FROM skp_r_kreatifitas where idskp = '" . $idSkp['id_skp'] . "' order by idkreatifitas asc");   
}
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Realisasi Kerja Per Tahun</h5>
</div>
<div class="row-fluid clearfix" >
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
                        <th class="center" rowspan="2" width="50%">Uraian</th> 
                        <th class="center" rowspan="2" width="7%">AK</th>
                        <th colspan="4" class="center"  width="40%">Realisasi</th>
                        <th rowspan="4" class="center" width="40%">Perhitungan</th>
                        <th rowspan="4" class="center" width="40%">Nilai Capaian</th>
                    </tr>
                    <tr>
                        <th class="center" width="10%">Output</th>
                        <th class="center"  width="10%">Mutu</th>
                        <th class="center" width="10%">Waktu</th>
                        <th class="center" width="10%">Biaya</th> 
                    </tr>
                </thead>
                <tbody id="tblRealisasi">
                    <?php
                    if (count($dtaRealisasi) > 0) {
                        $no = 1;
                        foreach ($dtaRealisasi as $isiRealisasi) {
                            $t_output = $isiRealisasi['output'];
                            $t_mutu = $isiRealisasi['mutu'];
                            $t_waktu = $isiRealisasi['waktu'];
                            $t_biaya = $isiRealisasi['biaya'];

                            $r_output = $isiRealisasi['r_output'];
                            $r_mutu = $isiRealisasi['r_mutu'];
                            $r_waktu = $isiRealisasi['r_waktu'];
                            $r_biaya = $isiRealisasi['r_biaya'];
                            $pembagi = 2;
                            $nOutput = (empty($t_output) OR ($t_output <= 0)) ? 0 : ($r_output / $t_output) * 100;
                            $nMutu = (empty($t_mutu) OR ($t_mutu <= 0)) ? 0 : ($r_mutu / $t_mutu) * 100;                            
                            $asWaktu = (empty($t_biaya) OR ($t_waktu <= 0)) ? 0 :100 - ($r_waktu / $t_waktu * 100) ;
                            if($asWaktu > 0){
                                $nWaktu = ($asWaktu <= 24)? ((1.76 * $t_waktu - $r_waktu) / $t_waktu) * 100: 76 - (((1.76 * $t_waktu - $r_waktu)/ $t_waktu * 100) - 100);
                                $pembagi++;
                            }else{
                                $nWaktu = 0;
                            }                            
                            $asBiaya = (empty($t_biaya) OR ($t_biaya <= 0)) ? 0 :100 - ($r_biaya / $t_biaya * 100) ;
                            if($asBiaya > 0){
                                $nBiaya = ($asBiaya <= 24)? ((1.76 * $t_biaya - $r_biaya) / $t_biaya) * 100 : 76 - (((1.76 * $t_biaya - $r_biaya)/ $t_biaya * 100) - 100) ;
                                $pembagi++;
                            }else{
                                $nBiaya = 0;
                            }                                                        
                            $prhtungan = $nOutput + $nMutu + $nWaktu + $nBiaya;                            
                            $nCapaianSKP = $prhtungan / $pembagi;
                            ?>
                            <tr>
                                <td valign="middle" align="center" style="width:3%;"><?php echo $no; ?></td>
                                <td align="center"><?php echo ucfirst($isiRealisasi['uraian']); ?></td>
                                <td>
                                    <label><?php echo $isiRealisasi['angka_kredit']; ?></label>
                                    <input type="hidden" name="trgtid[]" value="<?php echo $isiRealisasi['id_tkerja']; ?>" />
                                    <input type="hidden" name="realssid[]" value="<?php echo $isiRealisasi['id_realisasi']; ?>" />
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="output[]" id="output_<?php echo $no; ?>" value="<?php echo $r_output; ?>" />
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="mutu[]" id="mutu_<?php echo $no; ?>" value="<?php echo $r_mutu; ?>" />
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="waktu[]" id="waktu_<?php echo $no; ?>" value="<?php echo $r_waktu;?>" <?php if($t_waktu == '0') echo "title='Tidak Ada Target' readonly";?> />
                                </td>
                                <td>
                                    <input type="text" class="input-small " name="biaya[]" id="biaya_<?php echo $no ?>" value="<?php echo $r_biaya; ?>" <?php if($t_biaya == '0') echo "title='Tidak Ada Target' readonly";?> />
                                </td>
                                <td class="center">
                                    <?php echo number_format($prhtungan, 2); ?>
                                </td>
                                <td class="center">
                                    <?php echo number_format($nCapaianSKP, 2); ?>
                                </td>
                            </tr>
                            <?php
                            $no++;
                        }
                    }
                    ?>
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
        <button class="btn btn-small btn-primary no-radius" id="btn-tgsTmbhn"><i class="icon-plus-sign-alt"></i>Tugas Tambahan</button>
        &nbsp;<span id="loadT" class="spinner"></span>
    </div>
    <div id="page-content">
        <form id="foTambahan">
            <input type="hidden" name="act" value="tmbhn" />
            <input type="hidden" id="skp_d" name="skp_d" value="<?php echo $idSkp['id_skp'];?>" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:4%;">NO</th>
                        <th class="center" style="width:76%">URAIAN KREATIFITAS</th> 

                        <th class="center" style="width:20%">AKSI</th> 
                    </tr>
                </thead>
                <tbody id="isitgsTmbhn">
                    <?php
                    if (count($dtTmbhan) > 0) {
                        $n = 1;
                        foreach ($dtTmbhan as $isiTmbhn) {
                            ?>
                            <tr id="r_<?php echo 'tam_'.$n; ?>">
                                <td style="width:3%;" align="center" class="center"><?php echo $n;?>
                                    <label id="id_tam_<?php echo $n; ?>" name="idtmbhn[]" class="hide"><?php echo $isiTmbhn['id_uraian_tambahan']; ?></label></td>
                                <td><label style="width: 100%;" id="uraian_tam_<?php echo $n; ?>" name="uraian_tam[]"><?php echo ucfirst($isiTmbhn['uraian_tambahan']); ?></label></td>
                                <td class="center">
                                    <div id="btn_tam_<?php echo $n;?>">
                                         <span id="msg_tam_<?php echo $n; ?>"></span>
                                         <span id="ed_tam_<?php echo $n . "_" . $isiTmbhn['id_uraian_tambahan']; ?>" name="ed_tam_<?php echo $n; ?>" title="Ubah" onclick="edtRow(this)" class="badge badge-user center" 
                                             style="cursor:pointer;"><i class="icon-pencil"></i></span>                                             
                                         <span id="rmtm_<?php echo $n . "_" . $isiTmbhn['id_uraian_tambahan']; ?>" name="rmtm_<?php echo $n; ?>" title="Hapus" class="badge badge-important center rem-dataTam" 
                                             style="cursor:pointer;"><i class="icon-trash"></i></span>
                                    </div>
                                    <div id="btnh_tam_<?php echo $n; ?>" class="hide">
                                        <span id="msgh_tam_<?php echo $n; ?>"></span>
                                        <span style='cursor:pointer;' class='badge badge-info center' onclick="simpan(<?php echo $n.",'tam'"; ?>)" title="Simpan" id="sm_<?php echo $no . "_" . $isiTmbhn['id_uraian_tambahan']; ?>"><i class="icon-save"></i></span>
                                        <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $n.",'tam'"; ?>)" title="Cancel" id="ca_<?php echo $n . "_" . $isiTmbhn['id_uraian_tambahan']; ?>"><i class="icon-remove"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $n++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
        <div class="position-relative pull-right">
            <span id="loadtm" class=""></span>&nbsp;&nbsp;&nbsp;<span id="msgtm"></span>&nbsp;&nbsp;
            <button class="btn btn-small btn-primary no-radius" id="b-smpantm"><i class="icon-save"></i>Simpan</button>
        </div>
    </div><br />

    <!--kreatifitas-->
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> III. KREATIVITAS</div>
        <button class="btn btn-small btn-primary no-radius" id="btn-tgsKreatf"><i class="icon-plus-sign-alt"></i>Tambah Kreatifitas</button>
        &nbsp;<span id="loadT" class="spinner"></span>
    </div>
    <div id="page-content">
        <form id="foKreativitas">
            <input type="hidden" name="act" value="krea" />
            <input type="hidden" id="skpIdKre" name="skpIdKre" value="<?php echo $idSkp['id_skp'];?>" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:4%;">No</th>
                        <th class="center" style="width:76%">URAIAN KREATIFITAS</th> 

                        <th class="center" style="width:20%">AKSI</th> 
                    </tr>
                </thead>
                <tbody id="isikreatif">
                    <?php
                    if (count($krf) > 0) {
                        $no = 1;
                        foreach ($krf as $krfTmbhn) {
                            ?>
                           <tr id="r_<?php echo 'kre_' . $no; ?>">
            <td style="width:3%;" class="center" valign="middle"><?php echo $no; ?><label class="hide" id="id_kre_<?php echo $no; ?>" name="idtmbhn[]"><?php echo $krfTmbhn['idkreatifitas']; ?></label></td>
            <td><label style="width: 100%;" id="uraian_kre_<?php echo $no; ?>" name="uraian_kre[]"><?php echo ucfirst($krfTmbhn['uraiankreatifitas']); ?></label></td>
                    <td class="center">
                        <div id="btn_kre_<?php echo $no; ?>">
                            <span id="msg_kre_<?php echo $no; ?>"></span>
                            <span id="ed_kre_<?php echo $no . "_" . $krfTmbhn['idkreatifitas']; ?>" name="ed_kre_<?php echo $no; ?>" title="Ubah" onclick="edtRow(this)" class="badge badge-user center" 
                                style="cursor:pointer;"><i class="icon-pencil"></i></span>
                            <span id="rmkr_<?php echo $no . "_" . $krfTmbhn['idkreatifitas']; ?>" name="rmkr_<?php echo $no; ?>" title="Hapus" onclick="" class="badge badge-important center rem-dataKre" 
                              style="cursor:pointer;"><i class="icon-trash"></i></span>
                        </div>
                        <div id="btnh_kre_<?php echo $no; ?>" class="hide">
                            <span id="msgh_kre_<?php echo $no; ?>"></span>
                            <span style='cursor:pointer;' class='badge badge-info center' onclick="simpan(<?php echo $no . ",'kre'"; ?>);" title="Simpan" id="sm_<?php echo $no . "_" . $krfTmbhn['idkreatifitas']; ?>"><i class="icon-save"></i></span>
                                <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $no . ",'kre'"; ?>);" title="Cancel" id="ca_<?php echo $no . "_" . $krfTmbhn['idkreatifitas']; ?>"><i class="icon-remove"></i></span>
                         </div>
                    </td>
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
    <div class=" position-relative pull-right" id="page-content">
        <span id="loadkre" class=""></span>&nbsp;&nbsp;&nbsp;<span id="msgkre"></span>&nbsp;&nbsp;
        <button class="btn btn-small btn-primary no-radius" id="b-smpankre"><i class="icon-save"></i>Simpan</button>       
    </div> 
</div>


<script type="text/javascript">
    var rls = "jfu/realisasi/realisasi_.php";
    
    function edtRow(a){        
        var d = a.id.split('_');            
        $('.row_edt').each(function(){
            var a = $(this).attr('id');
            var on = a.split('_');
            cancel(on[2],on[1]);
        });
        $('#uraian_'+d[1]+'_'+d[2]).replaceWith(function(){
            return $('<textarea />',{html:$(this).html(), id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });        
        $('#id_'+d[1]+'_'+d[2]).replaceWith(function(){
            return $('<input />',{value:$(this).html(), type:'hidden',id:$(this).attr('id'),name:$(this).attr('name')});
        });
        $('#btn_'+d[1]+'_'+d[2]).addClass('hide');
        $('#btnh_'+d[1]+'_'+d[2]).removeClass('hide');
        $('#r_'+d[1]+'_'+d[2]).addClass('row_edt');
    }
    
    function cancel(a,on){   //nomer, on =  text
        $('#uraian_'+on+'_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).val(), id:$(this).attr('id'),name:$(this).attr('name'),style:$(this).attr('style')});
        });        
        $('#id_'+on+'_'+a).replaceWith(function(){
            return $('<label />',{html:$(this).val(), class:'hide', id:$(this).attr('id'),name:$(this).attr('name')});
        });
        $("#btn_"+on+'_'+a).removeClass('hide');        
        $('#btnh_'+on+'_'+a).addClass('hide');
        $('#r_'+on+'_'+a).removeClass('row_edt');
        console.log('cancel :'+a+'_'+on);
    }
    
    function simpan(a,on){ //nomer, on =  text
        var d = $('#id_'+on+'_'+a).val();
        var ur = $('#uraian_'+on+'_'+a).val();        
        var ld = $('#msgh_'+on+'_'+a);
        console.log('#msg_'+on+'_'+a);
        var msg = (on === 'tam')?$('#msgtm'):$('#msgkre');
        ld.addClass('icon-spin icon-spinner');
        msg.html("<font color='#BFBF07'>Wating response...</font>")
        var pst = $.post(rls, {act :'edtRow', bgian : on,uraian : ur, id : d});
        pst.done(function(sr){
            var d = sr.split('___');
            if (d[0] == '4'){
                msg.html(d[1]);                
                setTimeout(function(){cancel(a,on);msg.html('');ld.removeClass('icon-spin icon-spinner');},1230);
            }else if(d[0] == '1'){
                msg.html(d[1]);
                setTimeout(function(){msg.html('');ld.removeClass('icon-spin icon-spinner');},1230);
            }
            
        });
    }
    
    $('#b-smpantgs').click(function() {
        var fReal = $('#foRealisasi');        
        var dtReal = fReal.serializeArray();        
        var pFreal = $.post(rls, dtReal);
        var ld = $('#loadtgs');
        $('#msgtgs').html('Menyimpan data...&nbsp;&nbsp;');
        ld.addClass('icon-spin icon-spinner');
        pFreal.done(function(res) {
            var dt = res.split('___');
            if (dt[0] == '2') {
                $('#msgtgs').html(dt[1] + '&nbsp;&nbsp;');
                $('#tblRealisasi').html(dt[2]);
            } else if (dt[0] == '5') {
                $('#msgtgs').html(dt[1] + '&nbsp;&nbsp;');
            } else {
                $('#msgtgs').html("<font color='red'>Error in Paramater</font>");
            }
            setTimeout(function() {
                ld.removeClass('icon-spin icon-spinner');
                $('#msgtgs').html('');
            }, 2000);
        });        
    });

    $('#b-smpantm').click(function() {
        var fTmbhn = $('#foTambahan');
        var dtTmbhn = fTmbhn.serializeArray();
        var pfTmbhn = $.post(rls, dtTmbhn);
        console.log(dtTmbhn);
        $('#msgtm').html('Menyimpan data...&nbsp;&nbsp;');
        var ld = $('#loadtm');
        ld.addClass('icon-spin icon-spinner');
        pfTmbhn.done(function(rss) {              
            var dt = rss.split('___');
            if (dt[0] == '2') {
                $('#msgtm').html(dt[1] + '&nbsp;&nbsp;');
                $('#isitgsTmbhn').html(dt[2]);
                removeR();
            } else if (dt[0] == '1') {
                $('#msgtm').html(dt[1] + '&nbsp;&nbsp;');
            } else if(typeof variable_here === 'undefined'){
                $('#msgtm').html("<font color='red'>Tidak ada data yang disimpan</font>&nbsp;&nbsp;");
            } else {
                $('#msgtm').html("<font color='red'>Error in Paramater</font>");
            }
            setTimeout(function() {
                ld.removeClass('icon-spin icon-spinner');
                $('#msgtm').html('');
            }, 2000);
        });
    });

    $('#b-smpankre').click(function() {
        var fKreat = $('#foKreativitas');
        var dtKreat = fKreat.serializeArray();
        var pfKreat = $.post(rls, dtKreat);
        $('#msgkre').html('Menyimpan data...&nbsp;&nbsp;');
        var ld = $('#loadkre');
        ld.addClass('icon-spin icon-spinner');
        pfKreat.done(function(rss) {              
            var dt = rss.split('___');
            if (dt[0] == '2') {
                $('#msgkre').html(dt[1] + '&nbsp;&nbsp;');
                $('#isikreatif').html(dt[2]);
                removeR();
            } else if (dt[0] == '1') {
                $('#msgkre').html(dt[1] + '&nbsp;&nbsp;');
            } else if(typeof variable_here === 'undefined'){
                $('#msgkre').html("<font color='red'>Tidak ada data yang disimpan</font>&nbsp;&nbsp;");
            } else {
                $('#msgkre').html("<font color='red' title='no post'>Error in Paramater</font>");
            }
            setTimeout(function() {
                ld.removeClass('icon-spin icon-spinner');
                $('#msgkre').html('');
            }, 2000);
        });
    });

    $('#btn-tgsTmbhn').click(function() {
        var tbl = $('#isitgsTmbhn');
        var lent = tbl.children().length;
        lent = lent + 1;
        tbl.append("<tr id='rtm_" + lent + "'><td valign='middle' class='center' style='width:3%;'>" + lent + "</td><td><textarea style='width: 100%;' id='uraiantam_" + lent + "' name='uraian_tam[]'></textarea></td><td class='center'><span class='badge badge-important remR-tgstmbhn' name='rm_" + lent + "' style='cursor:pointer;' title='Hapus'><i class='icon-remove'></i></span></td></tr>");
        removeR();
        //<span class='badge badge-user' title='Ubah'><i class='icon-pencil'></i></span>
    });
    
    $('#btn-tgsKreatf').click(function() {
        var tbl = $('#isikreatif');
        var lent = tbl.children().length;
        lent = lent + 1;
        tbl.append("<tr id='rtk_" + lent + "'><td valign='middle' class='center' style='width:3%;'>" + lent + "</td><td><textarea style='width: 100%;' id='uraiankre_" + lent + "' name='uraian_kre[]'></textarea></td><td class='center'><span class='badge badge-important remR-Kreatvts' name='rmk_" + lent + "' style='cursor:pointer;' title='Hapus'><i class='icon-remove'></i></span></td></tr>");
        removeR();
        //<span class='badge badge-user' title='Ubah'><i class='icon-pencil'></i></span>
    });
    
    function removeR() {
        $('.remR-tgstmbhn').click(function() {
            var nm = ($(this).attr('name'));
            var di = nm.replace('rm_', '');
            console.log(di);
            $('#rtm_' + di).remove();
        });
        $('.remR-Kreatvts').click(function() {
            var nm = ($(this).attr('name'));
            var di = nm.replace('rmk_', '');
            console.log(di);
            $('#rtk_' + di).remove();
        });
        $('.rem-dataTam').click(function() {
            var nm = ($(this).attr('id'));
            console.log(nm);
            var di = nm.split('_');
            var post = $.post(rls, {act:'remTam',d : di[2], skpid : $('#skp_d').val()});
            var ld = $('#loadtm');
            ld.addClass('icon-spin icon-spinner');
            var msg= $('#msgtm');
            post.done(function(srr){
                var td = srr.split('___');
                if(td[0] == '3'){
                    msg.html(td[1]);
                    $('#isitgsTmbhn').html(td[2]);
                    removeR();
                }else if(td[0] == '1'){
                    msg.html(td[1]);
                }else{
                    msg.html("<font color='red'>Erorr di paramater, Tidak ada data yang terhapus !!</font>");
                }
                setTimeout(function(){
                    msg.html('');
                    ld.removeClass('icon-spin icon-spinner');
                },1230);
            });
        });
        
        $('.rem-dataKre').click(function() {
            var nm = ($(this).attr('id'));
            console.log(nm);
            var di = nm.split('_');
            var post = $.post(rls, {act:'remKre',d : di[2], skpid : $('#skpIdKre').val()});
            var ld = $('#loadkre');
            ld.addClass('icon-spin icon-spinner');
            var msg= $('#msgkre');
            post.done(function(srr){
                var td = srr.split('___');
                if(td[0] == '3'){
                    msg.html(td[1]);
                    $('#isikreatif').html(td[2]);
                    removeR();
                }else if(td[0] == '1'){
                    msg.html(td[1]);
                }else{
                    msg.html("<font color='red'>Erorr di paramater, Tidak ada data yang terhapus !!</font>");
                }
                setTimeout(function(){
                    msg.html('');
                    ld.removeClass('icon-spin icon-spinner');
                },1230);
            });
        });
    }
    removeR();
</script>