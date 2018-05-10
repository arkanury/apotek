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
        //tambah bom
        If (isset($_POST['tambahBB'])) {
            $b = explode("(", $_POST['cboBB']);
            $kodeBB = substr($b[1], 0, strlen($b[1]) - 1);
            $jumlah = $_POST['jumlahBB'];
            $kodeProduk = $_POST['kodeP'];
            $sama = 0;
            
            $sqlDataBB = "SELECT * FROM bom WHERE kode_produk = " . $kodeProduk;
            $resultDataBB = mysqli_query($link, $sqlDataBB);
            while ($rowDataBB = mysqli_fetch_object($resultDataBB)) {
                if ($kodeBB == $rowDataBB->kode_bahan_baku) {
                    $sama = 1;
                    $jumlah += $rowDataBB->jumlah_bb;
                }
            }


            
            if ($sama == 0) {
                $sql = "INSERT INTO bom (jumlah_bb, kode_produk, kode_bahan_baku) "
                        . "VALUES (" . $jumlah . ", " . $kodeProduk . ", " . $kodeBB . ")";
                $result = mysqli_query($link, $sql);
                if ($result) {
                    unset($_POST['tambahBB']);
                    header("Location: MasterB_O_M.php");
                } else {
                    die("SQL Error : " . $sql);
                }
            } else if ($sama == 1) {
                $sql = "UPDATE bom SET jumlah_bb = " . $jumlah . " "
                        . "WHERE kode_produk = " . $kodeProduk . " AND kode_bahan_baku = " . $kodeBB;
                $result = mysqli_query($link, $sql);
                if ($result) {
                    unset($_POST['tambahBB']);
                    header("Location: MasterB_O_M.php");
                } else {
                    die("SQL Error : " . $sql);
                }
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
                            <th>B.O.M</th>
                            <th><a href="MasterPembelianBahanBaku.php">PEMBELIAN BAHAN BAKU</a></th>
                            <th><a href="MasterDetailProduksi.php">DETAIL PRODUKSI</a></th>
                            <th><a href="MasterJadwalProduksi.php">JADWAL PRODUKSI</a></th>
                            <th><a href="MasterSpk.php">SPK</a></th>
                            <th><a href="MasterFormProgresProduksi.php">FORM PROGRES PRODUKSI</a></th>
                        </tr>
                    </table><br><br>
                </td>
            </tr>
            <tr>
            <center>
                <td width="100%" colspan="3" bgcolor="white">

                    <h2>ANDA BERADA DI HALAMAN B.O.M</h2><br>

                    <!--Pilih produk terlebih dahulu-->
                    <form action="" method="POST">
                        Pilih Produk : <select name="cboProduk">
                            <?php
                            $sqlProduk = "SELECT * FROM produk";
                            $resultProduk = mysqli_query($link, $sqlProduk);
                            while ($rowProduk = mysqli_fetch_object($resultProduk)) {
                                ?>
                                <option><?php echo $rowProduk->nama . " (" . $rowProduk->kode . ")" ?></option>
                            <?php } ?>    
                        </select>
                        <input type="hidden" name="pilihProduk">
                        <input type="submit" value="pilih">
                    </form>




                </td>
            </center>
        </tr>

        <tr>
        <center>
            <td width="100%" colspan="3" bgcolor="white"><br><br>
                <?php
                //Sudah memilih
                if (isset($_POST['pilihProduk'])) {
                    $a = explode("(", $_POST['cboProduk']);
                    $kodeProduk = substr($a[1], 0, strlen($a[1]) - 1);
                    echo "<strong>Produk (kode) = " . $_POST['cboProduk'] . "</strong>";
                    //unset($_POST['cboProduk']);
                    ?>
                    <br><br>
                    <!--Pilih Bahan baku-->
                    <form action="" method="POST">
                        Pilih Bahan Baku : <select name="cboBB">
                            <?php
                            $sqlBB = "SELECT * FROM bahanbaku";
                            $resultBB = mysqli_query($link, $sqlBB);
                            while ($rowBB = mysqli_fetch_object($resultBB)) {
                                ?>
                                <option><?php echo $rowBB->nama . " (" . $rowBB->kode . ")" ?></option>
                            <?php } ?>    
                        </select>  
                        Jumlah : <input type="text" name="jumlahBB">/satuan
                        <input type="hidden" name="kodeP" value="<?php echo $kodeProduk ?>">
                        <!--<input type="hidden" name="pilihProduk">-->
                        <input type="hidden" name="tambahBB"> 
                        <input type="submit" value="+">
                    </form>

                    <br><br>
                    <!--TABEL untuk menampilkan data-->
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>NAMA BAHAN BAKU</th>
                            <th>HARGA BAHAN BAKU</th>
                            <th>JUMLAH BAHAN BAKU</th>
                            <th>HAPUS</th>
                        </tr>
                        <?php
                        $sqlDataBB = "SELECT bb.nama, bb.kode, bb.harga, b.jumlah_bb, b.kode_produk "
                                . "FROM bom b INNER JOIN bahanbaku bb ON b.kode_bahan_baku = bb.kode "
                                . "WHERE b.kode_produk = " . $kodeProduk;
                        $resultDataBB = mysqli_query($link, $sqlDataBB);
                        while ($rowDataBB = mysqli_fetch_object($resultDataBB)) {
                            ?>
                            <tr>
                                <td><?php echo $rowDataBB->nama . " (" . $rowDataBB->kode . ")" ?></td>
                                <td>Rp. <?php echo $rowDataBB->harga ?>,-</td>
                                <td><?php echo $rowDataBB->jumlah_bb ?></td>
                                <td>
                                    <a href="delete.php?kodeBom=
                                       <?php echo $rowDataBB->kode . "." . $rowDataBB->kode_produk ?>" 
                                       onclick="alert('Data Dengan Kode Bahan Baku : <?php echo $rowDataBB->kode ?> telah terhapus')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </td>
        </center>
    </table>
</body>
</html>