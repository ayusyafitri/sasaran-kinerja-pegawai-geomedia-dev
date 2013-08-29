<?php
ob_start();
session_start();
include_once 'php/postgre.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SKP 1.0 ~ beta</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sistem Informasi Manajemen Kepegawaian">
        <meta name="author" content="haripinter">

        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="themes/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="themes/css/prettify.css"/>
        <link rel="stylesheet" href="css/skp.css"/>
        <link rel="stylesheet" href="themes/css/w8.min.css" />
        <link rel="stylesheet" href="themes/css/css.css" />
        <link rel="stylesheet" href="themes/css/w8-responsive.min.css" />
        <link rel="stylesheet" href="themes/css/w8-skins.min.css" />
    </head>
    <body>
        <!-- topbar starts -->
        <div class="navbar navbar-fixed-top" >
            <div class="navbar-inner home-pad-header">
                <div class="container-fluid">
                    <div class="top-nav">
                    </div><!--/ nav-collapse -->

                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>	
                        <span class="icon-bar"></span>
                    </a>

                    <div class="pull-left" style="margin-top:5px; font-size:11px">
                        Alamat : <span style="color:white">Jl. </span> 
				|  Telp & Fax :  <span style="color:white"></span> 
				|  Email :  <span style="color:white">email@blabla bla</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid home-width" style="margin-top:20px">
            <!--div class="row-fluid">
		</div-->

            <div class="row-fluid" style="margin-top:40px;">
                <div class="span6">
                    <div style="float:left; display: inline;"><img src="img/lambang.png" style="height:50px; margin-top:-8px"></img></div>
                    <div style="float:left; margin-left:5px; font-size:1.9em; margin-top:0px; font-weight:bold">PEMERINTAH KOTA SAMARINDA</div>
                    <div style="float:left; margin-left:5px; font-size:0.89em; margin-top:3px; color:blue;">Sistem Informasi Sasaran Kinerja Pegawai</div>
                </div>
                <div class="span6">
                    <div class="btn-group pull-right" style="margin-top:0px" id="toprightmenu">
                        <input type="button" class="btn btn-primary bt-home active" name="banner.php" value="Home">
                        <input type="button" class="btn btn-primary bt-home" name="profil.php" value="Profil">
                        <input type="button" class="btn btn-primary bt-home" name="info.php" value="Informasi">
                        <input type="button" class="btn btn-primary bt-home bt-login" name="login.php" value="Login">
                    </div>
                </div>
            </div>

            <noscript>
            <div class="alert alert-block span12">
                <h4 class="alert-heading">Warning!</h4>
                <p>You need to have JavaScript enabled to use this site.</p>
            </div>
            </noscript>

            <div id="content" class="row-fluid">
                <?php
                if (@$_GET['requestto'] == 'login') {
                    include_once('home/login.php');
                    echo '<script>$(".bt-home").removeClass("active"); $(".bt-login").addClass("active");</script>';
                } else {
                    include_once('home/banner.php');
                }
                ?>
            </div>
        </div>
        <div class="footer">
            <div class="center" style="max-width: 960px; margin:0px auto; font-size:11px; color:#777;">
                <hr class="horlines"/>
		Copyright 2013 &copy; Pemerintah Kota Samarinda
            </div>
        </div>
        <br/>
        <br/>
        <br/>

        <div class="footerbox" style="background-color:#fff;">
            <marquee>

            </marquee>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="themes/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="themes/js/jquery.ui.touch-punch.min.js"></script>

        <script src="themes/js/jquery.slimscroll.min.js"></script>
        <script src="themes/js/jquery.easy-pie-chart.min.js"></script>
        <script src="themes/js/jquery.sparkline.min.js"></script>

        <script src="themes/js/jquery.flot.min.js"></script>
        <script src="themes/js/jquery.flot.pie.min.js"></script>
        <script src="themes/js/jquery.flot.resize.min.js"></script>

        <!--w8 scripts-->

        <script src="themes/js/w8-elements.min.js"></script>
        <script src="themes/js/w8.min.js"></script>
        <script>
            $('.bt-home').click(function(x){
                var btn = $(this);
                btn.parent().children('.btn').removeClass('active');
                btn.addClass('active');
			
                var url = 'home/'+this.name;
                var get = $.get(url);
                get.done(function(data){
                    $('#content').html(data);
                });
            });
        </script>
    </body>
</html>