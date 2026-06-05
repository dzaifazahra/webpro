<?php

include '../koneksi.php';

header('Content-Type: application/json');

$id = $_GET['id'];

$query = mysqli_query($conn,
"DELETE FROM barang
WHERE id='$id'");

if($query){

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "error"
    ]);
}
?>