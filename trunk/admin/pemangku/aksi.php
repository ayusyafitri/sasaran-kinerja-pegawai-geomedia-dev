<?php
include_once ('../../php/postgre.php');

$act = '';
if (isset($_POST['act']))
    $act = $_POST['act'];
if ($act == 'simpan_pemangku') {
    $id = $_POST['id_pns'];
	$skpd = $_POST['id_skpd'];
    $kdjab = $_POST['jab'];
    $idgol = $_POST['gol'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $tempat = $_POST['tempat'];
	$tgl = sprintf("%02d%02d%02d",$_POST[thn],$_POST[bln],$_POST[tgl]);
	$pemno = $_POST['pem_no'];

    if (!is_numeric($id)) {
        echo "Err : invalid id. ";
        exit;
    }

    if ($id > 0) {
        exec_query("update skp_pns set nama='" . $nama . "', nip='" . $nip . "',  id_golongan=".$idgol.", kode_jabatan='".$kdjab."', alamat='".$alamat."', notelp='".$telp."', tempat_lahir='".$tempat."', tanggal_lahir='".$tgl."' where id_pns=" . $id . "");
        echo 'success__';
    } else {
        $maxid = get_maxid('id_pns', 'skp_pns');
        exec_query("insert into skp_pns (id_pns, nama, nip, id_golongan, kode_jabatan, alamat, notelp, tempat_lahir, tanggal_lahir, username, password, pem_no) values(" . $maxid . ", '".$nama."', '".$nip."', ".$idgol.", '".$kdjab."', '".$alamat."','".$telp."', '".$tempat."', '".$tgl."', '".$nip."', '".$nip."', ".$pemno.")");
        $st = get_data('select id_pns from skp_pns where id_pns=' . $maxid);
        if ($st['id_pns'] == $maxid) {
            echo 'success__';
            $id = $maxid;
        }
    }
    echo $id . '__';
    view_skpd($skpd);
	
} else if ($act == 'hapus_pemangku') {
    $id = $_POST['id'];
	$sk = get_data("select j.unit_kerja from skp_jabatan j, skp_pns p where j.kode_jabatan=p.kode_jabatan and p.id_pns=".$id);
	
    if (is_numeric($id)) {
        exec_query("delete from skp_pns where id_pns=" . $id);
        echo 'success__';
    } else {
        echo 'error';
    }
    view_skpd($sk['unit_kerja']);
} else if ($act == 'ubah_pemangku') {
    $id = $_POST['id'];
	
    if (is_numeric($id)) {
	    $data = get_data("select id_pns, nama, nip, id_golongan, kode_jabatan, alamat, notelp, tempat_lahir, tanggal_lahir from skp_pns where id_pns=" . $id);
	
		$pecah = explode('-',$data['tanggal_lahir']);
		$thn = $pecah[0];
		$bln = $pecah[1];
		$tgl = $pecah[2];
        $ress = implode($data, '__');
        print_r($ress);
        echo "__";
	 
		 echo $thn.'__'.$bln.'__'.$tgl.'__';
		
		$sk = get_data("select unit_kerja from skp_jabatan where kode_jabatan='".$data['kode_jabatan']."'order by idjab");
	//	echo $sk['unit_kerja']."__";
		$jabatan = get_datas("select * from skp_jabatan where unit_kerja=".$sk['unit_kerja']."order by idjab");
		$jj .=$jabatan[0]['unit_kerja'];
		if($data['kode_jabatan']=$jj){
			foreach($jabatan as $jab){
				$dpro .= '<option value="'.$jab['kode_jabatan'].'">'.$jab['nama_jabatan'].'</option>';
			}
		}
		echo $dpro;
		 
    } else {
        echo 'error';
    }

 //   view_skpd($sk['unit_kerja']);
} else if($act == 'get_induk'){
	$pp = $_POST['idindukk'];
	$jab = get_datas ("select * from skp_jabatan where unit_kerja=".$pp." order by idjab");
	$i.= "<option value='0'>-Pilih Jabatan-</option>";
	foreach ($jab as $jab){
	    $i.= "<option value='".$jab['kode_jabatan']."'>".$jab['nama_jabatan']."</option>";
    }
	echo $i;
}

function view_skpd($skpd) {

    $x = 1;
   $pr = get_datas("select p.id_pns, p.nama, p.nip, p.id_golongan, p.id_golongan, j.nama_jabatan, p.alamat, p.notelp, p.tempat_lahir, p.tanggal_lahir 
from skp_pns p, skp_jabatan j where j.kode_jabatan=p.kode_jabatan and j.unit_kerja=".$skpd." order by id_pns");
 foreach ($pr as $pr) {
                ?><tr>
                    <td><?php echo $x ?></td>
					<td><a href="#showDetail" data-toggle="modal" id="mutasi" name="mutasi" onclick="mutasion(<?php echo $pr['id_pns']?>)">&nbsp;<?php echo $pr['nama'] ?></a></td>
					<td><?php echo $pr['nip'] ?></td>
					<td><?php echo $golongan['nama_golongan']?> (<?  echo $golongan['keterangan'] ?>)</td>
					<td><?php echo $pr['nama_jabatan'] ?></td> 
					   <td class="center" >
                        <a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['id_pns']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                        <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['id_pns']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

                    </td>
                </tr>
        <?php
        $x++;
    } 
}
?>
 
