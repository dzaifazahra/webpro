<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
    DELETE FROM detail_transaksi
    WHERE id_detail='$id'
");

header("Location: riwayat.php");