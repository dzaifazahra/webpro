<?php

/*
Endpoint Barang
Method : GET & POST
API Key : TRANSISTOCK123
*/

include '../config/koneksi.php';

header("Content-Type: application/json");

$api_key = "TRANSISTOCK123";

if(
    !isset($_GET['api_key']) ||
    $_GET['api_key'] != $api_key
){
    echo json_encode([
        "status" => false,
        "message" => "API Key tidak valid"
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){

    $data = mysqli_query($conn,"
        SELECT *
        FROM barang
    ");

    $result = [];

    while($row = mysqli_fetch_assoc($data)){
        $result[] = $row;
    }

    echo json_encode($result);
}

elseif($method == 'POST'){

    $nama_barang = $_POST['nama_barang'];
    $sku = $_POST['sku'];
    $stok = $_POST['stok'];
    $harga_jual = $_POST['harga_jual'];
    $id_kategori = $_POST['id_kategori'];

    mysqli_query($conn,"
        INSERT INTO barang
        (
            nama_barang,
            sku,
            stok,
            harga_jual,
            id_kategori
        )
        VALUES
        (
            '$nama_barang',
            '$sku',
            '$stok',
            '$harga_jual',
            '$id_kategori'
        )
    ");

    echo json_encode([
        "status" => true,
        "message" => "Barang berhasil ditambah"
    ]);
}