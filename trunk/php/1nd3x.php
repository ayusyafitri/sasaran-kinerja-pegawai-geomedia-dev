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
    $p = abs($_POST['part']);
    $cek = get_data("SELECT * FROM alluser where lower(username) = '".  strtolower($usr)."' and password = '$pwd' order by id DESC LIMIT 1");
//    echo "SELECT * FROM alluser where lower(username) = '".  strtolower($usr)."' and password = '$pwd'";
    if (count($cek) > 0) {
        $h = get_datas("select p.nip, p.nama, p.kode_jabatan, p.username, p.id_pns, j.jabatan from skp_pns p, skp_jabatan j where p.kode_jabatan = j.kode_jabatan and lower(p.username)='" . strtolower($usr) . "' and p.password='" . $pwd . "'");
        if (count($h) > 0) {
            $_SESSION['_nip'] = $h[0]['nip'];
            $_SESSION['_nama'] = $h[0]['nama'];
            $_SESSION['_kdJabatan'] = $h[0]['kode_jabatan'];
            $_SESSION['_username'] = $h[0]['username'];
            $_SESSION['_id'] = $h[0]['id_pns'];
            $_SESSION['_jabatan'] = $h[0]['jabatan'];
            $_SESSION['_menu'] = 3;
            echo 'suk___admindata.php';
        } else {
            $dt = get_data("SELECT nama, username,kode,id FROM skp_skpd where lower(username) = '".strtolower($usr)."' and  password = '$pwd'");
            if (count($dt) > 0) {                
                $_SESSION['_namaSkpd'] = $dt['nama'];
                $_SESSION['_username'] = $dt['username'];
                $_SESSION['_kodeSkpd'] = $dt['kode'];
                $_SESSION['_id'] = $dt['id'];
                $_SESSION['_menu'] = 2;
                echo 'suk___admindata.php';
            }else{
                echo "gal___<font color='red'>Thi's weird there is no data &  no acces login !!!</font>";
            }
        }
    } else {
        echo "gal___<font color='red'>I don't understand</font>";
    }
} else if ($what == 'outt') {
    unset($_SESSION['_nip']);
    unset($_SESSION['_nama']);
    unset($_SESSION['_kdJabatan']);
    unset($_SESSION['_username']);
    unset($_SESSION['_idpns']);
    unset($_SESSION['_jabatan']);
    session_destroy();
    echo 'ko';
}
?>