<?php
@session_start();
include_once("../php/include_all.php");
if (isset($_SESSION['_username'])) {
    ?><script type='text/javascript'>location.href='admindata.php';</script><?php } ?>
<div class="widget-box" id="login">
    <div data-original-title="" class="widget-header">
        <h4 class="lighter smaller"><i class="icon-user"></i> AUTENTIKASI USER</h2>
            <a title="Refresh" class="btn btn-primary btn-small pull-right btRefresh"><i class="icon-refresh"></i></a>
    </div>
    <div class="widget-body" style="padding:20px">
        <div class="box center" style="width:260px; margin-bottom:80px; margin-top:70px">
            <div class="box-content">
                <div class="row-fluid" id="f0rm">
                    <span style="font-size:1.2em; font-weight:bold;">LOGIN SKP v1.0</span>
                    <hr style="margin:5px auto 15px auto;"/>
                    <div id="alerto"></div>
                    <label>
                        <span class="block input-icon input-icon-right">
                            <input name="whoareyou" type="text" placeholder="NIP Pegawai">
                            <i class="icon-user"></i>
                        </span>
                    </label>
                    <label>
                        <span class="block input-icon input-icon-right">
                    <input name="yoursecret" type="password" placeholder="Password">
                    <i class="icon-lock"></i>
                        </span>
                    </label>                    
                    <input type="button" class="btn btn-danger btn-small bt-cancel" value="Cancel">
                    <input type="button" class="btn btn-primary btn-small bt-login" value="Login">
                    <input type="hidden" value="hearme" name="what">
                </div>
                <hr/>
                 <center>Daftar<a href="#modalwin" data-toggle="modal">  disini</a>   </center>              
            </div>
        </div><!--/span-->
    </div>
</div>

<div id="modalwin" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<header class="modal-header">
    	<a href="#" class="close" data-dismiss="modal">x</a>
        <h3> <i class="icon-user"></i> DAFTAR USER</h3>
    </header>
    <div class="modal-body">
    	<form id="form_pendaftaran">
        	<input type="hidden" name="act" value="simpan_daftar">
            <input type="hidden" name="id_user" id="id_user" value="0">
            	<table class="table-form">
                    <tr>
                    	<td>Nama</td><td><input name="nama" type="text" id="nama" placeholder="Nama"></td>
                    </tr>
                    <tr>
                    	<td>NIP</td><td><input name="nip" type="text" id="nip" placeholder="NIP"></td>
                    </tr>
                    <tr>
                    	<td>SKPD</td>
                        <td>
                        	<select name="skpd" id="skpd">
                            	<option id="" value="">-Pilih SKPD-</option>
                                <?
								$skpd = get_datas ("select * from skp_skpd where nama not like '%admin%' order by id");
								foreach ($skpd as $skpd){
								?>
                                	<option value="<? echo $skpd['id']?>"><? echo $skpd ['nama']?></option>
                                 <?
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td>Email</td><td><input name="email" type="text" id="email" placeholder="Alamat Email"></td>
                    </tr>
                	<tr>
                    	<td>Username</td><td><input name="username" type="text" id="username" placeholder="Username"></td>
                    </tr>
                    <tr>
                    	<td>Password</td><td><input name="pass" type="password" id="pass" placeholder="Password"></td>
                    </tr>
                    <tr>
                    	<td>Confirm Password</td><td><input name="co_pass" type="password" id="co_pass" placeholder="Confirm Password"></td><td><span id="confirm"></span></td>
                    </tr>
                </table>
                <table align="right">
                	<tr>
                    	<td><input type="button" class="btn btn-primary bt-simpan-daftar" value="Simpan" /></td>
                    </tr>
                </table>
        </form>
    </div>
</div>
<?php
if (isset($_SESSION['$LEVEL'])) {
    ?>
    <script>
        var alerto = $("#alerto");
        alerto.removeClass().addClass('alert alert-success');
        alerto.html('<div class="icon-spin icon-spinner pull-left"></div> You have logged in, redirecting...');
        setTimeout(function() {
            location.href = 'system.php';
        }, 3000);
    </script>
    <?php
}
?>
<script type='text/javascript'>
	var urls= 'home/aksi_daftar.php';
	
	$('.bt-simpan-daftar').click(function(){
	var btn = $(this);
	var load = $('#loader');
	var rslt = $('#result');
	load.addClass('icon-spin icon-spinner pull-left');
	btn.removeClass('btn-primary').addClass('btn-info');
	
	var pass = $('#pass').val();
	var copass = $('#co_pass').val();
	
	if (pass != copass){
		var co = $('#confirm');
		co.html ('<font color="red">Password salah</font>');
				document.getElementById('username').value='';
				document.getElementById('pass').value='';
				document.getElementById('skpd').value='';
				document.getElementById('nama').value='';
				document.getElementById('nip').value='';
				document.getElementById('email').value='';
				document.getElementById('id_user').value='0';
				document.getElementById('co_pass').value='';

	}
	else{
	var form =$('#form_pendaftaran');
	var data = form.serializeArray();
	var post = $.post(urls,data);
	post.done(function(res){
		console.log(res);
		var result = res.split('__');
		if(result.length==2){
		 	
			if(result[0]=='success'){
				rslt.html('<font color="green">Tersimpan</font>');
				setTimeout(function(){
					rslt.html('');
				},1500);
				document.getElementById('username').value='';
				document.getElementById('co_pass').value='';
				document.getElementById('skpd').value='';
				document.getElementById('pass').value='';
				document.getElementById('nama').value='';
				document.getElementById('nip').value='';
				document.getElementById('email').value='';
				document.getElementById('id_user').value='0';
				$('#modalwin').modal('hide');
			}else{
				rslt.html('<font color="red">'+res+'</font>');
			}
		}else{
			rslt.html('<font color="red">'+res+'</font>');
		}
	
		load.removeClass();
		btn.removeClass('btn-info').addClass('btn-primary');

		});
		}
	});
    $('.bt-cancel').click(function(x) {
        var btns = $('#toprightmenu').children('.btn');
        btns.removeClass('active')
        console.log(btns)
        $(btns[0]).addClass('active');


        var url = 'home/banner.php';
        var get = $.get(url);
        get.done(function(data) {
            $('#content').html(data);
        });
    });

    $('.bt-login').click(function() {
        var f = $('#f0rm');
        var user = f.find('input[name="whoareyou"]').val();
        var pass = f.find('input[name="yoursecret"]').val();

        var alerto = $("#alerto");
        alerto.removeClass().addClass('alert');
        alerto.html('<div class="icon-spin icon-spinner icon-spin pull-right"></div>&nbsp;Mohon tunggu...');

        var url = 'php/1nd3x.php';
        var posting = $.post(url, {whoareyou: user, yoursecret: pass,part : $('#part').val(),what:'inn'});
        posting.done(function(data) {
            var dt = data.split('___');
            if (dt[0] == 'suk') {
                alerto.removeClass().addClass('alert alert-success');
                alerto.html('<div class="icon-spin icon-spinner pull-left"></div>Good, redirecting...');
                setTimeout(function() {
                    location.href = dt[1];
                }, 2000);
            } else if (dt[0] == 'gal') {
                alerto.removeClass().addClass('alert alert-error');
                alerto.html('Invalid user and/or password');
                alerto.attr('id')
            } else {
                alerto.removeClass().addClass('alert');
                alerto.html("System Error, contact Geomedia Corp.");
            }
        });
    });
</script>