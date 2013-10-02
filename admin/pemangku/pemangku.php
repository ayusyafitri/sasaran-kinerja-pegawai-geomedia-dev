<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Daftar Pemangku</h5>
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
			<td>&nbsp;</td>
			<td> <a href='#modalwin' data-toggle="modal" class="btn btn-small btn-primary no-radius btn-tambah"><i class="icon-plus"></i>&nbsp;Tambah Data</a>
				&nbsp;<span id="load" class="spinner"></span></td>
			<td id="tulisan"></td>
		</tr>
	</table>
</div>

<div class="box-content">
	<table>
		<tr><b>
			<td>Tabel Pemangku </td>
			<td>:</td>
			<td id="tabelSKPD"></td>
		</b></tr>
	</table>
</div>
<div id="modalwin" class="modal hide fade" style="width:800px;left:40%" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <header class="modal-header"> 
        <a href="#" class="close geo-clear" data-dismiss="modal">x</a>
        <h3>Input Pemangku</h3>
    </header>

    <div class="modal-body">
        <form id="form_pemangku">
            <input type="hidden" name="act" value="simpan_pemangku">
            <input type="hidden" id="id_pns" name="id_pns" value="0"> 
			<input type="hidden" id="id_skpd" name="id_skpd" value="0">
			<table class="table-form">
                <tbody>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>
                            <select name="jab" id="jab" onchange="jabatan()" onclick="jabatan()" >
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Golongan</td>
                        <td>:</td>
                        <td>
                            <select name="gol" id="gol">
                            	<option id="">-Pilih Golongan-</option>
                                <?php
                                $gol = get_datas ("select * from skp_golongan order by id_gol");
								foreach ($gol as $gol){
								?>
                                <option value="<?php echo $gol['id_gol'];?>"><?php echo $gol['nama_golongan'];?></option>
                                <?php
								}
								?>
                            </select>
                        </td>
                    <tr>
                    </tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama" id="nama"  />
                        </td>
                    </tr>

                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nip" id="nip"  />
                        </td>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="telp" id="telp"  />
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td colspan="3">
                            <input type="text" name="alamat" id="alamat"  />
                        </td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="tempat" id="tempat"  />
                        </td>
                        <td>
                            <select name="tgl" class="span1">
                            	<option value="0"></option>
                                <?php
                                for ($tgl=1; $tgl<=31; $tgl++){
								?>
                                <option value="<? echo $tgl;?>"><? echo $tgl;?></option>
                                <?php
								}
								?>
                            </select>
                         </td><td>
                            <select name="bln" class="span2">
                            	<option value="0"></option>
                                <?php
                                for ($bln=1; $bln<=12; $bln++){
								?>
                                <option value="<? echo $bln;?>"><? echo $nama_bln[$bln];?></option>
                                <?php
								}
								?>
                            </select>
                         </td><td>
                            <select name="thn" class="span1">
                            	<option value="0"></option>
                                <?php
								$t=date('Y');
                                for ($thn=1900; $thn<=$t; $thn++){
								?>
                                <option value="<? echo $thn;?>"><? echo $thn;?></option>
                                <?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <input type="hidden" name="pem_no" id="pem_no"  />
                </tbody>
            </table>
            <table align="right">
                    <tr>
                        <td>
                            <a class="btn btn-primary btn-small btn-simpan-pemangku "><div id="loader"></div>&nbsp;Simpan</a><span id="result"></span>
                        </td>
                    </tr>
            </table>
        </form>
    </div>
</div>

<div id="showDetail" class="modal hide fade" valign="midle" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <header class="modal-header">
            <a href="#" class="close" data-dismiss="modal">x</a>
                <h3>Mutasi</h3>
            </header>
        <div class="modal-body" id="modal_detailKeg">
    </div>
</div>

<div class="box-content">
    <table class="table table-bordered geo-table table-hover" width="100%">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="10%">Nama</th> 
                <th class="center" width="5%">NIP</th>
                <th class="center" width="5%">Gol</th>
                <th class="center" width="6%">Jabatan</th>
                <th class="center" width="8%"></th>
            </tr>
        </thead>
        <tbody id="tampil_pemangku">
             
        </tbody>
    </table>    
</div>
<div id="misal"></div>

<script>
    var url = 'admin/pemangku/aksi.php';
    var rslt = $('#result'); 
	var sourcess = 'admin/pemangku/listSKPD.php';
    
	$('#skpd').change(function(){								//skpd yg akan ditampilkan
		var load = $('#loaderSKPD');
		load.addClass('icon-spinner icon-spin white');
		var l = $.post(sourcess,{act:'tampil_nam',sk:this.value});
		l.done(function(data){
			var datt = data.split('___');
			$('#id_skpd').val(datt[0]);
			$('#tampil_pemangku').html(datt[2]);
			$('#tabelSKPD').html(datt[1]); 
			replay();
		//	mutasion(k);
		});
		load.removeClass();
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
			$('#id').val("0");
			var idinduk = $('#id_skpd').val();
			var post = $.post(url,{act:'piljabatan',skpd:idinduk});
				post.done(function(data){
					$('#jab').html(data);
				});
			$('#kode').val("");
			$('#nama').val("");
			$('#nip').val("");
		}
    });
	
	function jabatan(){										//utk menghitung jmlah orang pada jabatan itu
		var jab = $('#jab').val();
		source ="admin/pemangku/tools.php?code=jab&kdjab="+jab;
		var tes = $.get(source);
		tes.done(function(data){
			$('#pem_no').val(data);
		});
	}
	
	function mutasion(k){
		source = "admin/pemangku/det_mutasi?id_pns="+k;
		var kegiatan = $.get(source);
		kegiatan.done(function(datas){
			$('#modal_detailKeg').html(datas);
			simpan_mut();
	 });
		
	}
		
    $('.btn-simpan-pemangku').click(function(){      
        var btn = $(this);
        var load = $('#loader');
        load.addClass('icon-spinner icon-spin icon-2x white');
       
        var form = $('#form_pemangku');
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
                
                    var tbody = $('#tampil_pemangku');

                    tbody.html(result[2]);
                    replay();
                    $("#id").val("0");
                    $("#jab").val("");
                    $("#gol").val("");
                    $("#nama").val("");
                    $("#nip").val("");
                    $("#telp").val("");
                    $("#alamat").val("");
                    $("#tempat").val("");
                    $("#tgl").val("0");
                    $("#bln").val("0");
                    $("#thn").val("0");
                    $("#pem_no").val("");
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
    
    });
    
    function replay(){
        $('.bt-edit').click(function(){
            var id = this.name;
            var form = $('#form_pemangku');
            var post = $.post(url,{act:'ubah_pemangku',id:id});            
            post.done(function(res){
                var value = res.split('__');
                $('#id_pns').val(value[0]);
                form.find('input[name="nama"]').val(value[1]);
                form.find('input[name="nip"]').val(value[2]);
				//$("#jab").val(value[4]);
                form.find('select[name="jab"]').html(value[12]);
				form.find('select[name="gol"]').val(value[3]);
                form.find('input[name="telp"]').val(value[6]);
                form.find('input[name="alamat"]').val(value[5]);
                form.find('input[name="tempat"]').val(value[7]);
                form.find('select[name="tgl"]').val(value[11]);
				form.find('select[name="bln"]').val(value[10]);
                form.find('select[name="thn"]').val(value[9]);
				
            });
        });
        
        $('.bt-hapus').click(function(){
            var btn = $(this);
            var pid = this.name;
            var load = $(this);
            load.html('<div class="icon-spinner icon-spin icon-2x white"></div>');
            bootbox.confirm("sumpe lu mau ngehapus item ini?", function(hsl){
                if(hsl==true){
                    if(pid!=0){
                        var post = $.post(url,{act:"hapus_pemangku",id:pid});
                        post.done(function(res){
                            var hasil = res.split('__');
                              if(hasil.length == 2){
                                if(hasil[0] == 'success'){
                                    rslt.html('<font color="green">Data Telah Dihapus...</font>');
                                    setTimeout(function(){
                                        rslt.html('');
                                    }, 1500);
                                    var tbody = $('#tampil_pemangku');
                                    tbody.html(hasil[1]);
                                    replay();
                                    //btn.parent().parent().remove();
                                }
                            }
                        });
                        load.html('<i class="icon-trash icon-white">');
                    }
                }else{
                    load.html('<i class="icon-trash icon-white">');
                }
            });
        });
        
    }
	

function simpan_mut(){
 var url ='admin/pemangku/mutasi.php';
 
$('.btn-simpan-mutasi').click(function(){ 
	 var btn = $(this);
	var loadd = $('#loaderr');
	var rslt = $('#result'); 
    loadd.addClass('icon-spinner icon-spin icon-2x white');
	
	var form = $('#mutasi');
    var data = form.serializeArray();
	var post = $.post(url, data);
	post.done(function(res){
		var result = res.split('__');
		if(result.length==8){ 					
				console.log('tes : '+result[0]);
				if(result[1] == 'success'){
					rslt.html('<font color="green">data tersimpan </font>');
					setTimeout(function(){
						rslt.html('');
					}, 1500);
								
					
					bootbox.alert(result[3]+'('+result[4]+') telah dimutasi ke SKPD '+result[6]+' sebagai '+result[5], function() {
					//	Example.show("jakakaka");
						 console.log(result[4]);
					});
							
				//	alert(result[3]+'('+result[4]+') telah dimutasi ke SKPD '+result[6]+' sebagai '+result[5]);
					var tbody = $('#tampil_pemangku');
					tbody.html(result[7]);
				//	init();
					$('#showDetail').modal('hide');
				}else{
					//rslt.html('<font color="red">'+res+'</font>');   
									
					bootbox.alert(result[2], function() {
					//	Example.show("jakakaka");
						 console.log(result[2]);
					});
													
					$('#showDetail').modal('hide');
				}
			}else{
               rslt.html('<font color="red">'+res+'</font>');   
        }
		loadd.removeClass();
            btn.removeClass('btn-info').addClass('btn-primary');

	});
	
});
}


	
    
    
	
</script>