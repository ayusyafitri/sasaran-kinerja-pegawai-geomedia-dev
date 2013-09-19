<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
include_once ('../../php/postgre.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Daftar SKPD</h5>
</div>
<div class="box-content">
	<table class="table-jabatan">
		<tr><td class="center">SKPD</td>
			<td>&nbsp;</td>
			<td><div id="loaderSKPD"></div>
				<select name="skpd" id="skpd" >
					<option id="0" value="0">Pilih SKPD</option>
					<?php
					$skpd = get_datas("select * from skp_skpd where nama not like '%admin%' order by id");
					foreach ($skpd as $skpd) {
						?><option value="<?php echo $skpd['id'] ?>">
						<?php echo $skpd['nama'] ?>
						</option>	
						<?php
					}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>
<div class="position-relative" id="page-content">
    <table>
	<tr><td><a href="#modalwin" data-toggle="modal" class="btn btn-small btn-primary no-radius btn-tambah"><i class="icon-plus"></i>&nbsp;Tambah Data</a>
		&nbsp;<span id="load" class="spinner"></span></td>
		<td id="tulisan"></td>
	</tr></table>
</div>
<div class="box-content">
	<table>
		<tr><b>
			<td>Tabel SKPD</td>
			<td>:</td>
			<td id="tabelSKPD"></td>
		</b></tr>
	</table>
</div>

<div id="modalwin" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <header class="modal-header"> 
        <a href="#" class="close geo-clear" data-dismiss="modal">x</a>
        <h3>Data SKPD</h3>
    </header>

    <div class="modal-body">
        <form id="formjabatan">
            <input type="hidden" name="act" value="jabatan_simpan">
            <input type="hidden" id="id" name="id" value="0"> 
			<input type="hidden" id="id_skpd" name="id_skpd" value="0">
            <table class="table-form">
                <tbody>
                    <!--tr>
                        <td>Pilih SKPD</td>
                        <td>:</td>
                        <td  width="120px">
                            <select  name="id_skpd" id="id_skpd" >
                                <option value="0" id='idskpd'> pilih salah satu </option> 
                                <?php
                              /*  $skpd = get_datas("select * from skp_skpd where nama not like '%admin%' order by id");
                                foreach ($skpd as $skpd) {
                                    ?><option value="<?php echo $skpd['id'] ?>">
                                    <?php echo $skpd['nama'] ?>
                                    </option>	

                                    <?php
                                }*/
                                ?>
                            </select>
                        </td>
                    </tr-->

                    <tr>
                        <td>Nama Jabatan</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama" id="nama"  />
                        </td>
                    </tr>

                    <tr>
                        <td>Induk Jabatan</td>
                        <td>:</td>
                        <td>
                            <select  name="id_induk" id="id_induk" onchange="data()" onclick="data()">
                                <option value="0" id="idindukk"> Tidak ada </option> 
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Kode Jabatan</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="kodejab" id="kodejab"  />
                        </td>
                    </tr>

                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>
                            <select  name="id_jabatan" id="id_jabatan">
                                <option value="0" id='idjabatan'> pilih salah satu </option> 
                                <option value="Jabatan Struktural"> Jabatan Struktural </option> 
                                <option value="Jabatan Fungsional Umum"> Jabatan Fungsional Umum </option> 
                                <option value="Jabatan Fungsional Tertentu"> Jabatan Fungsional Tertentu</option> 
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Unit Organisasi</td>
                        <td>:</td>
                        <td id='unitOr' name="unitOr"></td><!--td id='eslon'></td>
                    </tr>

                    <!--tr>
    <td>Ikhtisar Jabatan</td>
    <td>:</td>
    <td>
        <textarea class="input-xlarge" name="ikhtisar" id="ikhtisar"  />
    </td>
</tr!-->



                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a class="btn btn-primary btn-small btn-simpan-jabatan "><div id="loader"></div>&nbsp;Simpan</a><span id="result"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="box-content">
    <table class="table table-bordered geo-table table-hover" width="100%">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="12%">Kode Jabatan</th> 
                <th class="center" width="33%">Nama Jabatan</th>
                <th class="center" width="20%">aksi</th>
            </tr>
        </thead>
        <tbody id="tampilJabatan">
            
        </tbody>
    </table>    
</div>

<script>
	var sourcess = 'admin/jabatan/listSKPD.php';
	
	$('#skpd').change(function(){
		var load = $('#loaderSKPD');
		load.addClass('icon-spinner icon-spin white');
		var l = $.post(sourcess,{act:'tampil_nam',sk:this.value});
		l.done(function(data){
			var datt = data.split('___');
			$('#id_skpd').val(datt[0]);
			$('#tampilJabatan').html(datt[2]);
			$('#tabelSKPD').html(datt[1]); 
		//	$('.btn-tambah').val()
			init();
		});
		load.removeClass();
	});

    var url = 'admin/jabatan/save_jabatan.php';
    var rslt = $('#result'); 
	
   function data(){
		var skpd = $('#id_skpd').val();
		var kode = $('#id_induk').val();
	    var post = $.post(url,{act:'get_kode', kode:kode, skpdd:skpd});
        post.done(function(data){
            //$('#kodejab').html(data);
            document.getElementById('kodejab').value=data;
        });
	}	

    $('#id_jabatan').change(function(){
        var jabatan = $('#id_jabatan').val();
        var skp = $('#id_skpd').val();
        var td = $('td#unitOr');  
	//	var tde = $('td#eslon');
        if(jabatan == 'Jabatan Struktural'){
            td.html("<td><input type='text' name='unit' id='unit'  class='span3'/></td><td><select name='eslon' id='eslon' class=span2><option value='0'>Pilih Golongan</option><option value='IIB'>IIB</option><option value='IIIA'>IIIA</option><option value='IIIB'>IIIB</option><option value='IVA'>IVA</option><option value=IVB>IVB</option></select></td>");
			//tde.html("<select name='eslon' id='eslon' class=span2><option value='0'>Pilih sala satu</option><option value='IIB'>IIB</option><option value='IIIA'>IIIA</option><option value='IIIB'>IIIB</option><option value='IVA'>IVA</option><option value=IVB>IVB</option></select>");
        }else{
            var post = $.post('admin/jabatan/save_jabatan.php',{act :'rlJabatan', skp : skp});
            post.done(function(rse){
                td.html(rse); 
            });            
        }
	});
	
	
    $('.btn-simpan-jabatan').click(function(){      
        var btn = $(this);
        var load = $('#loader');
        load.addClass('icon-spinner icon-spin icon-2x white');
       
        var form = $('#formjabatan');
        var data = form.serializeArray();
        var post = $.post(url,data);
        post.done(function(res){
			var result = res.split('__');
            if(result.length==3){
                if(result[0]=='success'){
                    rslt.html('<font color="green">data tersimpan </font>');
                    setTimeout(function(){
                        rslt.html('');
                    }, 1500);
                
                    var tbody = $('#tampilJabatan');
                    tbody.html(result[2]);
					init();
                    $("#id").val("0");
                    document.getElementById('nama').value='';
				//	document.getElementById('idindukk').selected=true;
					document.getElementById('kodejab').value='';
					document.getElementById('idjabatan').selected=true;                    $('#modalwin').modal('hide');
                }else{
                    rslt.html('<font color="red">'+res+'</font>');
                }
            }else{
                rslt.html('<font color="red">'+res+'</font>');
            }
            load.removeClass();
            btn.removeClass('btn-info').addClass('btn-primary');
           
        });
    
    });
	
	$('.btn-tambah').click(function(){
		var skpd = $('#skpd').val();
		var tulis = $('td#tulisan');
		$(this).attr('href','0');
		if(skpd == 0){
			tulis.html("<font color='red'>Pilih SKPD terlebih dahulu</font>");	
		}else{ 
			tulis.html(" ");
			$(this).attr('href','#modalwin');
			$('#id').val('0');
			var idinduk = $('#id_skpd').val();
			var post = $.post(url,{act:'get_induk',idindukk:idinduk});
				post.done(function(data){
					$('#id_induk').html(data);
				});
			document.getElementById('nama').value='';
		//	document.getElementById('idindukk').selected=true;
			document.getElementById('kodejab').value='';
			document.getElementById('idjabatan').selected=true;
		}

	});
    
	function getParent(){
		var post = $.post(url,{act:'get_induk',idinduk:this.value});
        post.done(function(data){
            $('#id_induk').html(data);
		});
	}
	
	
    function init(){
        $('.bt-edit-jabatan').click(function(){
			var id = this.name;
            var form = $('#formjabatan');
            var post = $.post(url,{act:'ubah_jabatan',id:id});            
            post.done(function(res){
                var value = res.split('__');
                $('#id').val(value[0]);
                form.find('input[name="nama"]').val(value[1]);
                form.find('input[name="kodejab"]').val(value[2]);
				form.find('select[name="id_induk"]').html(value[7]);
				form.find('select[name="id_skpd"]').val(value[4]);
				form.find('select[name="id_jabatan"]').val(value[6]);
				$("#unitOr").html(value[8]);
				$("#unitOr").val(value[5]);
				//form.find('select[name="eslon"]').html(value[8]);
			 });
        });
        
        $('.bt-hapus-jabatan').click(function(){
			var btn = $(this);
            var pid = this.name;
            var load = $(this);
            load.html('<div class="icon-spinner icon-spin icon-2x white"></div>');
            bootbox.confirm("Anda akan menghapus jabatan ini?", function(hsl){
                if(hsl==true){
                    if(pid!=0){
                        var post = $.post(url,{act:"hapus_skpd",id:pid});
                        post.done(function(res){
                            var hasil = res.split('__');
                            //alert(hasil.length);
                            if(hasil.length == 2){
                                if(hasil[0] == 'success'){
                                  //  rslt.html('<font color="green">Data Telah Dihapus...</font>');
                                  //  setTimeout(function(){
                                  //      rslt.html('');
                                  //  }, 1500);
                                    var tbody = $('#tampilJabatan');
                                    tbody.html(hasil[1]);
                                    init();
                                    //btn.parent().parent().remove();
                                }
                            }
                        });
                        load.html('<i class="icon-trash icon-white"></i>Hapus');
                    }
                }else{
                    load.html('<i class="icon-trash icon-white"></i>Hapus');
                }
            });
        });
        
    }
    init();
	/*
$(".geo-clear").change(function(){
	$('#id').val('0');
		var idinduk = $('#id_skpd').val();
		var post = $.post(url,{act:'get_induk',idindukk:idinduk});
			post.done(function(data){
				$('#id_induk').html(data);
			});
      	document.getElementById('nama').value='';
	//	document.getElementById('idindukk').selected=true;
		document.getElementById('kodejab').value='';
		document.getElementById('idjabatan').selected=true;
})*/
  
</script>