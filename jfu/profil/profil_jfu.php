<?php
@session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
echo SKP_ID;
$dtaAtasan = getDataAtasan(SKP_ID);
$dtPeg = getDataPNS(SKP_ID);
$imgSrc = (empty($dtPeg['imgProfil'])) ? 'themes/img/no-profile.gif' : 'imgPns/' . $dtPeg['imgProfil'];
?>

<div id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/skp/admindata.php">Home</a>

            <span class="divider">
                <i class="icon-angle-right"></i>
            </span>
        </li>
        <li class="active">Profil</li>
    </ul>

</div>
<div id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon-user-md"></i>&nbsp;Profil</h1>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div>
                <div id="user-profile-1" class="user-profile row-fluid">
                    <div class="span3">
                        <div class="center">
                            <span class="profile-picture">
                                <img id="avatar2"  class="editable editable-click editable-empty" src="<?php echo $imgSrc; ?>"></img>
                            </span>
                        </div>
                        <div class="space-4"></div>
                        <div class="width-80 label label-user label-large center">
                            <div class="inline position-relative">
                                <a class="user-title-label dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-circle light-green middle"></i>
                                    <span class="white middle bigger-120 "><?php echo $dtPeg['nama']; ?> </span>
                                </a>
                                    
                            </div>
                        </div>
                        <div class="hr hr12 dotted"></div>
                        <a> <button class="btn btn-small btn-primary no-radius"><i class="icon-upload-alt"></i></button> </a><a>Mutasi</a>
                        <div class="hr hr12 dotted"></div>
                        <a><button class="btn btn-info btn-small no-radius"><i class="icon-upload-alt"></i></button> </a><a>Promosi</a>
                        <div class="hr hr12 dotted"></div>
                        <a><button class="btn btn-small btn-danger no-radius"><i class="icon-upload-alt"></i></button> </a><a>Pengajuan Keberatan Penilaian</a>
                        <input type='password' class='hidden hidden-320 hidden-desktop hidden-480' id='old' name='old' value="<?php echo $dtPeg['pass']; ?>" />
                    </div>
                    <div class="span9">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> NIP</div>
                                <div class="profile-info-value">
                                    <span id="NIP_pf" class="" style="display: inline;"><?php echo $dtPeg['nip']; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nama</div>
                                <div class="profile-info-value">
                                    <span id="nama_pf" class="editable editable-click" name="nama" onclick="edtProfil(this);" style="display: inline;"><?php echo $dtPeg['nama']; ?></span>
                                </div>
                            </div> 
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Jabatan</div>
                                <div class="profile-info-value">
                                    <span id="jabatan_pf" class="editable editable-click" style="display: inline;"><?php echo $dtPeg['namajab']; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Atasan Langsung</div>
                                <div class="profile-info-value">
                                    <span id="jabAtasan_pf" class="editable editable-click" style="display: inline;"><?php echo stripIfEmpty($dtaAtasan['namajab']); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">Nama Atasan Langsung</div>
                                <div class="profile-info-value">
                                    <span id="nmAtasan_pf" class="" style="display: inline;"><?php echo stripIfEmpty($dtaAtasan['nama']); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Golongan</div>
                                <div class="profile-info-value">
                                    <span id="golongan_pf" class="editable editable-click" style="display: inline;"><?php echo stripIfEmpty($dtPeg['pangkatGol']); ?></span>
                                </div>
                            </div>
                        </div>
                        <div space="12"></div>
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tempat Lahir</div>
                                <div class="profile-info-value">
                                    <span id="tmptlahir_pf" class="editable editable-click" onclick="edtProfil(this);" name="tempat_lahir" style="display: inline;"><?php echo stripIfEmpty($dtPeg['tmpat_lhr']); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tanggal Lahir</div>                                
                                <div class="profile-info-value">
                                    <span id="tgllahir_pf" class="editable editable-click" onclick="edtProfil(this);" name="tanggal_lahir" style="display: inline;"><?php echo stripIfEmpty(format_tglSimpan($dtPeg['tgl_lhr'], '/', FALSE)); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">Alamat</div>
                                <div class="profile-info-value">
                                    <span id="alamat_pf" class="editable editable-click" onclick="edtProfil(this);" name="alamat" style="display: inline;"><?php echo stripIfEmpty($dtPeg['alamat']); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> No. Telp</div>
                                <div class="profile-info-value">
                                    <span id="notelp_pf" class="editable editable-click" onclick="edtProfil(this);" name="notelp" style="display: inline;"><?php echo stripIfEmpty($dtPeg['noTelp']); ?></span>
                                </div>
                            </div>
                        </div>
                        <div space="12"></div>
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">Username</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" onclick="edtProfil(this);" name="username" style="display: inline;"><?php echo stripIfEmpty(SKP_USER); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Password</div>
                                <div class="profile-info-value">
                                    <span id="password" class="editable editable-click" onclick="edtProfil(this);" name='password' style="display: inline;"><?php echo showPassInOtherCharacter($dtPeg['pass']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">       
    (function($) {
        $.fn.attributesToArray = function(attrs) {
            var t = $(this);
            if (attrs) {
                t.each(function(i, e) { // set Attributes
                    var j = $(e);
                    for (var attr in attrs) {
                        j.attr(attr, attrs[attr]);
                    };
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
    var urls = 'jfu/profil/profil__.php';
    var tol = "<div id='tools'>&nbsp&nbsp;<i class='icon-ok green' onclick='svePf(this);' style='cursor:pointer;' ></i>\
    &nbsp&nbsp;<i class='icon-remove red' style='cursor:pointer;' onclick='cancel(this);'></i>\
    &nbsp&nbsp;<span id='ld'></span>&nbsp&nbsp;<span id='ms'></span></div>";
    var toll = "<div id='tools'><input type='password' style='display: inline;float:left;' name='passNew' class='input-' id='passNew' placeholder='Masukkan Password Baru'>\
    <input type='password' style='display: inline;float:left;' name='passRe' class='input-large' id='passRe' placeholder='Ketik Lagi Password Baru'>\
    &nbsp;<i class='icon-ok green' onclick='svePf(this);' style='cursor:pointer;' ></i>\
    &nbsp&nbsp;<i class='icon-remove red' style='cursor:pointer;' onclick='cancel(this);'></i>\
    &nbsp&nbsp;<span id='ld'></span>&nbsp&nbsp;<span id='ms'></span></div>";
    function svePf(a){
        var modalPas = '<div class="modal hide fade" id="mdlSetPas">\
                                                <div class="modal-header">\
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>\
                                                        <h4 class="blue">Masukkan Password Lama</h4>\
                                                </div>\
                                                \
                                                <form class="no-margin" id="avatar_upload">\
                                                <div class="modal-body">\
                                                        <div class="space-4"></div>\
                                                        <div style="width:75%;margin-left:12%;"><input type="file" id="file-input" name="file-input" /></div>\
                                                </div>\
                                                <div class="modal-footer center">\
                                                        <button type="button" onclick="imgSend()" id="uploa" class="btn btn-small btn-success"><i class="icon-ok"></i> Submit</button>\
                                                        <button type="button" class="btn btn-small" data-dismiss="modal"><i class="icon-remove"></i> Cancel</button>\
                                                        <div id="inf"></div>\
                                                </div></form>\
                                        </div>';    
        var prnt = $(a).parent().parent();
        var ld = $(a).parent().children('#ld');
        var ms = $(a).parent().children('#ms');
        var input = prnt.children('input[type=text]');
        ld.addClass('icon-spin icon-spinner');
        var pst = '';       
        if(input.attr('name') === 'password'){
            var psN = $(a).parents().children('#passNew').val();
            var psRe = $(a).parents().children('#passRe').val();
            console.log(psN+' == '+psRe);
            if(psN === ""){
                ms.html("<font color='red'>Password Baru Kosong!!!</font>");
            }else if(psRe === ""){
                ms.html("<font color='red'>Ketik Ulang Password baru dahulu !!!</font>");
            }else if(psRe === psN){
                var passLm = prompt("Masukkan Password lama ??");
                if(passLm === $('#old').val()){
                    var dt = {act:'sve', isi:psN, nm:input.attr('name'), d:<?php echo SKP_ID;?>};        
                    pst = $.post(urls,dt);                            
                }else{
                    ms.html("<font color='red'>Password lama tidak cocok !!!</font>");
                }
            }else{
                ms.html("<font color='red'>Password Tidak Sama</font>");
            }
        }else{
            if((input.attr('name') === 'username') && (input.val() === "")){
                ms.html("<font color='red'>Username tidak boleh kosong !!!</font>");
            }else{
                var dt = {act:'sve', isi:input.val(), nm:input.attr('name'), d:<?php echo SKP_ID;?>};        
                pst = $.post(urls,dt);
            }
        }
        if(pst !== ''){
            pst.done(function(rs){
                var news = rs.split('___');
                if(news[0] === '2'){
                    var si = (news[2] === '' || news[2] === '0')?'-':news[2];                    
                    input.prop('title',si);                    
                    setTimeout(function(){ld.removeClass(); ld.addClass('icon-thumbs-up green icon-animated-vertical');ms.html(news[1]);},500);
                    setTimeout(function(){cancel(ld);},2000);
                }else if((news[0] === '5') || (news[0] === '10')){
                    ms.html(news[1]);
                }else{
                    ms.html("<font color='red'>Error in parameter !!! No respon accepted !!!</font>");
                }
            });
        }
        setTimeout(function(){
            ld.removeClass();
            ms.html('');
        },3000);
    }    
    function edtProfil(a) {
        var dt = a.id;
        var label = $('#' + dt);
        $('.text_edt').each(function() {
            var a = $(this).parent().children('#tools');
            var childA = a.children(".icon-remove");            
            cancel(childA);
        });
        var id = '';
        label.replaceWith(function() {
            var arCom = $(this).attributesToArray();
            arCom['type'] = 'text';
            delete arCom['onclick'];
            arCom['class'] = 'input-large';            
            arCom['title'] = $(this).html();
            arCom['style'] = arCom['style']+'float:left;';
            arCom['value'] = ($(this).html() === '-' || $(this).html() === '\\')?'':$(this).html().replace('&nbsp;','');
            if(arCom['id'] === 'tgllahir_pf' || (arCom['id'] === 'password')){               
                arCom['readonly'] = 'readonly';
                arCom['style'] = (arCom['id'] === 'password')?'display:inline;':arCom['style'];
            }
            id = arCom['id'];
            return $('<input />', arCom);
        });
        var t = (dt === 'password')?toll:tol;
      //  console.log(dt+" // "+t);
        $('#'+dt).after(t);
        $('#'+dt).addClass('text_edt');
        if(id === 'tgllahir_pf'){            
            setDate();
        }
    }  
    function setDate(){           
            $("#tgllahir_pf").datepicker({
                format : 'dd/mm/yyyy'
            });
    }
    
    function cancel(a) {
        var prnt = $(a).parent().parent();
        var child = prnt.children();             
        var arCom = $(child[0]).attributesToArray();
        $(child[1]).remove();  
        arCom['onclick'] = 'edtProfil(this);';
        arCom['style'] = 'style:display;';
        arCom['class'] = 'editable editable-click';
        arCom['html'] = $(child[0]).attr('title');
        $(child[0]).replaceWith(function(){
            return $('<span />', arCom);
        });        
        $(child[0]).removeClass('.text_edt');
    }
    var modalDiv = '<div class="modal hide fade" id="mdlUpload">\
                                                <div class="modal-header">\
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>\
                                                        <h4 class="blue">Ganti Profil</h4>\
                                                </div>\
                                                \
                                                <form class="no-margin" id="avatar_upload">\
                                                <div class="modal-body">\
                                                        <div class="space-4"></div>\
                                                        <div style="width:75%;margin-left:12%;"><input type="file" id="file-input" name="file-input" /></div>\
                                                </div>\
                                                <div class="modal-footer center">\
                                                        <button type="button" onclick="imgSend()" id="uploa" class="btn btn-small btn-success"><i class="icon-ok"></i> Submit</button>\
                                                        <button type="button" class="btn btn-small" data-dismiss="modal"><i class="icon-remove"></i> Cancel</button>\
                                                        <div id="inf"></div>\
                                                </div></form>\
                                        </div>';
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

    $('#avatar2').on('click', function() {
        var modal = $(modalDiv);
        modal.modal("show").on("hidden", function() {
            modal.remove();
        });

        var working = false;

        var form = modal.find('form');
        var file = form.find('input[type=file]').eq(0);
        file.ace_file_input({
            style: 'well',
            btn_choose: "Click Untuk Memilih Profile Baru",
            no_icon: 'icon-picture',
            thumbnail: 'small',
            before_remove: function() {
                //don't remove/reset files while being uploaded
                return !working;
            },
            before_change: function(files, dropped) {
                var file = files[0];
                if (typeof file === "string") {
                    //file is just a file name here (in browsers that don't support FileReader API)
                    if (!(/\.(jpe?g|png|gif)$/i).test(file))
                        $('#inf').html("<font color='red'>Browser doesn't support uploading !!!</font>");
                    setTimeout(function() {
                        $('#inf').html('');
                    }, 2000);
                    return false;
                } else {//file is a File object
                    var type = $.trim(file.type);
                    if ((type.length > 0 && !(/^image\/(jpe?g|png|gif)$/i).test(type))
                            || (type.length == 0 && !(/\.(jpe?g|png|gif)$/i).test(file.name))//for android default browser!
                            ) {
                        $('#inf').html("<font color='red'>Extension yang diperbolehkan hanya jpg, jpeg, png dan gif</font>");
                        setTimeout(function() {
                            $('#inf').html('');
                        }, 1500);
                        return false;
                    }
                    if (file.size > 330000) {//~100Kb                                                
                        $('#inf').html("<font color='red'>Ukuran Foto tidak boleh lebih dari 300Kb</font>");
                        setTimeout(function() {
                            $('#inf').html('');
                        }, 1500);
                        return false;
                    }
                }
                return true;
            }
        });
    });

    function imgSend() {
        var form = $('#avatar_upload');
        var file = form.find('input[type=file]').eq(0);
        var mdl = $('#mdlUpload');
        if (!file.data('ace_input_files'))
            return false;

        file.ace_file_input('disable');
        form.find('button').attr('disabled', 'disabled');
        form.find('.modal-body').append("<div class='center'><i class='icon-spinner icon-spin bigger-150 orange'></i></div>");
        mdl.modal("show").on("hidden", function() {
            mdl.remove();
        });
        var arr = {'act': 'imgUpload', 'nip': '<?php echo SKP_NIP; ?>'}
        var data = new FormData();
        data.append('imgUp', $('#file-input')[0].files[0]);
        $.each(arr, function(key, value) {
            data.append(key, value);
        });
        $.ajax({
            type: "POST",
            url: 'jfu/profil/profil__.php',
            data: data,
            processData: false,
            contentType: false,
            success: function(ret) {
                form.find('button').removeAttr('disabled');
                form.find('input[type=file]').ace_file_input('enable');
                form.find('.modal-body > :last-child').remove();
                mdl.modal("hide");
                var dp = ret.split('___');
                if (dp[0] == '2') {
                    // $('#avatar2').prop('src', '');
                    console.log($('#avatar2').attr('src'));
                    form.find('button').removeAttr('disabled');
                    form.find('input[type=file]').ace_file_input('enable');
                    form.find('.modal-body > :last-child').remove();
                    $('#avatar2').prop('src', dp[1]);
                    $('#icon-corner').prop('src', dp[1]);
                } else if (dp[0] == '3') {
                    $('#inf').html(dp[1]);
                    setTimeout(function() {
                        $('#inf').html('');
                    }, 1500);
                } else {
                    $('#inf').html("<font color='red'>Error in paramater !! no request accepted !!</font>");
                    setTimeout(function() {
                        $('#inf').html('');
                    }, 1500);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#inf').html(xhr, textStatus, errorThrown + 'error');
                setTimeout(function() {
                    $('#inf').html('');
                }, 1500);
                return false;
            }
        });
        return false;
    }
</script>

