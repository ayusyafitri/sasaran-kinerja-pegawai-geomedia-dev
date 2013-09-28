<?php
include_once ('../../php/postgre.php');
	$kode = addslashes($_POST['rum']);
	$embel = get_datas ("select r.id_rumpun, r.kode_jabatann, r.keterangan from skp_rumpun_jab r, skp_bkn_jabatan j where j.kode_jabatan=r.kode_jabatann and j.nama_jabatan='".$kode."'");
	foreach ($embel as $embel){
		$embelshow .= "<option value='".$embel['keterangan']."'>".$embel['keterangan']."</option>";
	}
	echo $embelshow ;

?>