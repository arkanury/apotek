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
        $sql = "SELECT * FROM customer";
        $result = mysqli_query($link, $sql);

        //Tambah data
        if (isset($_POST['tambahCustomer'])) {
            $nama = $_POST['namaCustomer'];
            $alamat = $_POST['alamatCustomer'];
            $cp = $_POST['cp'];
            $sql = "INSERT INTO customer (nama, alamat, kontak) "
                    . "VALUES ('" . $nama . "', '" . $alamat . "', '" . $cp . "') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahCustomer']);
                header("Location: MasterCustomer.php");
            } else {
                die("SQL Error : " . $sql);
            }
        }

        //Edit data
        if (isset($_POST['editCustomer'])) {
            $nama = $_POST['namaCustomer'];
            $alamat = $_POST['alamatCustomer'];
            $cp = $_POST['cp'];
            $sql = "UPDATE customer SET nama = '" . $nama . "', "
                    . "alamat = '" . $alamat . "', kontak = '" . $cp . "' "
                    . "WHERE kode_customer=".$_SESSION['kodeCustomer'];
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeCustomer']);
                unset($_POST['editCustomer']);
                header("Location: MasterCustomer.php");
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
                            <th>CUSTOMER</th>
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
                            <th><a href="MasterFormProgresProduksi.php">FORM PROGRES PRODUKSI</a></th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            <center>
                <td width="100%" colspan="3" bgcolor="white">

                    <h2>ANDA BERADA DI HALAMAN MASTER CUSTOMER</h2><br><br>

                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                        <tr>
                            <th><?php
                                if (isset($_SESSION['kodeCustomer'])) {
                                    echo "EDIT CUSTOMER";
                                } else {
                                    echo "TAMBAH CUSTOMER";
                                }
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if (isset($_SESSION['kodeCustomer'])) {
                                    $kodeCustomer = $_SESSION['kodeCustomer'];
                                    $sqlUpdate = "SELECT * FROM customer WHERE kode_customer=".$kodeCustomer;
                                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                                    $rowUpdate = mysqli_fetch_array($resultUpdate);
                                    ?>
                                    <form action="" method="POST">
                                        Nama Customer : <input type="text" name="namaCustomer" value="<?php echo $rowUpdate['nama'] ?>"><br><br>
                                        Alamat Customer : <input type="text" name="alamatCustomer" value="<?php echo $rowUpdate['alamat'] ?>"><br><br>
                                        CP : <input type="text" name="cp" value="<?php echo $rowUpdate['kontak'] ?>"><br><br>
                                        <input type="hidden" name="editCustomer">
                                        <input type="submit" value="Simpan">
                                    </form>
                                <?php } else { ?>
                                    <form action="" method="POST">
                                        Nama Customer : <input type="text" name="namaCustomer"><br><br>
                                        Alamat Customer : <input type="text" name="alamatCustomer"><br><br>
                                        CP : <input type="text" name="cp"><br><br>
                                        <input type="hidden" name="tambahCustomer">
                                        <input type="submit" value="Simpan">
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    </table><br>

                    <!--TABEL untuk menampilkan data-->
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>KODE</th>
                            <th>NAMA</th>
                            <th>ALAMAT</th>
                            <th>KONTAK</th>
                            <th>EDIT / HAPUS</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_object($result)) { ?>
                            <tr>
                                <td><?php echo $row->kode_customer ?></td>
                                <td><?php echo $row->nama ?></td>
                                <td><?php echo $row->alamat ?></td>
                                <td><?php echo $row->kontak ?></td>
                                <td>
                                    <a href="update.php?kodeCustomer=<?php echo $row->kode_customer ?>">EDIT</a> |
                                    <a href="delete.php?kodeCustomer=<?php echo $row->kode_customer ?>" 
                                       onclick="alert('Data Dengan Kode : <?php echo $row->kode_customer ?> telah terhapus')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>

                </td>
            </center>
        </table>
    </body>
</html>