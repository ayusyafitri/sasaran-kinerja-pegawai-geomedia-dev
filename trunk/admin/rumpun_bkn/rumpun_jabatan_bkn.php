<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
include_once ('../../php/postgre.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Daftar Jabatan BKN</h5>
</div>
<div class="position-relative" id="page-content">
    <table>
	<tr><td><a href="#modalwin" data-toggle="modal" class="btn btn-small btn-primary no-radius btn-tambah"><i class="icon-plus"></i>&nbsp;Tambah Data</a>
		&nbsp;<span id="load" class="spinner"></span></td>
		<td id="tulisan"></td>
	</tr></table>
</div>
<div id="modalwin" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <header class="modal-header"> 
        <a href="#" class="close geo-clear" data-dismiss="modal">x</a>
        <h3>Data Jabatan BKN</h3>
    </header>

    <div class="modal-body">
        <form id="formJabBKN">
            <input type="hidden" name="act" value="jabBKN_simpan">
            <input type="hidden" id="id_jab_bkn" name="id_jab_bkn" value="0"> 
            <table class="table-form" width="100%">
                <tbody>
                    <tr>
                        <td>Nama Jabatan</td>
                        <td>:</td>
                        <td colspan="5">
                            <input class="input-medium" type="text" name="nama" id="nama"  >
                        </td>
                    </tr>

                    <tr>
                        <td>Kode Jabtan</td>
                        <td>:</td>
                        <td colspan="5">
                            <input class="input-medium" type="text" name="kode" id="kode"  >
                        </td>
                    </tr>
					<tr>
                        <td>Ikhtisar Jabatan</td>
                        <td>:</td>
                        <td colspan="5">
                            <input class="input-large"  type="text" name="ikhtisar" id="ikhtisar" class="span7" >
                        </td>
                    </tr>
                </tbody>
            </table>
						<!--input type="hidden" id="jumlah" value="0"></input>
						<!--input type="hidden" id="kode_jabatan"></input-->
						<hr width="520px" align="left">
						<table width="520px" cellspacing="0" cellpadding="0" border="0">
							<thead>
								<tr>
									<th width="8px">No</th>
									<th width="100px">Uraian Tugas</th>
									<th width="50px"></th>
								</tr>
							</thead>
						</table>
						
						<div id="kotak">
							<div id="cobadt"></div>
							<div id="input0"></div>
						</div>
						<a href="javascript:tambah_uraian();">Tambah Rincian Kegiatan</a>
                        <table align="right">        
                                <tr>
                                    <td colspan="3">
                                        <a class="btn btn-primary btn-small bt-simpan-JabBKN"><div id="loader" style="margin-top:2px"></div>&nbsp;Simpan</a>
                                     
                                    </td>
                                </tr>
						</table>
						 
			 
        </form>
    </div>
</div>
<div class="box-content">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered geo-table" id="example">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="33%">Jabatan</th> 
                <th class="center" width="33%">Ikhtisar</th>
				<th class="center" width="20%">aksi</th>
			</tr>
        </thead>
        <tbody id="tampilJabBKN">
            <?php
            $x = 1;
            $pr = get_datas("select * from skp_bkn_jabatan order by idjab");
            foreach ($pr as $pr) {
                ?><tr>
                    <td><?php echo $x ?></td>
                    <td><?php echo $pr['nama_jabatan'] ?></td>
					<td><?php echo $pr['ikhtisar_jabatan']?></td>
					<td class="center" >
                        <a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['idjab']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                        <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['idjab']; ?>"><i class="icon-trash icon-white"></i> hapus</a>
				    </td>
                </tr>
                <?php
                $x++;
            }
            ?>
        </tbody>
    </table>    
</div> 
<!--script src="js/jquery.dataTables.js"></script>
<script src="js/DT_bootstrap.js"></script-->	
<script>
counter = 0;
function tambah_uraian(){
	var ccc = $('#kotak').find("input[name='rows[]']");
	var xcounter = ccc.length+1;
	counterNext = counter + 1 ;
	document.getElementById("input"+counter).innerHTML="<table width='520px' cellspacing='0' cellpadding='0' border='0'><tr><td width='60px' align='center'><input type='hidden' name='id[]'><input type='text' style='width:40px;' name='no[]' value="+xcounter+"></td><td width='430px' align='left'><textarea style='width:420px'  rows='1' name='uraian_tugas_bkn[]' ></textarea></td><td width='30px' align='center'><i class='icon-remove icon-green'></i><input type='hidden' name='rows[]' value='"+xcounter+"'></td></tr></table><div id=\"input"+counterNext+"\"></div>";
	counter++;
}

$('.btn-tambah').click(function(){
	$('#id_jab_bkn').val("0");
	$('#nama').val("");
	$('#kode').val("");
	$('#ikhtisar').val("");
	var ktk = $('#kotak');
	ktk.html("<div id='nyoba'></div><div id='input0'></div>");
});

var urls ='admin/rumpun_bkn/aksi_rumpun_jabBKN.php';
 
$('.bt-simpan-JabBKN').click(function(){
	var btn = $(this);
	var load = $('#loader');
	var rslt = $('#result');
	load.addClass('spinner pull-left');
	btn.removeClass('btn-primary').addClass('btn-info');
	
	var form = $('#formJabBKN');
	var data = form.serializeArray();
	var post = $.post(urls,data);
	
	post.done(function(res){
		var result = res.split('__');
		if(result.length==3){
			if(result[0]=='success'){
				rslt.html('<font color="green">Tersimpan</font>');
				setTimeout(function(){
					rslt.html(' ');
				}, 1500);
				
				var tbody = $('#tampilJabBKN');
				tbody.html(result[2]);
				init();
				$('#nama').val("");
				$('#kode').val("");
				$('#ikhtisar').val("");
				$('#kotak').val("");
				var ktk = $('#kotak');
				ktk.html("<div id='cobadt'></div><div id='input0'></div>");

				$('#modalwin').modal('hide');
			} else{
				rslt.html('<font color="red">'+res+'</font>');
			}
		}else{
			rslt.html('<font color="red">'+res+'</font>');
		}
		load.removeClass();
		btn.removeClass('btn-info').addClass('btn-primary');
	});
});

function init(){
	$('.bt-edit').click(function() {
		var id_jab_bkn= this.name;
		var form = $('#formJabBKN');
		var post = $.post(urls,{act:'edit-bkn', id_jab_bkn:id_jab_bkn});
		post.done(function(res){
			var value =res.split('__');
			$('#id_jab_bkn').val(value[0]);
			$('#nama').val(value[1]);
			$('#kode').val(value[2]);
			$('#ikhtisar').val(value[3]);
			$('#cobadt').html(value[4]);
			 
		});
	});
	$('.bt-hapus').click(function() {
		var btn  = $(this);
		var pid  = this.name;
		var load = $(this);
		 load.html('<div class="icon-spinner icon-spin icon-2x white"></div>');
         bootbox.confirm("Anda akan menghapus jabatan ini?", function(result){
			if(result==true){
				if(pid!=0){
						alert(34);
					var post = $.post(urls,{act:"hapus-bkn", idjab:pid});
					post.done(function(data){
						var hasil = data.split('__');
						if(hasil.length==2){
							if(hasil[0]=='success'){
								var tbody = $('#tampilJabBKN');
								tbody.html(result[1]);
								
								init();
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
</script>