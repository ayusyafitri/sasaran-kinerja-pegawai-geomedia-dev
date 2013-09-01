<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>

<div id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="#">Home</a>

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
                                <img id="avatar" class="editable editable-click editable-empty" src="img/172.jpg"></img>
                            </span>
                        </div>
                        <div class="space-4"></div>
                        <div class="width-80 label label-user label-large center">
                            <div class="inline position-relative">
                                <a class="user-title-label dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-circle light-green middle"></i>
                                    <span class="white middle bigger-120 ">INDRIYANI, SP </span>
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
                                    <span id="username" class="editable editable-click" style="display: inline;">197507242007012012</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nama</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">INDRIYANI, SP</span>
                                </div>
                            </div> 
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Jabatan</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">Mantri Pertanian</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Atasan Langsung</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">Kepala Sub Bagian Perencanaan Program</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">Nama Atasan Langsung</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">DWI RAHMI ADIATY, SP</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Golongan</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">III.b</span>
                                </div>
                            </div>
                        </div>
                        <div space="12"></div>
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tempat Lahir</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">Samarinda</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tanggal Lahir</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">24/07/1975</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">Alamat</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">Karang Jepun Street No. 50 Samarinda City - Republic of Indonesia</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> No. Telp</div>
                                <div class="profile-info-value">
                                    <span id="username" class="editable editable-click" style="display: inline;">085746954629</span>
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
                                    <span id="username" class="editable editable-click" style="display: inline;">123</span>
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
        var post = $.post(urls,{act : 'LdUraian'});
        post.done(function(ser){
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
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>'+
            '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>'; 
        $('#username').editable({
            type: 'text',
            name: 'username'
        }); 
</script>
