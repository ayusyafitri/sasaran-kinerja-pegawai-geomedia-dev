<?php
ob_start();
session_start();
include '../../php/include_all.php';

if (isset($_POST['act']))
    $act = $_POST['act'];
if (isset($_GET['act']))
    $act = $_GET['act'];

if ($act == 'LdUraian') {

    //"SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB . "'"
    $dta = get_datas("SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB . "'", 'samarinda');
    $no = 1;
    if (count($dta) > 0) {
        echo "SELECT kode_jabatan, uraian, volume_kerja,tupoksi, id_uraian from uraian where kode_jabatan = '" . SKP_KODEJAB . "'";
        foreach ($dta as $isiData) {
            ?>
            <tr><td align="center" valign="middle" style="width:3%;"><?php echo $no;?> </td>
                <td align="center" style="width:58%;"><?php echo ucfirst($isiData['uraian']); ?></td> 
                <td style="width:8%;"><input class="input-small" type="text" name="output[]" /></td>
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
} else {
    
}
?>
