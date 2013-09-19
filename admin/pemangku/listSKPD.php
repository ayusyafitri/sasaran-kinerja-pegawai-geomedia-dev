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
	$pr = get_datas("select p.id_pns, p.nama, p.nip, p.id_golongan, p.id_golongan, j.nama_jabatan, p.alamat, p.notelp, p.tempat_lahir, p.tanggal_lahir 
from skp_pns p, skp_jabatan j where j.kode_jabatan=p.kode_jabatan and j.unit_kerja=".$p." order by id_pns");
	
	if(count($pr) > 0){
		foreach ($pr as $pr){
		?>	<tr>
				<td><?php echo $x ?></td>
				<td><a href="#showDetail" data-toggle="modal" id="mutasi" name="mutasi" onclick="mutasion(<?php echo $pr['id_pns']; ?>)">&nbsp;<?php echo $pr['nama'] ?></a></td>
				<td><?php echo $pr['nip'] ?></td>
				<td><?php echo $golongan['nama_golongan']?> (<?  echo $golongan['keterangan'] ?>)</td>
                <td><?php echo $pr['nama_jabatan'] ?></td> 
				<td class="center" >
					<a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['id_pns']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                    <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['id_pns']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

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

 