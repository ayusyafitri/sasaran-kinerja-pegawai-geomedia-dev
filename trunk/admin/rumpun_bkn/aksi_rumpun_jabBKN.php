<?php
include_once ('../../php/postgre.php');
$act = '';
if (isset($_POST['act']))
    $act = $_POST['act']; 
if($act == 'jabBKN_simpan'){
	$id = $_POST['id_jab_bkn'];
	$nama = $_POST['nama'];
	$kode = $_POST['kode'];
	$ikhtisar= $_POST['ikhtisar'];
	//$idur = $_POST['id'];
	$no = $_POST['no'];
	$urtugas = $_POST['uraian_tugas_bkn'];
	$rows = $_POST['rows'];
	$idur =$_POST['id'];
	
	if(!is_numeric ($id)){
		echo "Err:invalid id";
		exit;
	}
	
	if($id > 0){
		exec_query("update skp_bkn_jabatan set nama_jabatan='".$nama."', kode_jabatan='".$kode."', ikhtisar_jabatan='".$ikhtisar."' where idjab=".$id);
				
		 
			 
				$dataUraianBKN = get_datas("SELECT * FROM skp_bkn_uraian where kode_jabatan = '$kode'");
				$n = 0;
				foreach($idur as $iduraian){
					$search = array_search($iduraian, $dataUraianBKN);
					if($search >= 0){
						exec_query("update skp_bkn_uraian set no_uraian=".$no[$n].", uraian='".$urtugas[$n]."' where id_uraian=".$iduraian);
					}else{
						$cek = get_data("SELECT * FROM skp_bkn_uraian where id_uraian = '$iduraian'");
						if($cek['id_uraian'] > 0){
							exec_query("DELETE FROM skp_bkn_uraian where id_uraian = '$iduraian'");
						}else{
							$maxid1 = get_maxid('id_uraian','skp_bkn_uraian');
							exec_query("insert into skp_bkn_uraian (id_uraian, kode_jabatan,no_uraian, uraian) values (".$maxid1.",'".$kode."', ".$no[$n].",'".$urtugas[$n]."')");
							$stored1 = get_data("select id_uraian from skp_bkn_uraian where id_uraian=".$maxid1);
							if($stored1['id_uraian']==$maxid1){
								$idur = $maxid1;
							}
						}
					}
					$n++;
				}		
			 
	 
		echo 'success__';
	}else{
		$maxid = get_maxid('idjab','skp_bkn_jabatan');
		exec_query("insert into skp_bkn_jabatan (idjab, nama_jabatan, kode_jabatan, ikhtisar_jabatan) values (".$maxid.",'".$nama."','".$kode."','".$ikhtisar."')");
		$stored = get_data('select idjab from skp_bkn_jabatan where idjab='.$maxid);
		
		//uraian tugaaas
		for ($i=0; $i<count($rows); $i++){
			$maxid1 = get_maxid('id_uraian','skp_bkn_uraian');
			exec_query("insert into skp_bkn_uraian (id_uraian, kode_jabatan,no_uraian, uraian) values (".$maxid1.",'".$kode."', ".$no[$i].",'".$urtugas[$i]."')");
			$stored1 = get_data("select id_uraian from skp_bkn_uraian where id_uraian=".$maxid1);
			if($stored1['id_uraian']==$maxid1){
				$idur = $maxid1;
			}
		}
		if($stored['idjab'] == $maxid){
			echo 'success__';
			$id = $maxid;
		}
	}
	echo $id.'__'.$idur;
	view_jabatanBKN();
}else if($act=='hapus-bkn'){
	$id = $_POST['idjab'];
	$uraian = get_data("select kode_jabatan from skp_bkn_jabatan where idjab=".$id);
	if(is_numeric ($id)){
		exec_query("delete from skp_bkn_jabatan where idjab=".$id);
		exec_query("delete from skp_bkn_uraian where kode_jabatan='".$uraian['kode_jabatan']."'");
		echo 'success__';
		view_jabatanBKN();
	}else{
		echo 'Error';
	}
} else if($act =='edit-bkn'){
	$id = $_POST['id_jab_bkn'];
	
	if(is_numeric($id)){
		$datajab = get_data("select idjab, nama_jabatan, kode_jabatan, ikhtisar_jabatan from skp_bkn_jabatan where idjab=".$id);
		$ress = implode($datajab,'__');
		print_r($ress);
	
		$dataur = get_datas ("select * from skp_bkn_uraian where kode_jabatan='".$datajab['kode_jabatan']."'");
		echo "__";
	 	$counter = 0; 
		
		foreach ($dataur as $dataur){
			echo "<tr id='input_".$dataur['no_uraian']."'>
				<td width='60px' align='center'>
				 	<input type='hidden' name='id[]' value=".$dataur['id_uraian'].">
					<input type='text' style='width:40px;' name='no[]' value=".$dataur['no_uraian'].">
				</td>
				<td width='430px' align='left'>
					<textarea style='width:420px' rows='1' name='uraian_tugas_bkn[]'>".$dataur['uraian']."</textarea>
					
				</td>
				<td width='30px' align='center'>
					<span class='badge badge-important removeUraian' name='icon_".$dataur['no_uraian']."' style='cursor:pointer;' title='Hapus'>
					    <i class='icon-remove icon-green'></i></span>
					<input type='hidden' name='rows[]' value='".$dataur['no_uraian']."'>
                                        </a>
                                </td>
			</tr>";
		}
	}else{
		echo 'error';
	}
}else if($act =='hps_uraian'){
	$id = $_POST['idur'];
	
}


function view_jabatanBKN(){
	    $x = 1;
            $pr = get_datas("select * from skp_bkn_jabatan order by idjab");
            foreach ($pr as $pr) {
                ?><tr>
                    <td><?php echo $x ?></td>
                    <td><?php echo stripIfEmpty($pr['nama_jabatan']); ?></td>
                    <td><?php echo stripIfEmpty($pr['ikhtisar_jabatan']);?></td>
					<td class="center" >
                        <a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['idjab']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                        <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['idjab']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

                    </td>
                </tr>
                <?php
                $x++;
            }
}

?>