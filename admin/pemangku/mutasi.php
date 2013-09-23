<?php
include_once("../../php/include_all.php");
include ("aksi.php");

$sk = $_GET['skpd'];
$tahun = date('Y');
$bulan = date('m');
$tgl = date('d');
$act = '';
if(isset($_POST['act']))
	$act = $_POST['act'];
if ($code == 'jab'){
	$jabatan = get_datas("select * from skp_jabatan where unit_kerja=".$sk."order by idjab ");
	echo "<option value='0'>--plih jabatan--</option>";
	foreach ($jabatan as $jab) {
		$kodejab = $jab['kode_jabatan'];
		$namajab = $jab['nama_jabatan'];
		echo "<option value='$kodejab'>&nbsp;$namajab</option>";
	}
}

else if($act == 'input_mutasi'){
	$id = $_POST['id_pns'];
	$skpd = $_POST['mut'];
	$jab = $_POST['jabb'];
	$jabawl = $_POST['kode_jabAwl'];
	if (!is_numeric($id)) {
	echo $id;
        echo "Err : invalid id. ";
        exit;
    }
	if($id > 0){
		exec_query ("update skp_pns set kode_jabatan='".$jab."' where id_pns=".$id."");
		echo 'success__';
	 
		$maxid = get_maxid('id_temp','skp_jabatan_hist');
		exec_query("insert into skp_jabatan_hist (id_temp, id_pns, kode_jabatan, bulan, tahun, tanggal) values (".$maxid.",".$id.",'".$kode_jabAwl."',".$bulan.",".$tahun.",".$tgl.")");
		$br = get_data("select id_temp from skp_jabatan_hist where id_temp=".$maxid);
		if($br['id_temp'] == $maxid){
			echo 'success__';
			$idd = $maxid; 
		}
	}
	echo $idd. '__';
	$pnsbr = get_data("select p.nama as nama_pe, p.nip, j.nama_jabatan, j.unit_kerja, s.nama from skp_skpd s, skp_jabatan j, skp_pns p where s.id=j.unit_kerja and j.kode_jabatan=p.kode_jabatan and id_pns=".$id);
	echo $namabr = $pnsbr['nama_pe'].'__';
	echo $nipbr = $pnsbr['nip'].'__';
	echo $jabbr = $pnsbr['nama_jabatan'].'__';
	echo $skpdbr = $pnsbr['nama'].'__';
	
	view_skpd($skpd);
}


?>