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
        $noNota = 0;
        $sqlNoNota = "SELECT * FROM form_pembelian_bahan_baku";
        $resultNoNota = mysqli_query($link, $sqlNoNota);
        while ($rowNoNota = mysqli_fetch_object($resultNoNota)) {
            $noNota++;
        }

        if (isset($_GET['sim'])) {
            $sqlFPBB = "INSERT INTO form_pembelian_bahan_baku (nomor, no_spk, tanggal_beli) "
                    . "VALUES (" . ($noNota + 1) . ", " . $_SESSION['spk'] . ", '" . date('Y-m-d') . "')";
            $resultFPBB = mysqli_query($link, $sqlFPBB);
            if ($resultFPBB) {
                unset($_SESSION['spk']);
                unset($_SESSION['namaDkodeProduk']);
                header("Location: MasterPembelianBahanBaku.php");
            } else {
                die("SQL Error : " . $sql);
            }
        }

        if (isset($_POST['cboBB'])) {
            $id = explode("(", $_SESSION['namaDkodeProduk']);
            $idP = substr($id[1], 0, strlen($id[1]) - 1);
            $i = explode("(", $_POST['cboBB']);
            $idB = substr($i[1], 0, strlen($i[1]) - 1);
            $jumlah = 0;
            $harga = 0;
            $sqlCariData = "SELECT b.jumlah_bb, bb.harga "
                    . "FROM bom b INNER JOIN bahanbaku bb ON b.kode_bahan_baku = bb.kode "
                    . "WHERE b.kode_bahan_baku = " . $idB . " AND b.kode_produk = " . $idP;
            $resultCariData = mysqli_query($link, $sqlCariData);
            while ($rowCariData = mysqli_fetch_object($resultCariData)) {
                $jumlah = $rowCariData->jumlah_bb;
                $harga = $rowCariData->harga;
            }
            $totalHarga = $jumlah * $harga;

            //apabila ada yg sama
            $sql = "SELECT * "
                    . "FROM bahanbaku_formpembelianbahanbaku bbfpbb INNER JOIN bahanbaku b "
                    . "ON bbfpbb.kode_bb = b.kode "
                    . "WHERE bbfpbb.no_form_pembelian_bb = " . ($noNota + 1);
            $result = mysqli_query($link, $sql);
            if (!$result) {
                die("SQL Error : " . $sql);
            }
            $samaBB = 0;
            while ($row = mysqli_fetch_object($result)) {
                if ($row->kode == $idB) {
                    $samaBB = 1;
                }
            }



            if ($samaBB == 0) {
                $sqlBBfpbb = "INSERT INTO bahanbaku_formpembelianbahanbaku (kode_bb, no_form_pembelian_bb, total, jumlah_beli) "
                        . "VALUES (" . $idB . ", " . ($noNota + 1) . ", " . $totalHarga . ", " . $jumlah . ")";
                $resultBBfpbb = mysqli_query($link, $sqlBBfpbb);
                if ($resultBBfpbb) {
                    unset($_POST['cboBB']);
                    header("Location: MasterPembelianBahanBaku.php");
                } else {
                    die("SQL Error : " . $sql);
                }
            } else {
                echo "<h1>BAHAN BAKU SUDAH DIBELI</h1>";
            }
        }

        if (isset($_POST['pilihSPK'])) {
            $spk = $_POST['cboSPK'];
            $_SESSION['spk'] = $spk;
            $sqlP = "SELECT p.kode, p.nama FROM spk s INNER JOIN produk p ON s.kode_produk = p.kode"
                    . " WHERE s.no_spk = " . $spk;
            $resultP = mysqli_query($link, $sqlP);
            while ($rowSPK = mysqli_fetch_object($resultP)) {
                $_SESSION['namaDkodeProduk'] = $rowSPK->nama . " (" . $rowSPK->kode . ")";
                $kodeP = $rowSPK->kode;
            }
            header("Location: MasterPembelianBahanBaku.php");
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
                            <th>PEMBELIAN BAHAN BAKU</th>
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

                    <h2>ANDA BERADA DI HALAMAN MASTER PEMBELIAN BAHAN BAKU</h2><br><br>

                    <!--TABEL Tambah dan Update-->
                    <table border="0" style="width: 30%; float: left;">
                        <tr>
                            <td>
                                <form action="" method="POST">
                                    No SPK : <select name="cboSPK">
                                        <?php
                                        $sqlSPK = "SELECT * FROM spk";
                                        $resultSPK = mysqli_query($link, $sqlSPK);
                                        while ($rowSPK = mysqli_fetch_object($resultSPK)) {
                                            ?>
                                            <option><?php echo $rowSPK->no_spk ?></option>
                                        <?php } ?>    
                                    </select>
                                    <input type="hidden" name="pilihSPK">
                                    <input type="submit" value="Pilih SPK">
                                </form><br>

                            </td>
                        </tr>

                    </table>
                    <?php if (isset($_SESSION['spk'])) { ?>
                        <table border="1" style="width: 50%; float: left;">

                            <tr>
                                <td>
                                    Nomor Nota : <?php echo ($noNota + 1); ?> <br><br>
                                    Nomor SPK : <?php echo $_SESSION['spk'] ?><br><br>
                                    Nama dan Kode Produk : <?php echo $_SESSION['namaDkodeProduk'] ?> <br><br>
                                    Tanggal : <input type="date" name="tgl" disabled="disabled"
                                                     value="<?php echo date('Y-m-d'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form action="" method="POST">
                                        <?php
                                        $id = explode("(", $_SESSION['namaDkodeProduk']);
                                        $idP = substr($id[1], 0, strlen($id[1]) - 1);
                                        ?>
                                        Kode BB : <select name="cboBB">
                                            <?php
                                            $sqlBB = "SELECT bb.nama, bb.kode FROM bom b INNER JOIN bahanbaku bb "
                                                    . "ON b.kode_bahan_baku = bb.kode "
                                                    . "WHERE b.kode_produk = " . $idP;
                                            $resultBB = mysqli_query($link, $sqlBB);
                                            while ($rowBB = mysqli_fetch_object($resultBB)) {
                                                ?>
                                                <option><?php echo $rowBB->nama . " (" . $rowBB->kode . ")" ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="submit" value="TAMBAH">
                                    </form>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 70%; float: right; margin-top: 30px">
                            <tr>
                                <th>NAMA BB</th>
                                <th>JUMLAH</th>
                                <th>HARGA</th>
                                <th>TOTAL</th>
                            </tr>

                            <?php
                            $sql = "SELECT * "
                                    . "FROM bahanbaku_formpembelianbahanbaku bbfpbb INNER JOIN bahanbaku b "
                                    . "ON bbfpbb.kode_bb = b.kode "
                                    . "WHERE bbfpbb.no_form_pembelian_bb = " . ($noNota + 1);
                            $result = mysqli_query($link, $sql);
                            if (!$result) {
                                die("SQL Error : " . $sql);
                            }
                            while ($row = mysqli_fetch_object($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row->nama . " (" . $row->kode . ")" ?></td>
                                    <td><?php echo $row->jumlah_beli ?></td>
                                    <td><?php echo $row->harga ?></td>
                                    <td><?php echo $row->total ?></td>
                                </tr>
                            <?php } ?>

                        </table>
                    <?php } ?>
                </td>
            </center>
        </tr>
        <tr>
            <th><a href="MasterPembelianBahanBaku.php?sim=0">SIMPAN</a></th>
        </tr>
    </table>
</body>
</html>