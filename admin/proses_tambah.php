<?php
include '../koneksi.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$role = $_POST['role'];

mysqli_query($conn,
"INSERT INTO users(
    nama,
    username,
    password,
    role
)

VALUES(
    '$nama',
    '$username',
    '$password',
    '$role'
)");

header("Location: user.php");
?>