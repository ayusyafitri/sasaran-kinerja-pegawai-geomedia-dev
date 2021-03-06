<?php
ob_start();
session_start();
include_once 'php/include_all.php';

if (!isset($_SESSION['_username'])) {
    header("Location:./");
}
if ($_SESSION['_menu'] == 3) {
    $dtPeg = getDataPNS(SKP_ID);
    $imgSrc = (empty($dtPeg['imgProfil'])) ? 'themes/img/no-profile.gif' : 'imgPns/' . $dtPeg['imgProfil'];
} else {
    $imgSrc = 'themes/img/no-profile.gif';
}
?>
<!DOCTIYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Admin Data</title>
        <meta name="descritption" content="This is page header(.page-header &gt; h1)"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="themes/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="themes/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="themes/css/prettify.css"/>
        <link rel="stylesheet" href="themes/css/skp.css"/>
        <link rel="stylesheet" href="themes/css/w8.min.css" />
        <link rel="stylesheet" href="themes/css/css.css" />
        <link rel="stylesheet" href="themes/css/datepicker.css" />
        <link rel="stylesheet" href="themes/css/w8-responsive.min.css" />
        <link rel="stylesheet" href="themes/css/w8-skins.min.css" />                

        <script src="themes/js/jquery.min.js"></script>        
        <script src="themes/js/jquery-ui-1.10.3.custom.min.js"></script>                

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
                    <ul class="nav ace-nav pull-right">
                        <li class="light-blue user-profile">
                            <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                                <img class="nav-user-photo" id="icon-corner" src="<?php echo $imgSrc; ?>" alt="<?php echo $dtPeg['nama']; ?>" />
                                <span id="user_info">
                                    <small>Welcome,</small><?php echo SKP_NAMA; ?>
                                </span>
                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
                                <li><a href="#"> <i class="icon-user"></i>Profil</a></li>
                                <li><a href="#"><i class="icon-cog"></i>Edit Profil</a></li>

                                <li><a href="#" id="idTextLogout"> <i class="icon-off"></i>Logout</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>        
        <!--content-->
        <div class="container-fluid" id="main-container">
            <div id="sidebar" >
                <?php
                if ($_SESSION['_menu'] == '3') {
                    include 'php/menu.php';
                } else if ($_SESSION['_menu'] == '2') {
                    include 'php/menuskpd.php';
                } else if ($_SESSION['_menu'] == '1') {
                    include 'php/menuadmin.php';
                } else if (!isset($_SESSION['_menu'])) {
                    
                } else {
                    ?>
                    <script type="text/javascript">
                        location.href = './';
                    </script>
                    <?php
                    session_destroy();
                }
                ?>
            </div>

            <div id="main-content">    
                <?php if ($_SESSION['_menu'] == 3) { ?>
                    <script type='text/javascript'>
                        var pst = $.post('jfu/overview/overview.php', {open: 'please'});
                        pst.done(function(e) {
                            $('#main-content').html(e);
                        });
                <?php } ?>
                </script>
            </div>

        </div>        
        <script src="themes/js/jquery.ui.touch-punch.min.js"></script>        
        <script src="themes/js/jquery.slimscroll.min.js"></script>
        <script src="themes/js/jquery.easy-pie-chart.min.js"></script>
        <script src="themes/js/jquery.sparkline.min.js"></script>
        <script src="themes/js/bootstrap-editable.min.js"></script>
        <script src="themes/js/w8-editable.min.js"></script>
        <script src="themes/js/jquery.flot.min.js"></script>
        <script src="themes/js/jquery.flot.pie.min.js"></script>
        <script src="themes/js/jquery.flot.resize.min.js"></script>
        <script src="themes/js/jquery.tools.min.js"></script>
        <script src="themes/js/bootstrap.min.js"></script>        
        <script src="themes/js/bootstrap-datepicker.js"></script>          
        <script type="text/javascript" charset="utf-8" language="javascript" src="themes/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" language="javascript" src="themes/js/DT_bootstrap.js"></script>
        <script src="themes/js/bootbox.min.js"></script>
        <!--w8 scripts-->

        <script src="themes/js/w8-elements.min.js"></script>
        <script src="themes/js/w8.min.js"></script>
        <script>
            $('a#idTextLogout').click(function() {
                var to = 'php/1nd3x.php';
                var p = $.post(to, {what: 'outt'});
                p.done(function(res_) {
                    if (res_ == 'ko') {
                        window.location.href = './';
                    }
                });
            });

            $('a.geo-link').click(function(e) {
                if (e.preventDefault())
                    e.preventDefault = false;

                var link = $(this);
                link.parent().parent().children().removeClass('active');
                link.parent().addClass('active');

                var urls = link.attr('lnk') + '' + link.attr('name');
                var post = $.post(urls, {open: 'please'});
                post.done(function(response) {
                    $('#main-content').html(response);
                });
            });
        </script>
    </body>
</html>
<!---->
