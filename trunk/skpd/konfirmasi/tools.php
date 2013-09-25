<?php
include_once("../../php/include_all.php");
$rows = $_POST['rows'];
$con = $_POST['con'];
$idpns = $_POST['id_pns'];
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$pass = $_POST['pass'];
$user = $_POST['user'];
$iduser = $_POST['iduser'];
for ($i=0; $i<count($rows); $i++){
	if ($con[$i] == '1'){
		$maxid = get_maxid ('id_pns', 'skp_pns');
		exec_query("insert into skp_pns (id_pns, nama, nip, username, password, status_aktif) values(".$maxid.", '".$nama[$i]."', '".$nip[$i]."', '".$user[$i]."', '".$pass[$i]."', 1)");
		exec_query("delete from skp_username where id_user=".$iduser[$i]);
		$stored = get_data ('select id_pns from skp_pns where id_pns='.$maxid);
		if ($stored['id_pns']==$maxid){
			$idpns = $maxid;
			echo 'success__';
		}
	}else if ($con[$i] == '2'){
		exec_query("delete from skp_username where id_user=".$iduser[$i]);
		echo 'success__';
	}
	
}
view_kon();

function view_kon (){
	$x = 1;
	$counter = 0;
	$user = get_datas("select * from skp_username order by id_user");
	foreach ($user as $user) {
	?>
    <tr>
                    <input type="hidden" name="id_pns[]">
                    <input type='hidden' name='rows[]' value='<?php echo $counter++ ; ?>'>
                    <td><?php echo $x ?></td>
                    <td>&nbsp;<?php echo $user['nip'] ?></td>
                    <td><?php echo $user['nama'] ?></td>
                    <input type="hidden" name="iduser[]" value="<?php echo $user ['id_user'];?>">
                    <input type="hidden" name="nama[]" value="<?php echo $user ['nama'];?>">
                    <input type="hidden" name="nip[]" value="<?php echo $user['nip'];?>">
                    <input type="hidden" name="user[]" value="<?php echo $user['username'];?>">
                    <input type="hidden" name="pass[]" value="<?php echo $user['password'];?>">
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