<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'ldUraian') {
    $status = '0';
    $idp = abs($_POST['pg']);
    $y = abs($_POST['th']);
    $count = get_data("SELECT id_tkerja,id_skp FROM skp_t_kerja where id_pns = '$idp' and tahun = '$y' LIMIT 1");
    if (count($count) > 0) {
        $realisasi = get_datas("SELECT * FROM skp_r_kerja where id_tkerja = '" . $count['id_tkerja'] . "'");
        if (count($realisasi) > 0) {
            echo "2___";
            viewTblRealisasi($idp, $y);
            echo "___";
            viewTgsTambhan($count['id_skp'], $status);
            echo "___";
            viewKreatifitas($count['id_skp'], $status);
            echo "___$status";
        } else {
            echo "5___<font color='red'>Belum ada data realisasi yang diinputkan</font>";
        }
    } else {
        echo "5___<font color='red'>Belum ada data target yang diinputkan</font>";
    }
} else if ($act == 'saveTP') {
    $idTrget = abs($_POST['idtgt']);
    $biaya = (isset($_POST['bya'])) ? abs($_POST['bya']) : '0';
    $idReals = abs($_POST['realsid']);
    $output = abs($_POST['out']);
    $wkt = (isset($_POST['wkt'])) ? abs($_POST['wkt']) : '0';
    $mutu = abs($_POST['mut']);
    $ak = (isset($_POST['ak'])) ? abs($_POST['ak']) : '0';
    if (!empty($idReals) AND !empty($mutu) AND !empty($output)) {
        $exec = exec_query("UPDATE skp_r_kerja SET r_output = '$output', r_mutu = '$mutu', r_waktu = '$wkt', r_biaya = '$biaya' WHERE id_realisasi = '$idReals'");
        if ($exec) {
            echo "5___$output|||$mutu|||$wkt|||$biaya";
        } else {
            echo "2___<font color='red'>Gagal menyimpan data !!!</font>";
        }
    } else {
        
    }
} else if ($act == 'edtRow') {
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
        $nilai = abs($_POST['nlai']);
        $sqlTam = exec_query("UPDATE skp_r_kreatifitas SET uraiankreatifitas = '$uraian_', nilai = '$nilai' where idkreatifitas = $idUraian_");
        if ($sqlTam) {
            echo "4___<font color='green'>Data Tersimpan</font>___$nilai";
        } else {
            echo "1___<font color='red' title='edit' >Terjadi kesalahan ketika menyimpan data..</font>___";
        }
    } else {
        echo "1___<font color='red'>Error in paramater</font>";
    }
} else if ($act == 'sveStatus') {
    $doing = abs($_POST['do']);  // 1 = comfirm ; 0 =reconfirm
    $idRealisasi = $_POST['realssid'];
    $thn = abs($_POST['y']);
    $idPeg = abs($_POST['Peg']);
    $cek = FALSE;
    $idTKerja_temp = array();
    if (count($idRealisasi) > 0) {
        for ($i = 0; $i < count($idRealisasi); $i++) {
            $idrealisasi_ = abs($idRealisasi[$i]);

            if (!empty($idrealisasi_)) {
                $sta = ($doing == '1') ? '1' : '0';
                $sql = exec_query("UPDATE skp_r_kerja SET r_status = $sta where id_tkerja = '" . $idrealisasi_ . "'");
                if ($sql) {
                    $cek = TRUE;
                    array_push($idTKerja_temp, $idrealisasi_);
                    unset($idrealisasi_);
                } else {
                    $cek = FALSE;
                    echo "5___<font color='red'>Konfirmasi Target Gagal !!</font>";
                    rollBack($idTKerja_temp, $doing);
                    break 1;
                }
            } else {
                $cek = FALSE;
                echo "5___<font color='red'>Konfirmasi Target Gagal !!. ID Target Kosong !!</font>";
                rollBack($idTKerja_temp, $doing);
                break 1;
            }
        }
        if ($cek) {
            $msg = ($doing == '1')?"Data Telah Dikonfirmasi":"Pembatalan Konfirmasi sukses !!";
            echo "2___<font color='Green'>$msg</font>___";
            $count = get_data("SELECT id_tkerja,id_skp FROM skp_t_kerja where id_pns = '$idPeg' and tahun = '$thn' LIMIT 1");
            viewTblRealisasi($idPeg, $thn);
            echo "___";
            viewTgsTambhan($count['id_skp'], $status);
            echo "___";
            viewKreatifitas($count['id_skp'], $status);
            echo "___$status";
        }
    } else {
        echo "5___Tidak Ada Data Tersimpan";
    }
} else if ($act == 'rConfirm') {
    
} else {
    
}

function rollBack($arStatus, $st) {
    for ($ur = 0; $ur < count($arStatus); $ur++) {
        exec_query("UPDATE skp_r_kerja SET r_status = $st where id_realisasi = '" . $arStatus[$ur] . "'");
    }
}

function viewTblRealisasi($idPns, $year) {
    $dtPns = get_data("SELECT p.nip, p.id_pns, p.kode_jabatan, j.jabatan FROM skp_pns p, skp_jabatan j where p.kode_jabatan = j.kode_jabatan and id_pns = " . $idPns);
    $dtaRealisasi = get_datas("SELECT t.id_skp,t.id_tkerja,t.output, t.mutu, t.waktu, t.biaya, u.id_uraian, u.uraian, t.angka_kredit, r.id_realisasi, r.r_output,r.r_mutu,r.r_waktu,r.r_biaya,r.r_status FROM skp_t_kerja t 
INNER JOIN skp_uraian u  ON t.id_uraian = u.id_uraian and t.tahun = '" . $year . "' and t.id_pns = '" . $idPns . "' and t.kode_jabatan = '" . $dtPns['kode_jabatan'] . "'
LEFT OUTER JOIN skp_r_kerja r ON t.id_tkerja = r.id_tkerja ORDER BY u.no_uraian ASC");
    if (count($dtaRealisasi) > 0) {
        global $status;
        $no = 1;
        $jbt = ($dtPns['jabatan'] == 'Jabatan Fungsional Tertentu') ? 'jft' : 'oth';
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
            <tr id="rTP_<?php echo $no; ?>">
                <td class="center" style=""><?php echo $no; ?></td>
                <td align="center" style="text-align: justify;"><label style="" name="uraianTP[]" id="uraianTP_<?php echo $no; ?>"><?php echo ucfirst($isiRealisasi['uraian']); ?></label></td>
                <td>
                    <label style="cursor:default;width: 50px;" class="input-small" name="ak[]" name="<?php echo $jbt; ?>" id="ak_<?php echo $no; ?>"><?php echo $isiRealisasi['angka_kredit']; ?></label>
                    <input type="hidden" id="trgtid_<?php echo $no; ?>" name="trgtid[]" value="<?php echo $isiRealisasi['id_tkerja']; ?>" />
                    <input type="hidden" id="realssid_<?php echo $no; ?>" name="realssid[]" value="<?php echo $isiRealisasi['id_realisasi']; ?>" />
                </td>
                <td>
                    <label style="cursor:default;" class="input-small" name="output[]" id="outputTP_<?php echo $no; ?>"><?php echo $r_output; ?></label>
                </td>
                <td>
                    <label style="cursor:default;" class="input-small" name="mutu[]" id="mutuTP_<?php echo $no; ?>" ><?php echo $r_mutu; ?></label>
                </td>
                <td>
                    <label style="cursor:default;" class="input-small" name="waktu[]" id="waktuTP_<?php echo $no; ?>"><?php echo $r_waktu; ?></label>
                </td>
                <td>
                    <label style="cursor:default;" class="input-small" name="biaya[]" id="biayaTP_<?php echo $no; ?>"><?php echo $r_biaya; ?></label>
                </td>
                <td class="center">
                    <label style="cursor:default;" id="pr_<?php echo $no; ?>"><?php echo number_format($prhtungan, 2); ?></label>
                </td>
                <td class="center">
                    <label style="cursor:default;" id="cap_<?php echo $no; ?>"><?php echo number_format($nCapaianSKP, 2); ?></label>
                </td>
                <td class="center">
                    <?php if ($isiRealisasi['r_status'] == '1') { ?>
                        <i style="cursor:default" title="Sudah Konfirmasi" class="icon-ok"></i>
                    <?php } else { ?>
                        <span style='cursor:pointer;' class='badge badge-user center' onclick="edtRowTP(this)" title="Ubah" name ="edTP_<?php echo $no . "_" . $isiRealisasi['id_tkerja']; ?>" id="edTP_<?php echo $no; ?>"><i class="icon-pencil"></i></span>                    
                        <div id="btn-actTP_<?php echo $no; ?>" style="" class="hide">                        
                            <span style='cursor:pointer;' class='badge badge-info center' onclick="sveTP(<?php echo $no; ?>)" title="Simpan" id="sm_<?php echo $no . "_" . $isiRealisasi['id_tkerja']; ?>"><i class="icon-save"></i></span>
                            <span style='cursor:pointer;' class='badge badge-important center' onclick="cancelTP(<?php echo $no; ?>)" title="Cancel" id="ca_<?php echo $no . "_" . $isiRealisasi['id_tkerja']; ?>"><i class="icon-remove"></i></span>
                            <span id="msgEd_<?php echo $no; ?>"></span>
                        </div><?php } ?>                    
                </td>
            </tr>
            <?php
            $no++;
            $status = $isiRealisasi['r_status'];
        }
    }
}

function viewTgsTambhan($id_skp, $status = '0') {
    $dtTmbhan = get_datas("SELECT * FROM skp_r_tambahan where id_skp = '$id_skp'");
    $no = 1;
    print_r($dtTmbhan);
    foreach ($dtTmbhan as $isinya) {
        ?>
        <tr id="r_<?php echo 'tam_' . $no; ?>">
            <td style="width:3%;" class="center" valign="middle"><?php echo $no; ?><label class="hide" id="id_tam_<?php echo $n; ?>" name="idtmbhn[]"><?php echo $isinya['id_uraian_tambahan']; ?></label></td>
            <td><label style="width: 100%;" id="uraian_tam_<?php echo $no; ?>" name="uraian_tam[]"><?php echo ucfirst($isinya['uraian_tambahan']); ?></label></td>
            <td class="center">
                <?php if ($status == '1') { ?>
                    <i style="cursor:default" title="Sudah Konfirmasi" class="icon-ok"></i>
                <?php } else { ?>
                    <div id="btn_tam_<?php echo $no; ?>">
                        <span id="msg_tam_<?php echo $no; ?>"></span>
                        <span id="ed_tam_<?php echo $no . "_" . $isinya['id_uraian_tambahan']; ?>" name="ed_tam_<?php echo $no; ?>" title="Ubah" onclick="edtRow(this)" class="badge badge-user center" 
                              style="cursor:pointer;">
                            <i class="icon-pencil"></i></span>
                        <span id="rmtm_<?php echo $no . "_" . $isinya['id_uraian_tambahan']; ?>" name="rmtm_<?php echo $no; ?>" title="Hapus" onclick="" class="badge badge-important center rem-dataTam" 
                              style="cursor:pointer;">
                            <i class="icon-trash"></i></span>
                    </div><?php } ?>
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

function viewKreatifitas($id_skp, $status = '0') {
    $dtKreatifitas = get_datas("SELECT * FROM skp_r_kreatifitas where idskp = '$id_skp'");
    $no = 1;
    foreach ($dtKreatifitas as $isinya) {
        ?>
        <tr id="r_<?php echo 'kre_' . $no; ?>">
            <td style="width:3%;" class="center" valign="middle"><?php echo $no; ?><label class="hide" id="id_kre_<?php echo $no; ?>" name="idtmbhn[]"><?php echo $isinya['idkreatifitas']; ?></label></td>
            <td><label style="width: 100%;" id="uraian_kre_<?php echo $no; ?>" name="uraian_kre[]"><?php echo ucfirst($isinya['uraiankreatifitas']); ?></label></td>
            <td class="center"><label id="nilai_kre_<?php echo $no; ?>"><?php echo $isinya['nilai'];?></label></td>
            <td class="center">
                <?php if ($status == '1') { ?>
                    <i style="cursor:default" title="Sudah Konfirmasi" class="icon-ok"></i>
                <?php } else { ?>
                    <div id="btn_kre_<?php echo $no; ?>">
                        <span id="msg_kre_<?php echo $no; ?>"></span>
                        <span id="ed_kre_<?php echo $no . "_" . $isinya['idkreatifitas']; ?>" name="ed_kre_<?php echo $no; ?>" title="Ubah" onclick="edtRow(this);" class="badge badge-user center" 
                              style="cursor:pointer;">
                            <i class="icon-pencil"></i></span>
                        <span id="rmkr_<?php echo $no . "_" . $isinya['idkreatifitas']; ?>" name="rmkr_<?php echo $no; ?>" title="Hapus" onclick="" class="badge badge-important center rem-dataKre" 
                              style="cursor:pointer;">
                            <i class="icon-trash"></i></span>
                    </div><?php } ?>
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