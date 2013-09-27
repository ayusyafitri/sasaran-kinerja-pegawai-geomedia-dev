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
            <input type="hidden" name="act" value="save_jab_bkn">
            <input type="hidden" id="id_jab_bkn" name="id_jab_bkn" value="0"> 
            <table class="table-form" width="100%">
                <tbody>
                    <tr>
                        <td>Nama Jabatan</td>
                        <td>:</td>
                        <td colspan="5">
                            <select name="gol" id="gol" value="0">
                            	<option value="0" id="bb">-Pilih Rumpun Jabatan-</option>
                                <?php
                                $gol = get_datas ("select * from skp_bkn_jabatan order by idjab");
								foreach ($gol as $gol){
								?>
                                <option value="<?php echo $gol['kode_jabatan'];?>"><?php echo $gol['nama_jabatan'];?></option>
                                <?php
								}
								?>
                            </select>
                        </td>
						<td>
							<input class="input-medium" type="text" name="jabatan" id="jabatan"  >
						</td>
                    </tr>
					 <tr>
                         <td colspan="3">
                            <a class="btn btn-primary btn-small bt-simpan-JabBKN"><div id="loader" style="margin-top:2px"></div>&nbsp;Simpan</a>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
						 
					 
			 
        </form>
    </div>
</div>
<div class="box-content">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered geo-table" id="example">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="33%">Rumpun Jabatan</th> 
                <th class="center" width="33%">Jabatan</th>
				<th class="center" width="20%">aksi</th>
			</tr>
        </thead>
        <tbody id="tampilJabBKN">
            <?php
				$kegiatan = get_datas("select id_rumpun, keterangan, R.kode_jabatann, J.nama_jabatan from skp_bkn_jabatan J, skp_rumpun_jab R where J.kode_jabatan=R.kode_jabatann order by J.kode_jabatan");
				$no=1;
				foreach($kegiatan as $kegiatan){
				?>
				<tr><td style="text-align:center;"><?php echo $no?></td>
					<td><?php echo $kegiatan['nama_jabatan']; ?></td>
					<td><?php echo $kegiatan['keterangan']; ?></td>
					<td class="center">
						<a href="#modalwin" data-toggle="modal" class="btn btn-info btn-small bt-edit" name="<?php echo $kegiatan['id_rumpun']; ?>"><i class="icon-edit icon-white"></i>Ubah</a>
						<a class="btn btn-danger btn-small bt-hapus" name="<?php echo $kegiatan['id_rumpun']; ?>"><i class="icon-trash icon-white"></i>Hapus</a>
					</td>
				</tr>
				<?php
				$no++;
				}
            ?>
        </tbody>
    </table>    
</div> 
<!--script src="js/jquery.dataTables.js"></script>
<script src="js/DT_bootstrap.js"></script-->	
<script>
 
$('.btn-tambah').click(function(){
	$('#id_jab_bkn').val("0");
 	$('#jabatan').val("");
	document.getElementById('bb').selected=true;
});

var urls ='admin/jabatan_bkn/aksi_jabatanBKN.php';
var rslt = $('#result'); 
 
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
				$('#id_jab_bkn').val("0");
				$('#jabatan').val("");

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
		var post = $.post(urls,{act:'edit_jab_bkn', id_jab_bkn:id_jab_bkn});
		post.done(function(res){
			var value =res.split('__');
			$('#id_jab_bkn').val(value[0]);
			$('#gol').val(value[1]);
			$('#jabatan').val(value[2]);
			 
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
					var post = $.post(urls,{act:"del_jab_bkn", id_jab_bkn:pid});
					post.done(function(data){
						var hasil = data.split('__');
						                             if(hasil.length == 2){
                                if(hasil[0] == 'success'){
                                    rslt.html('<font color="green">Data Telah Dihapus...</font>');
                                    setTimeout(function(){
                                        rslt.html('');
                                    }, 1500);
                                    var tbody = $('#tampilJabBKN');
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
</script>