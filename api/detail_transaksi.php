<?php

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
        FROM detail_transaksi
    ");

    $result = [];

    while($row = mysqli_fetch_assoc($data)){
        $result[] = $row;
    }

    echo json_encode($result);
}

elseif($method == 'POST'){

    $id_transaksi = $_POST['id_transaksi'];
    $id_barang = $_POST['id_barang'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];
    $subtotal = $_POST['subtotal'];

    mysqli_query($conn,"
        INSERT INTO detail_transaksi
        (
            id_transaksi,
            id_barang,
            qty,
            harga,
            subtotal
        )
        VALUES
        (
            '$id_transaksi',
            '$id_barang',
            '$qty',
            '$harga',
            '$subtotal'
        )
    ");

    echo json_encode([
        "status" => true,
        "message" => "Detail transaksi berhasil ditambahkan"
    ]);
}