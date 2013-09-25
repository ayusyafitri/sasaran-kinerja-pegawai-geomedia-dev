<?php
include_once ('../../php/postgre.php');
include ('../../php/function_global.php');
session_start();
$act = '';
if (isset($_POST['act']))
    $act = $_POST['act'];
if ($act == 'jabatan_simpan') {
    $id = $_POST['id'];
    $skpd = $_POST['id_skpd'];
	$nama = $_POST['nama'];
	$induk = $_POST['id_induk'];
	$kode = $_POST['kodejab'];
	$jabatan = $_POST['id_jabatan'];
	$nameUnit = $_POST['unit'];
	$golUnit = $_POST['eslon'];
	$idunit=$_POST['unitorgnisasi'];
	
    if (!is_numeric($id)) {
        echo "Err : invalid id. ";
        exit;
    }

    if ($id > 0) {
        exec_query("update skp_jabatan set unit_kerja=".$skpd.", nama_jabatan='".$nama."', parent=".$induk.", kode_jabatan='" . $kode . "', jabatan='".$jabatan."', unit_organisasi=".$unitorgnisasi." where idjab=" . $id . "");
        echo 'success__';
    } else {
		if($jabatan=="Jabatan Struktural"){
				//simpan unit organisasi
			$maxid1 = get_maxid('id_unit','skp_unit_eselon');
			exec_query("insert into skp_unit_eselon(id_unit,nama_unit, eselon, id_skpd) values (".$maxid1.",'".$nameUnit."','".$golUnit."',".$skpd." )");
			$store1 = get_data("select id_unit from skp_unit_eselon where id_skpd=".$skpd);
			if ($store1['id_unit'] == $maxid1) {
				$idunit = $maxid1;
			}
			$maxid = get_maxid('idjab', 'skp_jabatan');
			exec_query("insert into skp_jabatan (idjab, nama_jabatan, kode_jabatan, parent, unit_kerja, unit_organisasi, jabatan) values(" . $maxid . ",'". $nama."','". $kode."',".$induk.", ".$skpd.",".$maxid1.",'".$jabatan."')");
			$store = get_data("select idjab from skp_jabatan where idjab=".$maxid);
						
			if($store['idjab']==$maxid){
				echo "success__";
				$id = $maxid;
			}
		}else{
			$maxid = get_maxid('idjab', 'skp_jabatan');
			exec_query("insert into skp_jabatan (idjab, nama_jabatan, kode_jabatan, parent, unit_kerja, unit_organisasi, jabatan) values(" . $maxid . ",'". $nama."','". $kode."',".$induk.", ".$skpd.",".$idunit.",'".$jabatan."')");
			$store = get_data("select idjab from skp_jabatan where idjab=".$maxid);
						
			if($store['idjab']==$maxid){
				echo "success__$jabatan";
				$id = $maxid;
			}		
		}
	}
    echo $id.'__';
	view_jabatan();
} 
else if ($act == 'hapus_skpd') {
    $id = $_POST['id'];
	$status = get_data("select * from skp_jabatan where idjab=".$id);
	
	if (is_numeric($id)) {
        if($status['jabatan']=="Jabatan Struktural"){
			exec_query("delete from skp_jabatan where idjab=".$id);
			exec_query("delete from skp_unit_eselon where id_unit=".$status['unit_organisasi']);
		}
		else{
			exec_query("delete from skp_jabatan where idjab=".$id);
		}
	    echo 'success__';
    } else {
        echo 'error';
    }
    view_jabatan();
} 

else if ($act == 'ubah_jabatan') {
    $id = $_POST['id'];
    if (is_numeric($id)) {
        $data = get_data("select idjab, nama_jabatan, kode_jabatan, parent, unit_kerja, unit_organisasi, jabatan from skp_jabatan where idjab=" . $id);
		
		if ($data['jabatan'] == "Jabatan Struktural") {
			$unit2 = get_data("select distinct (id_unit), nama_unit, eselon from skp_unit_eselon, skp_jabatan where id_unit=unit_organisasi and id_unit=".$data['unit_organisasi']);

			$i.= "<td><input type='text' name='unit' id='unit' value='".$unit2['nama_unit']."' class='span3'/></td><td><input type='text' name='eslon' id='eslon' value='".$unit2['eselon']."' class='span1'/></td>";
			
		}else{
			$unit1 = get_datas("select distinct u.nama_unit, u.id_unit,  u.id_skpd, j.unit_organisasi from skp_unit_eselon u, skp_jabatan j where u.id_skpd=j.unit_kerja and u.id_unit=j.unit_organisasi and u.id_skpd=".$data['unit_kerja']);
			$i.= "<select name='unitorgnisasi' id='unitorgnisasi'>";
				foreach ($unit1 as $unit){
					$s = ($unit["id_unit"] == $data['unit_organisasi']) ? 'selected':'';
					$i.= '<option value="'. $unit["id_unit"].'" '.$s.'>'.$unit["nama_unit"] . '</option>';
				}
			 $i.= '</select>';
		}		
		$ress = implode($data, '__');
        print_r($ress);
		echo '__'.$i;
	} else {
        echo 'error';
    }

} else if ($act == 'get_induk') {
    $idinduk = $_POST['idindukk'];
    $parent = 0;
    $iter = 1;
	echo $idinduk;
    get_induk($val = '', $parent, $iter=0, $idinduk);
} 


else if ($act == 'get_kode') {
    $kode = $_POST['kode'];
    $skpd = $_POST['skpdd'];

   $organisasi = get_data("select * from skp_skpd where id=" . $skpd);
    $kdskpd = $organisasi['kode'];

    $parent = get_data("select * from skp_jabatan where idjab=" . $kode);
    $idk = $parent['kode_jabatan'];
    $idpar = $parent['idjab'];

    $kodejab = get_data("select count(idjab) as kodeq from skp_jabatan where parent=" . $kode . " and unit_kerja=" . $skpd);

    if ($kode == 0) {
        $kdjab = $kodejab['kodeq'] + 1;
        $kode_jab = $kdskpd . "." . $kdjab;
        echo $kode_jab;
    } else {
        $kdjab = $kodejab['kodeq'] + 1;
        $kode_jab = $idk . "." . $kdjab;
        echo $kode_jab;
    }

} else if ($act == 'rlJabatan') {
    $skp = $_POST['skp'];
    $unitorganisasi = get_datas("select * from skp_unit_eselon where id_skpd=" .$skp);
    $i = "<select name='unitorgnisasi' id='unitorgnisasi'>";
    foreach ($unitorganisasi as $unitor) {
        $i.= "<option value='" . $unitor["id_unit"] . "'>" . $unitor["nama_unit"] . "</option>";
    }
    $i.= '</select>';
    echo $i;
}

function get_induk($val='', $parent=0, $iter=1, $idinduk) {

    $induk = get_datas("select nama_jabatan, idjab, unit_kerja from skp_jabatan where unit_kerja=".$idinduk . " and parent=" . $parent . " order by idjab");
   
	if ($parent == 0)
        echo "<option value='0'>Tidak Ada Induk</option>";
    foreach ($induk as $induk) {
        if ($val == $induk['idjab'])
            $sel = "selected='selected'";
        echo "<option $sel value='$induk[idjab]'>" . space($iter * 5, "&nbsp;", false) . "$induk[nama_jabatan]</option>\n";
		$idinduk = $induk['unit_kerja'];
        echo get_induk($val, $induk['idjab'], ($iter + 1), $idinduk);
        $sel = '';
    }
}

function view_jabatan() {
    $x = 1;
    $pr = get_datas("select * from skp_jabatan where unit_kerja=".$_SESSION['_idSkpd']." order by kode_jabatan ");
    foreach ($pr as $pr) {
        ?><tr>
            <td><?php echo $x ?></td>
            <td>&nbsp;<?php echo $pr['kode_jabatan'] ?></td>
            <td><?php echo $pr['nama_jabatan'] ?></td>
            <td class="center" >
                <a href="#modalwin" data-toggle="modal"  class="btn btn-info btn-small bt-edit-jabatan" name="<?php echo $pr['idjab']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
			   <a class="btn btn-danger btn-small bt-hapus-jabatan" name="<?php echo $pr['idjab']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

            </td>
        </tr>
        <?php
        $x++;
    }
}
?>

