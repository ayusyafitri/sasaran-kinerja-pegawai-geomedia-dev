<?php
include_once('../../php/postgre.php');

$act = '';
if(isset($_POST['act'])) $act = $_POST['act'];
if($act=='save_jab_bkn'){
	$idjab = $_POST['id_jab_bkn'];
	$rumpun = $_POST['gol'];
	$jabatan = $_POST['jabatan']; 
	
	if(!is_numeric($idjab)) {
		echo "Err: invalid id.";
		exit;
	}
	
	if($idjab>0){
		exec_query("update skp_rumpun_jab set keterangan='".$jabatan."' ,kode_jabatann='".$rumpun."' where id_rumpun=".$idjab);
		echo 'success__';
	}else{
		$maxid = get_maxid('id_rumpun','skp_rumpun_jab');
		exec_query("insert into skp_rumpun_jab(id_rumpun,kode_jabatann,keterangan) values(".$maxid.",'".$rumpun."','".$jabatan."')");
		$stored = get_data('select id_rumpun from skp_rumpun_jab where id_rumpun='.$maxid);
		if($stored['id_rumpun']==$maxid){
			echo 'success__';
			$idjab = $maxid;
		}
	}
	
	echo $idkeg.'__';
	view_jabatan_bkn();
	
}else if($act=='del_jab_bkn'){
	$idjab = $_POST['id_jab_bkn'];
	if(is_numeric($idjab)){
		exec_query("delete from skp_rumpun_jab where id_rumpun=".$idjab);
		echo 'success';
	}
	echo '__';
	view_jabatan_bkn();
}

else if($act=='edit_jab_bkn'){
$idjab = $_POST['id_jab_bkn'];
	if(is_numeric($idjab)){
		$data = get_data("select * from skp_rumpun_jab  where id_rumpun=".$idjab);
		$rumpun = get_datas("select idjab, nama_jabatan from skp_bkn_jabatan where kode_jabatan='".$data['kode_jabatann']."'");
		$drum = '__';
			$drum .= '<option value="0">- Pilih Rumpun Jabatan -</option>';
		foreach($rumpun as $rumpun){
			$drum .= '<option value="'.$rumpun['kode_jabatan'].'">'.$rumpun['nama_jabatan'].'</option>';
		}
		
		$ress = implode($data,'__');
		print_r($ress);
		echo $drum;
	}else{
		echo 'error';
	}
} 

function view_jabatan_bkn(){
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
}
?>