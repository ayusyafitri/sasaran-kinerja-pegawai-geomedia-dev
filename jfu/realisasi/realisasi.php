<?php
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Capaian Kerja Per Tahun</h5>
</div>
<div class="row-fluid clearfix" >
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> I. Tugas Pokok</div>
    </div>
    <div id="page-content">
        <table class="table table-bordered geo-table table-hover" width="100%">
            <thead>
                <tr>
                    <td align="center" valign="middle"rowspan="2" width="3%">No</td>
                    <td align="center" rowspan="2" width="50%">Uraian</td> 
                    <td align="center" rowspan="2" width="7%">AK</td>
                    <td colspan="4" width="40%">Realisasi</td>
                    <td rowspan="4" width="40%">Perhitungan</td>
                    <td rowspan="4" width="40%">Nilai Capaian</td>
                </tr>
                <tr>
                    <td width="10%">Output</td>
                    <td width="10%">Mutu</td>
                    <td width="10%">Waktu</td>
                    <td width="10%">Biaya</td> 
                </tr>
            </thead>
            <tbody >

            </tbody>
        </table>    
    </div>
    <!--tugas tambahan-->
    <div class="page-header position-relative" id="page-content">
        <div class="span12"> II. Tugas Tambahan</div>
        <button class="btn btn-small btn-primary no-radius" id="tgsTambahan"><i class="icon-plus-sign-alt"></i>Tugas Tambahan</button>
        &nbsp;<span id="load" class="spinner"></span>
    </div>
    <div id="page-content">
        <table class="table table-striped table-bordered table-hover geo-table" style="width:100%">
            <thead >
                <tr>
                    <th class="center" valign="middle" style="width:3%;">No</th>
                    <th class="center" style="width:50%">Uraian Tambahan</th> 
                    <th class="center" style="width:37%">nilai</th>
                    <th class="center" style="width:10%">aksi</th> 
                </tr>

            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!--kreatifitas-->
     <div class="page-header position-relative" id="page-content">
        <div class="span12"> III. Kreativitas</div>
    </div>
    <div id="page-content">
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
                    <td><input class="input-large" type="text" name="" /></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Integritas</td>
                    <td><input class="input-large" type="text" name="" /></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Komitmen</td>
                    <td><input class="input-large" type="text" name="" /></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Disiplin</td>
                    <td><input class="input-large" type="text" name="" /></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Kerjasama</td>
                    <td><input class="input-large" type="text" name="" /></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Kepemimpinan</td>
                    <td><input class="input-large" type="text" name="" /></td>
                </tr>
            </tbody>
        </table>
    </div>
        <div class=" position-relative pull-right" id="page-content">
        <button class="btn btn-small btn-primary no-radius" id=""><i class="icon-save"></i>Simpan</button>
        &nbsp;<span id="load" class="spinner"></span>
    </div>
</div>
</div>
