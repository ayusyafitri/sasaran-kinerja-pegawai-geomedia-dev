<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
	
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Daftar SKPD</h5>
</div>
<div class="position-relative" id="page-content">
    <a href="#modalwin" data-toggle="modal" class="btn btn-small btn-primary no-radius btn-tambah"><i class="icon-plus"></i>&nbsp;Tambah Data</a>
    &nbsp;<span id="load" class="spinner"></span>
</div>
<div id="modalwin" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <header class="modal-header"> 
        <a href="#" class="close geo-clear" data-dismiss="modal">x</a>
        <h3>Data SKPD</h3>
    </header>

    <div class="modal-body">
        <form id="formSKPD">
            <input type="hidden" name="act" value="skpd_simpan">
            <input type="hidden" id="id" name="id" value="0"> 
            <table class="table-form">
                <tbody>
                    <tr>
                        <td>Kode SKPD</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="kode" id="kode"  />
                        </td>
                    </tr>

                    <tr>
                        <td>Nama SKPD Skpd</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama" id="nama"  />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a class="btn btn-primary btn-small btn-simpan-skpd "><div id="loader"></div>&nbsp;Simpan</a><span id="result"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="box-content">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered geo-table" id="example">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="12%">Kode SKPD</th> 
                <th class="center" width="33%">Nama SKPD</th>
				<th class="center" width="10%">Username</th>
				<th class="center" width="10%">Password</th>
                <th class="center" width="20%">aksi</th>
			</tr>
        </thead>
        <tbody id="tampilSKPD">
            <?php
            $x = 1;
            $pr = get_datas("select * from skp_skpd where nama not like '%admin%' order by id");
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
            ?>
        </tbody>
    </table>    
</div>
<script src="js/jquery.dataTables.js"></script>
<script src="js/DT_bootstrap.js"></script>	

<script>
    var url = 'admin/skpd/skpd_save.php';
    var rslt = $('#result'); 
    
    $('.btn-simpan-skpd').click(function(){      
        var btn = $(this);
        var load = $('#loader');
        load.addClass('icon-spinner icon-spin icon-2x white');
       
        var form = $('#formSKPD');
        var data = form.serializeArray();
        var post = $.post(url,data);
        post.done(function(res){
            var result = res.split('__');
            if(result.length==3){
                if(result[0]=='success'){
                    rslt.html('<font color="green">data tersimpan </font>');
                    setTimeout(function(){
                        rslt.html('');
                    }, 1500);
                
                    var tbody = $('#tampilSKPD');
                    tbody.html(result[2]);
                    init();
                    $("#id").val("0");
                    $("#kode").val("");
                    $("#nama").val("");
                    $('#modalwin').modal('hide');
                }else{
                    rslt.html('<font color="red">'+res+'</font>');
                }
            }else{
                rslt.html('<font color="red">'+res+'</font>');
            }
            load.removeClass();
            btn.removeClass('btn-info').addClass('btn-primary');
           
        });
    
    });
    
    function init(){
        $('.bt-edit').click(function(){
            var id = this.name;
            var form = $('#formSKPD');
            var post = $.post(url,{act:'ubah_skpd',id:id});            
            post.done(function(res){
                var value = res.split('__');
                $('#id').val(value[0]);
                form.find('input[name="kode"]').val(value[1]);
                form.find('input[name="nama"]').val(value[2]);
            });
        });
        
        $('.bt-hapus').click(function(){
            var btn = $(this);
            var pid = this.name;
            var load = $(this);
            load.html('<div class="icon-spinner icon-spin icon-2x white"></div>');
            bootbox.confirm("sumpe lu mau ngehapus item ini?", function(hsl){
                if(hsl==true){
                    if(pid!=0){
                        var post = $.post(url,{act:"hapus_skpd",id:pid});
                        post.done(function(res){
                            var hasil = res.split('__');
                            //alert(hasil.length);
                            if(hasil.length == 2){
                                if(hasil[0] == 'success'){
                                    rslt.html('<font color="green">Data Telah Dihapus...</font>');
                                    setTimeout(function(){
                                        rslt.html('');
                                    }, 1500);
                                    var tbody = $('#tampilSKPD');
                                    tbody.html(hasil[1]);
                                    init();
                                    //btn.parent().parent().remove();
                                }
                            }
                        });
                        load.html('<i class="icon-trash icon-white"></i>&nbsp; Hapus');
                    }
                }else{
                    load.html('<i class="icon-trash icon-white"></i>&nbsp; Hapus');
                }
            });
        });
        
    }
    init();
    
    $('.btn-tambah').click(function(){
        $('#id').val("0");
        $('#kode').val("");
        $('#nama').val("");
    })
</script>