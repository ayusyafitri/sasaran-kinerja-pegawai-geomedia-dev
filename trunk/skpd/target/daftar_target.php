<?php
session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Laporan Kinerja Pemangku <?php echo SKP_NAMA ?></h5>
</div>
<div class="box-content">
	<table class="table table-bordered geo-table table-hover" width="100%">
    	<thead align="center">
        <tr>
        	<th width="20%">Kode Jabatan</th>
        	<th width="20%">Nama Jabatan</th>
        	<th width="10%">NIP</th>
            <th width="20%">Nama Pemangku</th>
            <th width="5%">L-a</th>
            <th width="5%">L-b</th>
            <th width="5%">L-c</th>
            <th width="5%">L-d</th>
            <th width="5%">L-e</th>
            <th width="5%">L-f</th>
        </tr>
        </thead>
        <?php
        $tampil = get_datas("select distinct (j.kode_jabatan), j.nama_jabatan, p.id_pns, p.nip, p.nama from skp_pns p , skp_jabatan j where p.kode_jabatan=j.kode_jabatan and j.unit_kerja=".SKP_ID." order by j.kode_jabatan");
		foreach($tampil as $tampil){
		?>
        <tbody id="daftar_target">
        	<tr>
            	<td><?php echo $tampil['kode_jabatan'];?></td>
                <td><?php echo $tampil['nama_jabatan'];?></td>
                <td><?php echo $tampil['nip'];?></td>
                <td><?php echo $tampil['nama'];?></td>
                <td><a href="jfu/laporan/la.php?id=<?php echo $tampil['id_pns'];?>" target="_blank" ><i class="icon-file"></i></a></td>
                <td><a href="jfu/laporan/lb.php?id=<?php echo $tampil['id_pns'];?>" target="_blank" ><i class="icon-file"></i></a></td>
                <td><a href="jfu/laporan/lc.php?id=<?php echo $tampil['id_pns'];?>" target="_blank" ><i class="icon-file"></i></a></td>
                <td><a href="jfu/laporan/ld.php?id=<?php echo $tampil['id_pns'];?>" target="_blank" ><i class="icon-file"></i></a></td>
                <td><a href="jfu/laporan/le.php?id=<?php echo $tampil['id_pns'];?>" target="_blank" ><i class="icon-file"></i></a></td>
                <td><a href="jfu/laporan/lf.php?id=<?php echo $tampil['id_pns'];?>" target="_blank" ><i class="icon-file"></i></a></td>
            </tr>
        </tbody>
        <?php
		}
		?>
    </table>
</div>
