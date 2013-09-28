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
	$jab_bkn= $_POST['rumpun'].' '.$_POST['embel'];
	
    if (!is_numeric($id)) {
        echo "Err : invalid id. ";
        exit;
    }

    if ($id > 0) {     
		if($jabatan == "Jabatan Struktural"){
			$dataunit = get_data("select * from skp_jabatan where idjab=".$id);
			exec_query("update skp_unit_eselon set nama_unit='".$nameUnit."', eselon='".$golUnit."' where id_unit=".$dataunit['unit_organisasi']."");
			exec_query("update skp_jabatan set unit_kerja=".$skpd.", nama_jabatan='".$nama."', parent=".$induk.", kode_jabatan='" . $kode . "', jabatan='".$jabatan."' where idjab=" . $id . "");
			echo 'success__';
		}
		else {
			exec_query("update skp_jabatan set unit_kerja=".$skpd.", nama_jabatan='".$jab_bkn."', parent=".$induk.", kode_jabatan='" . $kode . "', jabatan='".$jabatan."', unit_organisasi=".$idunit." where idjab=" . $id . "");
			echo 'success__';
		}
		
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
			exec_query("insert into skp_jabatan (idjab, nama_jabatan, kode_jabatan, parent, unit_kerja, unit_organisasi, jabatan) values(" . $maxid . ",'". $jab_bkn."','". $kode."',".$induk.", ".$skpd.",".$idunit.",'".$jabatan."')");
			$store = get_data("select idjab from skp_jabatan where idjab=".$maxid);
						
			if($store['idjab']==$maxid){
				echo "success__$jabatan";
				$id = $maxid;
			}		
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
    view_jabatan($status['unit_kerja']);
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
		
		$kk = get_induk($parent, $iter=1, $idinduk,$data['parent']);
		
		$i = '__';
		if($data['jabatan']=="Jabatan Struktural"){
			$unit2 = get_data("select distinct (id_unit), nama_unit, eselon from skp_unit_eselon, skp_jabatan where id_unit=unit_organisasi and id_unit=".$data['unit_organisasi']);
			$unitsd = get_datas("select * from skp_unit_eselon where id_skpd=".$data['unit_kerja']);
			$i.= "<td><input type='text' name='unit' id='unit' value='".$unit2['nama_unit']."' class='span3'/></td>
				  <td><input type='text' name='eslon' id='eslon' value='".$unit2['eselon']."' class='span1'/></td>";
			$nmjab.="<input type='text' name='nama' id='nama'  value ='".$data['nama_jabatan']."'/>" ;
		}
		else {
			$unit1 = get_datas("select distinct u.nama_unit, u.id_unit,  u.id_skpd, j.unit_organisasi from skp_unit_eselon u, skp_jabatan j where u.id_skpd=j.unit_kerja and u.id_unit=j.unit_organisasi and u.id_skpd=".$data['unit_kerja']);
				$i.= "<select name='unitorgnisasi' id='unitorgnisasi'>";
					foreach ($unit1 as $unit){
						$s = ($unit["id_unit"] == $data['unit_organisasi']) ? 'selected':'';
						$i.= '<option value="'. $unit["id_unit"].'" '.$s.'>'.$unit["nama_unit"] . '</option>';
					}
				 $i.= '</select>';
			
			$pecah = explode(' ', $data['nama_jabatan']);
			 $rumpun = get_datas ("select * from skp_bkn_jabatan order by kode_jabatan");
				$nmjab = "<td><select name='rumpun' id='rumpun' onchange='emb(this.value);'> ";
				foreach ($rumpun as $rumpun){
					$se = ($rumpun['nama_jabatan'] == $pecah[0])?'selected':'';
					$nmjab.="<option value='".$rumpun['nama_jabatan']."' ".$se.">".$rumpun['nama_jabatan']."</option>";
				}
			$nmjab.="</select></td><td><select id='embel' name='embel'>";
			
			$t_embel = get_datas ("select r.id_rumpun, r.kode_jabatann, r.keterangan from skp_rumpun_jab r, skp_bkn_jabatan j where j.kode_jabatan=r.kode_jabatann and j.nama_jabatan='".$pecah[0]."'");
			//print_r($pecah[1]);
			foreach ($t_embel as $t_embel){
				$sel = ($t_embel['keterangan'] == $pecah[1])?'selected':'';
				$nmjab .= "<option value='".$t_embel['keterangan']."' ".$sel.">".$t_embel['keterangan']."</option>";
			}
			$nmjab.="</select></td>";
			
		}
		echo $i.'__'.$nmjab.'__'.$pecah[0].'__'.$pecah[1];
	} else {
        echo 'error';
    }

  //  view_jabatan($skpd);
} else if ($act == 'get_induk') {
    $idinduk = $_POST['idindukk'];
    $parent = 0;
    $iter = 1;
	echo $idinduk;
    get_induk($parent, $iter=0, $idinduk);
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
} else if ($act == 'rlJabatan') {
    $skp = $_POST['skp'];
//	echo $skp;
    $unitorganisasi = get_datas("select * from skp_unit_eselon where id_skpd=" .$skp);
    $i = "<select name='unitorgnisasi' id='unitorgnisasi'>";
    foreach ($unitorganisasi as $unitor) {
        $i.= "<option value='" . $unitor["id_unit"] . "'>" . $unitor["nama_unit"] . "</option>";
    }
    $i.= '</select>';

	//rumpun jabatan:
	$tamRumpun = get_datas("select * from skp_bkn_jabatan order by kode_jabatan");
	$rum = "<td><select name='rumpun' id='rumpun' onchange='emb(this.value);'> 
				<option value=''>-Pilih Nama Rumpun-</option>";
	foreach ($tamRumpun as $rumpun){
		$rum.="<option value='".$rumpun['nama_jabatan']."'>".$rumpun['nama_jabatan']."</option>";
	}
	$rum.="</select></td><td><select id='embel' name='embel'><option value=''>-Spesifik-</option></select></td>";

   echo $i.'__'.$rum;
} else if($act == 'pil_rum'){
	$rumput = addslashes($_POST['rump']);
	$embel = get_datas ("select r.id_rumpun, r.kode_jabatann, r.keterangan from skp_rumpun_jab r, skp_bkn_jabatan j where j.kode_jabatan=r.kode_jabatann and j.nama_jabatan='".$rumput."'");
	foreach ($embel as $embel){
		$embelshow .= "<option value='".$embel['keterangan']."'>".$embel['keterangan']."</option>";
	}
	echo $embelshow ;

} 

function get_induk($parent=0, $iter=1, $idinduk,$val = ''){
   $induk = get_datas("select nama_jabatan, idjab, unit_kerja from skp_jabatan where unit_kerja=".$idinduk . " and parent=" . $parent . " order by idjab");
	if ($parent == 0)
        echo "<option value='0'>Tidak Ada Induk</option>";
    foreach ($induk as $induk) {
        if ($val == $induk['idjab'])
            $sel = "selected='selected'";
        echo "<option $sel value='$induk[idjab]'>" . space($iter * 5, "&nbsp;", false) . "$induk[nama_jabatan]</option>\n";
		$idinduk = $induk['unit_kerja'];
        echo get_induk($induk['idjab'], ($iter + 1), $idinduk, $val);
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

