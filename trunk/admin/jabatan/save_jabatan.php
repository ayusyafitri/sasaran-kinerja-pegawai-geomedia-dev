<?php
include_once ('../../php/postgre.php');
include ('../../php/function_global.php');

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
        exec_query("update skp_jabatan set unit_kerja=".$skpd."', nama_jabatan='".$nama."', parent=".$induk.", kode_jabatan='" . $kode . "', jabatan='".$jabatan."', unit_organisasi=".$unitorgnisasi." where idjab=" . $id . "");
        echo 'success__';
    } else {
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
    }
    echo $id.'__';
	view_jabatan($skpd);
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
 //   view_jabatan($skpd);
} 

else if ($act == 'ubah_jabatan') {
    $id = $_POST['id'];
    if (is_numeric($id)) {
        $data = get_data("select idjab, nama_jabatan, kode_jabatan, parent, unit_kerja,unit_organisasi, jabatan from skp_jabatan where idjab=" . $id);
    	$ress = implode($data, '__');
        print_r($ress);
		
		echo "__".$kk;
		$idinduk = $data['unit_kerja'];
		$parent = 0;
		if ($val == $induk['idjab'])
		$kk = get_induk($val='', $parent, $iter=1, $idinduk);
	
		$unit = get_datas("select * from skp_unit_eselon where id_skpd=".$data['unit_kerja']);
		if($data=="Jabatan Struktural"){
		//	$i = $unit['nama_unit'];
			$i.= '<input type="text" name="unit" id="unit" class="span3" value="'.$unit['nama_unit'].'">
				  <input type="text" name="eslon" id="eslon" class="span2" value="'.$unit['eselon'].'">';
		}
		else {
			foreach ($unit as $unit){
				$i.= '<option value="' . $unit["id_unit"] . '">"' . $unit["nama_unit"] . '"</option>';
			}
		}
		echo "__".$i;
	} else {
        echo 'error';
    }

  //  view_jabatan($skpd);
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

    //	echo $skpd;
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

    /* 	$kode = $_POST['kode'];
      if(!is_numeric($kode)) exit();
      $kodeindk = get_data("select * from skp_jabatan where idjab=".$kode);
      $kdinduk = $kodeindk['parent'];

      $kodejab = get_data("select count(idjab) as kode from skp_jabatan where parent=".$kdinduk);
      $kdjab = $kodejab['kode']+1;
      $kjb = ($kdjab <=9)? "0".$kdjab:$kdjab;
      $kode_jab = $kodeindk['kode_jabatan'].".".$kjb;
      echo $kode_jab;
     */
} else if ($act == 'rlJabatan') {
    $skp = $_POST['skp'];
	echo $skp;
    $unitorganisasi = get_datas("select * from skp_unit_eselon where id_skpd=" .$skp);
    $i = "<select name='unitorgnisasi' id='unitorgnisasi'>";
    foreach ($unitorganisasi as $unitor) {
        $i.= "<option value='" . $unitor["id_unit"] . "'>" . $unitor["nama_unit"] . "</option>";
    }
    $i.= '</select>';
    echo $i;
}

function get_induk($val='', $parent=0, $iter=1, $idinduk) {
   // $idinduk = $_POST['idindukk'];
//	$parent =0;
//	$iter=1;

    $induk = get_datas("select nama_jabatan, idjab, unit_kerja from skp_jabatan where unit_kerja=".$idinduk . " and parent=" . $parent . " order by idjab");
   
//	echo $idinduk;
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

function view_jabatan($skpd) {
	//$skpd = $skpd;
    $x = 1;
    $pr = get_datas("select * from skp_jabatan where unit_kerja=".$skpd." order by idjab ");
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

