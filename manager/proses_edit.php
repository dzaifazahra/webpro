<?php

include '../koneksi.php';

$id = $_POST['id'];
$nama_barang = $_POST['nama_barang'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$kategori = $_POST['kategori'];

mysqli_query($conn, "UPDATE barang SET

nama_barang='$nama_barang',
harga='$harga',
jumlah='$jumlah',
kategori='$kategori'

WHERE id='$id'
");

header("Location: barang.php");
?>