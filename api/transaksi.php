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
        FROM transaksi
        ORDER BY tanggal DESC
    ");

    $result = [];

    while($row = mysqli_fetch_assoc($data)){
        $result[] = $row;
    }

    echo json_encode($result);
}

elseif($method == 'POST'){

    $id_user = $_POST['id_user'];
    $total = $_POST['total'];
    $metode = $_POST['metode_pembayaran'];

    mysqli_query($conn,"
        INSERT INTO transaksi
        (
            id_user,
            tanggal,
            total,
            metode_pembayaran,
            status
        )
        VALUES
        (
            '$id_user',
            NOW(),
            '$total',
            '$metode',
            'SELESAI'
        )
    ");

    echo json_encode([
        "status" => true,
        "message" => "Transaksi berhasil ditambahkan"
    ]);
}