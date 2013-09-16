<?php
include_once ('../../php/postgre.php');
$act = '';
if (isset($_POST['act']))
    $act = $_POST['act'];
if ($act == 'skpd_simpan') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];

    if (!is_numeric($id)) {
        echo "Err : invalid id. ";
        exit;
    }

    if ($id > 0) {
        exec_query("update skp_skpd set nama='" . $nama . "', kode='" . $kode . "', username='".$kode."', password='".$kode."' where id=" . $id . "");
        echo 'success__';
    } else {
        $maxid = get_maxid('id', 'skp_skpd');
        exec_query("insert into skp_skpd (nama, kode, id, username, password) values('" . $nama . "', '" . $kode . "', " . $maxid . ",'".$kode."','".$kode."')");
        $st = get_data('select id from skp_skpd where id=' . $maxid);
        if ($st['id'] == $maxid) {
            echo 'success__';
            $id = $maxid;
        }
    }
    echo $id . '__';
    view_skpd();
} else if ($act == 'hapus_skpd') {
    $id = $_POST['id'];
    if (is_numeric($id)) {
        exec_query("delete from skp_skpd where id=" . $id);
        echo 'success__';
    } else {
        echo 'error';
    }
    view_skpd();
} else if ($act == 'ubah_skpd') {
    $id = $_POST['id'];
    if (is_numeric($id)) {
        $data = get_data("select id,kode, nama from skp_skpd where id=" . $id);
        $ress = implode($data, '__');
        print_r($ress);
        echo "__";
    } else {
        echo 'error';
    }

    view_skpd();
}

function view_skpd() {

    $x = 1;
    $pr = get_datas("select * from skp_skpd order by id");
    foreach ($pr as $pr) {
        ?><tr>
            <td><?php echo $x ?></td>
            <td>&nbsp;<?php echo $pr['kode'] ?></td>
            <td><?php echo $pr['nama'] ?></td>
			<td><?php echo $pr['username']?></td>
			<td><?php echo $pr['password']?></td>
            <td class="center" >
                <a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['id']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['id']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

            </td>
        </tr>
        <?php
        $x++;
    }
}
?>

