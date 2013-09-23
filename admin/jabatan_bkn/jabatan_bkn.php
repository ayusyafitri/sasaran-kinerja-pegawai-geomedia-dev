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
        <form id="formSKPD">
            <input type="hidden" name="act" value="jabBKN_simpan">
            <input type="hidden" id="id" name="id" value="0"> 
            <table class="table-form" width="100%">
                <tbody>
                    <tr>
                        <td>Nama Jabatan</td>
                        <td>:</td>
                        <td colspan="5">
                            <input class="input-medium" type="text" name="kode" id="kode"  >
                        </td>
                    </tr>

                    <tr>
                        <td>Kode Jabtan</td>
                        <td>:</td>
                        <td colspan="5">
                            <input class="input-medium" type="text" name="nama" id="nama"  >
                        </td>
                    </tr>
					<tr>
                        <td>Ikhtisar Jabtan</td>
                        <td>:</td>
                        <td colspan="5">
                            <input class="input-large"  type="text" name="nama" id="nama" class="span7" >
                        </td>
                    </tr>
                </tbody>
            </table>
						<input type="hidden" id="jumlah" value="0"></input>
						<input type="hidden" id="kode_jabatan"></input>
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
                        <table>        
                                <tr>
                                    <td colspan="3">
                                        <a class="btn btn-primary bt-simpan-usSKPD"><div id="loader" style="margin-top:2px"></div>&nbsp;Simpan</a>
                                     
                                    </td>
                                </tr>
						</table>
						 
			 
        </form>
    </div>
</div>
<!--div class="box-content">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered geo-table" id="example">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="33%">Jabatan</th> 
                <th class="center" width="33%">Ikhtisar</th>
				<th class="center" width="20%">aksi</th>
			</tr>
        </thead>
        <tbody id="tampilSKPD">
            <?php
            $x = 1;
            $pr = get_datas("select * from skp_bkn_jabatan order by idjab");
            foreach ($pr as $pr) {
                ?><tr>
                    <td><?php echo $x ?></td>
                    <td><?php echo $pr['nama_jabatan'] ?></td>
					<td><?php echo $pr['ikhisar_jabatan']?></td>
					<td class="center" >
                        <a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['id']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                        <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['id']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

                    </td>
                </tr>
                <?php
                $x++;
            }
            ?>
        </tbody>
    </table>    
</div--> 
<script src="js/jquery.dataTables.js"></script>
<script src="js/DT_bootstrap.js"></script>	
<script>
counter = 0;
function tambah_uraian(){
	var ccc = $('#kotak').find("input[name='rows[]']");
	var xcounter = ccc.length+1;
	counterNext = counter + 1 ;
	document.getElementById("input"+counter).innerHTML="<table width='520px' cellspacing='0' cellpadding='0' border='0'><tr><td width='60px' align='center'><input type='hidden' name='id[]'><input type='text' style='width:40px;' name='no[]' value="+xcounter+"></td><td width='430px' align='left'><textarea style='width:420px' name='uraian_tugas[]'  rows='1'></textarea></td><td width='30px' align='center'><i class='icon-remove icon-green'></i><input type='hidden' name='rows[]' value='"+xcounter+"'></td></tr></table><div id=\"input"+counterNext+"\"></div>";
	counter++;
}

</script>