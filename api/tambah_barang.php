<?php

include '../koneksi.php';

header('Content-Type: application/json');

$nama_barang = $_POST['nama_barang'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$kategori = $_POST['kategori'];

$query = mysqli_query($conn,
"INSERT INTO barang VALUES(
    NULL,
    '$nama_barang',
    '$harga',
    '$jumlah',
    '$kategori',
    NOW()
)");

if($query){

    echo json_encode([
        "status" => "success",
        "message" => "Barang berhasil ditambahkan"
    ]);

} else {

    echo json_encode([
        "status" => "error"
    ]);
}
?>