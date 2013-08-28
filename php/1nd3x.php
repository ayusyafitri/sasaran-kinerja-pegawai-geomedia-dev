<?php

ob_start();
session_start();
include_once('postgre.php');
$usr = addslashes($_POST['whoareyou']);
$pwd = addslashes($_POST['yoursecret']);

if (isset($_POST['what']))
    $what = $_POST['what'];
if (isset($_GET['what']))
    $what = $_GET['what'];

if ($what == 'inn') {
    $h = get_datas("select nip, nama, kode_jabatan, username, id_pns from skp_pns where username='" . $usr . "' and password='" . $pwd . "'");    
    if (count($h) > 0) {
        
        $_SESSION['_nip'] = $h[0]['nip'];
        $_SESSION['_nama'] = $h[0]['nama'];
        $_SESSION['_kdJabatan'] = $h[0]['kode_jabatan'];
        $_SESSION['_username'] = $h[0]['username'];
        echo 'suk___admindata.php';
    } else {
        echo 'gal';
    }
}else if ($what == 'outt'){
    unset($_SESSION['_nip']);
    unset($_SESSION['_nama']);
    unset($_SESSION['_kdJabatan']);
    unset($_SESSION['_username']);
    session_destroy();
    header("Location:index.php");
}
?>