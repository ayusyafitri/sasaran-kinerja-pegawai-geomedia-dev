<?php
@session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$idSkp = get_data("SELECT DISTINCT(id_skp) FROM skp_t_kerja where kode_jabatan = '" . SKP_KODEJAB . "' and tahun = '" . date('Y') . "'");
$dtaRealisasi = get_datas("SELECT t.id_skp,t.output, t.mutu, t.waktu, t.biaya, u.id_uraian, u.uraian, t.angka_kredit, r.id_realisasi, r.r_output,r.r_mutu,r.r_waktu,r.r_biaya FROM skp_t_kerja t 
INNER JOIN skp_uraian u  ON t.id_uraian = u.id_uraian and t.tahun = '" . date('Y') . "' and t.id_pns = '" . SKP_ID . "' and t.kode_jabatan = '" . SKP_KODEJAB . "'
LEFT OUTER JOIN skp_r_kerja r ON t.id_skp = r.id_skp");
echo "SELECT t.id_skp,t.output, t.mutu, t.waktu, t.biaya, u.id_uraian, u.uraian, t.angka_kredit, r.id_realisasi, r.r_output,r.r_mutu,r.r_waktu,r.r_biaya FROM skp_t_kerja t 
INNER JOIN skp_uraian u  ON t.id_uraian = u.id_uraian and t.tahun = '" . date('Y') . "' and t.id_pns = '" . SKP_ID . "' and t.kode_jabatan = '" . SKP_KODEJAB . "'
LEFT OUTER JOIN skp_r_kerja r ON t.id_skp = r.id_skp";
$dtTmbhan = get_datas("SELECT * FROM skp_r_tambahan where id_skp = '" . $idSkp['id_skp'] . "'");
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Realisasi Kerja Per Tahun</h5>
</div>
<div class="row-fluid clearfix" >
    <div class="page-header position-relative" id="page-content">
        <div class="span12">I. Tugas Pokok</div>
    </div>   
    <form id="foRealisasi">
        <input type="hidden" name="act" value="realss" />
        <input type="hidden" name="skp_d" value="<?php echo $dtaRealisasi[0][0]; ?>" />
        <div id="page-content">            
            <table class="table table-bordered geo-table table-hover" width="100%">
                <thead>
                    <tr>
                        <th class="center"  valign="middle"rowspan="2" width="3%">No</th>
                        <th class="center" rowspan="2" width="50%">Uraian</th> 
                        <th class="center" rowspan="2" width="7%">AK</th>
                        <th colspan="4" class="center"  width="40%">Realisasi</th>
                        <th rowspan="4" class="center" width="40%">Perhitungan</th>
                        <th rowspan="4" class="center" width="40%">Nilai Capaian</th>
                    </tr>
                    <tr>
                        <th class="center" width="10%">Output</th>
                        <th class="center"  width="10%">Mutu</th>
                        <th class="center" width="10%">Waktu</th>
                        <th class="center" width="10%">Biaya</th> 
                    </tr>
                </thead>
                <tbody >
                    <?php
                    if (count($dtaRealisasi) > 0) {
                        $no = 1;
                        foreach ($dtaRealisasi as $isiRealisasi) {
                            $t_output = $isiRealisasi['output'];
                            $t_mutu = $isiRealisasi['mutu'];
                            $t_waktu = $isiRealisasi['waktu'];
                            $t_biaya = $isiRealisasi['biaya'];

                            $r_output = $isiRealisasi['r_output'];
                            $r_mutu = $isiRealisasi['r_mutu'];
                            $r_waktu = $isiRealisasi['r_waktu'];
                            $r_biaya = $isiRealisasi['r_biaya'];

                            $nOutput = (empty($r_output) OR ($r_output < 0)) ? 0 : ($r_output / $t_output) * 100;
                            $nMutu = (empty($r_mutu) OR ($r_mutu < 0)) ? 0 : ($r_mutu / $t_mutu) * 100;
                            $nWaktu = (empty($r_biaya) OR ($r_waktu < 0)) ? 0 : ((1.76 * $t_waktu - $r_waktu) / $t_waktu) * 100;
                            $nBiaya = (empty($r_biaya) OR ($r_biaya < 0)) ? 0 : ((1.76 * $t_biaya - $r_biaya) / $t_biaya) * 100;

                            $prhtungan = $nOutput + $nMutu + $nWaktu + $nBiaya;
                            $nCapaianSKP = $prhtungan / 4;
                            ?>
                            <tr>
                                <td valign="middle" align="center" style="width:3%;"><?php echo $no; ?></td>
                                <td align="center"><?php echo ucfirst($isiRealisasi['uraian']); ?></td>
                                <td>
                                    <label><?php echo $isiRealisasi['angka_kredit']; ?></label>
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="output[]" id="output_<?php echo $no; ?>" value="<?php echo $r_output; ?>" />
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="mutu[]" id="mutu_<?php echo $no; ?>" value="<?php echo $r_mutu; ?>" />
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="waktu[]" id="waktu_<?php echo $no; ?>" value="<?php echo $r_waktu; ?>" />
                                </td>
                                <td>
                                    <input type="text" class="input-small" name="biaya[]" id="biaya_<?php echo $no; ?>" value="<?php echo $r_biaya; ?>" />
                                </td>
                                <td class="center">
                                    <?php echo $prhtungan; ?>
                                </td>
                                <td class="center">
                                    <?php echo $nCapaianSKP; ?>
                                </td>
                            </tr>
                            <?php
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>    
        </div>
    </form>
    <!--tugas tambahan-->
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> II. Tugas Tambahan</div>
        <button class="btn btn-small btn-primary no-radius" id="btn-tgsTmbhn"><i class="icon-plus-sign-alt"></i>Tugas Tambahan</button>
        &nbsp;<span id="loadT" class="spinner"></span>
    </div>
    <div id="page-content">
        <form id="foTambahan">
            <input type="hidden" name="act" value="tmbhn" />
            <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
                <thead >
                    <tr>
                        <th class="center" valign="middle" style="width:3%;">No</th>
                        <th class="center" style="width:50%">Uraian Tambahan</th> 
                        <th class="center" style="width:16%">nilai</th>
                        <th class="center" style="width:10%">aksi</th> 
                    </tr>
                </thead>
                <tbody id="isitgsTmbhn">
                    <?php
                    if (count($dtTmbhan) > 0) {
                        $n = 1;
                        foreach ($dtTmbhan as $isiTmbhn) {
                            ?>
                            <tr id='rtm_'>
                                <td valign='middle' align='center' style='width:3%;'><?php echo $n; ?></td>
                                <td><textarea style='width: 100%;' id='uraiantam_<?php echo $n; ?>' name='uraian_tam[]'><?php echo ucfirst($isiTmbhn['uraian']); ?></textarea></td>
                                <td class='center'><input type='text' value="<?php echo $isiTmbhn['nilai']; ?>" style='width:100%;' name='nilai_tam[]' id='nilaitam_<?php echo $n; ?>'/></td>
                                <td class='center'>
                                    <span class='badge badge-important edt-tgstmbhn' name="ed_<?php echo $n; ?>"style="cursor: pointer;" title='Ubah'><i class='icon-pencil'></i></span>
                                    <span class='badge badge-important remR-tgstmbhn' name='rm_<?php echo $n; ?>' style='cursor:pointer;' title='Hapus'><i class='icon-trash'></i></span>                                    
                                </td></tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <!--kreatifitas-->
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> III. Kreativitas</div>
    </div>
    <div id="page-content">
        <form id="foKreativitas">
            <input type="hidden" name="act" value="krea" />
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
                        <td><input class="input-large" type="text" name="kre_orientasi" /></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Integritas</td>
                        <td><input class="input-large" type="text" name="kre_integritas" /></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Komitmen</td>
                        <td><input class="input-large" type="text" name="kre_komitmen" /></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Disiplin</td>
                        <td><input class="input-large" type="text" name="kre_disiplin" /></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Kerjasama</td>
                        <td><input class="input-large" type="text" name="kre_kerjasama" /></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Kepemimpinan</td>
                        <td><input class="input-large" type="text" name="kre_kepemimpinan" /></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class=" position-relative pull-right" id="page-content">
        <span id="loadAl" class=""></span><span id="msgAl"></span>&nbsp;&nbsp;
        <button class="btn btn-small btn-primary no-radius" id="b-smpan"><i class="icon-save"></i>Simpan</button>       
    </div>           
</div>
</div>

<script type="text/javascript">
    var rls = "jfu/realisasi/realisasi_.php";
    $('#b-smpan').click(function() {
        var fReal = $('#foRealisasi');
        var fTmbhn = $('#foTambahan');
        var fKreat = $('#foKreativitas');
        var dtReal = fReal.serializeArray();
        var dtTmbhn = fTmbhn.serializeArray();
        var dtKreat = fKreat.serializeArray();
        var pFreal = $.post(rls, dtReal);
        var ld = $('#loadAl');
        $('#msgAl').html('Menyimpan data...&nbsp;&nbsp;');
        ld.addClass('icon-spin icon-spinner');
        pFreal.done(function(res) {
            var dt = res.split('___');
            if (dt[0] == '2') {
                $('#msgAl').html(dt[1] + '&nbsp;&nbsp;');
            } else if (dt[0] == '5') {
                $('#msgAl').html(dt[1] + '&nbsp;&nbsp;');
            } else {
                $('#msgAl').html("<font color='red'>Error in Paramater</font>");
            }
            setTimeout(function() {
                ld.removeClass('icon-spin icon-spinner');
                $('#msgAl').html('');
            }, 1000);
        });
    });
    $('#btn-tgsTmbhn').click(function() {
        var tbl = $('#isitgsTmbhn');
        var lent = tbl.children().length;
        lent = lent + 1;
        tbl.append("<tr id='rtm_" + lent + "'><td valign='middle' align='center' style='width:3%;'>" + lent + "</td><td><textarea style='width: 100%;' id='uraiantam_" + lent + "' name='uraian_tam[]'></textarea></td><td class='center'><input type='text' style='width:100%;' name='nilai_tam[]' id='nilaitam_" + lent + "'/></td><td class='center'><span class='badge badge-important remR-tgstmbhn' name='rm_" + lent + "' style='cursor:pointer;' title='Hapus'><i class='icon-trash'></i></span></td></tr>");
        removeR();
        //<span class='badge badge-user' title='Ubah'><i class='icon-pencil'></i></span>
    });

    function removeR() {
        $('.remR-tgstmbhn').click(function() {
            var nm = ($(this).attr('name'));
            var di = nm.replace('rm_', '');
            console.log(di);
            $('#rtm_' + di).remove();
        });
    }
</script>