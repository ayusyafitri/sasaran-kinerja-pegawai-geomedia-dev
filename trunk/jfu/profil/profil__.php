<?php

ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'imgUpload') {
    $uploaddir = '../../imgPns/';
    $fileName = basename($_FILES['imgUp']['name']);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileNew = 'pf_' . SKP_NIP . "_." . $ext;
    $fileDir = $uploaddir . $fileNew;
    if (move_uploaded_file($_FILES['imgUp']['tmp_name'], $fileDir)) {
        $exec = exec_query("UPDATE skp_pns SET image_profil = '$fileNew' where id_pns = " . SKP_ID);
        if ($exec) {
            echo "2___imgPns/$fileNew?" . mktime();
        } else {
            echo "3___<font color='red'>Failed Save Image Name !!!</font>";
            unlink($fileDir);
        }
    } else {            
        echo "3___<font color='red'>Gagal Upload Gambar !! Cek koneksi !!!</font>";
    }
} else if ($act == 'sve') {
    $kolom = addslashes($_POST['nm']);
    $id = abs($_POST['d']);
    $isi = str_replace("'", "''", $_POST['isi']);
    if ($kolom == 'username') {
        $cek = get_data("select * FROM alluser where lower(username) = '" . strtolower($isi) . "'");
        if (count($cek) > 0) {
            echo "5___<font color='red'>Username '$isi' sudah digunakan !!</font>";
        } else {
            UpdatePns($kolom, $isi, $id);
        }
    } else {
        UpdatePns($kolom, $isi, $id);
    }
} else {
    echo "10___echo <font color='red'>Error in paramater !! no request accepted !!!</font>";
}

function UpdatePns($kolom, $isi, $id) {
    $exec = exec_query("UPDATE skp_pns SET $kolom = '$isi' where id_pns = " . $id);
    $isi = ($kolom == 'password') ? showPassInOtherCharacter($isi) : $isi;
    if ($exec) {
        echo "2___<font color='green'>Data sudah tersimpan</font>___$isi";
    } else {
        echo "5___<font color='red'>Data belum tersimpan !!</font>";
    }
}

?>
