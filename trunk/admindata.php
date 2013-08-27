<?php
ob_start();
session_start();
include_once 'php/include_all.php';

//if (!isset($_SESSION['_username'])){
//    header("Location:index.php");
//}

print_r($_SESSION);
?>
<!DOCTIYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Admin Data</title>
        <meta name="descritption" content="This is page header(.page-header &gt; h1)"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="themes/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="themes/css/prettify.css"/>
        <link rel="stylesheet" href="css/skp.css"/>
        <link rel="stylesheet" href="themes/css/w8.min.css" />
        <link     
    </head>
    <body style=" font-family:'Open Sans' ;" >
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="#" class="brand">
                        <small>
                            <i class="icon-unlock-alt"></i>
                            Sasaran Kinerja Pegawai Versi 1.0
                        </small>
                    </a>
                    <ul class="nav pull-right">
                        <li >
                            <a data-togle="dropdown" href="#" class="user-menu dropdown-toggle">
                                <img class="nav-user-photo" src="" alt="" />
                                <span id="user_info">
                                    <small>Selamat datang</small> admin
                                </span>
                                <i class="icon-caret-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--content-->
        <div class="container-fluid" id="main-container">
            <div id="sidebar" >
                <?php include 'php/menu.php' ?>
            </div>

            <div id="main-content"  >
                Hello Admin!!
            </div>
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
            $('a.geo-link').click(function(e){
                if(e.preventDefault()) e.preventDefault = false;
	
                var link = $(this);
                link.parent().parent().children().removeClass('active');
                link.parent().addClass('active');
	
                var urls = link.attr('href');
                var post = $.post(urls,{open:'please'});
                post.done(function(response){
                    $('#main-content').html(response);
                });
            });
        </script>
    </body>
</html>