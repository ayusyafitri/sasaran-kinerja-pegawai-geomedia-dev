<?php

function nbsp($str) {
    if ($str == '' or $str == 0)
        return '&nbsp;';
    return $str;
}

/**
 * Mengembalikan string format tanggal. 
 * @param type $date input tanggal type string dgn format dd mm yyyy Atau yyyy mm dd
 * @param type $splitChar karakter pemisah di tanggal
 * @param type $flip boolean, true untuk format dd mm yyyy -> yyyy mm dd (toDb) , false untuk format yyyy mm dd -> dd mm yyyy (from db)
 * @return string Tanggal
 */
function format_tglSimpan($date, $splitChar = '-', $flip = TRUE) {
    $tt = '';
    if ($flip) {
        $tgl = explode($splitChar, $date);
        $tt = $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
    } else {
        $tgl = explode('-', $date);
        $tt = $tgl[2] . $splitChar . $tgl[1] . $splitChar . $tgl[0];
    }
    if(empty($date)){
        $tt = '';   
    }
    return $tt;
}

/**
 * index array : id, nama, nip,kodejab, alamat, noTelp, tmpat_lhr, tgl_lhr,imgProfil, namajab,idJabAtasan,unitOrg,
 * idJab,jnsJab(JFU,JFT,JS), pangkatGol (I,IV,III),ketGol (keterangan Golongan),UnitKerja, namaUnit, eselon
 * @param type $idPns
 * @return type array
 */
function getDataPNS($idPns) {
    $arrData = array();
    $dtaPns = get_data("SELECT p.username, p.password,p.id_pns, p.nama, p.nip, p.kode_jabatan, p.alamat, p.notelp,p.tempat_lahir,p.tanggal_lahir,p.image_profil,
        j.nama_jabatan, j.parent as idjabatasan,j.unit_organisasi,j.idjab,j.jabatan,g.nama_golongan,g.keterangan, 
        sk.nama as nmskpd, es.nama_unit, es.eselon  FROM skp_pns p, skp_jabatan j, skp_golongan g, skp_skpd sk, skp_unit_eselon es where 
        es.id_unit = j.unit_organisasi and sk.id = j.unit_kerja and g.id_gol = j.golongan and p.kode_jabatan = j.kode_jabatan and p.id_pns = '$idPns'");
    echo "";
    $arrData ['id'] = $dtaPns['id_pns'];
    $arrData ['nama'] = $dtaPns['nama'];
    $arrData ['nip'] = $dtaPns['nip'];
    $arrData ['kodejab'] = $dtaPns['kode_jabatan'];
    $arrData ['alamat'] = $dtaPns['alamat'];
    $arrData ['noTelp'] = $dtaPns['notelp'];
    $arrData ['tmpat_lhr'] = $dtaPns['tempat_lahir'];
    $arrData ['tgl_lhr'] = $dtaPns['tanggal_lahir'];
    $arrData ['namajab'] = $dtaPns['nama_jabatan'];
    $arrData ['idJabAtasan'] = $dtaPns['idjabatasan'];
    $arrData ['unitOrg'] = $dtaPns['unit_organisasi'];
    $arrData ['idJab'] = $dtaPns['idjab'];
    $arrData ['jnsJab'] = $dtaPns['jabatan'];
    $arrData ['pangkatGol'] = $dtaPns['nama_golongan'];
    $arrData ['ketGol'] = $dtaPns['keterangan'];
    $arrData ['UnitKerja'] = $dtaPns['nmskpd'];
    $arrData ['namaUnit'] = $dtaPns['nama_unit'];
    $arrData ['eselon'] = $dtaPns['eselon'];
    $arrData ['imgProfil'] = $dtaPns['image_profil'];
    $arrData ['user'] = $dtaPns['username'];
    $arrData ['pass'] = $dtaPns['password'];
    return $arrData;
}

/**
 * index array : id, nama, nip,kodejab, alamat, noTelp, tmpat_lhr, tgl_lhr, imgProfil,namajab,idJabAtasan,unitOrg,idJab,
 * jnsJab(JFU,JFT,JS), pangkatGol (I,IV,III),ketGol (keterangan Golongan), UnitKerja, namaUnit, eselon
 * @param type $idPns
 * @return type array data atasan
 */
function getDataAtasan($idPns) {
    $data = getDataPNS($idPns);
    $dt = get_data("SELECT p.id_pns FROM skp_pns p, skp_jabatan j where j.kode_jabatan = p.kode_jabatan and j.idjab = '" . $data['idJabAtasan'] . "'");
    echo "SELECT p.id_pns FROM skp_pns p, skp_jabatan j where j.kode_jabatan = p.kode_jabatan and j.idjab = '" . $data['idJabAtasan'] . "'";
    $dataAtasan = getDataPNS($dt['id_pns']);
    return $dataAtasan;
}

/**
 * Mengambalikan string tanda min jika $var =>  empty OR ""  OR 0
 * @param type $var mixed
 * @param String $rp currency ex:Rp
 * @param String $extension Beberapa tanda di belakang nilai ex : ,-
 * @return string
 */
function stripIfEmpty($var, $rp = null, $ext = NULL) {
    if (empty($var) OR $var == "" OR $var == '0') {
        return "-";
    } else {
        return $rp."&nbsp;".$var.$ext;
    }
}

function dotIfEmpty($var) {
    if (empty($var) OR $var == "" OR $var == '0') {
        return ".........................................";
    } else {
        return $var;
    }
}

function showPassInOtherCharacter($pass,$char = "#"){
    $symbol = '';
    for ($u = 0; $u < strlen($pass); $u++) {
        $symbol .= $char;
    }
    return $symbol;
}

function tugasTambahan($n) {
    if ((n >= 1) && (n <= 3)) {
        $nilai = 1;
    } elseif ((n >= 4) && (n <= 6)) {
        $nilai = 2;
    } elseif ((n >= 7) && (n <= 100)) {
        $nilai = 3;
    }
    return $nilai;
}
/**
 * Array multi dimensi, do foreach first to get value with these indexs : uraian, no_uraian, tupoksi, angka_kredit, output,
 * mutu, waktu, biaya, id_tkerja, status
 * @param String $idPns id Pns
 * @param Int $year tahun
 * @param String $kodeJab kode jabatan yang dipangku sekarang
 * @return Array
 */
function getDataTarget($idPns, $year, $kodeJab){
    $target = get_datas("SELECT u.uraian,u.no_uraian,u.tupoksi,k.angka_kredit,k.output, k.mutu,k.waktu,k.biaya,k.id_tkerja, s.status FROM skp_t_kerja k, skp_uraian u, skp_t_status s 
where s.id_tkerja = k.id_tkerja AND k.id_uraian = u.id_uraian and k.tahun = '" . $year. "' and k.id_pns = '" . $idPns . "' and k.kode_jabatan = '" . $kodeJab . "' order by u.no_uraian ASC");    
    return $target;
}

/**
 * index  => stgsTam : Nilai Tugas Tambahan; kreatif : Nilai Tugas Kreatif; 
 * nilaiSKP : Nilai SKP ;skpAbjad : bentuk Nilai SKP dalam Abjad; perilaku : Nilai Perilaku; capaian: n Perilaku ditambah SKP
 * <br/> Untuk indekx 'dataSKP' ,'uraianTam' : type array <br/> <b>mSih belum ada perhitungan angka kredit</b>
 * @param String $idPns : id nya pns
 * @param Integer $year : tahun
 * @return array
 */
function hitungSkp($idPns, $year, $bulan) {
    $total_perhitungan = 0;
    $jumlah = array();
    $target = array();
    $total_capaian = 0;
    $dtaRealisasi = get_datas("SELECT u.uraian, t.id_skp,t.id_tkerja,t.output, t.mutu, t.waktu, t.biaya, t.angka_kredit,r.id_realisasi, r.r_output,r.r_mutu,r.r_waktu,r.r_biaya
FROM skp_t_kerja t INNER JOIN skp_uraian u  ON t.tahun = '$year' and t.id_pns = '$idPns' and u.id_uraian = t.id_uraian
LEFT OUTER JOIN skp_r_kerja r ON t.id_tkerja = r.id_tkerja order by u.no_uraian ASC");  
    $id_skp = 0;
    $pembagi = 0;
    $no = 0;
    foreach ($dtaRealisasi as $isiRealisasi) {
        $t_output = $isiRealisasi['output'];
        $t_mutu = $isiRealisasi['mutu'];
        $t_waktu = $isiRealisasi['waktu'];
        $t_biaya = $isiRealisasi['biaya'];
        $target[$no]['uraian'] = $isiRealisasi['uraian'];
        $target[$no]['output'] = $t_output;
        $target[$no]['mutu'] = $t_mutu;
        $target[$no]['waktu'] = $t_waktu;
        $target[$no]['biaya'] = $t_biaya;        
        $target[$no]['angka_kredit'] = $isiRealisasi['angka_kredit'];
        $r_output = $isiRealisasi['r_output'];
        $r_mutu = $isiRealisasi['r_mutu'];
        $r_waktu = $isiRealisasi['r_waktu'];
        $r_biaya = $isiRealisasi['r_biaya'];
        $target[$no]['r_output'] = $r_output;
        $target[$no]['r_mutu'] = $r_mutu;
        $target[$no]['r_waktu'] = $r_waktu;
        $target[$no]['r_biaya'] = $r_biaya;
        $pembagi = 2;
        $nOutput = (empty($t_output) OR ($t_output <= 0)) ? 0 : ($r_output / $t_output) * 100;
        $nMutu = (empty($t_mutu) OR ($t_mutu <= 0)) ? 0 : ($r_mutu / $t_mutu) * 100;
        $asWaktu = (empty($t_biaya) OR ($t_waktu <= 0)) ? 0 : 100 - ($r_waktu / $t_waktu * 100);
        if ($asWaktu > 0) {
            $nWaktu = ($asWaktu <= 24) ? ((1.76 * $t_waktu - $r_waktu) / $t_waktu) * 100 : 76 - (((1.76 * $t_waktu - $r_waktu) / $t_waktu * 100) - 100);
            $pembagi++;
        } else {
            $nWaktu = 0;
        }
        $asBiaya = (empty($t_biaya) OR ($t_biaya <= 0)) ? 0 : 100 - ($r_biaya / $t_biaya * 100);
        if ($asBiaya > 0) {
            $nBiaya = ($asBiaya <= 24) ? ((1.76 * $t_biaya - $r_biaya) / $t_biaya) * 100 : 76 - (((1.76 * $t_biaya - $r_biaya) / $t_biaya * 100) - 100);
            $pembagi++;
        } else {
            $nBiaya = 0;
        }
        $prhtungan = $nOutput + $nMutu + $nWaktu + $nBiaya;
        $nCapaianSKP = $prhtungan / $pembagi;
        $target[$no]['penghitungan'] = $prhtungan;
        $target[$no]['capaian'] = $nCapaianSKP;
        $total_perhitungan = $total_perhitungan + $prhtungan;
        $total_capaian = $total_capaian + $nCapaianSKP;
        $id_skp = $isiRealisasi['id_skp'];
        $pembagi++;
        $no++;
    }
    $tm = hitungTgsTambahan($id_skp);
    $jumlah['dataSKP'] = $target;
    $jumlah['NilaiTgsTam'] = $tm['nilai'];
    $jumlah['uraianTam'] = $tm['uraians'];
    $jumlah['kreatif'] = hitungNilaiKreatif($id_skp);
    $jumlah['perilaku'] = hitungNPerilaku($idPns, $year, $bulan);
    $jumlah['nilaiSKP'] = ($total_capaian / $pembagi) + $jumlah['kreatif'] + $jumlah['tgsTam'];
    $jumlah['nilaiSKP'] = ($jumlah['nilaiSKP'] * 60) / 100;
    $triW = getTriwulan($bulan);
    if ($triW < 4) { // untuk penetapan skp itu ada di akhir tahun
        $jumlah['perilaku'] = ($jumlah['perilaku'] * 10) / 100;
    } else {
        $prilk = ($jumlah['perilaku'] * 10) / 100; // triwulan 4 
        $pr = get_data("SELECT sum(nilai_prilaku) as nperilaku FROM skp_penilaian where EXTRACT(YEAR from tanggal) = $year");
        if (count($pr) > 0) {
            $jumlah['perilaku'] = ($pr['nperilaku'] + $prilk) / 4;
        } else {
            $jumlah['perilaku'] = ($jumlah['perilaku'] * 60) / 100;
        }
    }
    $jumlah['capaian'] = number_format(($jumlah['nilaiSKP'] + $jumlah['perilaku']), 2);
    $jumlah['skpAbjad'] = abjadSkp($jumlah['nilaiSKP']);
    return $jumlah;
}

/**
 * indeks : uraians: list uraian dalam array indeks uraianTam_'(indeks mulai 0)'; &nbsp; nilai: nilai dari tugas tambahan
 * @param type $idSkp integer
 * @return array
 */
function hitungTgsTambahan($idSkp) {
    $tambahan = get_datas("SELECT uraian_tambahan FROM skp_r_tambahan where id_skp = " . $idSkp);    
    $tbhn = array();
    $tugas = array();
    foreach ($tambahan as $value) {
        array_push($tugas, $value['uraian_tambahan']);        
    }    
    $tbhn['uraians'] = $tugas;
    $jum = count($tugas);
    if ($jum >= 1 AND $jum <= 3) {
        $tbhn['nilai'] = 1;
    } else if ($jum >= 4 AND $jum <= 6) {
        $tbhn['nilai'] = 2;
    } else {
        $tbhn['nilai'] = 3;
    }
    return $tbhn;
}

function hitungNilaiKreatif($idSkp) {
    $nilai = get_data("SELECT SUM(nilai) as jum FROM skp_r_kreatifitas where idskp =$idSkp");
    return $nilai['jum'];
}

function hitungNPerilaku($idPns, $Year, $bulan) {
    $nilai = get_data("SELECT integritas,komitmen,disiplin,kerjasama,kepemimpinan,orientasi_pelayanan FROM skp_r_perilaku where id_pns =$idPns AND tahun = $Year and bulan = $bulan ");
    $n = array_sum($nilai) / 5;
    return number_format($n, 2);
}

function abjadSkp($value) {
    if ($value <= 50) {
        $abjad = 'Buruk';
    } elseif ($value > 50 && $value <= 60) {
        $abjad = 'Sedang';
    } elseif ($value > 60 && $value <= 75) {
        $abjad = 'Cukup';
    } elseif ($value > 75 && $value <= 90) {
        $abjad = 'Baik';
    } else {
        $abjad = 'Sangat Baik';
    }
    return $abjad;
}

function getTriwulan($bulan) {
    $bln = abs($bulan);
    if ($bln <= 3) {
        $caturwln = 1;
    } elseif ($bln > 3 && $bln <= 6) {
        $caturwln = 2;
    } else if ($bln > 6 && $bln <= 9) {
        $caturwln = 3;
    } else {
        $caturwln = 4;
    }
    return $caturwln;
}

?>