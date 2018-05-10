<!DOCTYPE html>
<html>
    <head>

        <link rel="icon" type="image/ico" href="images/logo_ubaya.ico" src="images/logo_ubaya.ico">
        <title>Teaching Industry</title>
    </head>
    <body style="background-image:url(images/bg.jpg)">
        <?php
        session_start();
        require './db.php';
        //unset($_SESSION['noSpk']);
        if (isset($_POST['cboSPK'])) {
            if ($_POST['cboSPK'] == "-----") {
                unset($_SESSION['noSpk']);
            } else {
                $_SESSION['noSpk'] = $_POST['cboSPK'];
                unset($_POST['cboSPK']);
                header("Location: MasterJadwalProduksi.php");
            }
        }

        $noDetJadPro = 0;
        $sqlNoDetJadPro = "SELECT * FROM detail_jadwal_produksi";
        $resultNoDetJadPro = mysqli_query($link, $sqlNoDetJadPro);
        while ($rowNoDetJadPro = mysqli_fetch_object($resultNoDetJadPro)) {
            $noDetJadPro++;
        }

        $nomorJadwal = 0;
        $sqlNoJad = "SELECT * FROM jadwal_produksi";
        $resultNoJad = mysqli_query($link, $sqlNoJad);
        while ($rowNoJad = mysqli_fetch_object($resultNoJad)) {
            $nomorJadwal++;
        }
        //Tambah data detail
        if (isset($_POST['tambahDetailProduksi'])) {
            $m = explode("(", $_POST['mesin']);
            $mesin = substr($m[1], 0, strlen($m[1]) - 1);

            $sqlDJP = "INSERT INTO detail_jadwal_produksi (no_detail_jadwal_produksi, no_jadwal_produksi, "
                    . "kode_mesin) "
                    . "VALUES (" . ($noDetJadPro + 1) . ", " . ($nomorJadwal + 1) . ", " . $mesin . ") ";
            $resultDJP = mysqli_query($link, $sqlDJP);
            if ($resultDJP) {
                $k = explode("(", $_POST['mesin']);
                $karyawan = substr($k[1], 0, strlen($k[1]) - 1);
                $sql = "INSERT INTO karyawan_detailjadwalproduksi (kode_karyawan, nomor_detail_jadwal_produksi)"
                        . "VALUES ('" . $karyawan . "', " . ($noDetJadPro + 1) . ") ";
                $result = mysqli_query($link, $sql);
                if ($result) {
                    unset($_POST['tambahDetailProduksi']);
                    header("Location: MasterJadwalProduksi.php");
                } else {
                    die("SQL Error : " . $sql);
                }
            } else {
                die("SQL Error : " . $sql);
            }
        }
        
        //tambah data jadwal
        if (isset($_POST['tambahJadwalProduksi'])) {
            $sql = "INSERT INTO jadwal_produksi (no_jadwal_produksi, rencana_tgl_mulai, rencana_tgl_selesai, "
                    . "no_spk ) "
                    . "VALUES (" . ($nomorJadwal + 1) . ", '".$_POST['rcTglMulai']."', '".$_POST['rcTglSelesai']."',"
                    . " ".$_SESSION['noSpk'].") ";
            $result = mysqli_query($link, $sql);
            if ($resultDJP) {
                unset($_POST['tambahJadwalProduksi']);
                unset($_SESSION['noSpk']);
                header("Location: MasterJadwalProduksi.php");
            } else {
                die("SQL Error : " . $sql);
            }
        }
        ?>
        <table width="80%" border="0" style="background-color: #F6F6F6; 
               margin-top:50px; margin-right:10%; margin-bottom:50px; margin-left:10%;">
            <tr>
                <td style="align-items: baseline;">
                    <img src="images/ubaya2.png" height="100px" 
                         width="350px" style="float: left;">
                    <h1 style="float: right; margin-top:40px; 
                        margin-left:50px;">TEACHING INDUSTRY</h1>
                </td>
            </tr>
            <tr>
                <td height="400" width="100%" colspan="3"><img src="images/gedung_ti.jpg" width="100%" height="100%">
                    <table class="btnHeader" width="100%" border="0">
                        <tr>
                            <th><a href="MasterCustomer.php">CUSTOMER</a></th>
                            <th><a href="MasterSupplier.php">SUPPLIER</a></th>
                            <th><a href="MasterProduk.php">PRODUK</a></th>
                            <th><a href="MasterBahanBaku.php">BAHAN BAKU</a></th>
                            <th><a href="MasterKaryawan.php">KARYAWAN</a></th>
                            <th><a href="MasterMesin.php">MESIN</a></th>
                        </tr>

                        <tr>
                            <th><a href="MasterB_O_M.php">B.O.M</a></th>
                            <th><a href="MasterPembelianBahanBaku.php">PEMBELIAN BAHAN BAKU</a></th>
                            <th><a href="MasterDetailProduksi.php">DETAIL PRODUKSI</a></th>
                            <th>JADWAL PRODUKSI</th>
                            <th><a href="MasterSpk.php">SPK</a></th>
                            <th><a href="MasterFormProgresProduksi.php">FORM PROGRES PRODUKSI</a></th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            <center>
                <td width="100%" colspan="3" bgcolor="white">

                    <h2>ANDA BERADA DI HALAMAN MASTER JADWAL PRODUKSI</h2><br><br>

                    <form action="" method="POST">
                        Pilih SPK : <select name="cboSPK">
                            <option><?php echo "-----"; ?></option>
                            <?php
                            $sqlSpk = "SELECT * FROM spk";
                            $resultSpk = mysqli_query($link, $sqlSpk);
                            while ($rowSpk = mysqli_fetch_object($resultSpk)) {
                                ?>
                                <option><?php echo $rowSpk->no_spk ?></option>
                            <?php } ?>    
                        </select>
                        <input type="submit" value="pilih">
                    </form><br><br>
                    <?php if (isset($_SESSION['noSpk'])) { ?>


                        <!--TABEL Tambah dan Update-->
                        <table border="0" style="width: 60%">
                            <tr>
                                <th>TAMBAH JADWAL PRODUKSI</th>
                            </tr>
                            <tr>
                                <td>
                                    <form action="" method="POST">
                                        Nomor Jadwal Produksi : 
                                        <input type="text" name="noJadPro" 
                                               disabled="disabled" value="<?php echo $nomorJadwal + 1 ?>"><br><br>

                                        Rencana Tanggal Mulai : <input type="date" name="rcTglMulai"><br><br>
                                        Rencana Tanggal Selesai : <input type="date" name="rcTglSelesai"><br><br>
                        <!--                Realisasi Tanggal Mulai : <input type="date" name="rlTglMulai"><br><br>
                                        Realisasi Tanggal Selesai : <input type="date" name="rlTglSelesai"><br><br>                
                                        -->
                                        Nomor SPK : <input type="text" name="noSpk" 
                                                           disabled="disabled" value="<?php echo $_SESSION['noSpk'] ?>">
                                        <input type="hidden" name="tambahJadwalProduksi">
                                        <input type="submit" value="Simpan Semua" style="float: right;">
                                    </form><br><br><br>

                                    <?php
                                    ?>
                                    <form action="" method="POST">
                                        Nomor Detail Jadwal Produksi : 
                                        <input type="text" name="noJadPro" 
                                               disabled="disabled" value="<?php echo $noDetJadPro + 1 ?>"><br><br>
                                        Mesin : <select name="mesin">
                                            <?php
                                            $sqlMesin = "SELECT * FROM mesin";
                                            $resultMesin = mysqli_query($link, $sqlMesin);
                                            while ($rowMesin = mysqli_fetch_object($resultMesin)) {
                                                ?>
                                                <option><?php echo $rowMesin->nama . " (" . $rowMesin->kode . ")" ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php
                                        $sqlKaryawan = "SELECT * "
                                                . "FROM karyawan k INNER JOIN spk s "
                                                . "ON k.kode = s.kode_karyawan "
                                                . "WHERE s.no_spk = " . $_SESSION['noSpk'];
                                        $resultKaryawan = mysqli_query($link, $sqlKaryawan);
                                        $rowKaryawan = mysqli_fetch_object($resultKaryawan);
                                        ?>
                                        Karyawan : <input type="text" name="noSpk" 
                                                          disabled="disabled" 
                                                          value="<?php echo $rowKaryawan->nama . " (" . $rowKaryawan->kode . ")" ?>">
                                        <input type="hidden" name="tambahDetailProduksi">
                                        <input type="submit" value="+">
                                    </form><br><br>


                                </td>
                            </tr>
                        </table><br>
                        <h3>DETAIL JADWAL PRODUKSI</h3>
                        <!--TABEL untuk menampilkan data-->
                        <table border="1" style="width: 80%">
                            <tr>
                                <th>NO</th>
                                <th>KARYAWAN</th>
                                <th>MESIN</th>
                            </tr>
                            <?php
                            $sql = "SELECT djp.no_detail_jadwal_produksi, k.kode AS kode_k, k.nama AS nama_k, "
                                    . "m.kode, m.nama "
                                    . "FROM detail_jadwal_produksi djp INNER JOIN karyawan_detailjadwalproduksi kdjp "
                                    . "ON djp.no_detail_jadwal_produksi = kdjp.nomor_detail_jadwal_produksi "
                                    . "INNER JOIN karyawan k ON kdjp.kode_karyawan = k.kode "
                                    . "INNER JOIN mesin m ON m.kode = djp.kode_mesin "
                                    . "WHERE djp.no_jadwal_produksi = " . ($nomorJadwal + 1);
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_object($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row->no_detail_jadwal_produksi ?></td>
                                    <td><?php echo $row->nama_k . " (" . $row->kode_k . ")" ?></td>
                                    <td><?php echo $row->nama . " (" . $row->kode . ")" ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </td>
            </center>
        </table>
    </body>
</html>