<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
    DELETE FROM meja
    WHERE id_meja='$id'
");

header("Location: meja.php");