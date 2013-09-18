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
    $idtargetK = $_POST['idtkerja'];
    $ak = @$_POST['ak'];
    $idKinerja_temp = array();
    $idUraian_temp = array();
    $idStatus_temp = array();
    $cek = FALSE;
    if (count($waktu) > 0) {
        $skp = get_data("SELECT sum(distinct(id_skp)) as jumlah from skp_t_kerja");
        $id_skp = (empty($skp['jumlah'])) ? 1 : (int) $skp['jumlah'] + 1;
        for ($i = 0; $i < count($uraian); $i++) {
            $biy = abs($mutu[$i]);
            $mut = abs($biaya[$i]);
            $uraian_ = str_replace("'", "''", $uraian[$i]);
            $mutu_ = (empty($mut)) ? '0' : $mut;
            $biaya_ = (empty($biy)) ? '0' : $biy;
            $output_ = abs($output[$i]);
            $waktu_ = abs($waktu[$i]);
            $tupoksi_ = abs($tupoksi[$i]);
            $nouraian_ = abs($nouraian[$i]);
            $idtkerja_ = abs($idtargetK[$i]);
            $ak_ = (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') ? abs($ak[$i]) : 'NULL';
            if (!empty($uraian_) AND !empty($mutu_) AND !empty($output_)) {
                $idKinerja = get_maxID('id_tkerja', 'skp_t_kerja');
                $idUraian = get_maxid('id_uraian', 'skp_uraian');
                $idStatus = get_maxID('id_status', 'skp_t_status');
                if (empty($idtkerja_) OR ($idtkerja_ == '0')) {
                    $insK = exec_query("insert into skp_t_kerja(bulan,tahun,kode_jabatan,angka_kredit,id_pns,id_uraian,output,mutu,waktu,biaya,id_skp,id_tkerja)
                    VALUES('" . date('n') . "','" . date('Y') . "','" . SKP_KODEJAB . "',$ak_," . SKP_ID . ",$idUraian,$output_,$mutu_,$waktu_,$biaya_,$id_skp,$idKinerja)");
                    $insU = exec_query("insert into skp_uraian(id_uraian,uraian,tupoksi,no_uraian,tahun,kode_jabatan,jns_jabatan)
                    VALUES($idUraian,'$uraian_',$tupoksi_,$nouraian_,'" . date('Y') . "','" . SKP_KODEJAB . "','" . SKP_JNSJAB . "')");
                    $insS = exec_query("INSERT INTO skp_t_status (id_status, id_tkerja, status) VALUES ($idStatus,$idKinerja,0)");
                    if ($insK AND $insU AND $insS) {
                        array_push($idUraian_temp, $idUraian);
                        array_push($idKinerja_temp, $idKinerja);
                        array_push($idStatus_temp, $idStatus);
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
                        rollBack($idUraian_temp, $idKinerja_temp, $idStatus_temp);
                        break 1;
                    }
                }
            } else {
                $cek = FALSE;
                echo "5___Ada data yang kosong";
                rollBack($idUraian_temp, $idKinerja_temp, $idStatus_temp);
                break 1;
            }
        }
        if ($cek) {
            echo "2___Data Tersimpan___";
            viewTable();
        }
//        else {
//            $er = error_get_last();            
//            echo "<br />".$er['message']." ON LIne : ";
//        }
    } else {
        echo "5___Tidak Ada Data Tersimpan";
    }
} elseif ($act == 'rbTgt') {
    $uraian_ = str_replace("'", "''", $_POST['ur']);
    $m = abs($_POST['mt']);
    $mutu_ = (empty($m)) ? '0' : $m;
    $b = abs($_POST['by']);
    $biaya_ = (empty($b)) ? '0' : $b;
    $output_ = abs($_POST['out']);
    $waktu_ = abs($_POST['wkt']);
    $tpk = abs($_POST['tpk']);
    $tupoksi_ = (empty($tpk)) ? 1 : $tpk;
    $nouraian_ = abs($_POST['nour']);
    $idTargetKerja = abs($_POST['di']);
    $ak_ = (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') ? abs(@$_POST['ak']) : 'NULL';
    if (!empty($uraian_) AND !empty($mutu_) AND !empty($output_) AND !empty($idTargetKerja)) {
        $idUr = get_data("SELECT id_uraian FROM skp_t_kerja where id_tkerja = $idTargetKerja");
        $setUr = exec_query("UPDATE skp_uraian SET uraian = '$uraian_' where id_uraian = '" . $idUr['id_uraian'] . "'");
        $setTK = exec_query("UPDATE skp_t_kerja SET angka_kredit = $ak_, mutu = $mutu_, biaya = $biaya_,waktu = $waktu_ , output = $output_ 
            where id_tkerja = $idTargetKerja");
        if ($setUr AND $setTK) {
            $ak_ = ($Ak_ == 'NULL') ? '' : $ak_;
            echo "3___Data tersimpan !!___$uraian_|||$ak_|||$output_|||$mutu_|||$waktu_|||$biaya_";
        } else {
            echo "1___Data gagal di simpan !!! ";
        }
    }
} else if ($act == 'delTgt') {
    $idtargetK = abs($_POST['idtgt']);
    if (!empty($idtargetK)) {
        $target = get_data("SELECT * FROM skp_t_kerja where id_tkerja = '$idtargetK'");
        $delKerja = exec_query("DELETE FROM skp_t_kerja WHERE id_tkerja = '$idtargetK'");
        $delUr = exec_query("DELETE FROM skp_uraian WHERE id_uraian = '" . $target['id_uraian'] . "'");
        $delS = exec_query("DELETE FROM skp_t_status WHERE id_tkerja = '$idtargetK'");
        if ($delKerja AND $delS AND $delUr) {
            echo "3___<font color='green'>Data Telah di Hapus!!</font>___";
            viewTable();
        } else {
            echo "2___<font color='red'>Terjadi kesalahan ketika menghapus data !!</font>";
        }
    } else {
        echo "2___<font color='red'>Gagal menghapus data, Parameter Kosong !!</font>";
    }
}

function rollBack($arUraian, $arKinerja, $arStatus) {
    for ($ur = 0; $ur < count($arUraian); $ur++) {
        exec_query("DELETE FROM skp_uraian where id_uraian = '" . $arUraian[$ur] . "'");
    }
    for ($aK = 0; $aK < count($arKinerja); $aK++) {
        exec_query("DELETE FROM skp_t_kerja where id_tkerja = '" . $arKinerja[$aK] . "'");
    }
    for ($aS = 0; $aS < count($arStatus); $aS++) {
        exec_query("DELETE FROM skp_t_status where id_status = '" . $arStatus[$aK] . "'");
    }
}

function viewTable() {
    $tkerja = get_datas("SELECT * FROM skp_t_kerja where tahun = '" . date('Y') . "' and kode_jabatan = '" . SKP_KODEJAB . "'");
    $nmJabatan = get_data("SELECT nama_jabatan FROM skp_jabatan where kode_jabatan = '" . SKP_KODEJAB . "'");
    if (count($tkerja) > 0) {
        $kinerjaJfu_awal = get_datas("SELECT u.uraian,u.no_uraian,u.tupoksi,k.angka_kredit,k.output, k.mutu,k.waktu,k.biaya,k.id_tkerja FROM skp_t_kerja k, skp_uraian u 
where k.id_uraian = u.id_uraian and k.tahun = '" . date('Y') . "' and k.id_pns = '" . SKP_ID . "' and k.kode_jabatan = '" . SKP_KODEJAB . "' order by u.no_uraian ASC");
    }
//    else {
//        if (SKP_JNSJAB == 'Jabatan Struktural') {
//            $kinerjaJfu_awal = get_datas("SELECT uraian_temp as uraian,no_uraian from skp_uraiantemp where kodejab_temp = '" . SKP_KODEJAB . "'");
//        } else {
//            $kinerjaJfu_awal = get_datas("SELECT u.uraian, u.no_uraian,u.tupoksi FROM skp_bkn_uraian u, skp_bkn_jabatan j 
//   where j.nama_jabatan LIKE '%" . $nmJabatan['nama_jabatan'] . "%' and u.kode_jabatan = j.kode_jabatan order by u.no_uraian ASC");
//        }
//    }
    ?>    
    <thead >
        <tr>
            <th class="center" valign="middle" rowspan="2" style="width:3%;">No</th>
            <th class="center" rowspan="2" style="width:50%">Uraian</th> 
            <?php if (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') { ?>
                <th class="center" rowspan="2" style="width:7%">AK</th>
            <?php } ?>
            <th class="center" colspan="4" style="width:32%">Target</th>
            <?php if (count($tkerja) > 0) { ?>
                <th class="center" rowspan="2" style="width:8%">aksi</th>
            <?php } ?>
        </tr>
        <tr>
            <th style="width:8%;text-align: center;">Output</th>
            <th style="width:8%;text-align: center;">Mutu</th>
            <th style="width:8%;text-align: center;">Waktu</th>
            <th style="width:8%;text-align: center;">Biaya</th> 
        </tr>
    </thead>
    <tbody id="rlTabel"> 
        <?php
        if (count($kinerjaJfu_awal) > 0) {
            $no = 1;
            foreach ($kinerjaJfu_awal as $isiData) {
                ?>
                <tr id="tr<?php echo $no; ?>"><td valign="middle" style="width:3%;text-align: center;"><?php echo $no; ?> </td>
                    <td style="width:58%;"><label style="width: 100%;" id="uraian_<?php echo $no; ?>"name="uraian[]"><?php echo ucfirst($isiData['uraian']); ?></label></td> 
                    <?php if (SKP_JNSJAB == 'Jabatan Fungsional Tertentu') { ?>
                        <td style="width:8%;text-align: center;"><label id="ak_<?php echo $no; ?>" name="ak[]" ><?php echo $isiData['angka_kredit']; ?></label></td>
                    <?php } ?>
                    <td style="width:8%;text-align: center;"><label id="output_<?php echo $no; ?>" name="output[]" ><?php echo $isiData['output']; ?></label></td>
                    <td style="width:8%;text-align: center;"><label id="mutu_<?php echo $no; ?>" name="mutu[]" ><?php echo $isiData['mutu']; ?></label></td>
                    <td style="width:8%;text-align: center;"><label id="waktu_<?php echo $no; ?>" name="waktu[]" ><?php echo $isiData['waktu']; ?></label></td>
                    <td style="width:8%;text-align: center;"><label id="biaya_<?php echo $no; ?>" name="biaya[]" ><?php echo $isiData['biaya']; ?></label>
                        <input type="hidden" name="idtkerja[]" value="<?php echo $isiData['id_tkerja']; ?>" />
                        <input type="hidden" id="tupoksi_<?php echo $no; ?>" name="tupoksi[]" value="<?php echo $isiData['tupoksi']; ?>" />
                        <input type="hidden" id="nouraian_<?php echo $no; ?>"name="nouraian[]" value="<?php echo $isiData['no_uraian']; ?>" />
                    </td>
                    <?php if (count($tkerja) > 0) { ?>
                        <td style="text-align:center;">
                            <div id="btns-act_<?php echo $no; ?>" style='width:75px;'>
                                <span id="msgEd_<?php echo $no; ?>"></span><span style='cursor:pointer;' class='badge badge-user center' onclick="edtRow(this);" title="ubah" id="ed_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-pencil"></i></span>
                                <?php if (SKP_JNSJAB != 'Jabatan Fungsional Umum') { ?>
                                    <span style='cursor:pointer;' class='badge badge-important center' onclick="delTgt(this);" title="Ubah" name ="del_<?php echo $no; ?>" id="del_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-trash"></i></span>
                                <?php } ?>
                            </div>    
                        <!--<span style='cursor:pointer;' class='badge badge-important remRow center' name='r<?php echo $no; ?>' title='Hapus' ><i class='icon-remove'></i></span>-->
                            <div id="btn-act_<?php echo $no; ?>" style="width:75px;" class="hide">
                                <span id="msgEd_<?php echo $no; ?>"></span>
                                <span style='cursor:pointer;' class='badge badge-info center' onclick="edtRow1(this);" title="Simpan" id="sm_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-save"></i></span>
                                <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $no; ?>);" title="Cancel" id="ca_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-remove"></i></span>
                            </div>
                        </td>
                    <?php } ?>
                </tr>
                <?php
                $no++;
            }
        }
        ?>                       
    </tbody>      
    <?php
}
?>
