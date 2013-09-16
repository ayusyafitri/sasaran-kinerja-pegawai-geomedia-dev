<?php
include_once ('../../php/postgre.php');
$act = '';
if (isset($_POST['act']))
    $act = $_POST['act'];
if ($act == 'simpan_pemangku') {
    $id = $_POST['id_pns'];
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
    view_skpd();
	
} else if ($act == 'hapus_pemangku') {
    $id = $_POST['id'];
    if (is_numeric($id)) {
        exec_query("delete from skp_pns where id_pns=" . $id);
        echo 'success__';
    } else {
        echo 'error';
    }
    view_skpd();
} else if ($act == 'ubah_pemangku') {
    $id = $_POST['id'];
    if (is_numeric($id)) {
        $data = get_data("select id_pns, nama, nip, id_golongan, kode_jabatan, alamat, notelp, tempat_lahir, tanggal_lahir from skp_pns where id_pns=" . $id);
		$pecah = explode('-',$data['tanggal_lahir']);
		//$pecah = $data['tanggal_lahir'].split('-');
		$thn = $pecah[0];
		$bln = $pecah[1];
		$tgl = $pecah[2];
        $ress = implode($data, '__');
        print_r($ress);
        echo "__";
		echo $thn.'__'.$bln.'__'.$tgl.'__';
    } else {
        echo 'error';
    }

    view_skpd();
}

function view_skpd() {

    $x = 1;
    $pr = get_datas("select p.id_pns, p.nama, p.nip, g.nama_golongan, g.keterangan, j.nama_jabatan, p.alamat, p.notelp, p.tempat_lahir, p.tanggal_lahir from skp_pns p, skp_jabatan j, skp_golongan g where g.id_gol=p.id_golongan and j.kode_jabatan=p.kode_jabatan order by p.id_pns");
    foreach ($pr as $pr) {
                ?><tr>
                    <td><?php echo $x ?></td>
                    <td><?php echo $pr['nama'] ?></td>
                    <td><?php echo $pr['nip'] ?></td>
                    <td><?php echo $pr['nama_golongan']?> (<? echo $pr['keterangan'] ?>)</td>
                    <td><?php echo $pr['nama_jabatan'] ?></td>
                    <td><?php echo $pr['alamat'] ?></td>
                    <td><?php echo $pr['notelp'] ?></td>
                    <td><?php echo $pr['tempat_lahir'] ?>, <? echo $pr['tanggal_lahir']?></td>
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

