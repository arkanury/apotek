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
            $sql = "SELECT * FROM Supplier";
            $result = mysqli_query($link, $sql);
                    
            //Tambah data
            if (isset($_POST['tambahSupplier'])) {
            $nama = $_POST['namaSupplier'];
            $alamat = $_POST['alamatSupplier'];
            $sql = "INSERT INTO supplier (nama, alamat) "
                . "VALUES ('" . $nama . "', '" . $alamat . "') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahSupplier']);
                header("Location: MasterSupplier.php");
            } else {
                die("SQL Error : " . $sql);
            }}
            
            //Edit data
            if (isset($_POST['editSupplier'])) {  
            $nama = $_POST['namaSupplier'];
            $alamat = $_POST['alamatSupplier'];
            $sql = "UPDATE Supplier SET nama = '" . $nama . "', "
                    . "alamat = '" . $alamat . "' "
                    . "WHERE kode = '".$_SESSION['kodeSupplier']."'";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeSupplier']);
                unset($_POST['editSupplier']);
                header("Location: MasterSupplier.php");
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
            <th>SUPPLIER</th>
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
                
                    <h2>ANDA BERADA DI HALAMAN MASTER SUPPLIER</h2><br><br>
                    
                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                    <tr>
                    <th><?php 
                    if(isset($_SESSION['kodeSupplier'])){echo "EDIT SIPPLIER";} 
                    else {echo "TAMBAH SUPPLIER";}
                ?>
                    </th>
                    </tr>
                <tr>
                <td>
                <?php if(isset($_SESSION['kodeSupplier'])){ 
                    $kodeSupplier = $_SESSION['kodeSupplier'];
                    $sqlUpdate = "SELECT * FROM Supplier WHERE kode='" . $kodeSupplier . "'";
                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                    $rowUpdate = mysqli_fetch_array($resultUpdate); ?>
                <form action="" method="POST">
                Nama Supplier : <input type="text" name="namaSupplier" value="<?php echo $rowUpdate['nama'] ?>"><br><br>
                Alamat Supplier : <input type="text" name="alamatSupplier" value="<?php echo $rowUpdate['alamat'] ?>"><br><br>
                <input type="hidden" name="editSupplier">
                <input type="submit" value="Simpan">
                </form>
                <?php } else { ?>
                <form action="" method="POST">
                Nama Supplier : <input type="text" name="namaSupplier"><br><br>
                Alamat Supplier : <input type="text" name="alamatSupplier"><br><br>
                <input type="hidden" name="tambahSupplier">
                <input type="submit" value="Simpan">
                </form>
                <?php } ?>
                </td>
                </tr>
                </table><br>
                
                <!--TABEL untuk menampilkan data-->
                <table border="1" style="width: 100%">
                <tr>
                <th>KODE SUPPLIER</th>
                <th>NAMA SUPPLIER</th>
                <th>ALAMAT SUPPLIER</th>
                <th>EDIT / HAPUS</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) { ?>
                <tr>
                <td><?php echo $row->kode ?></td>
                <td><?php echo $row->nama ?></td>
                <td><?php echo $row->alamat ?></td>
                <td>
                <a href="update.php?kodeSupplier=<?php echo $row->kode ?>">EDIT</a> |
                <a href="delete.php?kodeSupplier=<?php echo $row->kode ?>" 
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