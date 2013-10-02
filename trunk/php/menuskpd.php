<?php if ($_SESSION['_id'] == 2) { ?>
    <!--Menu untuk admin bkd   -->
    <ul class="nav nav-list">
        <!--              <li class="nav-header">Master</li>-->        
        <li><a class="geo-link" href="" lnk="admin/overview/" name="overview.php"><i class="icon-dashboard"></i><span>Overview</span></a></li>
    <li><a class="geo-link" href="" lnk="admin/skpd/" name="skpd.php" ><i class="icon-dashboard"></i><span>Daftar SKPD</span></a></li>
    <li><a class="geo-link" href="" lnk="admin/jabatan/" name="jabatan.php" ><i class="icon-dashboard"></i><span>Daftar Jabatan</span></a></li>
    <li><a class="geo-link" href="" lnk="admin/pemangku/" name="pemangku.php" ><i class="icon-dashboard"></i><span>Daftar Pemangku</span></a></li>   
	<li><a class="geo-link" href="" lnk="admin/rumpun_bkn/" name="rumpun_jabatan_bkn.php"><i class="icon-user-md"></i><span>Rumpun Jabatan BKN</span></a></li>
	<li><a class="geo-link" href="" lnk="admin/jabatan_bkn/" name="jabatan_bkn.php"><i class="icon-user-md"></i><span>Jabatan BKN</span></a></li>
        <li class="open">
            <a class="dropdown-toggle" href="#">
                <span>Setting</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu" style="display: none;">
                <li><a class="geo-link" href="" lnk="admin/home/" name="home.php">Halaman Utama</a></li>
                <li><a class="geo-link" href="" lnk="admin/profil/" name="profil.php">Profil</a></li>
                <li><a class="geo-link" href="" lnk="admin/info/" name="info.php">Informasi</a></li>
            </ul>
        </li>
    </ul>
<?php } else { ?>
    <!--Menu untuk admin SKPD   -->
    <ul class="nav nav-list">
        <!--              <li class="nav-header">Master</li>-->
        <li><a class="geo-link" href="" lnk="admin/overview/" name="overview.php"><i class="icon-dashboard"></i><span>Overview</span></a></li>
        <li><a class="geo-link" href="" lnk="skpd/jabatan/" name="jabatan.php" ><i class="icon-dashboard"></i><span>Daftar Jabatan</span></a></li>
        <li><a class="geo-link" href="" lnk="skpd/pemangku/" name="pemangku.php" ><i class="icon-dashboard"></i><span>Daftar Pemangku</span></a></li>
     	<li><a class="geo-link" href="" lnk="skpd/target/" name="daftar_target.php"><i class="icon-user-md"></i><span>Laporan</span></a></li>
        <li><a class="geo-link" href="" lnk="skpd/konfirmasi/" name="konfirmasi.php"><i class="icon-user-md"></i><span>Konfirmasi</span></a></li>
        <li class="open">
            <a class="dropdown-toggle" href="#">
                <span>Setting</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu" style="display: none;">
                <li><a class="geo-link" href="" lnk="admin/home/" name="home.php">Halaman Utama</a></li>
                <li><a class="geo-link" href="" lnk="admin/profil/" name="profil.php">Profil</a></li>
                <li><a class="geo-link" href="" lnk="admin/info/" name="info.php">Informasi</a></li>
            </ul>
        </li>
    </ul><?php
}?>