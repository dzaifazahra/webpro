<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
    DELETE FROM detail_transaksi
    WHERE id_transaksi='$id'
");

mysqli_query($conn,"
    DELETE FROM transaksi
    WHERE id_transaksi='$id'
");

header("Location: riwayat.php");