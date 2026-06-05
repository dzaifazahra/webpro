<?php
include '../koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$role = $_POST['role'];
$password = $_POST['password'];

if($password != ''){

    $password = md5($password);

    mysqli_query($conn,
    "UPDATE users SET

    nama='$nama',
    username='$username',
    password='$password',
    role='$role'

    WHERE id='$id'");

} else {

    mysqli_query($conn,
    "UPDATE users SET

    nama='$nama',
    username='$username',
    role='$role'

    WHERE id='$id'");
}

header("Location: user.php");
?>