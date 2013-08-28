<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'LdUraian') {
    ?>
    <tr>
        <td align="center" valign="middle"rowspan="2" width="3%">No</td>
        <td align="center" rowspan="2" width="50%">Uraian</td> 
        <td align="center" rowspan="2" width="7%">AK</td>
        <td align="center" colspan="4" width="40%">Target</td>
    </tr>
    <tr>
        <td width="10%">Output</td>
        <td width="10%">Mutu</td>
        <td width="10%">Waktu</td>
        <td width="10%">Biaya</td> 
    </tr>
    <?php
    //"SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB . "'"
    $dta = get_datas("SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB. "'",'samarinda');
    $no = 1;
    if (count($dta) > 0) {
        echo "SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB. "'";
        foreach ($dta as $isiData) {
            ?>
            <tr><td align="center" valign="middle" width="3%"><?php echo $no; ?></td>
                <td align="center" width="50%"><?php echo ucfirst($isiData['uraian']); ?></td> 
                <td widht='10%'><?php echo ucfirst($isiData['volume_kerja']); ?></td>
                <td width="10%"><input type="text" name="output[]" /></td>
                <td width="10%"><input type="text" name="mutu[]" /></td>
                <td width="10%"><input type="text" name="waktu[]" /></td>
                <td width="10%"><input type="text" name="biaya[]" /></td></tr>
            <?php
            $no++;
        }
    }else{        
        echo "<tr colspan='8'><div class='alert alert-info center'>Tidak ada uraian"."SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . $_SESSION['_kdJabatan'] . "'"."</tr>";
    }
} else {
    
}
?>
