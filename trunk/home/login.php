<?php
@session_start();
?>
<div class="widget-box">
    <div data-original-title="" class="widget-header">
        <h4 class="lighter smaller"><i class="icon-user"></i> AUTENTIKASI USER</h2>
        <a title="Refresh" class="btn btn-primary btn-small pull-right btRefresh"><i class="icon-refresh"></i></a>
    </div>
    <div class="widget-body" style="padding:20px">
        <div class="box center" style="width:250px; margin-bottom:80px; margin-top:70px">
            <div class="box-content">
                <div class="row-fluid" id="f0rm">
                    <span style="font-size:1.2em; font-weight:bold;">LOGIN SKP v1.0</span>
                    <hr style="margin:5px auto 15px auto;"/>
                    <div id="alerto"></div>
                    <input name="whoareyou" type="text" placeholder="NIPegawai">
                    <input name="yoursecret" type="password" placeholder="Password">

                    <input type="button" class="btn btn-danger btn-small bt-cancel" value="Cancel">
                    <input type="button" class="btn  btn-primary btn-small bt-login" value="Login">
                    <input type="hidden" value="hearme" name="what">
                </div>                   
            </div>
        </div><!--/span-->
    </div>
</div>
<?php
if (isset($_SESSION['$LEVEL'])) {
    ?>
    <script>
        var alerto = $("#alerto");
        alerto.removeClass().addClass('alert alert-success');
        alerto.html('<div class="spinner pull-left"></div> You have logged in, redirecting...');
        setTimeout(function() {
            location.href = 'system.php';
        }, 3000);
    </script>
    <?php
}
?>
<script>
    $('.bt-cancel').click(function(x) {
        var btns = $('#toprightmenu').children('.btn');
        btns.removeClass('active')
        console.log(btns)
        $(btns[0]).addClass('active');


        var url = 'inline/front_home.php';
        var get = $.get(url);
        get.done(function(data) {
            $('#content').html(data);
        });
    });

    $('.bt-login').click(function() {
        var f = $('#f0rm');
        var what = f.find('input[name="what"]').val();
        var levl = f.find('select[name="level"]').val();
        var user = f.find('input[name="whoareyou"]').val();
        var pass = f.find('input[name="yoursecret"]').val();

        var alerto = $("#alerto");
        alerto.removeClass().addClass('alert');
        alerto.html('<div class="spinner center"></div>&nbsp;');

        var url = 'login_exec.php';
        var posting = $.post(url, {what: what, whoareyou: user, yoursecret: pass, level: levl});
        posting.done(function(data) {
            if (data == 'success') {
                alerto.removeClass().addClass('alert alert-success');
                alerto.html('<div class="spinner pull-left"></div>Good, redirecting...');
                setTimeout(function() {
                    location.href = 'system.php';
                }, 2000);
            } else if (data == 'error') {
                alerto.removeClass().addClass('alert alert-error');
                alerto.html('Invalid user and/or password');
                alerto.attr('id')
            } else {
                alerto.removeClass().addClass('alert');
                alerto.html("System Error, contact Geomedia Corp.");
            }
        });
    });
</script>