<?php

function opendb($db) {
    return pg_connect("host=localhost port=5432 dbname=$db user=postgres password=roketpostgre");
}

function get_data($query) {
    $q = pg_query($query);
    $r = pg_fetch_array($q);
    return $r[0];
}


function get_datas($query){
  $result = array();
  $q = pg_query($query);
  while($r = pg_fetch_array($q)){
    $result[] = $r;
  }
  return $result;
}

$db1 = opendb('evjab');
$dataBefore = get_datas("SELECT * FROM eva_pemangku order by pem_kode");
pg_close($db1);

$db2 = opendb('eskape');
foreach ($dataBefore as $value) {
    pg_query("INSERT INTO skp_pns (id_pns,nama,nip,pem_no,kode_jabatan) VALUES (".$value['pem_kode'].",
        '".$value['pem_nama']."','".$value['pem_nip']."','".$value['pem_no']."','".$value['pem_kodeja']."')");
}
pg_close($db2);
?>
