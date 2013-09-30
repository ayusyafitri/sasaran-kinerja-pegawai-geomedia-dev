<?php
@session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$jabPeg = get_data("SELECT kode_jabatan,parent,unit_organisasi,idjab FROM skp_jabatan where kode_jabatan = '" . SKP_KODEJAB . "'");
$jabStaf = get_datas("SELECT * FROM skp_jabatan where parent = '" . $jabPeg['idjab'] . "'");
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-print"></i>Konfirmasi Cetak TPP</h5>
</div>
<div class="page-header position-relative" id="page-content">
    Daftar Pemangku Jabatan yang dinilai : 
    <div class="pull-right"><a data-placement="bottom" title="" class="help" href="#" data-toggle="tooltip" data-original-title="Title"><i class="icon-question-sign icon-large pull-right" style="color: blue;cursor:default;" ></i></a>
        <br /><div id="msgAl"></div>
    </div>
</div>
<div class="row-fluid clearfix" >
    <div id="page-content">      
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:5%;">NO</th>
                        <th class="center" valign="middle" style="width:15%;">NIP</th>
                        <th class="center" valign="middle" style="width:24%;">Nama</th>
                        <th class="center" valign="middle" style="width:28%;">Jabatan</th>
                        <th class="center" valign="middle" style="width:10%;">Tanggal&nbsp;&nbsp;<i class="help icon-question-sign" data-original-title="Tanggal konfirmasi terakhir"></i></th>
                        <th class="center" valign="middle" style="width:23%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    $no = 1;
                    foreach ($jabStaf as $ygDinilai) {
                        $idPns = get_data("SELECT * FROM skp_pns where kode_jabatan = '" . $ygDinilai['kode_jabatan'] . "'");
                        $dtaPegawai = getDataPNS($idPns['id_pns']);
                        $tgl = get_data("SELECT tanggal FROM skp_penilaian where id_pns = '".$idPns['id_pns']."' and EXTRACT(YEAR FROM tanggal) = '".date('Y')."'");
                     //   echo "SELECT tanggal FROM skp_penilaian where id_pns = '".$idPns['id_pns']."' and EXTRACT(YEAR FROM tanggal) = '".date('Y')."'";
                    ?>
                    <tr>
                        <td class="center" style="vertical-align: middle;" ><?php echo $no; ?></td>
                        <td class="center" valign="middle" ><?php echo $dtaPegawai['nip'];?></td>
                        <td class="left" valign="middle" ><?php echo $dtaPegawai['nama'];?></td>                        
                        <td class="left" valign="middle" ><?php echo ucwords(strtolower($dtaPegawai['namajab']));?></td>
                        <td class="center" valign="middle" ><label id="tgl_<?php echo $dtaPegawai['id']; ?>"><?php echo stripIfEmpty(format_tglSimpan($tgl['tanggal'], '-', FALSE));?></label></td>
                        <td class="center" valign="middle" ><span id="ld_<?php echo $dtaPegawai['id'];?>"></span>&nbsp;&nbsp;<button class="btn btn-small btn-primary proses" name="pg_<?php echo $dtaPegawai['id']; ?>"><i class="icon-lock"></i>&nbsp;Confirm</button></td>
                    </tr>
                    <?php $no++;} ?>
                </tbody>
            </table>        
    </div>
</div>
<script type="text/javascript">
    $('.help').tooltip({
        delay: { show: 200, hide: 200 }
    });
    
    $('.proses').click(function(){
      var name = $(this).attr('name');
      var icn = $(this).children();
      var d = name.replace('pg_','');      
      var rls = 'jfu/konfirmasiCetak/konfirmasi__.php';
      var pst = $.post(rls, {'act':'cfm', 'di' : d});
      var ld = $('#ld_'+d);
      var ms = $('#msgAl');
      ld.addClass('icon-spin icon-spinner');
      pst.done(function(se){
          var news = se.split('___');
          if(news[0] == '2'){
              ms.html(news[1]);
              ld.removeClass('icon-spin icon-spinner');
              ld.prop('style','color:red');
              ld.addClass('icon-remove');
          }else if(news[0] == '3'){
              ms.html(news[1]);
              ld.removeClass('icon-spin icon-spinner');
              ld.prop('style','color:green');
              ld.addClass('icon-ok');
              $('#tgl_'+d).html(news[2]);
          }else{
              ms.html("<blink><font color='red'>Error in parameter !! No respon accepted..</font></blink>");
              ld.removeClass('icon-spin icon-spinner');
              ld.prop('style','color:red');
              ld.addClass('icon-remove');
          }
      });
      setTimeout(function(){                    
          ld.removeClass();
          ms.html('');          
      },2000);
    });
</script>