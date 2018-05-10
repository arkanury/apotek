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
        $sql = "SELECT * FROM spk";
        $result = mysqli_query($link, $sql);

        //Tambah data
        if (isset($_POST['tambahSpk'])) {

            $tanggalMulaiSpk = $_POST['tglMulaiSpk'];
            $tanggalJadiSpk = $_POST['tglJadiSpk'];
            
            $p = explode("(", $_POST['cboProduk']);
            $kodeProduk = substr($p[1], 0, strlen($p[1]) - 1);
            
            $c = explode("(", $_POST['cboCustomer']);
            $kodeCustomer = substr($c[1], 0, strlen($c[1]) - 1);
            
            $k = explode("(", $_POST['cboKaryawan']);
            $kodeKaryawan = substr($k[1], 0, strlen($k[1]) - 1);

            $sql = "INSERT INTO spk (tanggal_mulai_spk, tanggal_jadi_spk, "
                    . "kode_produk, kode_customer, kode_karyawan) "
                    . "VALUES ('" . $tanggalMulaiSpk . "', '" . $tanggalJadiSpk . "', "
                    . "" . $kodeProduk . ", " . $kodeCustomer . ", '" . $kodeKaryawan . "') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahSpk']);
                header("Location: MasterSpk.php");
            } else {
                die("SQL Error : " . $sql);
            }
        }

        //Edit data
        if (isset($_POST['editSpk'])) {
            $tanggalMulaiSpk = $_POST['tglMulaiSpk'];
            $tanggalJadiSpk = $_POST['tglJadiSpk'];
            
            $p = explode("(", $_POST['cboProduk']);
            $kodeProduk = substr($p[1], 0, strlen($p[1]) - 1);
            
            $c = explode("(", $_POST['cboCustomer']);
            $kodeCustomer = substr($c[1], 0, strlen($c[1]) - 1);
            
            $k = explode("(", $_POST['cboKaryawan']);
            $kodeKaryawan = substr($k[1], 0, strlen($k[1]) - 1);
            
            $sql = "UPDATE spk SET tanggal_mulai_spk = '" . $tanggalMulaiSpk . "', "
                    . "tanggal_jadi_spk = '" . $tanggalJadiSpk . "', "
                    . "kode_produk = " . $kodeProduk . ", "
                    . "kode_customer = " . $kodeCustomer . ", "
                    . "kode_karyawan = '" . $kodeKaryawan . "' "
                    . "WHERE no_spk = " . $_SESSION['noSpk'];
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['noSpk']);
                unset($_POST['editSpk']);
                header("Location: MasterSpk.php");
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
                            <th>SPK</th>
                            <th><a href="MasterFormProgresProduksi.php">FORM PROGRES PRODUKSI</a></th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>

                <td width="100%" colspan="3" bgcolor="white">

                    <h2>ANDA BERADA DI HALAMAN MASTER SPK</h2><br><br>

                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                        <tr>
                            <th><?php
                                if(isset($_SESSION['noSpk'])){
                                    echo "EDIT SPK";
                                } else {
                                    echo "TAMBAH SPK";
                                }
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if (isset($_SESSION['noSpk'])) {
                                    $noSpk = $_SESSION['noSpk'];
                                    $sqlUpdate = "SELECT * FROM spk WHERE no_spk=" . $noSpk;
                                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                                    $rowUpdate = mysqli_fetch_array($resultUpdate);
                                    ?>
                                    <form action="" method="POST">
                                        Kode Produk : <select name="cboProduk">
                                            <?php
                                            $sqlProduk = "SELECT * FROM produk";
                                            $resultProduk = mysqli_query($link, $sqlProduk);
                                            while ($rowProduk = mysqli_fetch_object($resultProduk)) {
                                                ?>
                                                <option><?php echo $rowProduk->nama . " (" . $rowProduk->kode . ")" ?></option>
                                            <?php } ?>    
                                        </select><br><br>

                                        Kode Customer : <select name="cboCustomer">
                                            <?php
                                            $sqlCustomer = "SELECT * FROM customer";
                                            $resultCustomer = mysqli_query($link, $sqlCustomer);
                                            while ($rowCustomer = mysqli_fetch_object($resultCustomer)) {
                                                ?>
                                                <option><?php echo $rowCustomer->nama . " (" . $rowCustomer->kode_customer . ")" ?></option>
                                            <?php } ?>    
                                        </select><br><br>

                                        Kode Karyawan : <select name="cboKaryawan">
                                            <?php
                                            $sqlKaryawan = "SELECT * FROM karyawan";
                                            $resultKaryawan = mysqli_query($link, $sqlKaryawan);
                                            while ($rowKaryawan = mysqli_fetch_object($resultKaryawan)) {
                                                ?>
                                                <option><?php echo $rowKaryawan->nama . " (" . $rowKaryawan->kode . ")" ?></option>
                                            <?php } ?>    
                                        </select><br><br>
                                        Tanggal Mulai SPK : <input type="date" name="tglMulaiSpk" value="<?php echo $rowUpdate['tanggal_mulai_spk'] ?>"><br><br>
                                        Tanggal Jadi SPK : <input type="date" name="tglJadiSpk" value="<?php echo $rowUpdate['tanggal_jadi_spk'] ?>"><br><br>
                                        <input type="hidden" name="editSpk">
                                        <input type="submit" value="Simpan">
                                    </form>
                                
                                
                                
                                
                                
                                
                                <?php } else { ?>
                                    <form action="" method="POST">        
                                        Kode Produk : <select name="cboProduk">
                                            <?php
                                            $sqlProduk = "SELECT * FROM produk";
                                            $resultProduk = mysqli_query($link, $sqlProduk);
                                            while ($rowProduk = mysqli_fetch_object($resultProduk)) {
                                                ?>
                                                <option><?php echo $rowProduk->nama . " (" . $rowProduk->kode . ")" ?></option>
                                            <?php } ?>    
                                        </select><br><br>

                                        Kode Customer : <select name="cboCustomer">
                                            <?php
                                            $sqlCustomer = "SELECT * FROM customer";
                                            $resultCustomer = mysqli_query($link, $sqlCustomer);
                                            while ($rowCustomer = mysqli_fetch_object($resultCustomer)) {
                                                ?>
                                                <option><?php echo $rowCustomer->nama . " (" . $rowCustomer->kode_customer . ")" ?></option>
                                            <?php } ?>    
                                        </select><br><br>

                                        Kode Karyawan : <select name="cboKaryawan">
                                            <?php
                                            $sqlKaryawan = "SELECT * FROM karyawan";
                                            $resultKaryawan = mysqli_query($link, $sqlKaryawan);
                                            while ($rowKaryawan = mysqli_fetch_object($resultKaryawan)) {
                                                ?>
                                                <option><?php echo $rowKaryawan->nama . " (" . $rowKaryawan->kode . ")" ?></option>
                                            <?php } ?>    
                                        </select><br><br>
                                        Tanggal Mulai SPK : <input type="date" name="tglMulaiSpk"><br><br>
                                        Tanggal Jadi SPK : <input type="date" name="tglJadiSpk"><br><br>
                                        <input type="hidden" name="tambahSpk">
                                        <input type="submit" value="Simpan">
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    </table><br>

                    <!--TABEL untuk menampilkan data-->
                    <table border="1" style="width: 100%">
                        <tr style="height: 50px;">
                            <th>NOMOR SPK</th>    
                            <th>TANGGAL MULAI SPK</th>
                            <th>TANGGAL JADI SPK</th>
                            <th>KODE PRODUK</th>
                            <th>KODE CUSTOMER</th>
                            <th>KODE KARYAWAN</th>
                            <th>EDIT / HAPUS</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_object($result)) { ?>
                            <tr>
                                <td><?php echo $row->no_spk ?></td>
                                <td><?php echo $row->tanggal_mulai_spk ?></td>
                                <td><?php echo $row->tanggal_jadi_spk ?></td>
                                <td><?php echo $row->kode_produk ?></td>
                                <td><?php echo $row->kode_customer ?></td>
                                <td><?php echo $row->kode_karyawan ?></td>
                                <td>
                                    <a href="update.php?noSpk=<?php echo $row->no_spk ?>">EDIT</a> |
                                    <a href="delete.php?noSpk=<?php echo $row->no_spk ?>" 
                                       onclick="alert('Data Dengan Kode : <?php echo $row->no_spk ?> telah terhapus')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
        </table>
    </body>
</html>