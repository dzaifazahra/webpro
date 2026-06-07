<?php

include '../config/koneksi.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){

    $data = [];

    $query = mysqli_query($conn,"
        SELECT *
        FROM supplier
        ORDER BY id_supplier DESC
    ");

    while($row = mysqli_fetch_assoc($query)){
        $data[] = $row;
    }

    echo json_encode($data);

}

elseif($method == 'POST'){

    $nama_supplier = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn,"
        INSERT INTO supplier
        (
            nama_supplier,
            telepon,
            email,
            alamat
        )
        VALUES
        (
            '$nama_supplier',
            '$telepon',
            '$email',
            '$alamat'
        )
    ");

    echo json_encode([
        "status" => true,
        "message" => "Supplier berhasil ditambahkan"
    ]);

}

else{

    echo json_encode([
        "status" => false,
        "message" => "Method tidak didukung"
    ]);

}

?>
