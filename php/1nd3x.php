<?php

ob_start();

include_once('postgre.php');
$usr = addslashes($_POST['whoareyou']);
$pwd = addslashes($_POST['yoursecret']);

$r = 'index.php';
$h = get_datas("select nip, nama, kode_jabatan, username, id_pns from skp_pns where username='" . $usr . "' and password='" . $pwd . "'");
//$d = count($ih);
print_r($h);
if (count($h) > 0) {    
    session_start();
    $_SESSION['_nip'] = $h[0];
    echo $h[0]." - ";
    $_SESSION['_nama'] = $h[1];
    echo $h[1]." - ";
    $_SESSION['_kdJabatan'] = $h[2];
    echo $h[2]." - ";
    $_SESSION['_username'] = $h[3];
    echo $h[3]." - ";
    echo 'suk___admindata.php<br>';
    
    print_r($_SESSION);
    
} else {
    echo 'gal';
}
?>