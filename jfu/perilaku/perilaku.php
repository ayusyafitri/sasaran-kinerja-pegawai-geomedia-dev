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
    <h5><i class="icon-calendar"></i>Perilaku</h5>
</div>
<div class="row-fluid clearfix" >    
    <div class="page-header position-relative" id="page-content">        
        <div class="span12"> Perilaku Kerja<div class="pull-right">
                <a class="help" data-original-title="Title" data-toggle="tooltip" href="#" title="" data-placement="bottom">
                    <i class="icon-question-sign icon-large" style="color: blue;cursor:default;"></i>
                </a>
            </div></div>        
    </div>
    <div id="page-content">
        <select class="input-medium" id="tahun">
            <option value="0">--Pilih Tahun--</option>
            <?php
            $y = date('Y');
            while ($y >= 2012) {
                $sel = ($y == date('Y')) ? 'selected' : '';
                echo "<option value='$y' $sel>$y</option>";
                $y--;
            }
            ?>
        </select>
        <select id="pilihPeg">
            <option value="0">-Pilih Pegawai-</option>
            <?php
            foreach ($jabStaf as $staf) {
                $dtPeg = get_data("SELECT * FROM skp_pns where kode_jabatan = '" . $staf['kode_jabatan'] . "'");
                echo "<option value='" . $dtPeg['id_pns'] . "'>" . $dtPeg['nama'] . "</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary btn-small" style='margin-top: -10px;'id="findPeg"><i class="icon-search"></i>&nbsp;Cari</button>&nbsp;&nbsp;<span id='loadSc' class=''></span>
        <div id='msgTbl' class='pull-right' ></div>
        <form id="foKreativitas">
            <input type="hidden" name="act" value="actPrilaku" />
            <input type="hidden" name="skpId" id="skpId" value="" />            
            <input type="hidden" name="prlkuId" id="prlkuId" value="" />            
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:3%;">No</th>
                        <th class="center" style="width:50%">Kreativitas</th> 
                        <th class="center" style="width:37%">nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Orientasi Pelayanan</td>
                        <td><input class="input-large" type="text" id="kre_orientasi" name="kre_orientasi" value="<?php echo $dtPerilaku['orientasi_pelayanan']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Integritas</td>
                        <td><input class="input-large" type="text" id="kre_integritas" name="kre_integritas" value="<?php echo $dtPerilaku['integritas']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Komitmen</td>
                        <td><input class="input-large" type="text" id="kre_komitmen" name="kre_komitmen" value="<?php echo $dtPerilaku['komitmen']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Disiplin</td>
                        <td><input class="input-large" type="text" id="kre_disiplin" name="kre_disiplin" value="<?php echo $dtPerilaku['disiplin']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Kerjasama</td>
                        <td><input class="input-large" type="text" id="kre_kerjasama" name="kre_kerjasama" value="<?php echo $dtPerilaku['kerjasama']; ?>"/></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Kepemimpinan</td>
                        <td><input class="input-large" type="text" id="kre_kepemimpinan" name="kre_kepemimpinan" value="<?php echo $dtPerilaku['kepemimpinan']; ?>" /></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class=" position-relative pull-right" id="page-content">
        <span id="loadAl" class=""></span>&nbsp;&nbsp;&nbsp;<span id='msgAl'></span>&nbsp;&nbsp;
        <button class="btn btn-small btn-primary no-radius" id="b_smpan" ><i class="icon-save"></i>Simpan</button>       
    </div>           
</div>


<script type="text/javascript">
    var rls = "jfu/perilaku/perilaku_.php";
    $('.help').tooltip();
    $('#b_smpan').click(function() {
        var pg = $('#pilihPeg').val();
        var thn = $('#tahun').val();
        if (pg !== '0' && thn !== '0' && !$(this).hasClass('disabled')) {
            var peg = {'name': 'pnsId', 'value': pg};
            var frm = $('#foKreativitas');
            var dt = frm.serializeArray();
            var ms = $('#msgAl');
            dt.push(peg);
            var ld = $('#loadAl');
            ld.addClass('icon-spin icon-spinner');           
            var pst = $.post(rls, dt);             
            pst.done(function(crawl) {
                ms.removeClass('alert');            
                var splt = crawl.split('___');                
                if (splt[0] === '4' || splt[0] === '2') {                    
                    ms.html(splt[1]);
                    console.log(splt[1]);
                    if (splt[0] === '4'){
                        $('#prlkuId').val(splt[2]);
                    }
                } else {                    
                    ms.html("<font color='red'>Error in parameter !!!</font>");
                }
                setTimeout(function() {
                    ld.removeClass('icon-spin icon-spinner');
                    ms.html('');
                }, 1500);
            });
        }else{
            $('#msgAl').html('<font color="red">Pilih tahun dan pegawai terlebih dahulu !!</font>');
            setTimeout(function(){$('#msgAl').html('');},1700);            
        }
    });

    $('#findPeg').click(function() {
        var p = $('#pilihPeg').val();
        var y = $('#tahun').val();
        var ld = $('#loadSc');        
        if (p === '0' || y === '0') {
            ld.html("<font color='red'>Pilih Tahun dan Pegawai terlebih dahulu !!</font>");
        } else {
            ld.addClass('icon-spin icon-spinner');
            var pst = $.post(rls, {act: 'ldUraian', th: y, pg: p});
            pst.done(function(sre) {
                var dt = sre.split('___');
                if (dt[0] === '5') {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html("<i class='icon-ok'></i>");
                    var dt = dt[1].split('_');
                    $('#prlkuId').val(dt[0]);
                    $('#kre_integritas').val(dt[1]);
                    $('#kre_komitmen').val(dt[2]);
                    $('#kre_disiplin').val(dt[3]);
                    $('#kre_kerjasama').val(dt[4]);
                    $('#kre_kepemimpinan').val(dt[5]);
                    $('#kre_orientasi').val(dt[6]);                    
                    $('#b_smpan').removeClass('disabled');
                } else if (dt[0] === '2') {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html(dt[1]);
                    setTimeout(function(){$('#foKreativitas').find('input[type=text]').val('')},2000);
                } else {
                    ld.removeClass('icon-spin icon-spinner');
                    ld.html(dt[1]);
                }
            });
        }
        setTimeout(function() {
            ld.removeClass('icon-spin icon-spinner');
            ld.html('');
        }, 2000);
    });
</script>