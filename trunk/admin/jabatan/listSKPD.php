<?php
include_once("../../php/postgre.php");
$act='';
if(isset($_POST['act'])) $act = $_POST['act'];
$skp = $_POST['sk'];
$skpd = get_data("select * from skp_skpd where id=".$skp);


if($act=='tampil_nam'){
	$p =$skpd['id'];
	echo $p."___".$skpd['nama']."___";
	view_jabatan($p);
}

function view_jabatan($p){
	$x=1;
	echo $act;
	$pr = get_datas("select * from skp_jabatan where unit_kerja=$p order by idjab");
	if(count($pr) > 0){
		foreach ($pr as $pr){
		?>	<tr>
				<td><?php echo $x ?></td>
				<td>&nbsp;<?php echo $pr['kode_jabatan'] ?></td>
				<td><?php echo $pr['nama_jabatan'] ?></td>
				<td class="center" >
				 <a href="#modalwin" data-toggle="modal"  class="btn btn-info btn-small bt-edit-jabatan" name="<?php echo $pr['idjab']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
				 <a class="btn btn-danger btn-small bt-hapus-jabatan" name="<?php echo $pr['idjab']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

			   </td>
			</tr>
		<?php
		$x++;
		}
	}else{
		 echo "<tr><td colspan='7'><div class='alert center'>Tidak ada data</div></td></tr>";
	}

	
	

}



?>