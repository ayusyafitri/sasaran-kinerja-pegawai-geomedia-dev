<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'realss') {
    $mutu = $_POST['mutu'];
    $biaya = $_POST['biaya'];
    $output = $_POST['output'];
    $waktu = $_POST['waktu'];
    $idTargetK = $_POST['trgtid'];
    $idreals = $_POST['realssid'];
    $idArSKP = array();
    $cek = FALSE;   
    if (count($mutu) > 0) {
        for ($u = 0; $u < count($mutu); $u++) {
            $mutu_ = abs($mutu[$u]);
            $biaya__ = abs($biaya[$u]);
            $output_ = abs($output[$u]);
            $waktu__ = abs($waktu[$u]);
            $idtarget_ = abs($idTargetK[$u]);
            $idreal_ = abs($idreals[$u]);
            $dtTarget = get_data("SELECT waktu, biaya FROM skp_t_kerja where id_tkerja = '$idtarget_'");
            $waktu_ = ($dtTarget['waktu'] == '0')? '0':$waktu__ ;
            $biaya_ = ($dtTarget['biaya'] == '0')? '0' : $biaya__;
            if (!empty($mutu_) AND !empty($output_)) {
                if (empty($idreal_)) {
                    $idRealisasi = get_maxID('id_realisasi', 'skp_r_kerja');
                    $execR = exec_query("INSERT INTO skp_r_kerja (r_output, r_mutu, r_waktu, r_biaya,id_tkerja, id_realisasi) 
                    VALUES($output_,$mutu_, $waktu_,$biaya_,$idtarget_,$idRealisasi)");
                } else {
                    $execR = exec_query("UPDATE skp_r_kerja SET r_output = $output_ , 
                        r_mutu = $mutu_ , r_waktu = $waktu_ , r_biaya = $biaya_ where id_realisasi = '$idreal_'");
                }
                if ($execR) {
                    array_push($idArSKP, $idRealisasi);
                    unset($mutu_);
                    unset($biaya_);
                    unset($output_);
                    unset($waktu_);
                    unset($idtarget_);
                    unset($idreal_);
                    $cek = TRUE;
                } else {
                    echo "5___<font color='red'>Ada data <b>Output</b> atau <b>Mutu</b>  yang kosong, simpan gagal !!! </font>&nbsp;&nbsp;" . print_r(error_get_last());
                    $cek = FALSE;
                    rollBack($idArSKP, 'realisasi');
                    break 1;
                }
            } else {
                echo "5___<font color='red'>Ada data yang kosong</font>" . print_r(error_get_last());
                $cek = FALSE;
                rollBack($idArSKP, 'realisasi');
                break 1;
            }
        }
    } else {
        echo "5___<font color='blue'>Tidak Ada data yang tersimpan</font>";
        $cek = FALSE;
    }
    if ($cek) {
        echo "2___<font color='green'>Data Tersimpan</font>___";
        viewTblRealisasi();
    }
} else if ($act == 'tmbhn') {
    $uraian = $_POST['uraian_tam'];
    $ditamb = $_POST['idtmbhn'];
    $idSKP = $_POST['skp_d'];
    $cek = FALSE;
    for ($in = 0; $in < count($uraian); $in++) {
        $uraiantam_ = str_replace("'", "''", $uraian[$in]);
        $idUraianTam_ = $ditamb[$in];
        if (!empty($uraiantam_)) {
            if (empty($idUraianTam_)) {
                $idUraianTam_ = get_maxid('id_uraian_tambahan', 'skp_r_tambahan');
                $sqlTam = exec_query("INSERT INTO skp_r_tambahan (id_uraian_tambahan,id_skp,uraian_tambahan) VALUES ($idUraianTam_,$idSKP,'$uraiantam_')");
                if ($sqlTam) {
                    unset($uraiantam_);
                    unset($idUraianTam_);
                    $cek = TRUE;
                } else {
                    $cek = FALSE;
                    echo "1___<font color='red' title='simpan' >Terjadi kesalahan ketika menyimpan data..</font>___";
                    break 1;
                }
            } else {
                $sqlTam = exec_query("UPDATE skp_r_tambahan SET uraian_tambahan = '$uraiantam_' where id_uraian_tambahan = $idUraianTam_");
                if ($sqlTam) {
                    $cek = TRUE;
                } else {
                    echo "1___<font color='red' title='edit' >Terjadi kesalahan ketika menyimpan data..</font>___";
                    break 1;
                }
            }
        }
    }
    if ($cek) {
        echo "2___<font color='green'>Data Tersimpan</font>___";
        viewTgsTambhan($idSKP);
    }
} else if ($act == 'krea') {
    $uraian = $_POST['uraian_kre'];
    $ditamb = $_POST['idtmbhn'];
    $idSKP = $_POST['skpIdKre'];
    $cek = FALSE;
    for ($in = 0; $in < count($uraian); $in++) {
        $uraiankre_ = str_replace("'", "''", $uraian[$in]);
        $idUraianKre_ = $ditamb[$in];
        if (!empty($uraiankre_)) {
            if (empty($idUraianKre_)) {
                $idUraianKre_ = get_maxid('idkreatifitas', 'skp_r_kreatifitas');
                $sqlTam = exec_query("INSERT INTO skp_r_kreatifitas (idkreatifitas,idskp,uraiankreatifitas) VALUES ($idUraianKre_,$idSKP,'$uraiankre_')");
          //      echo "INSERT INTO skp_r_kreatifitas (idkreatifitas,idskp,uraiankreatifitas) VALUES ($idUraianKre_,$idSKP,'$uraiankre_')";
                if ($sqlTam) {
                    unset($uraiankre_);
                    unset($idUraianKre_);
                    $cek = TRUE;
                } else {
                    $cek = FALSE;
                    echo "1___<font color='red' title='simpan' >Terjadi kesalahan ketika menyimpan data..</font>___";
                    break 1;
                }
            } else {
                $sqlTam = exec_query("UPDATE skp_r_kreatifitas SET uraiankreatifitas = '$uraiankre_' where idkreatifitas = $idUraianKre_");
            //    echo "UPDATE skp_r_kreatifitas SET uraiankreatifitas = '$uraiankre_' where idkreatifitas = $idUraianKre_";
                if ($sqlTam) {
                    $cek = TRUE;
                } else {
                    echo "1___<font color='red' title='edit' >Terjadi kesalahan ketika menyimpan data..</font>___";
                    break 1;
                }
            }
        }
    }
    if ($cek) {
        echo "2___<font color='green'>Data Tersimpan</font>___";
        viewKreatifitas($idSKP);
    }
} else if ($act == 'remTam') {
    $idskp = abs($_POST['skpid']);
    $id = abs($_POST['d']);
    $sqldel = exec_query("DELETE FROM skp_r_tambahan WHERE id_uraian_tambahan = '$id'");
    if ($sqldel) {
        echo "3___<font color='green'>Data berhasil dihapus !!</font>___";
        viewTgsTambhan($idskp);
    } else {
        echo "1___<font color='red'>Data gagal dihapus !!</font>___";
    }
} else if ($act == 'remKre') {
    $idskp = abs($_POST['skpid']);
    $id = abs($_POST['d']);
    $sqldel = exec_query("DELETE FROM skp_r_kreatifitas WHERE idkreatifitas = '$id'");
    if ($sqldel) {
        echo "3___<font color='green'>Data berhasil dihapus !!</font>___";
        viewKreatifitas($idskp);
    } else {
        echo "1___<font color='red'>Data gagal dihapus !!</font>___";
    }
}else if ($act == 'edtRow') {
    $_bgian = $_POST['bgian'];
    $uraian_ = str_replace("'", "''", $_POST['uraian']);
    $idUraian_ = abs($_POST['id']);
    if ($_bgian == 'tam') {
        $sqlTam = exec_query("UPDATE skp_r_tambahan SET uraian_tambahan = '$uraian_' where id_uraian_tambahan = $idUraian_");
        if ($sqlTam) {
            echo "4___<font color='green'>Data Tersimpan</font>";
        } else {
            echo "1___<font color='red' title='edit' >Terjadi kesalahan ketika menyimpan data..</font>___";
        }
    } else if ($_bgian == 'kre') {
        $sqlTam = exec_query("UPDATE skp_r_kreatifitas SET uraiankreatifitas = '$uraian_' where idkreatifitas = $idUraian_");
        if ($sqlTam) {
            echo "4___<font color='green'>Data Tersimpan</font>";
        } else {
            echo "1___<font color='red' title='edit' >Terjadi kesalahan ketika menyimpan data..</font>___";
        }
    } else {
        echo "1___<font color='red'>Error in paramater</font>";
    }
} else {
    
}

function rollBack($arID, $tble) {
    if ($tble == 'realisasi') {
        $sql = "DELETE FROM skp_r_kerja where id_realisasi = ";
    } else if ($tble == 'tambahan') {
        $sql = "DELETE FROM skp_r_tambahan where id_uraian_tambahan = ";
    } else if ($tble == 'prilaku') {
        $sql = "DELETE FROM skp_r_perilaku where id_perilaku = ";
    }
    for ($ur = 0; $ur < count($arID); $ur++) {
        exec_query($sql . "'" . $arID[$ur] . "'");
    }
}

function viewTblRealisasi() {
    $dtaRealisasi = get_datas("SELECT t.id_skp,t.id_tkerja,t.output, t.mutu, t.waktu, t.biaya, u.id_uraian, u.uraian, t.angka_kredit, r.id_realisasi, r.r_output,r.r_mutu,r.r_waktu,r.r_biaya FROM skp_t_kerja t 
INNER JOIN skp_uraian u  ON t.id_uraian = u.id_uraian and t.tahun = '" . date('Y') . "' and t.id_pns = '" . SKP_ID . "' and t.kode_jabatan = '" . SKP_KODEJAB . "'
LEFT OUTER JOIN skp_r_kerja r ON t.id_tkerja = r.id_tkerja");
    if (count($dtaRealisasi) > 0) {
        $no = 1;
        foreach ($dtaRealisasi as $isiRealisasi) {
            $t_output = $isiRealisasi['output'];
            $t_mutu = $isiRealisasi['mutu'];
            $t_waktu = $isiRealisasi['waktu'];
            $t_biaya = $isiRealisasi['biaya'];

            $r_output = $isiRealisasi['r_output'];
            $r_mutu = $isiRealisasi['r_mutu'];
            $r_waktu = $isiRealisasi['r_waktu'];
            $r_biaya = $isiRealisasi['r_biaya'];

            $nOutput = (empty($r_output) OR ($r_output < 0)) ? 0 : ($r_output / $t_output) * 100;
            $nMutu = (empty($r_mutu) OR ($r_mutu < 0)) ? 0 : ($r_mutu / $t_mutu) * 100;
            $nWaktu = (empty($r_biaya) OR ($r_waktu < 0)) ? 0 : ((1.76 * $t_waktu - $r_waktu) / $t_waktu) * 100;
            $nBiaya = (empty($r_biaya) OR ($r_biaya < 0)) ? 0 : ((1.76 * $t_biaya - $r_biaya) / $t_biaya) * 100;

            $prhtungan = $nOutput + $nMutu + $nWaktu + $nBiaya;
            $nCapaianSKP = $prhtungan / 4;
            ?>
            <tr>
                <td class="center" align="center" style="width:3%;"><?php echo $no; ?></td>
                <td align="center"><?php echo ucfirst($isiRealisasi['uraian']); ?></td>
                <td>
                    <label><?php echo $isiRealisasi['angka_kredit']; ?></label>
                    <input type="hidden" name="trgtid[]" value="<?php echo $isiRealisasi['id_tkerja']; ?>" />
                    <input type="hidden" name="realssid[]" value="<?php echo $isiRealisasi['id_realisasi']; ?>" />
                </td>
                <td>
                    <input type="text" class="input-small" name="output[]" id="output_<?php echo $no; ?>" value="<?php echo $r_output; ?>" />
                </td>
                <td>
                    <input type="text" class="input-small" name="mutu[]" id="mutu_<?php echo $no; ?>" value="<?php echo $r_mutu; ?>" />
                </td>
                <td>
                    <input type="text" class="input-small" name="waktu[]" id="waktu_<?php echo $no; ?>" value="<?php echo $r_waktu; ?>" />
                </td>
                <td>
                    <input type="text" class="input-small" name="biaya[]" id="biaya_<?php echo $no; ?>" value="<?php echo $r_biaya; ?>" />
                </td>
                <td class="center">
                    <?php echo number_format($prhtungan, 2); ?>
                </td>
                <td class="center">
                    <?php echo number_format($nCapaianSKP, 2); ?>
                </td>
            </tr>
            <?php
            $no++;
        }
    }
}

function viewTgsTambhan($id_skp) {
    $dtTmbhan = get_datas("SELECT * FROM skp_r_tambahan where id_skp = '$id_skp'");
    $no = 1;
    foreach ($dtTmbhan as $isinya) {
        ?>
        <tr id="r_<?php echo 'tam_' . $no; ?>">
            <td style="width:3%;" class="center"><?php echo $no; ?><label class="hide" id="id_tam_<?php echo $n; ?>" name="idtmbhn[]"><?php echo $isinya['id_uraian_tambahan']; ?></label></td>
            <td><label style="width: 100%;" id="uraian_tam_<?php echo $no; ?>" name="uraian_tam[]"><?php echo ucfirst($isinya['uraian_tambahan']); ?></label></td>
            <td class="center">
                <div id="btn_tam_<?php echo $no; ?>">
                    <span id="msg_tam_<?php echo $no; ?>"></span>
                    <span id="ed_tam_<?php echo $no . "_" . $isinya['id_uraian_tambahan']; ?>" name="ed_tam_<?php echo $no; ?>" title="Ubah" onclick="edtRow(this)" class="badge badge-user center" 
                          style="cursor:pointer;">
                        <i class="icon-pencil"></i></span>
                    <span id="rmtm_<?php echo $no . "_" . $isinya['id_uraian_tambahan']; ?>" name="rmtm_<?php echo $no; ?>" title="Hapus" onclick="" class="badge badge-important center rem-dataTam" 
                          style="cursor:pointer;">
                        <i class="icon-trash"></i></span>
                </div>
                <div id="btnh_tam_<?php echo $no; ?>" class="hide">
                    <span id="msgh_tam_<?php echo $no; ?>"></span>
                    <span style='cursor:pointer;' class='badge badge-info center' onclick="simpan(<?php echo $no . ",'tam'"; ?>);" title="Simpan" id="sm_<?php echo $no . "_" . $isinya['id_uraian_tambahan']; ?>"><i class="icon-save"></i></span>
                    <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $no . ",'tam'"; ?>);" title="Cancel" id="ca_<?php echo $no . "_" . $isinya['id_uraian_tambahan']; ?>"><i class="icon-remove"></i></span>
                </div>
            </td>
        </tr>
        <?php
        $no++;
    }
}

function viewKreatifitas($id_skp) {
    $dtKreatifitas = get_datas("SELECT * FROM skp_r_kreatifitas where idskp = '$id_skp'");
    $no = 1;
    foreach ($dtKreatifitas as $isinya) {
        ?>
        <tr id="r_<?php echo 'kre_' . $no; ?>">
            <td style="width:3%;" class="center"><?php echo $no; ?><label class="hide" id="id_kre_<?php echo $no; ?>" name="idtmbhn[]"><?php echo $isinya['idkreatifitas']; ?></label></td>
            <td><label style="width: 100%;" id="uraian_kre_<?php echo $no; ?>" name="uraian_kre[]"><?php echo ucfirst($isinya['uraiankreatifitas']); ?></label></td>
            <td class="center">
                <div id="btn_kre_<?php echo $no; ?>">
                    <span id="msg_kre_<?php echo $no; ?>"></span>
                    <span id="ed_kre_<?php echo $no . "_" . $isinya['idkreatifitas']; ?>" name="ed_kre_<?php echo $no; ?>" title="Ubah" onclick="edtRow(this);" class="badge badge-user center" 
                          style="cursor:pointer;">
                        <i class="icon-pencil"></i></span>
                    <span id="rmkr_<?php echo $no . "_" . $isinya['idkreatifitas']; ?>" name="rmkr_<?php echo $no; ?>" title="Hapus" onclick="" class="badge badge-important center rem-dataKre" 
                          style="cursor:pointer;">
                        <i class="icon-trash"></i></span>
                </div>
                <div id="btnh_kre_<?php echo $no; ?>" class="hide">
                    <span id="msgh_kre_<?php echo $no; ?>"></span>
                    <span style='cursor:pointer;' class='badge badge-info center' onclick="simpan(<?php echo $no . ",'kre'"; ?>);" title="Simpan" id="sm_<?php echo $no . "_" . $isinya['idkreatifitas']; ?>"><i class="icon-save"></i></span>
                    <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $no . ",'kre'"; ?>);" title="Cancel" id="ca_<?php echo $no . "_" . $isinya['idkreatifitas']; ?>"><i class="icon-remove"></i></span>
                </div>
            </td>
        </tr>
        <?php
        $no++;
    }
}
?>
