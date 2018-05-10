<?php  
session_start();
require './db.php';

//Update pada master Customer
if(isset ($_GET['kodeCustomer'])) {
    $_SESSION['kodeCustomer'] = $_GET['kodeCustomer'];
    header("Location: MasterCustomer.php");
}

//Update pada master Supplier
if(isset ($_GET['kodeSupplier'])) {
    $_SESSION['kodeSupplier'] = $_GET['kodeSupplier'];
    header("Location: MasterSupplier.php");
}

//Update pada master Produk
if(isset ($_GET['kodeProduk'])) {
    $_SESSION['kodeProduk'] = $_GET['kodeProduk'];
    header("Location: MasterProduk.php");
}

//Update pada master Bahan Baku
if(isset ($_GET['kodeBahanBaku'])) {
    $_SESSION['kodeBahanBaku'] = $_GET['kodeBahanBaku'];
    header("Location: MasterBahanBaku.php");
}

//Update pada master Karyawan
if(isset ($_GET['kodeKaryawan'])) {
    $_SESSION['kodeKaryawan'] = $_GET['kodeKaryawan'];
    header("Location: MasterKaryawan.php");
}

//Update pada master Mesin
if(isset ($_GET['kodeMesin'])) {
    $_SESSION['kodeMesin'] = $_GET['kodeMesin'];
    header("Location: MasterMesin.php");
}

//Update pada master Bom
if(isset ($_GET['kodeBom'])) {
    $_SESSION['kodeBom'] = $_GET['kodeBom'];
    header("Location: MasterB_O_M.php");
}

//Update pada master SPK
if(isset ($_GET['noSpk'])) {
    $_SESSION['noSpk'] = $_GET['noSpk'];
    header("Location: MasterSpk.php");
}

//Update pada master Detail Produksi
if(isset ($_GET['kodeDetailProduksi'])) {
    $_SESSION['kodeDetailProduksi'] = $_GET['kodeDetailProduksi'];
    header("Location: MasterDetailProduksi.php");
}

//Update pada master Jadwal Produksi
if(isset ($_GET['kodeJadwalProduksi'])) {
    $_SESSION['kodeJadwalProduksi'] = $_GET['kodeJadwalProduksi'];
    header("Location: MasterJadwalProduksi.php");
}


?>