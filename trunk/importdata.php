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


$db2 = opendb('eskape');
$no = 1;
$dataBefore = get_datas("(SELECT distinct(nip) FROM skp_pns)",'eskape');
foreach ($dataBefore as $value) {
      $delData = get_datas("SELECT * FROM skp_pns where nip = '".$value['nip']."' order by id_pns ASC");      
      $no = 1;
      foreach ($delData as $delVa) {
          if($no > 1){
            echo $no.". ".$delVa['id_pns']." / ".$delVa['nama'];
            exec_query_noconnect("DELETE FROM skp_pns WHERE id_pns = '".$delVa['id_pns']."'");
          }
          $no++;
      }
//    $pas = substr($value['nip'], (strlen($value['nip']) - 3));    
//    $rs = exec_query_noconnect("UPDATE skp_skpd SET username = '$user',password = '$pas' where id = '$id'");
//    if(!$rs){
//        print_r(error_get_last());
//        break 1;
//    }else{        
//        echo "$no. ".$user." : $pass<br/>";
////    }
//    $no++;
}
pg_close($db2);
?>
