<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$cek = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total
     FROM barang
     WHERE id_kategori='$id'"
);

$data = mysqli_fetch_assoc($cek);

if($data['total'] > 0){
    echo "
    <script>
        alert('Kategori masih digunakan oleh barang!');
        window.location='kategori.php';
    </script>
    ";
    exit;
}

mysqli_query(
    $conn,
    "DELETE FROM kategori
     WHERE id_kategori='$id'"
);

header("Location: kategori.php");
exit;