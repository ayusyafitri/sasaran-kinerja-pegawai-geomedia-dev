<?php
include_once('../../php/include_all.php');
$code = $_GET['code'];
if ($code == 'jab'){
	$kdjab = $_GET['kdjab'];
	$cek = get_data ("select count(p.id_pns) as jml from skp_pns p, skp_jabatan j where j.kode_jabatan=p.kode_jabatan and p.kode_jabatan='".$kdjab."'");
	$jml = $cek['jml'];
	$pemno=$jml+1;
	echo $pemno;
}
?>
