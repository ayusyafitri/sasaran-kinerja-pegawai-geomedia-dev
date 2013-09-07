<?php
function nbsp($str){
	if($str=='' or $str==0) return '&nbsp;';
	return $str;
}
/**
 * Mengembalikan string format tanggal. 
 * @param type $date input tanggal type string dgn format dd mm yyyy Atau yyyy mm dd
 * @param type $splitChar karakter pemisah di tanggal
 * @param type $flip boolean, true untuk format dd mm yyyy -> yyyy mm dd (toDb) , false untuk format yyyy mm dd -> dd mm yyyy (from db)
 * @return string Tanggal
 */

function format_tglSimpan($date, $splitChar = '-', $flip = TRUE){
    $tt = '';
    if ($flip){
        $tgl = explode($splitChar, $date);
        $tt = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
    }else{
        $tgl = explode('-', $date);
        $tt = $tgl[2].$splitChar.$tgl[1].$splitChar.$tgl[0];
    }
    return $tt;
}
?>