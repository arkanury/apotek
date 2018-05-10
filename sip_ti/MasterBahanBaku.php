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
        $sql = "SELECT * FROM bahanbaku";
        $result = mysqli_query($link, $sql);

        //Tambah data
        if (isset($_POST['tambahBahanBaku'])) {
            $nama = $_POST['namaBahanBaku'];
            $harga = $_POST['hargaBahanBaku'];
            $sql = "INSERT INTO bahanbaku (nama, harga) "
                    . "VALUES ('" . $nama . "', '" . $harga . "') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahBahanBaku']);
                header("Location: MasterBahanBaku.php");
            } else {
                die("SQL Error : " . $sql);
            }
        }

        //Edit data
        if (isset($_POST['editBahanBaku'])) {
            $nama = $_POST['namaBahanBaku'];
            $harga = $_POST['hargaBahanBaku'];
            $sql = "UPDATE bahanbaku SET nama = '" . $nama . "', "
                    . "harga = " . $harga . " "
                    . "WHERE kode = '" . $_SESSION['kodeBahanBaku'] . "'";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeBahanBaku']);
                unset($_POST['editBahanBaku']);
                header("Location: MasterBahanBaku.php");
            } else {
                die("SQL Error : " . $sql);
            }
        }
        ?>
        <!--    <form style="margin-top:50px; margin-right:15%; margin-bottom:50px; margin-left:15%;">  -->
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
                            <th>BAHAN BAKU</th>
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

                    <h2>ANDA BERADA DI HALAMAN MASTER BAHAN BAKU</h2><br><br>

                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                        <tr>
                            <th><?php
                                if (isset($_SESSION['kodeBahanBaku'])) {
                                    echo "EDIT BAHAN BAKU";
                                } else {
                                    echo "TAMBAH BAHAN BAKU";
                                }
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if (isset($_SESSION['kodeBahanBaku'])) {
                                    $kodeBahanBaku = $_SESSION['kodeBahanBaku'];
                                    $sqlUpdate = "SELECT * FROM bahanBaku WHERE kode='" . $kodeBahanBaku . "'";
                                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                                    $rowUpdate = mysqli_fetch_array($resultUpdate);
                                    ?>
                                    <form action="" method="POST">
                                        Nama Bahan Baku : <input type="text" name="namaBahanBaku" value="<?php echo $rowUpdate['nama'] ?>"><br><br>
                                        Harga Bahan Baku : <input type="text" name="hargaBahanBaku" value="<?php echo $rowUpdate['harga'] ?>"> /satuan<br><br>
                                        <input type="hidden" name="editBahanBaku">
                                        <input type="submit" value="Simpan">
                                    </form>
                                <?php } else { ?>
                                    <form action="" method="POST">
                                        Nama Bahan Baku : <input type="text" name="namaBahanBaku"><br><br>
                                        Harga Bahan Baku : <input type="text" name="hargaBahanBaku"> /satuan<br><br>
                                        <input type="hidden" name="tambahBahanBaku">
                                        <input type="submit" value="Simpan">
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    </table><br>

                    <!--TABEL untuk menampilkan data-->
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>KODE BAHAN BAKU</th>
                            <th>NAMA BAHAN BAKU</th>
                            <th>HARGA BAHAN BAKU</th>
                            <th>EDIT / HAPUS</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_object($result)) { ?>
                            <tr>
                                <td><?php echo $row->kode ?></td>
                                <td><?php echo $row->nama ?></td>
                                <td>Rp. <?php echo $row->harga ?>,- /satuan</td>
                                <td>
                                    <a href="update.php?kodeBahanBaku=<?php echo $row->kode ?>">EDIT</a> |
                                    <a href="delete.php?kodeBahanBaku=<?php echo $row->kode ?>" 
                                       onclick="alert('Data Dengan Kode : <?php echo $row->kode ?> telah terhapus')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>

                </td>
            </center>
        </table>
        <!--    </form> -->
    </body>
</html>