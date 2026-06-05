<?php

include '../koneksi.php';

header('Content-Type: application/json');

$id = $_POST['id'];
$nama_barang = $_POST['nama_barang'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$kategori = $_POST['kategori'];

$query = mysqli_query($conn,
"UPDATE barang SET

nama_barang='$nama_barang',
harga='$harga',
jumlah='$jumlah',
kategori='$kategori'

WHERE id='$id'
");

if($query){

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "error"
    ]);
}
?>