<?php

/*
Endpoint Kategori
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
        FROM kategori
    ");

    $result = [];

    while($row = mysqli_fetch_assoc($data)){
        $result[] = $row;
    }

    echo json_encode($result);
}

elseif($method == 'POST'){

    $nama_kategori = $_POST['nama_kategori'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn,"
        INSERT INTO kategori
        (
            nama_kategori,
            deskripsi,
            status
        )
        VALUES
        (
            '$nama_kategori',
            '$deskripsi',
            'AKTIF'
        )
    ");

    echo json_encode([
        "status" => true,
        "message" => "Kategori berhasil ditambah"
    ]);
}