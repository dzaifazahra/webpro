<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "webpro"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>