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
            $sql = "SELECT * FROM mesin";
            $result = mysqli_query($link, $sql);
                    
            //Tambah data
            if (isset($_POST['tambahMesin'])) {
            $nama = $_POST['namaMesin'];
            $total = $_POST['totalMesin'];
            
            $sql = "INSERT INTO mesin (nama, total) "
                . "VALUES ('" . $nama . "', ".$total.") ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahMesin']);                
                header("Location: MasterMesin.php");
            } else {
                die("SQL Error : " . $sql);
            }}
            
            //Edit data
            if (isset($_POST['editMesin'])) {
            $nama = $_POST['namaMesin'];
            $total = $_POST['totalMesin'];
            
            
            $sql = "UPDATE mesin SET nama = '" . $nama . "',total = ".$total." "
                    
                    . "WHERE kode = '".$_SESSION['kodeMesin']."'";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeMesin']);
                unset($_POST['editMesin']);                
                header("Location: MasterMesin.php");
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
            <th><a href="MasterProduk.php">PRODUK</a></th>
            <th><a href="MasterBahanBaku.php">BAHAN BAKU</a></th>
            <th><a href="MasterKaryawan.php">KARYAWAN</a></th>
            <th>MESIN</th>
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
                
                    <h2>ANDA BERADA DI HALAMAN MASTER MESIN</h2><br><br>
                    
                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                    <tr>
                    <th><?php 
                    if(isset($_SESSION['kodeMesin'])){echo "EDIT MESIN";} 
                    else {echo "TAMBAH MESIN";}
                ?>
                    </th>
                    </tr>
                <tr>
                <td>
                <?php if(isset($_SESSION['kodeMesin'])){ 
                    $kodeMesin = $_SESSION['kodeMesin'];
                    $sqlUpdate = "SELECT * FROM mesin WHERE kode='" . $kodeMesin . "'";
                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                    $rowUpdate = mysqli_fetch_array($resultUpdate); ?>
                <form action="" method="POST">
                Nama Mesin : <input type="text" name="namaMesin" value="<?php echo $rowUpdate['nama'] ?>"><br><br>
                Total Mesin : <input type="text" name="totalMesin" value="<?php echo $rowUpdate['total'] ?>"><br><br>
                
                <input type="hidden" name="editMesin">
                <input type="submit" value="Simpan">
                </form>
                <?php } else { ?>
                <form action="" method="POST">
                Nama Mesin : <input type="text" name="namaMesin"><br><br>
                Total Mesin : <input type="text" name="totalMesin"><br><br>
                
                <input type="hidden" name="tambahMesin">
                <input type="submit" value="Simpan">
                </form>
                <?php } ?>
                </td>
                </tr>
                </table><br>
                
                <!--TABEL untuk menampilkan data-->
                <table border="1" style="width: 100%">
                <tr>
                <th>KODE MESIN</th>
                <th>NAMA MESIN</th>
                <th>TOTAL MESIN</th>
                
                <th>EDIT / HAPUS</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) { ?>
                <tr>
                <td><?php echo $row->kode ?></td>
                <td><?php echo $row->nama ?></td>
                 <td><?php echo $row->total ?></td>
                
                <td>
                <a href="update.php?kodeMesin=<?php echo $row->kode ?>">EDIT</a> |
                <a href="delete.php?kodeMesin=<?php echo $row->kode ?>" 
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