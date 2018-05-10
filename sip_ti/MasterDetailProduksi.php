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
            $sql = "SELECT * FROM detail_jadwal_produksi";
            $result = mysqli_query($link, $sql);
                    
            //Tambah data
            if (isset($_POST['tambahDetailProduksi'])) {            
            $nomor = $_POST['noDePro'];
            $tglMulai = $_POST['tglMulai'];
            $hasil = $_POST['hasil'];
            $a = explode("(",$_POST['kodeMesin']);
            $kodeMesin = substr($a[1], 0, strlen($a[1])-1);
            $sql = "INSERT INTO detail_jadwal_produksi (nomor, tanggal_mulai, hasil, kode_mesin, nomor_mesin) "
                . "VALUES (".$nomor.", '".$tglMulai."', '".$hasil."', '".$kodeMesin."', '".$kodeMesin."') ";
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_POST['tambahDetailProduksi']);
                header("Location: MasterDetailProduksi.php");
            } else {
                die("SQL Error : " . $sql);
            }}
            
            //Edit data
            if (isset($_POST['editDetailProduksi'])) {            
            $nomor = $_POST['noDePro'];
            $tglMulai = $_POST['tglMulai'];
            $hasil = $_POST['hasil'];
            $a = explode("(",$_POST['kodeMesin']);
            $kodeMesin = substr($a[1], 0, strlen($a[1])-1);
            $sql = "UPDATE detail_jadwal_produksi SET nomor=".$nomor.", tanggal_mulai='".$tglMulai."', "
                    . "hasil='".$hasil."', kode_mesin='".$kodeMesin."', nomor_mesin='".$kodeMesin."' "
                    . "WHERE nomor = ".$_SESSION['kodeDetailProduksi'];
            $result = mysqli_query($link, $sql);
            if ($result) {
                unset($_SESSION['kodeDetailProduksi']);
                unset($_POST['editDetailProduksi']);
                header("Location: MasterDetailProduksi.php");
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
            <th><a href="MasterMesin.php">MESIN</a></th>
            </tr>
            
            <tr>
            <th><a href="MasterB_O_M.php">B.O.M</a></th>
            <th><a href="MasterPembelianBahanBaku.php">PEMBELIAN BAHAN BAKU</a></th>
            <th>DETAIL PRODUKSI</th>
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
                
                    <h2>ANDA BERADA DI HALAMAN MASTER DETAIL PRODUKSI</h2><br><br>
                    
                    <!--TABEL Tambah dan Update-->
                    <table border="1" style="width: 50%">
                    <tr>
                    <th><?php //unset($_SESSION['kodeDetailProduksi']);
                    if(isset($_SESSION['kodeDetailProduksi'])){echo "EDIT DETAIL PRODUKSI";} 
                    else {echo "TAMBAH DETAIL PRODUKSI";}
                ?>
                    </th>
                    </tr>
                <tr>
                <td>
                <?php if(isset($_SESSION['kodeDetailProduksi'])){ 
                    $kodeDetailProduksi = $_SESSION['kodeDetailProduksi'];
                    $sqlUpdate = "SELECT * FROM detail_jadwal_produksi WHERE nomor=".$kodeDetailProduksi;
                    $resultUpdate = mysqli_query($link, $sqlUpdate);
                    $rowUpdate = mysqli_fetch_array($resultUpdate); ?>
                <form action="" method="POST">
                Nomor Detail Produksi : <input type="text" name="noDePro" value="<?php echo $rowUpdate['nomor'] ?>"><br><br>
                Tanggal Mulai : <input type="date" name="tglMulai" value="<?php echo $rowUpdate['tanggal_mulai'] ?>"><br><br>
                Hasil : <textarea name="hasil" style="height: 100px; width: 250px;"><?php echo $rowUpdate['hasil'] ?>
                </textarea><br><br>
                Kode Mesin yg Terpakai : <select name="kodeMesin">
                <?php
                $sqlMesin = "SELECT * FROM mesin";
                $resultMesin = mysqli_query($link, $sqlMesin);
                while ($rowMesin = mysqli_fetch_object($resultMesin)) { ?>
                    <option><?php echo $rowMesin->nama." (".$rowMesin->kode.")" ?></option>
                <?php } ?>
                </select><br><br>
                <input type="hidden" name="editDetailProduksi">
                <input type="submit" value="Simpan">
                </form>
                <?php } else { ?>
                    
                <form action="" method="POST">
                Nomor Detail Produksi : <input type="text" name="noDePro"><br><br>
                Tanggal Mulai : <input type="date" name="tglMulai"><br><br>
                Hasil : <textarea name="hasil" style="height: 100px; width: 250px;"></textarea><br><br>
                Kode Mesin yg Terpakai : <select name="kodeMesin">
                <?php
                $sqlMesin = "SELECT * FROM mesin";
                $resultMesin = mysqli_query($link, $sqlMesin);
                while ($rowMesin = mysqli_fetch_object($resultMesin)) { ?>
                    <option><?php echo $rowMesin->nama." (".$rowMesin->kode.")" ?></option>
                <?php } ?>
                </select><br><br>
                <input type="hidden" name="tambahDetailProduksi">
                <input type="submit" value="Simpan">
                </form>
                <?php } ?>
                </td>
                </tr>
                </table><br>
                
                <!--TABEL untuk menampilkan data-->
                <table border="1" style="width: 100%">
                <tr>
                <th>NOMOR</th>
                <th>TANGGAL MULAI</th>
                <th>HASIL</th>
                <th>KODE MESIN</th>
                <th>EDIT / HAPUS</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) { ?>
                <tr>
                <td><?php echo $row->nomor ?></td>
                <td><?php echo $row->tanggal_mulai ?></td>
                <td><?php echo $row->hasil ?></td>
                <td><?php echo $row->kode_mesin ?></td>
                <td>
                <a href="update.php?kodeDetailProduksi=<?php echo $row->nomor ?>">EDIT</a> |
                <a href="delete.php?kodeDetailProduksi=<?php echo $row->nomor ?>" 
                   onclick="alert('Data Dengan Nomor : <?php echo $row->nomor ?> telah terhapus')">HAPUS</a>
                </td>
                </tr>
                <?php } ?>
                </table>
                
                </td>
            </center>
            </tr>
    </table>
<!--    </form> -->
</body>
</html>