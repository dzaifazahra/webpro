<?php

include '../koneksi.php';

$nama_barang = $_POST['nama_barang'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$kategori = $_POST['kategori'];

mysqli_query($conn, "INSERT INTO barang
VALUES(
    NULL,
    '$nama_barang',
    '$harga',
    '$jumlah',
    '$kategori',
    NOW()
)");

header("Location: barang.php");
?>