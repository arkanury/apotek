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
            $sql = "SELECT * FROM produk";
            $result = mysqli_query($link, $sql);
                    
            //Tambah data
            if (isset($_POST['tambahProduk'])) {            
            $nama = $_POST['namaProduk'];
            
            $a = explode(".",$_FILES['gbrProduk']['name']);
            $produk = substr(md5($_FILES['gbrProduk']['name'] . time()), 0, 10).".".$a[count($a)-1];
            //if ($_FILES['gbrProduk']['type'] == "image/jpeg") {
                if(move_uploaded_file($_FILES['gbrProduk']['tmp_name'], "gbr_produk/".$produk)){
                    echo "upload sukses";
                } else {
                    echo "upload error"; 
                }
            //} else {
                //echo "file must jpeg";
            //
            $harga = "Rp. ".$_POST['harga'].",- /unit";
            
            $sql = "INSERT INTO Produk (nama, gbr, harga) "
                . "VALUES ('" . $nama . "', '" . $produk . "', '".$harga."') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahProduk']);
                header("Location: MasterProduk.php");
            } else {
                die("SQL Error : " . $sql);
            }}
            
            //Edit data
            if (isset($_POST['editProduk'])) {            
            $nama = $_POST['namaProduk'];
            
            $a = explode(".",$_FILES['gbrProduk']['name']);
            $produk = substr(md5($_FILES['gbrProduk']['name'] . time()), 0, 10).".".$a[count($a)-1];
            if ($_FILES['gbrProduk']['type'] == "") {
                $produk = $_POST['gbrP'];
            } else {
                if(move_uploaded_file($_FILES['gbrProduk']['tmp_name'], "gbr_produk/".$produk)){
                    echo "upload sukses";
                } else {
                    echo "upload error"; 
                }
            }
            $harga = $_POST['harga'];
            
            $sql = "UPDATE produk SET nama = '" . $nama . "', "
                    . "gbr = '" . $produk . "', harga = '".$harga."' "
                    . "WHERE kode = '".$_SESSION['kodeProduk']."'";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeProduk']);
                unset($_POST['editProduk']);
                header("Location: MasterProduk.php");
            } else {
                die("SQL Error : " . $sql);
            }}
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
            <th>PRODUK</th>
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
                
                    <h2>ANDA BERADA DI HALAMAN MASTER PRODUK</h2><br><br>
                    
                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                    <tr>
                    <th><?php 
                    if(isset($_SESSION['kodeProduk'])){echo "EDIT PRODUK";} 
                    else {echo "TAMBAH PRODUK";}
                ?>
                    </th>
                    </tr>
                <tr>
                <td>
                <?php if(isset($_SESSION['kodeProduk'])){ 
                    $kodeProduk = $_SESSION['kodeProduk'];
                    $sqlUpdate = "SELECT * FROM produk WHERE kode='" . $kodeProduk . "'";
                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                    $rowUpdate = mysqli_fetch_array($resultUpdate); ?>
                <form action="" method="POST" enctype="multipart/form-data">
                Nama Produk : <input type="text" name="namaProduk" value="<?php echo $rowUpdate['nama'] ?>"><br><br>
                Gambar Produk : <input type="file" name="gbrProduk" value="<?php echo $rowUpdate['gbr'] ?>"><br><br>
                Harga Produk : <input type="text" name="harga" value="<?php echo $rowUpdate['harga'] ?>"> /unit<br><br>
                <input type="hidden" name="gbrP" value="<?php echo $rowUpdate['gbr'] ?>">
                <input type="hidden" name="editProduk">
                <input type="submit" value="Simpan">
                </form>
                <?php } else { ?>
                <form action="" method="POST" enctype="multipart/form-data">
                Nama Produk : <input type="text" name="namaProduk"><br><br>
                Gambar Produk : <input type="file" name="gbrProduk"><br><br>
                Harga Produk : <input type="text" name="harga"> /unit<br><br>
                <input type="hidden" name="tambahProduk">
                <input type="submit" value="Simpan">
                </form>
                <?php } ?>
                </td>
                </tr>
                </table><br>
                
                <!--TABEL untuk menampilkan data-->
                <table border="1" style="width: 100%">
                <tr>
                <th>KODE PRODUK</th>
                <th>NAMA PRODUK</th>
                <th>GAMBAR PRODUK</th>
                <th>HARGA PRODUK</th>
                <th>EDIT / HAPUS</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) { ?>
                <tr>
                <td><?php echo $row->kode ?></td>
                <td><?php echo $row->nama ?></td>
                <td><img src="gbr_produk/<?php echo $row->gbr ?>" style="width: 100px; height: 100px;"></td>
                <td>Rp. <?php echo $row->harga ?>,- /unit</td>
                <td>
                <a href="update.php?kodeProduk=<?php echo $row->kode ?>">EDIT</a> |
                <a href="delete.php?kodeProduk=<?php echo $row->kode ?>" 
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