<?php
include_once("../php/include_all.php");
$act = '';
if(isset($_POST['act'])) $act = $_POST['act'];
if ($act=='simpan_daftar'){
	$id_user = $_POST['id_user'];
	$username = $_POST['username'];
	$pass = $_POST['pass'];
	$nama = $_POST['nama'];
	$nip = $_POST['nip'];
	$email = $_POST['email'];
	$copas = $_POST['co_pass'];
	$idskpd = $_POST['skpd'];
	if (!is_numeric ($id_user)){
		echo "Err: invalid id";
		exit;
	}
	$maxid = get_maxid ('id_user', 'skp_username');
	exec_query("insert into skp_username (id_user, nama, nip, username, password, id_skpd, email) values(".$maxid.", '".$nama."', '".$nip."', '".$username."', '".$pass."', ".$idskpd.", '".$email."')");
	$stored = get_data("select id_user from skp_username where id_user=".$maxid);
	if ($stored['id_user']==$maxid){
		echo "success__";
		$id_user = $maxid;
	}
	echo $id_user;
}
?>
