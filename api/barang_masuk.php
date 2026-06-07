<?php

include '../config/koneksi.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){

    $data = [];

    $query = mysqli_query($conn,"
        SELECT
            barang_masuk.*,
            supplier.nama_supplier,
            barang.nama_barang
        FROM barang_masuk
        LEFT JOIN supplier
        ON barang_masuk.id_supplier = supplier.id_supplier
        LEFT JOIN barang
        ON barang_masuk.id_barang = barang.id_barang
        ORDER BY barang_masuk.id_masuk DESC
    ");

    while($row = mysqli_fetch_assoc($query)){
        $data[] = $row;
    }

    echo json_encode($data);

}

elseif($method == 'POST'){

    $tanggal_masuk = $_POST['tanggal_masuk'];
    $id_supplier = $_POST['id_supplier'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];
    $catatan = $_POST['catatan'];

    mysqli_query($conn,"
        INSERT INTO barang_masuk
        (
            tanggal_masuk,
            id_supplier,
            status,
            catatan,
            id_barang,
            jumlah
        )
        VALUES
        (
            '$tanggal_masuk',
            '$id_supplier',
            '$status',
            '$catatan',
            '$id_barang',
            '$jumlah'
        )
    ");

    if($status == 'SELESAI'){

        mysqli_query($conn,"
            UPDATE barang
            SET stok = stok + $jumlah
            WHERE id_barang='$id_barang'
        ");

    }

    echo json_encode([
        "status" => true,
        "message" => "Barang masuk berhasil ditambahkan"
    ]);

}

else{

    echo json_encode([
        "status" => false,
        "message" => "Method tidak didukung"
    ]);

}

?>
