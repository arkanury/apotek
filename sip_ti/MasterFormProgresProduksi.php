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
        //unset($_SESSION['spk']);
        if (isset($_POST['cboSPK'])) {
            $_SESSION['spk'] = $_POST['cboSPK'];
            unset($_POST['cboSPK']);
            header("Location: MasterFormProgresProduksi.php");
        }
        
        if(isset($_POST['tambahFormProgresProduksi'])){
            $spk = $_SESSION['noSpk'];
            $jamKerja = $_POST['jamKerja'];
            $m = explode("(", $_POST['cboMesin']);
            $mesin = substr($m[1], 0, strlen($m[1]) - 1);
            $tanggal = $_POST['tanggal'];
            $hasil = $_POST['hasil'];
            
            
            $sql = "INSERT INTO form_progres_produksi (no_spk, jam_kerja, kode_mesin, tanggal, hasil) "
                    . "VALUES (".$spk.", ".$jamKerja.", ".$mesin.", '".$tanggal."', '".$hasil."') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahFormProgresProduksi']);
                unset($_SESSION['spk']);
                header("Location: MasterFormProgresProduksi.php");
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
                            <th><a href="MasterJadwalProduksi.php">JADWAL PRODUKSI</a></th>
                            <th><a href="MasterSpk.php">SPK</a></th>
                            <th>FORM PROGRES PRODUKSI</th>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
            <center>
                <td width="100%" colspan="3" bgcolor="white">

                <center><h2>ANDA BERADA DI HALAMAN MASTER PROGRES PRODUKSI</h2><br><br> </center>  

                <!--Pilih produk terlebih dahulu-->
                <form action="" method="POST">
                    Pilih SPK : <select name="cboSPK">
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
                <?php if (isset($_SESSION['spk'])) { ?>
                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                        <tr>
                            <th>
                                FORM PROGRES PRODUKSI
                            </th>
                        </tr>
                        <tr>
                            <td><?php
                                $sql = "SELECT  p.kode AS kodeP, p.nama AS namaP, k.kode, k.nama "
                                        . "FROM spk s INNER JOIN produk p "
                                        . "ON s.kode_produk = p.kode INNER JOIN karyawan k "
                                        . "ON s.kode_karyawan = k.kode "
                                        . "WHERE s.no_spk=" . $_SESSION['spk'];
                                $result = mysqli_query($link, $sql);
                                if (!$result) {
                                    die($sql);
                                }
                                $row = mysqli_fetch_array($result);
                                ?>
                                <form action="" method="POST">

                                    Nomor SPK : <input type="text" name="nomorSpk" 
                                                       disabled="disabled" 
                                                       value="<?php echo $_SESSION['spk'] ?>"><br><br>
                                    Produk : <input type="text" name="produk" 
                                                    disabled="disabled" 
                                                    value="<?php echo $row['namaP'] . " (" . $row['kodeP'] . ")" ?>"><br><br>
                                    Karyawan : <input type="text" name="karyawan" 
                                                      disabled="disabled" 
                                                      value="<?php echo $row['nama'] . " (" . $row['kode'] . ")" ?>"><br><br>
                                    Jam Kerja : <input type="text" name="jamKerja"> Jam<br><br>
                                    Mesin : <select name="cboMesin">
                                        <?php
                                        $sqlMesin = "SELECT * FROM mesin";
                                        $resultMesin = mysqli_query($link, $sqlMesin);
                                        while ($rowMesin = mysqli_fetch_object($resultMesin)) {
                                            ?>
                                            <option><?php echo $rowMesin->nama." (".$rowMesin->kode.")" ?></option>
                                        <?php } ?>    
                                    </select><br><br>
                                    Tanggal : <input type="date" name="tanggal"><br><br>
                                    Hasil : <textarea name="hasil" style="height: 100px; width: 250px;"></textarea><br><br>
                                    <input type="hidden" name="tambahFormProgresProduksi">
                                    <input type="submit" value="Simpan">
                                </form>
                            </td>
                        </tr>
                    </table><br>
                <?php } ?>    
                    <!--TABEL untuk menampilkan data-->
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>NO</th>
                            <th>NO SPK</th>
                            <th>JAM KERJA</th>
                            <th>KODE MESIN</th>
                            <th>TANGGAL</th>
                            <th>HASIL</th>
                        </tr>
                        <?php
                        $sqlData = "SELECT * FROM form_progres_produksi fpp INNER JOIN mesin m "
                                . "ON fpp.kode_mesin = m.kode";
                        $resultData = mysqli_query($link, $sqlData);
                        while ($rowData = mysqli_fetch_object($resultData)) { ?>
                            <tr>
                                <td><?php echo $rowData->kode_fpp ?></td>
                                <td><?php echo $rowData->no_spk ?></td>
                                <td><?php echo $rowData->jam_kerja ?></td>
                                <td><?php echo $rowData->nama." (".$rowData->kode.")" ?></td>
                                <td><?php echo $rowData->tanggal ?></td>
                                <td><?php echo $rowData->hasil ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                



                </td>
            </center>

        </table>
    </body>
</html>