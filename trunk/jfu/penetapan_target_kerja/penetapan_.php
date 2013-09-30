<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'confirmed') {
    $idtargetK = $_POST['idtkerja'];
    $thn = abs($_POST['thn']);
    $idPeg = abs($_POST['idPeg']);
    $cek = FALSE;
    $idTKerja_temp = array();
    if (count($idtargetK) > 0) {
        for ($i = 0; $i < count($idtargetK); $i++) {
            $idtkerja_ = abs($idtargetK[$i]);

            if (!empty($idtkerja_)) {
                $sql = exec_query("UPDATE skp_t_status SET status = 1 where id_tkerja = '" . $idtkerja_ . "'");
                if ($sql) {
                    $cek = TRUE;
                    array_push($idTKerja_temp, $idtkerja_);
                    unset($idtkerja_);
                } else {
                    $cek = FALSE;
                    echo "5___<font color='red'>Konfirmasi Target Gagal !!</font>";
                    rollBack($idTKerja_temp);
                    break 1;
                }
            } else {
                $cek = FALSE;
                echo "5___<font color='red'>Konfirmasi Target Gagal !!. ID Target Kosong !!</font>";
                rollBack($idTKerja_temp);
                break 1;
            }
        }
        if ($cek) {
            echo "2___<font color='Green'>Data Telah Dikonfirmasi</font>___";
            $kdJab = get_data("SELECT kode_jabatan FROM skp_pns WHERE id_pns = '$idPeg'");
            viewTable($thn, $idPeg, $kdJab['kode_jabatan']);
        }
    } else {
        echo "5___Tidak Ada Data Tersimpan";
    }
} elseif ($act == 'reconfirm') {
    $idtargetK = $_POST['idtkerja'];
    $thn = abs($_POST['thn']);
    $idPeg = abs($_POST['idPeg']);
    $cek = FALSE;
    $idTKerja_temp = array();
    if (count($idtargetK) > 0) {
        for ($i = 0; $i < count($idtargetK); $i++) {
            $idtkerja_ = abs($idtargetK[$i]);

            if (!empty($idtkerja_)) {
                $sql = exec_query("UPDATE skp_t_status SET status = 0 where id_tkerja = '" . $idtkerja_ . "'");
                if ($sql) {
                    $cek = TRUE;
                    array_push($idTKerja_temp, $idtkerja_);
                    unset($idtkerja_);
                } else {
                    $cek = FALSE;
                    echo "5___<font color='red'>Status Uraian Target Gagal !!</font>";
                    rollBack($idTKerja_temp);
                    break 1;
                }
            } else {
                $cek = FALSE;
                echo "5___<font color='red'>Status Rubah Target Gagal !!. ID Target Kosong !!</font>";
                rollBack($idTKerja_temp);
                break 1;
            }
        }
        if ($cek) {
            echo "2___<font color='Green'>Status uraian telah dikembalikan</font>___";
            $kdJab = get_data("SELECT kode_jabatan FROM skp_pns WHERE id_pns = '$idPeg'");
            viewTable($thn, $idPeg, $kdJab['kode_jabatan']);
        }
    } else {
        echo "5___Tidak Ada Data Tersimpan";
    }
} elseif ($act == 'edtData') {
    $uraian_ = str_replace("'", "''", $_POST['ur']);
    $m = abs($_POST['mt']);
    $mutu_ = (empty($m)) ? '0' : $m;
    $b = abs($_POST['by']);
    $biaya_ = (empty($b)) ? '0' : $b;
    $output_ = abs($_POST['out']);
    $waktu_ = abs($_POST['wkt']);
    $idTargetKerja = abs($_POST['di']);
    $j = get_data("SELECT j.jabatan FROM skp_t_kerja t, skp_jabatan j where t.kode_jabatan = j.kode_jabatan and t.id_tkerja = '$idTargetKerja';");
    $jab = $j['jabatan'];
    $ak_ = ($jab == 'Jabatan Fungsional Tertentu') ? abs(@$_POST['ak']) : 'NULL';
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
} elseif ($act == 'ldTarget') {
    $year = abs($_POST['th']);
    $pegawai = htmlentities($_POST['pg']);
    $dt = get_data("SELECT id_pns, kode_jabatan FROM skp_pns where id_pns = '" . $pegawai . "'");
    viewTable($year, $dt['id_pns'], $dt['kode_jabatan']);
} else {
    
}

function rollBack($arStatus) {
    for ($ur = 0; $ur < count($arStatus); $ur++) {
        exec_query("UPDATE skp_t_status SET status = 0 where id_status = '" . $arStatus[$ur] . "'");
    }
}

function viewTable($year, $idPns, $kodeJab) {
    $tkerja = get_datas("SELECT * FROM skp_t_kerja where tahun = '$year' and kode_jabatan = '$kodeJab'");
    echo "SELECT * FROM skp_t_kerja where tahun = '$year' and kode_jabatan = '$kodeJab'";    
    $jbtn = get_data("SELECT nama_jabatan,jabatan FROM skp_jabatan where kode_jabatan = '$kodeJab'");    
    if (count($tkerja) > 0) {
//        if ($jbtn['nama_jabatan'] == 'Jabatan Struktural') {
//            
//        } else {
            $kinerjaJfu_awal = get_datas("SELECT u.uraian,u.no_uraian,u.tupoksi,k.angka_kredit,k.output, k.mutu,k.waktu,k.biaya,k.id_tkerja, s.status FROM skp_t_kerja k, skp_uraian u ,skp_t_status s
where s.id_tkerja = k.id_tkerja and  k.id_uraian = u.id_uraian and k.tahun = '" . $year . "' and k.id_pns = '" . $idPns . "' and k.kode_jabatan = '" . $kodeJab . "' order by u.no_uraian ASC");
//        }
        ?>    
        <thead >
            <tr>
                <th class="center" valign="middle" rowspan="2" style="width:3%;">No</th>
                <th class="center" rowspan="2" style="width:50%">Uraian</th> 
                <?php if ($jbtn['jabatan'] == 'Jabatan Fungsional Tertentu') { ?>
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
                        <?php if ($jbtn['jabatan'] == 'Jabatan Fungsional Tertentu') { ?>
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
                        <td style="text-align:center;">                                   
                            <span style='cursor:pointer;' class='badge badge-user center' onclick="edtRow(this)" title="Ubah" name ="ed_<?php echo $no; ?>" id="ed_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-only icon-pencil"></i></span>
                            <?php if ($isiData['status'] == '1') { ?>
                                <i class="icon-ok" title='Sudah Konfirmasi' style='cursor:default' ></i>
                            <?php } ?>
                            <div id="btn-act_<?php echo $no; ?>" style="width:75px;" class="hide">
                                <span id="msgEd_<?php echo $no; ?>"></span>
                                <span style='cursor:pointer;' class='badge badge-info center' onclick="edtRow1(this)" title="Simpan" id="sm_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-save"></i></span>
                                <span style='cursor:pointer;' class='badge badge-important center' onclick="cancel(<?php echo $no; ?>)" title="Cancel" id="ca_<?php echo $no . "_" . $isiData['id_tkerja']; ?>"><i class="icon-remove"></i></span>
                            </div>
                        </td>                        
                    </tr>
                    <?php
                    $no++;
                }
            }
            ?>                       
        </tbody>      
        <?php
    } else {
        ?>
        <thead >
            <tr>
                <th class="center" valign="middle" rowspan="2" style="width:3%;">No</th>
                <th class="center" rowspan="2" style="width:50%">Uraian</th>                 
                <th class="center" rowspan="2" style="width:7%">AK</th>                
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
        <tr><td colspan='10'><div class='alert alert-danger'>Tidak ada data target. Data Target Belum di masukkan oleh pegawai</div></td></tr>
        <?php
    }
}
?>
