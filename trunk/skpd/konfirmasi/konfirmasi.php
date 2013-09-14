<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Konfirmasi User</h5>
</div>
<div class="box-content">
    <form class="navbar-search pull-right">
  		<input type="text" class="search-query" name="cari" id="cari" onkeyup="search(this.value)" placeholder="Cari">
        <div id='loader' style='margin-top:2px'></div>
	</form>
</div>
&nbsp;
<div class="box-content">
	<form class="form-horizontal" id="konfirmasi">
    <table class="table table-bordered geo-table table-hover" width="100%">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="12%">NIP</th> 
                <th class="center" width="33%">Nama</th>
                <th class="center" width="20%">aksi</th>
            </tr>
        </thead>
        <tbody id="tampil_user">
            <?php
            $x = 1;
			$counter = 0;
            $user = get_datas("select * from skp_username order by id_user");
            foreach ($user as $user) {
                ?><tr>
                    <input type="hidden" name="id_pns[]">
                    <input type='hidden' name='rows[]' value='<?php echo $counter++ ; ?>'>
                    <td><?php echo $x ?></td>
                    <td>&nbsp;<?php echo $user['nip'] ?></td>
                    <td><?php echo $user['nama'] ?></td>
                    <input type="hidden" name="iduser[]" value="<?php echo $user ['id_user'];?>">
                    <input type="hidden" name="nama[]" value="<?php echo $user ['nama'];?>">
                    <input type="hidden" name="nip[]" value="<?php echo $user['nip'];?>">
                    <input type="hidden" name="user[]" value="<?php echo $user['username'];?>">
                    <input type="hidden" name="pass[]" value="<?php echo $user['password'];?>">
                    <td class="center" >
                        <select name="con[]" id="con" class="con">
                        	<option id="0">-Pilih Status-</option>
                            <option value="1">Konfirmasi</option>
                            <option value="2">Tolak</option>
                        </select>
                    </td>
                </tr>
                <?php
                $x++;
            }
            ?>
        </tbody>
    </table>  
    <div class="pull-right">
            <span id='loader' style='width:30px;height:30px;'></span><button type="button" class="btn btn-primary btn-simpan-konfirmasi"><i class="icon-white icon-check"></i>&nbsp;Simpan</button>
   </div>  
   </form>
</div>
<script type="text/javascript">
	var urls = 'skpd/konfirmasi/tools.php';
        $('.btn-simpan-konfirmasi').click(function() {
            var btn = $(this);
            var load = $('#loader');
            var rslt = $('#result');
            //var wind = $('#windowRincPro');

            load.addClass('spinner pull-left');
			load.removeClass();
            var form = $('#konfirmasi');
            var data = form.serializeArray();
            var post = $.post(urls, data);            
            post.done(function(res) {
                // 0-> no data; 1-> ok; 2-> error
                var result = res.split('__');
                if (result.length == 2) {
                    if (result[0] == 'success') {
                        rslt.html('<font color="green">Tersimpan...</font>');
                        setTimeout(function() {
                            rslt.html('');
                            //wind.modal('hide');
                        }, 2000);
						var tbody = $('#tampil_user');   
						tbody.html(result[1]);
						                   
                    
                    } else {
                        rslt.html('<font color="#000">Tidak ada data</font>');
                        load.removeClass();
                        setTimeout(function(){
                            rslt.html('');
                        },2000);
                    }
                } else {
                    rslt.html('<font color="red">' + res + '</font>');
                }
            });
        });
		function search(){
			var si = $('#cari').val();
			source = "skpd/konfirmasi/cari.php?si=" + si;
			var cobapro = $.get(source);
			cobapro.done(function(data){
				$('#tampil_user').html(data);
			});
		}
		/*
		$('.search-query').change(function(){
			var si = $('#cari').val();
			source = "cari.php?si=" + si;
			var cobapro = $.get(source);
			cobapro.done(function(data){
				$('#tampil_user').html(data);
			});
		});
*/
</script>
