<?php
if (isset($_SESSION['_nip'])) define ('SKP_NIP', $_SESSION['_nip']);
if (isset($_SESSION['_nama'])) define ('SKP_NAMA', $_SESSION['_nama']);
if (isset($_SESSION['_kdJabatan'])) define ('SKP_KODEJAB', $_SESSION['_kdJabatan']);
if (isset($_SESSION['_username'])) define ('SKP_USER', $_SESSION['_username']); 
if (isset($_SESSION['_idpns'])) define ('SKP_ID',$_SESSION['_idpns']);
if (isset($_SESSION['_jabatan'])) define ('SKP_JAB',$_SESSION['_jabatan']);


function openDB($db='eskape'){
	$_server = "localhost";
	$_dbport = "5432";
	$_dbname = $db;
	$_dbuser = "postgres";
	$_dbpass = "root";
	$con = pg_connect("host=$_server port=$_dbport dbname=$_dbname user=$_dbuser password=$_dbpass");
	return $con;
}

function closeDB($db){
	return pg_close($db);
}

/*
 * in  - string query
 * out - true or erre
 */


function exec_query($query = null,$dbb='eskape'){
	$db = openDB($dbb);
	$q  = pg_query($query) or die('Invalid Syntax');
	closeDB($db);
	return $q;
}

/* data untuk tabel (banyak baris)
 * in  - string query
 * out - result array orobject
 * example in use - (banyak data, banyak row)
 * $data = get_datas("select * from table");
 * foreach($data as $data){
 * 		echo $data['nama_kolom'];
 * }
 */
function get_datas($query = null,$dbb= 'eskape'){
	$db = openDB($dbb);
	$r  = array();
	$q  = pg_query($query) or die('Can\'t Retrieve Data');
	while($s = pg_fetch_array($q)){
		array_push($r,$s);
	}
	closeDB($db);
	return (count($r)>0) ? $r: array();
}

/* data untuk tampilan (hanya satu baris/row) / bukan untuk baris tabel
 * in  - string query
 * out - result array orobject
 * example use -
 * (single data, satu row)
 * $data = get_data("select * from table");
 * echo $data['nama_kolom']; atau echo $data[0,1,2,etc]
 *
 * (banyak data, banyak row)
 * $data = get_data("select * from table where id=3");
 * echo $data['nama_kolom1'];
 * echo $data['nama_kolom2'];
 * 
 */
function get_data($query = null,$dbb='eskape'){
	$db = openDB($dbb);       
	$r  = array();
	$q  = pg_query($query) or die('Can\'t Retrieve Data');
	if(pg_num_rows($q)==1){
		$s = pg_fetch_object($q);
		$r = get_object_vars($s);
	}
	closeDB($db);
	return (count($r)>0) ? $r: array();
}

/* 
 * in  - nama_id, nama_tabel
 * out - angka (id) maksimal
 */
function get_maxid($column,$table){
	$res = get_data("SELECT MAX(".$column.") as max FROM ".$table."");
	$rex = $res['max']+1;
	return $rex;
}

// function unconnect --

function exec_query_unconnect($query){
	$q  = pg_query($query) or die('Invalid Syntax');
	return $q;
}

function get_datas_unconnect($query){
	$r  = array();
	$q  = pg_query($query) or die('Can\'t Retrieve Data');
	while($s = pg_fetch_array($q)){
		array_push($r,$s);
	}
	return (count($r)>0) ? $r: array();
}

function get_data_unconnect($query){
	$r  = array();
	$q  = pg_query($query) or die('Can\'t Retrieve Data');
	if(pg_num_rows($q)==1){
		$s = pg_fetch_object($q);
		$r = get_object_vars($s);
	}
	return (count($r)>0) ? $r: array();
}

function get_maxid_unconnect($column,$table){
	$res = get_data_unconnect("SELECT MAX(".$column.") as max FROM ".$table."");
	$rex = $res['max']+1;
	return $rex;
}

?>