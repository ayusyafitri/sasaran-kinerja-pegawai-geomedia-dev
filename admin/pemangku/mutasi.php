<?php
include_once("../../php/include_all.php");
$sk = $_GET['skpd'];
if ($code == 'jab'){
	$jabatan = get_datas("select * from skp_jabatan where unit_kerja=".$sk."order by idjab ");
	echo "<option value='0'>--plih jabatan--</option>";
	foreach ($jabatan as $jab) {
		$kodejab = $jab['kode_jabatan'];
		$namajab = $jab['nama_jabatan'];
		echo "<option value='$kodejab'>&nbsp;$namajab</option>";
	}
}
else if($code == 'input_mutasi'){
	$id = $_POST['pns'];
	$skpd = $_POST['skpd'];
	$jab = $_POST['jab'];
	if (!is_numeric($id)) {
        echo "Err : invalid id. ";
        exit;
    }
	if($id > 0){
		exec_query ("update skp_pns where set kode_jabatan='".$jab."' where id_pns=".$id);
		echo 'success__';
	}else {
		$maxid = get_maxid('id_temp','skp_temp_jabatan');
		exec_query("insert into skp_temp_jabatan (id_temp, id_pns, id_jabatan) values (".$maxid.",".$id.",'".$jab."')");
		$br = get_data("select id_temp from where id_temp=".$maxid);
		if($st['id_temp'] == $maxid){
			echo 'success__';
			$idtemp = $maxid; 
		}
	}
	echo $idtemp. '__';

}

?>