<?php
include_once("../../php/include_all.php");
include ("aksi.php");

$sk = $_GET['skpd'];
$tahun = date('Y');
$bulan = date('m');
$tgl = date('d');
$act = '';
if(isset($_POST['act']))
	$act = $_POST['act'];
if ($code == 'jab'){
	$jabatan = get_datas("select * from skp_jabatan where unit_kerja=".$sk."order by idjab ");
	echo "<option value='0'>--plih jabatan--</option>";
	foreach ($jabatan as $jab) {
		$kodejab = $jab['kode_jabatan'];
		$namajab = $jab['nama_jabatan'];
		echo "<option value='$kodejab'>&nbsp;$namajab</option>";
	}
}

else if($act == 'input_mutasi'){
	$id = $_POST['id_pns'];
	$skpd = $_POST['mut'];
	$jab = $_POST['jabb'];
	$jabawl = $_POST['kode_jabAwl'];
	if (!is_numeric($id)) {
	echo $id;
        echo "Err : invalid id. ";
        exit;
    }
	if($id > 0){
		exec_query ("update skp_pns set kode_jabatan='".$jab."' where id_pns=".$id."");
		echo 'success__';
	 
		$maxid = get_maxid('id_temp','skp_jabatan_hist');
		exec_query("insert into skp_jabatan_hist (id_temp, id_pns, kode_jabatan, bulan, tahun, tanggal) values (".$maxid.",".$id.",'".$kode_jabAwl."',".$bulan.",".$tahun.",".$tgl.")");
		$br = get_data("select id_temp from skp_jabatan_hist where id_temp=".$maxid);
		if($st['id_temp'] == $maxid){
			echo 'success__';
			$id = $maxid; 
		}
	}
	echo $id. '__';
	$pnsbr = get_data("select p.nama as nama_pe, p.nip, j.nama_jabatan, j.unit_kerja, s.nama from skp_skpd s, skp_jabatan j, skp_pns p where s.id=j.unit_kerja and j.kode_jabatan=p.kode_jabatan and id_pns=".$id);
	echo $namabr = $pnsbr['p.nama'].'__';
	echo $nipbr = $pnsbr['nip'].'__';
	echo $jabbr = $pnsbr['nama_jabatan'].'__';
	echo $skpdbr = $pnsbr['nama'].'__';
	
	view_skpd($skpd);
}
/*
function view_skpd($skpd){
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
}*/
?>