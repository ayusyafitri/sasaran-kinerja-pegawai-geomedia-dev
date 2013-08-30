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
        <li class="active">Overview</li>
    </ul>

</div>
<div id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon-user-md"></i>&nbsp;Overview</h1>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span6 widget-container-span ui-sortable">
                    <div class="widget-box">
                        <div class="widget-header"><h5>Default Widget Box</h5></div>
                        <div class="widget-body">bagan</div>
                    </div>
                </div>
                <div class="span6 widget-container-span ui-sortable"></div>
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
