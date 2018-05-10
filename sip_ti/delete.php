<?php  //delete pada master Customer
session_start();
require './db.php';
if(isset ($_GET['kodeCustomer'])) {
    $kode = $_GET['kodeCustomer'];
    $sql = "DELETE FROM customer WHERE kode_customer = " . $kode;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterCustomer.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Supplier
if(isset ($_GET['kodeSupplier'])) {
    $kode = $_GET['kodeSupplier'];
    $sql = "DELETE FROM supplier WHERE kode = " . $kode;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterSupplier.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Produk
if(isset ($_GET['kodeProduk'])) {
    $kode = $_GET['kodeProduk'];
    $sql = "DELETE FROM produk WHERE kode = " . $kode;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterProduk.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Bahan Baku
if(isset ($_GET['kodeBahanBaku'])) {
    $kode = $_GET['kodeBahanBaku'];
    $sql = "DELETE FROM bahanBaku WHERE kode = " . $kode;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterBahanBaku.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Karyawan
if(isset ($_GET['kodeKaryawan'])) {
    $kode = $_GET['kodeKaryawan'];
    $sql = "DELETE FROM karyawan WHERE kode = " . $kode;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterKaryawan.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Mesin
if(isset ($_GET['kodeMesin'])) {
    $kode = $_GET['kodeMesin'];
    $sql = "DELETE FROM mesin WHERE kode = " . $kode;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterMesin.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Bom
if(isset ($_GET['kodeBom'])) {
    $kodeBom = explode(".", $_GET['kodeBom']);
    $sql = "DELETE FROM bom WHERE kode_produk = ".$kodeBom[1]." AND kode_bahan_baku = ".$kodeBom[0];
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterB_O_M.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master spk
if(isset ($_GET['noSpk'])) {
    $noSpk = $_GET['noSpk'];
    $sql = "DELETE FROM spk WHERE no_spk = " . $noSpk;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterSpk.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master detail produksi
if(isset ($_GET['kodeDetailProduksi'])) {
    $kodeDetailProduksi = $_GET['kodeDetailProduksi'];
    $sql = "DELETE FROM detail_jadwal_produksi WHERE nomor=".$kodeDetailProduksi;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterDetailProduksi.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>

<?php  //delete pada master Jadwal produksi
if(isset ($_GET['kodeJadwalProduksi'])) {
    $kodeJadwalProduksi = $_GET['kodeJadwalProduksi'];
    $sql = "DELETE FROM jadwal_produksi WHERE nomor=".$kodeJadwalProduksi;
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: MasterJadwalProduksi.php");
    } else {
        die("SQL Error : " . $sql);
    }
}
?>