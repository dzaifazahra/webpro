<?php

session_start();
include '../koneksi.php';

$username = $_POST['username'];
$password = MD5($_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

$data = mysqli_fetch_assoc($query);

if ($data) {

    $_SESSION['login'] = true;
    $_SESSION['id'] = $data['id'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];
    mysqli_query($conn,
    "UPDATE users SET last_login = NOW() WHERE id = '".$data['id']."'");

    if ($data['role'] == 'admin') {
        header("Location: ../admin/user.php");
    }

    elseif ($data['role'] == 'kasir') {
        header("Location: ../kasir/transaksi.php");
    }

    elseif ($data['role'] == 'manager') {
        header("Location: ../manager/barang.php");
    }

} else {

    echo "
    <script>
        alert('Username atau Password salah!');
        window.location='login.php';
    </script>
    ";
}
?>