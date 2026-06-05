<?php

include '../koneksi.php';

header('Content-Type: application/json');

$data = mysqli_query($conn,
        "SELECT * FROM barang
         ORDER BY id DESC");

$result = [];

while($row = mysqli_fetch_assoc($data)){

    $result[] = $row;
}

echo json_encode($result);
?>