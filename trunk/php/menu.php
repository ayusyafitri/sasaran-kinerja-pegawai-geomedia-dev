
<ul class="nav nav-list">
    <li><a class="geo-link" href="" lnk="jfu/overview/" name="overview.php"><i class="icon-dashboard"></i><span>Overview</span></a></li>
    <li><a class="geo-link" href="" lnk="jfu/targetkerja/" name="targetkerja.php" ><i class="icon-dashboard"></i><span>Target Kerja</span></a></li>
    <li><a class="geo-link" href="" lnk="jfu/realisasi/" name="realisasi.php" ><i class="icon-dashboard"></i><span>Realisasi</span></a></li>    
    <li><a class="geo-link" href="" lnk="jfu/laporan/" name="laporan.php" ><i class="icon-dashboard"></i><span>Laporan</span></a></li>
    <li><a class="geo-link" href="" lnk="jfu/profil/" name="profil_jfu.php"><i class="icon-user-md"></i><span>Profil</span></a></li>
    <?php if (SKP_JNSJAB == 'Jabatan Struktural') { ?>
        <li><a class="geo-link" href="" lnk="jfu/perilaku/" name="perilaku.php" title="Penilaian Perilaku"><i class="icon-dashboard"></i><span>Penilaian Perilaku</span></a></li>
        <li><a class="geo-link" href="" lnk="jfu/penetapan_target_kerja/" name="penetapan.php"><i class="icon-user-md"></i><span>Penetapan Target</span></a></li>
        <li><a class="geo-link" href="" lnk="jfu/penilaian/" name="penilaian.php"><i class="icon-tasks"></i><span>Penetapan Realisasi</span></a></li>
        <li><a class="geo-link" href="" lnk="jfu/konfirmasiCetak/" name="konfirmasi.php"><i class="icon-key"></i><span style="font-size: 12px;">Konfirmasi Cetak SKP</span></a></li>
    <?php } ?>
</ul>