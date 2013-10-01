<?php
session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include('../../php/include_all.php');
$nama_bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei",
    "Juni", "Juli", "Agustus", "September",
    "Oktober", "November", "Desember");
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Daftar Pemangku</h5>
</div>
<div class="position-relative" id="page-content">
    <a href="#modalwin" data-toggle="modal" class="btn btn-small btn-primary no-radius btn-tambah"><i class="icon-plus"></i>&nbsp;Tambah Data</a>
    &nbsp;<span id="load" class="spinner"></span>
</div>
<div id="modalwin" class="modal hide fade" style="width:800px;left:40%" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <header class="modal-header"> 
        <a href="#" class="close geo-clear" data-dismiss="modal">x</a>
        <h3>Input Pemangku</h3>
    </header>

    <div class="modal-body">
        <form id="form_pemangku">
            <input type="hidden" name="act" value="simpan_pemangku">
            <input type="hidden" id="id_pns" name="id_pns" value="0"> 
            <input type="hidden" id="skpd" name="skpd" value="<? echo SKP_ID; ?>"> 
            <table class="table-form">
                <tbody>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>
                            <select name="jab" id="jab" onChange="jab()" class="jab">
                                <option id="">-Pilih Jabatan-</option>
                                <?php
								echo "select * from skp_jabatan where unit_kerja='" . SKP_ID . "' order by idjab";
                                $jabb = get_datas("select * from skp_jabatan where unit_kerja='" . SKP_ID . "' order by idjab");
                                foreach ($jabb as $jab) {
                                    ?>
                                    <option value="<?php echo $jab['kode_jabatan']; ?>"><?php echo $jab['nama_jabatan']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Golongan</td>
                        <td>:</td>
                        <td>
                            <select name="gol" id="gol">
                                <option id="">-Pilih Golongan-</option>
                                <?php
                                $gol = get_datas("select * from skp_golongan order by id_gol");
                                foreach ($gol as $gol) {
                                    ?>
                                    <option value="<?php echo $gol['id_gol']; ?>"><?php echo $gol['nama_golongan']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama" id="nama"  />
                        </td>
                    </tr>

                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nip" id="nip"  />
                        </td>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="telp" id="telp"  />
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td colspan="3">
                            <input type="text" name="alamat" id="alamat"  />
                        </td>
                    </tr>
                    <tr>
                        <td>Tempat/Tanggal Lahir</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="tempat" id="tempat"  />&nbsp;/
                        </td>
                        <td>
                            <input type="text" name="tglLahir" id="tglLahir" readonly="" />&nbsp;/
                        </td>
                    </tr>
                <input type="hidden" name="pem_no" id="pem_no"  />
                </tbody>
            </table>
            <table align="right">
                <tr>
                    <td>
                        <a class="btn btn-primary btn-small btn-simpan-pemangku "><div id="loader"></div>&nbsp;Simpan</a><span id="result"></span>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<div class="box-content">
    <table class="table table-bordered geo-table table-hover" width="100%">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="15%">Nama</th> 
                <th class="center" width="10%">NIP</th>
                <th class="center" width="5%">Gol</th>
                <th class="center" width="15%">Jabatan</th>
                <th class="center" width="20%">Alamat</th>
                <th class="center" width="10%">No.Telp</th>
                <th class="center" width="15%">Kelahiran</th>
                <th class="center" width="7%"></th>
            </tr>
        </thead>
        <tbody id="tampil_pemangku">
            <?php
            $x = 1;
            $pr = get_datas("select p.id_pns, p.nama, p.nip, g.nama_golongan, g.keterangan, j.nama_jabatan, p.alamat, p.notelp, p.tempat_lahir, p.tanggal_lahir from skp_pns p, skp_jabatan j, skp_golongan g where g.id_gol=p.id_golongan and j.kode_jabatan=p.kode_jabatan and j.unit_kerja=" . SKP_ID . " order by p.id_pns");
            foreach ($pr as $pr) {
                ?><tr>
                    <td><?php echo $x ?></td>
                    <td><?php echo $pr['nama'] ?></td>
                    <td><?php echo $pr['nip'] ?></td>
                    <td><?php echo $pr['nama_golongan'] ?> (<? echo $pr['keterangan'] ?>)</td>
                    <td><?php echo $pr['nama_jabatan'] ?></td>
                    <td><?php echo $pr['alamat'] ?></td>
                    <td><?php echo $pr['notelp'] ?></td>
                    <td><?php echo $pr['tempat_lahir'] ?>, <? echo $pr['tanggal_lahir'] ?></td>
                    <td class="center" >
                        <a href="#modalwin" data-toggle="modal"  class="btn btn-info bt-edit btn-small" name="<?php echo $pr['id_pns']; ?>"><i class="icon-edit icon-white"></i> ubah</a>
                        <a class="btn btn-danger bt-hapus btn-small" name="<?php echo $pr['id_pns']; ?>"><i class="icon-trash icon-white"></i> hapus</a>

                    </td>
                </tr>
                <?php
                $x++;
            }
            ?>
        </tbody>
    </table>    
</div>

<script>
                                var url = 'skpd/pemangku/aksi.php';
                                var rslt = $('#result');
                                $("#tglLahir").datepicker({
                                    format: 'dd/mm/yyyy'
                                });
                                $('.jab').change(function() {
                                    source = "skpd/pemangku/tools.php?code=jab&kdjab=" + this.value;
                                    var tes = $.get(source);
                                    tes.done(function(data) {
                                        $('#pem_no').val(data);
                                    })
                                });

                                $('.btn-tambah').click(function() {
                                    var skpd = $('#skpd').val();
                                    var post = $.post(url, {act: 'tab', skpd: skpd});
                                    post.done(function(data) {
                                        $('#jab').html(data);
                                    });
                                    $('#id').val("0");
                                    $('#kode').val("");
                                    $('#nama').val("");

                                });

                                $('.btn-simpan-pemangku').click(function() {
                                    var btn = $(this);
                                    var load = $('#loader');
                                    load.addClass('icon-spinner icon-spin icon-2x white');

                                    var form = $('#form_pemangku');
                                    var data = form.serializeArray();
                                    var post = $.post(url, data);
                                    post.done(function(res) {
                                        var result = res.split('__');
                                        if (result.length == 3) {
                                            if (result[0] == 'success') {
                                                rslt.html('<font color="green">data tersimpan </font>');
                                                setTimeout(function() {
                                                    rslt.html('');
                                                }, 1500);

                                                var tbody = $('#tampil_pemangku');

                                                tbody.html(result[2]);
                                                init();
                                                $("#id").val("0");
                                                $("#jab").val("");
                                                $("#gol").val("");
                                                $("#nama").val("");
                                                $("#nip").val("");
                                                $("#telp").val("");
                                                $("#alamat").val("");
                                                $("#tempat").val("");
                                                $("#tgl").val("0");
                                                $("#bln").val("0");
                                                $("#thn").val("0");
                                                $("#pem_no").val("");
                                                $('#modalwin').modal('hide');
                                            } else {
                                                rslt.html('<font color="red">' + res + '</font>');
                                            }
                                        } else {
                                            rslt.html('<font color="red">' + res + '</font>');
                                        }
                                        load.removeClass();
                                        btn.removeClass('btn-info').addClass('btn-primary');

                                    });

                                });

                                function init() {
                                    $('.bt-edit').click(function() {
                                        var id = this.name;
                                        var form = $('#form_pemangku');
                                        var post = $.post(url, {act: 'ubah_pemangku', id: id});
                                        post.done(function(res) {
                                            var value = res.split('__');
                                            $('#id_pns').val(value[0]);
                                            form.find('input[name="nama"]').val(value[1]);
                                            form.find('input[name="nip"]').val(value[2]);
                                            form.find('select[name="jab"]').val(value[4]);
                                            form.find('select[name="gol"]').val(value[3]);
                                            form.find('input[name="telp"]').val(value[6]);
                                            form.find('input[name="alamat"]').val(value[5]);
                                            form.find('input[name="tempat"]').val(value[7]);
                                            //form.find('select[name="tgl"]').val(value[11]);
                                            //form.find('select[name="bln"]').val(value[10]);										
                                            $("#tglLahir").val(value[9]);
                                        });
                                    });

                                    $('.bt-hapus').click(function() {
                                        var btn = $(this);
                                        var pid = this.name;
                                        var load = $(this);
                                        load.html('<div class="icon-spinner icon-spin icon-2x white"></div>');
                                        bootbox.confirm("sumpe lu mau ngehapus item ini?", function(hsl) {
                                            if (hsl == true) {
                                                if (pid != 0) {
                                                    var post = $.post(url, {act: "hapus_pemangku", id: pid});
                                                    post.done(function(res) {
                                                        var hasil = res.split('__');
                                                        //alert(hasil.length);
                                                        if (hasil.length == 2) {
                                                            if (hasil[0] == 'success') {
                                                                rslt.html('<font color="green">Data Telah Dihapus...</font>');
                                                                setTimeout(function() {
                                                                    rslt.html('');
                                                                }, 1500);
                                                                var tbody = $('#tampil_pemangku');
                                                                tbody.html(hasil[1]);
                                                                init();
                                                                //btn.parent().parent().remove();
                                                            }
                                                        }
                                                    });
                                                    load.html('<i class="icon-trash icon-white">');
                                                }
                                            } else {
                                                load.html('<i class="icon-trash icon-white">');
                                            }
                                        });
                                    });

                                }
                                init();


</script>