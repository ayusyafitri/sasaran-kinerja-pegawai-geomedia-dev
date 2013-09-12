<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'LdUraian') {
    $dta = get_datas("SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB . "'", 'samarinda');
    $no = 1;
    if (count($dta) > 0) {
        //   echo "SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB . "'";
        foreach ($dta as $isiData) {
            ?>
            <tr><td align="center" valign="middle" style="width:3%;"><?php echo $no; ?> </td>
                <td align="center" style="width:58%;"><textarea style="width: 100%;" name="uraian[]"><?php echo ucfirst($isiData['uraian']); ?></textarea></td> 
                <?php if (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') { ?>
                    <td style="width:8%;"><input class="input-small" type="text" name="ak[]" /></td>
                <?php } ?>
                <td style="width:8%;"><input class="input-small" type="text" name="output[]" /></td>
                <td style="width:8%;"><input class="input-small" type="text" name="mutu[]" /></td>
                <td style="width:8%;"><input class="input-small" type="text" name="waktu[]" /></td>
                <td style="width:8%;"><input class="input-small" type="text" name="biaya[]" /></td>
                <td >
                    <button class="btn btn-info bt-edit btn-small"  name="<?php echo $isiData['id_uraian'] ?>"><i class="icon-edit icon-white"></i></button>
                    <button class='btn btn-danger bt-hapus btn-small' name="<?php echo $isiData['id_uraian'] ?>"><i class="icon-trash icon-white"></i></button>   
                </td>
            </tr>
            <?php
            $no++;
        }
    } else {
        echo "<tr colspan='8'><div class='alert alert-info center'>Tidak ada uraian" . "SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . $_SESSION['_kdJabatan'] . "'" . "</tr>";
    }
} else if ($act == 'saveTgt') {
    $uraian = $_POST['uraian'];
    $mutu = $_POST['mutu'];
    $biaya = $_POST['biaya'];
    $output = $_POST['output'];
    $waktu = $_POST['waktu'];
    $tupoksi = $_POST['tupoksi'];
    $nouraian = $_POST['nouraian'];
    $ak = @$_POST['ak'];
    $idKinerja_temp = array();
    $idUraian_temp = array();
    $cek = FALSE;
    if (count($waktu) > 0) {
        $skp = get_data("SELECT sum(distinct(id_skp)) as jumlah from skp_t_kerja");
        $id_skp = (empty($skp)) ? 1 : (int) $skp + 1;
        for ($i = 0; $i < count($uraian); $i++) {
            $uraian_ = str_replace("'", "''", $uraian[$i]);
            $mutu_ = abs($mutu[$i]);
            $biaya_ = abs($biaya[$i]);
            $output_ = abs($output[$i]);
            $waktu_ = abs($waktu[$i]);
            $tupoksi_ = abs($tupoksi[$i]);
            $nouraian_ = abs($nouraian[$i]);
            $ak_ = (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') ? abs($ak[$i]) : 'NULL';
            if (!empty($uraian_) AND !empty($mutu_) AND !empty($biaya_) AND !empty($output_) AND !empty($waktu_)) {
                $idKinerja = get_maxID('id_tkerja', 'skp_t_kerja');
                $idUraian = get_maxid('id_uraian', 'skp_uraian');
                $insK = exec_query("insert into skp_t_kerja(bulan,tahun,kode_jabatan,angka_kredit,id_pns,id_uraian,output,mutu,waktu,biaya,id_skp,id_tkerja)
                    VALUES('" . date('n') . "','" . date('Y') . "','" . SKP_KODEJAB . "',$ak_," . SKP_ID . ",$idUraian,$output_,$mutu_,$waktu_,$biaya_,$id_skp,$idKinerja)");
                $insU = exec_query("insert into skp_uraian(id_uraian,uraian,tupoksi,no_uraian,tahun,kode_jabatan,jns_jabatan)
                    VALUES($idUraian,'$uraian_',$tupoksi_,$nouraian_,'" . date('Y') . "','" . SKP_KODEJAB . "','" . SKP_JNSJAB . "')");
                if ($insK AND $insU) {
                    array_push($idUraian_temp, $idUraian);
                    array_push($idKinerja_temp, $idKinerja);
                    unset($mutu_);
                    unset($uraian_);
                    unset($biaya_);
                    unset($waktu_);
                    unset($output_);
                    unset($nouraian_);
                    unset($tupoksi_);
                    $cek = TRUE;
                    //echo $cek . " :: " . print_r($idKinerja_temp) . " :: " . print_r($idUraian_temp);
                } else {
                    echo "5___Ada data yang kosong";
                    $cek = FALSE;
                    rollBack($idUraian_temp, $idKinerja_temp);
                    break 1;
                }
            } else {
                $cek = FALSE;
                echo "5___Ada data yang kosong";
                rollBack($idUraian_temp, $idKinerja_temp);
                break 1;
            }
        }
        if ($cek) {
            echo "2___Data Tersimpan";
        }
    } else {
        echo "5___Tidak Ada Data Tersimpan";
    }
} elseif ($act == 'rbTgt') {
    $uraian_ = str_replace("'", "''", $_POST['ur']);
    $mutu_ = abs($_POST['mt']);
    $biaya_ = abs($_POST['by']);
    $output_ = abs($_POST['out']);
    $waktu_ = abs($_POST['wkt']);
    $tupoksi_ = abs($_POST['tpk']);
    $nouraian_ = abs($_POST['nour']);
    $idTargetKerja = abs($_POST['di']);
    $ak_ = (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') ? abs($ak[$i]) : 'NULL';
    if (!empty($uraian_) AND !empty($mutu_) AND !empty($biaya_) AND !empty($output_) AND !empty($waktu_) AND !empty($idTargetKerja)) {
        $idUr = exec_query("SELECT id_uraian FROM skp_t_kerja where id_tkerja = $idTargetKerja");
        $setUr = exec_query("UPDATE skp_uraian SET uraian = '$uraian_'");
        $setTK = exec_query("UPDATE skp_t_kerja SET angka_kredit = $ak_, mutu = $mutu_, biaya = $biaya_,waktu = $waktu_ , output = $output_ 
            where id_tkerja = $idTargetKerja");
        if ($setUr AND $setTK){
            echo "3___Data tersimpan !!";
        }else{
            echo "1___Data gagal di simpan !!! ";
        }
    }
}

function rollBack($arUraian, $arKinerja) {
    for ($ur = 0; $ur < count($arUraian); $ur++) {
        exec_query("DELETE FROM skp_uraian where id_uraian = '" . $arUraian[$ur] . "'");
    }
    for ($aK = 0; $aK < count($arKinerja); $aK++) {
        exec_query("DELETE FROM skp_t_kerja where id_tkerja = '" . $arUraian[$aK] . "'");
    }
}
?>
