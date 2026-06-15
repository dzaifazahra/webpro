<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $conn,
    "UPDATE barang
     SET status='aktif'
     WHERE id_barang='$id'"
);

header("Location: barang_nonaktif.php");
exit;

?>