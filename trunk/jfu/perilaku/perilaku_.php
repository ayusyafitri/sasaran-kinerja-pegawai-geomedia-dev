<?php

ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];
/**
 *  untuk tahun , bulan baik itu simpan baru atau edit tetap menyimpan saat waktu berjalan
 */
if ($act == 'actPrilaku') {
    $pnsId = abs($_POST['pnsId']);
    $idPrilaku = abs($_POST['prlkuId']);
    $orientasiPlyn_ = abs($_POST['kre_orientasi']);
    $integritas_ = abs($_POST['kre_integritas']);
    $komitmen_ = abs($_POST['kre_komitmen']);
    $disiplin_ = abs($_POST['kre_disiplin']);
    $kerjasama_ = abs($_POST['kre_kerjasama']);
    $kepemimpinan_ = abs($_POST['kre_kepemimpinan']);
    if (!isset($idPrilaku) OR empty($idPrilaku)) {
        if (!empty($orientasiPlyn_) AND !empty($integritas_) AND !empty($komitmen_) AND !empty($disiplin_) AND
                !empty($kerjasama_) AND !empty($kepemimpinan_)) {
            $idMax = get_maxid('id_perilaku', 'skp_r_perilaku');
            $exec = exec_query("INSERT INTO skp_r_perilaku (id_perilaku,id_pns,orientasi_pelayanan,integritas,komitmen,disiplin,kerjasama,kepemimpinan,tahun,bulan) 
                VALUES ($idMax,$pnsId,$orientasiPlyn_,$integritas_,$komitmen_,$disiplin_,$kerjasama_,$kepemimpinan_, " . date('Y') . ", " . date('n') . ")");
            if (!$exec) {
                echo "2___<font color='red'>Data gagal disimpan !!</font>";
            } else {
                echo "4___<font color='Green'>Data berhasil disimpan !!</font>";
            }
        } else {
            echo "2___<font color='red'>Tidak boleh ada data penilaian yang kosong !!</font>";
        }
    } else {
        if (!empty($orientasiPlyn_) AND !empty($integritas_) AND !empty($komitmen_) AND !empty($disiplin_) AND
                !empty($kerjasama_) AND !empty($kepemimpinan_)) {
            $exec = exec_query("UPDATE skp_r_perilaku SET integritas = $integritas_, komitmen = $komitmen_, disiplin = $disiplin_ , kerjasama = $kerjasama_,
                    kepemimpinan = $kepemimpinan_, orientasi_pelayanan = $orientasiPlyn_ , bulan = " . date('n') . ", tahun = '" . date('Y') . "' where id_perilaku = $idPrilaku");
            if ($exec) {
                echo "4___<font color='green'>Data Penilaian Telah disimpan !!</font>___" . $idPrilaku;
            } else {
                $er = error_get_last();
                echo "2___<font color='red'> Terjadi Kesalahan ketika menyimpan data !! (" . $er['message'] . ")</font>";
            }
        } else {
            echo "2___<font color='red'>Tidak boleh ada data penilaian yang kosong !!</font>";
        }
    }
} else if ($act == 'ldUraian') {
    $thn = abs($_POST['th']);
    $idPns = abs($_POST['pg']);
    $prilaku = get_data("SELECT * FROM skp_r_perilaku where id_pns = '$idPns' and tahun = '$thn'");    
    if (count($prilaku) > 0) {
        echo "5___" . $prilaku['id_perilaku'] . "_" . $prilaku['integritas'] . "_" . $prilaku['komitmen'] . "_" . $prilaku['disiplin'] . "_" . $prilaku['kerjasama'] . "_" . $prilaku['kepemimpinan'] . "_" . $prilaku['orientasi_pelayanan'] . "_";
    } else {
        echo "2___<font color='red'>Belum ada nilai perilaku yang disimpan !!!</font>";
    }
} else {
    echo "10___<font color='red'>System error, no parameter in session !!!</font>";
}
?>
