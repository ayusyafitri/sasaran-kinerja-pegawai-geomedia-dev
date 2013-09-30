<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'cfm') {
    $idPns = abs($_POST['di']);
    $tglSkr = date('Y').'-'.date('m').'-'.date('d');
    $dtTarget = get_data("SELECT s.status FROM skp_t_kerja t, skp_t_status s where t.id_tkerja = s.id_tkerja 
        and t.id_pns = '$idPns' and t.tahun = '" . date('Y') . "' and s.status = '1' GROUP BY s.status");
    if (count($dtTarget) > 0) {
        $dtRealisasi = get_data("SELECT r.r_status FROM skp_r_kerja r, skp_t_kerja t WHERE t.id_tkerja = r.id_tkerja 
            and t.id_pns = '$idPns' and r.r_status = '1' GROUP BY r.r_status");
        if (count($dtRealisasi) > 0) {
            $nilaiSKP = hitungSkp($idPns, date('Y'), date('n'));
            $dtPerilaku = get_data("SELECT integritas,komitmen,disiplin,kerjasama,kepemimpinan,orientasi_pelayanan FROM skp_r_perilaku WHERE id_pns = '$idPns' and tahun = '" . date('Y') . "' order BY bulan DESC LIMIT 1");
            if (count($dtPerilaku) > 0) {
                $dtPenilaian = get_data("SELECT * FROM skp_penilaian where id_pns = '$idPns' and EXTRACT(YEAR FROM tanggal) = '".  date('Y')."'");               
                $cturwlnSkr = getTriwulan(date('n'));               
                if($cturwlnSkr != $dtPenilaian['caturwulan']){
                    $idPen = get_maxid("id_penilaian", "skp_penilaian");
                    $exec = exec_query("INSERT INTO skp_penilaian (id_penilaian,id_pns,caturwulan,nilai_prilaku,nilai_capaian,tanggal) VALUES
                        ($idPen,$idPns,$cturwlnSkr,".$nilaiSKP['nilaiSKP'].",".$nilaiSKP['perilaku'].",'".$tglSkr."')");
                }else{                          
                    $exec = exec_query("UPDATE skp_penilaian SET nilai_prilaku = ".$nilaiSKP['perilaku'].", nilai_capaian = ".$nilaiSKP['capaian']." WHERE id_penilaian = '".$dtPenilaian['id_penilaian']."' ");                    
                }
                if(!$exec){                    
                    echo "2___<font color='red'>Gagal menyimpan data penilaian!!</font>";
                }else{                    
                    echo "3___<font color='Green'>Data berhasil disimpan !!!</font>___$tglSkr";
                }
            } else {
                echo "2___<font color='red'>Penilaian perilaku masih kosong</font>";
            }
        } else {
            echo "2___<font color='red'>Belum ada realisasi kerja yang sudah disetujui !!</font>";
        }
    } else {
        echo "2___<font color='red'>Belum ada target kerja yang sudah disetujui !!</font>";
    }
}
?>
