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
            $sql = "SELECT * FROM karyawan";
            $result = mysqli_query($link, $sql);
                    
            //Tambah data
            if (isset($_POST['tambahKaryawan'])) {            
            $kode = $_POST['kodeKaryawan'];
            $nama = $_POST['namaKaryawan'];
            $jabatan = $_POST['jabatanKaryawan'];
            $sql = "INSERT INTO karyawan (kode, nama, jabatan) "
                . "VALUES ('" . $kode . "', '" . $nama . "', '" . $jabatan . "') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahKaryawan']);
                unset($_POST['kodeKaryawan']);
                unset($_POST['namaKaryawan']);
                unset($_POST['jabatanKaryawan']);
                header("Location: MasterKaryawan.php");
            } else {
                die("SQL Error : " . $sql);
            }}
            
            //Edit data
            if (isset($_POST['editKaryawan'])) {            
            $kode = $_POST['kodeKaryawan'];
            $nama = $_POST['namaKaryawan'];
            $jabatan = $_POST['jabatanKaryawan'];
            $sql = "UPDATE karyawan SET kode = '" . $kode . "', nama = '" . $nama . "', "
                    . "jabatan = '" . $jabatan . "' "
                    . "WHERE kode = '".$_SESSION['kodeKaryawan']."'";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeKaryawan']);
                unset($_POST['editKaryawan']);
                unset($_POST['kodeKaryawan']);
                unset($_POST['namaKaryawan']);
                unset($_POST['jabatanKaryawan']);
                header("Location: MasterKaryawan.php");
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
            <th>KARYAWAN</th>
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
                
                    <h2>ANDA BERADA DI HALAMAN MASTER KARYAWAN</h2><br><br>
                    
                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                    <tr>
                    <th><?php 
                    if(isset($_SESSION['kodeKaryawan'])){echo "EDIT KARYAWAN";} 
                    else {echo "TAMBAH KARYAWAN";}
                ?>
                    </th>
                    </tr>
                <tr>
                <td>
                <?php if(isset($_SESSION['kodeKaryawan'])){ 
                    $kodeKaryawan = $_SESSION['kodeKaryawan'];
                    $sqlUpdate = "SELECT * FROM karyawan WHERE kode='" . $kodeKaryawan . "'";
                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                    $rowUpdate = mysqli_fetch_array($resultUpdate); ?>
                <form action="" method="POST">
                Kode Karyawan : <input type="text" name="kodeKaryawan" value="<?php echo $rowUpdate['kode'] ?>"><br><br>
                Nama Karyawan : <input type="text" name="namaKaryawan" value="<?php echo $rowUpdate['nama'] ?>"><br><br>
                Jabatan Karyawan : <input type="text" name="jabatanKaryawan" value="<?php echo $rowUpdate['jabatan'] ?>"><br><br>
                <input type="hidden" name="editKaryawan">
                <input type="submit" value="Simpan">
                </form>
                <?php } else { ?>
                <form action="" method="POST">
                Kode Karyawan : <input type="text" name="kodeKaryawan"><br><br>
                Nama Karyawan : <input type="text" name="namaKaryawan"><br><br>
                Jabatan Karyawan: <input type="text" name="jabatanKaryawan"><br><br>
                <input type="hidden" name="tambahKaryawan">
                <input type="submit" value="Simpan">
                </form>
                <?php } ?>
                </td>
                </tr>
                </table><br>
                
                <!--TABEL untuk menampilkan data-->
                <table border="1" style="width: 100%">
                <tr>
                <th>KODE KARYAWAN</th>
                <th>NAMA KARYAWAN</th>
                <th>JABATAN KARYAWAN</th>
                <th>EDIT / HAPUS</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) { ?>
                <tr>
                <td><?php echo $row->kode ?></td>
                <td><?php echo $row->nama ?></td>
                <td><?php echo $row->jabatan ?></td>
                <td>
                <a href="update.php?kodeKaryawan=<?php echo $row->kode ?>">EDIT</a> |
                <a href="delete.php?kodeKaryawan=<?php echo $row->kode ?>" 
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