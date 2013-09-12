<?php
session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
$info = get_data("SELECT * from skp_pns where id_pns = " . SKP_ID);
$gol = get_data("SELECT nama_golongan from skp_golongan where id_gol = " . $info['id_golongan']);
//$atsan = get_data("SELECT from skp_pns p, ");
?>

<div id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/skp/admindata.php">Home</a>

            <span class="divider">
                <i class="icon-angle-right"></i>
            </span>
        </li>
        <li class="active">Profil</li>
    </ul>

</div>
<div id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon-user-md"></i>&nbsp;Profil</h1>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div>
                <div id="user-profile-1" class="user-profile row-fluid">
                    <div class="span3">
                        <div class="center">
                            <span class="profile-picture">
                                <img id="avatar" class="editable editable-click editable-empty" src="img/162.jpg"></img>
                            </span>
                        </div>
                        <div class="space-4"></div>
                        <div class="width-80 label label-user label-large center">
                            <div class="inline position-relative">
                                <a class="user-title-label dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-circle light-green middle"></i>
                                    <span class="white middle bigger-120 "><?php echo $info['nama']; ?> </span>
                                </a>

                            </div>
                        </div>
                        <div class="hr hr12 dotted"></div>
                        <a> <button class="btn btn-small btn-primary no-radius"><i class="icon-upload-alt"></i></button> </a><a>Mutasi</a>
                        <div class="hr hr12 dotted"></div>
                        <a><button class="btn btn-info btn-small no-radius"><i class="icon-upload-alt"></i></button> </a><a>Promosi</a>
                        <div class="hr hr12 dotted"></div>
                        <a><button class="btn btn-small btn-danger no-radius"><i class="icon-upload-alt"></i></button> </a><a>Pengajuan Keberatan Penilaian</a>
                    </div>
                    <div class="span9">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> NIP</div>
                                <div class="profile-info-value">
                                    <span id="username_pf" class="" style="display: inline;"><?php echo $info['nip']; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nama</div>
                                <div class="profile-info-value">
                                    <span id="nama_pf" class="editable editable-click" style="display: inline;"><?php echo $info['nama']; ?></span>
                                </div>
                            </div> 
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Jabatan</div>
                                <div class="profile-info-value">
                                    <span id="jabatan_pf" class="editable editable-click" style="display: inline;">Kepala Bidang</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Atasan Langsung</div>
                                <div class="profile-info-value">
                                    <span id="atasan_pf" class="editable editable-click" style="display: inline;">Kepala Sub Bagian Perencanaan Program</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">Nama Atasan Langsung</div>
                                <div class="profile-info-value">
                                    <span id="username" class="" style="display: inline;">DWI RAHMI ADIATY, SP</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Golongan</div>
                                <div class="profile-info-value">
                                    <span id="golongan_pf" class="editable editable-click" style="display: inline;"><?php echo $gol['nama_golongan']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div space="12"></div>
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tempat Lahir</div>
                                <div class="profile-info-value">
                                    <span id="tmptlahir_pf" class="editable editable-click" style="display: inline;"><?php echo $info['tempat_lahir']; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tanggal Lahir</div>
                                <div class="profile-info-value">
                                    <span id="tgllahir_pf" class="editable editable-click" style="display: inline;"><?php echo format_tglSimpan($info['tanggal_lahir'], '/', FALSE); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">Alamat</div>
                                <div class="profile-info-value">
                                    <span id="alamat" class="editable editable-click" style="display: inline;"><?php echo $info['alamat']; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> No. Telp</div>
                                <div class="profile-info-value">
                                    <span id="notelp_pf" class="editable editable-click" style="display: inline;"><?php echo $info['notelp']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div space="12"></div>
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">Username</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">Indri</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Password</div>
                                <div class="profile-info-value">
                                    <span id="password" class="editable editable-click" style="display: inline;">123</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var urls = 'jfu/targetkerja/targetKerja__.php';
    $('#loadUraian').click(function() {
        var ld = $('#load');
        ld.addClass('loading');
        var tbl = $('#rlTabel');
        var post = $.post(urls, {act: 'LdUraian'});
        post.done(function(ser) {
            tbl.html(ser);
        });
    });
    $('#tgsTambahan').click(function() {
        var ld = $('#load');
        ld.addClass('spinner');
    });

    jQuery(function($) {
        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';        
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>' +
                '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';
        var glongan = [];
        $('#username').editable({
            type: 'text',
            name: 'username',
            id:'usernameeee'
        });
<?php
$gol = get_datas("SELECT nama_golongan, id_gol FROM skp_golongan order by id_gol ASC");
$dt = '';
foreach ($gol as $vGol) {
    $dt .= "\"" . $vGol['id_gol'] . "\":\"" . $vGol['nama_golongan'] . "\",";
}
$dtq = substr($dt, 0, (strlen($dt) - 1));
?>
        $.each({<?php echo $dtq; ?>}, function(k, v) {
            glongan.push({id: k, text: v});
        });
        $('#alamat').editable({
            mode: 'inline',
            type: 'wysiwyg',
            name: 'alamat',
            wysiwyg: {
//css : {'max-width':'300px'}
            },
            success: function(response, newValue) {
            }
        });

        $('#golongan_pf').editable({
            type: 'select',
            value: '<?php echo $info['id_golongan']; ?>',
            source: glongan
        });

        $('#nama_pf').editable({
            type: 'text',
            name: 'nama'
        });

        $('#notelp_pf').editable({
            type: 'text',
            name: 'notelp'
        });

        $('#tgllahir_pf').editable({
            name: 'tglLahir',
            type: 'date',
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datepicker: {
                weekStart: 1
            }
        });

        $('#tmptlahir_pf').editable({
            type: 'text',
            name: 'tmptLahir'
        });
    });
</script>
