<?php

function opendb($db) {
    return pg_connect("host=localhost port=5432 dbname=$db user=postgres password=root");
}

function get_data($query) {
    $q = pg_query($query);
    $r = pg_fetch_array($q);
    return $r[0];
}

function get_maxID($column, $table) {
    $res = get_data("SELECT MAX(" . $column . ") as max FROM " . $table . "");
    $rex = ((int) $res['max']) + 1;
    return $rex;
}

function get_datas($query) {
    $result = array();
    $q = pg_query($query);
    while ($r = pg_fetch_array($q)) {
        $result[] = $r;
    }
    return $result;
}

function exec_query_noconnect($query) {
    $q = pg_query($query) or die('Invalid Syntax');
    return $q;
}

//$db1 = opendb('samarinda');
//$dataBefore = get_datas("SELECT kode_jabatan, uraian, volume_kerja, no_uraian from uraian order by id_uraian asc", 'samarinda');
//pg_close($db1);

$db2 = opendb('eskape');
$kdeJabatan = get_datas("SELECT distinct(kode_jabatan), id_pns from skp_pns order by id_pns");
$idMax = 1;
$sb = "";
$sb1 = '';
foreach ($kdeJabatan as $value) {
    $dt = get_datas("SELECT * from skp_pns where kode_jabatan = '" . $value['kode_jabatan'] . "' order by id_pns ASC");
    foreach ($dt as $dta) {
        if ($sb1 != $dta['kode_jabatan']) {
            $sb1 = $dta['kode_jabatan'];
            echo "other <br />";
        } else {
            $query = exec_query_noconnect("DELETE FROM skp_pns where id_pns = " . $dta['id_pns']);
            echo "DELETE FROM skp_pns where id_pns = " . $dta['id_pns'] . "<br/>";
            if (!$query) {
                break 1;
                echo "eror in delete value : " . $dta['id_pns'];
                exit();
            }
            echo " Del ".$value['kode_jabatan']." id : ".$dta['id_pns']."<br/>";
        }
    }    
}
pg_close($db2);
?>
