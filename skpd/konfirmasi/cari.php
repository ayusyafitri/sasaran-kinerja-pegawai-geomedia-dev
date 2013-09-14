<?php
include_once("../../php/include_all.php");

$sintak=$_GET[si];
$sql = get_datas("select u.id_user, u.nama, u.nip, u.username, u.password from skp_username u where (u.nama like '%$sintak%' or u.nip like '%$sintak%') order by id_user");

if (count($sql)== 0 ) {

?>	<tr>
		<td colspan="4" bgcolor="#FF0000">Maaf Data Tidak Ditemukan</td>
	</tr>
<?php
}
else {
	$x = 1;
	$counter = 0;
	foreach ($sql as $sql){
	?>
    <tr>
                    <input type="hidden" name="id_pns[]">
                    <input type='hidden' name='rows[]' value='<?php echo $counter++ ; ?>'>
                    <td><?php echo $x ?></td>
                    <td>&nbsp;<?php echo $sql['nip'] ?></td>
                    <td><?php echo $sql['nama'] ?></td>
                    <input type="hidden" name="iduser[]" value="<?php echo $sql ['id_user'];?>">
                    <input type="hidden" name="nama[]" value="<?php echo $sql ['nama'];?>">
                    <input type="hidden" name="nip[]" value="<?php echo $sql['nip'];?>">
                    <input type="hidden" name="user[]" value="<?php echo $sql['username'];?>">
                    <input type="hidden" name="pass[]" value="<?php echo $sql['password'];?>">
                    <td class="center" >
                        <select name="con[]" id="con" class="con">
                        	<option id="0">-Pilih Status-</option>
                            <option value="1">Konfirmasi</option>
                            <option value="2">Tolak</option>
                        </select>
                    </td>
    </tr>
    <?php
	$x++;
	}
}
?>