<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama_supplier = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];

    mysqli_query($conn,"
        INSERT INTO supplier
        (
            nama_supplier,
            telepon,
            email,
            alamat
        )
        VALUES
        (
            '$nama_supplier',
            '$telepon',
            '$email',
            '$alamat'
        )
    ");

    echo "
    <script>
        alert('Supplier berhasil ditambahkan');
        window.location='supplier.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Tambah Supplier</title>

<link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

<div class="main">

<div class="inventory-card">

<div class="inventory-top">

<div>

<h2>Tambah Supplier</h2>

<p>Tambahkan supplier baru.</p>

</div>

</div>

<form method="POST">

<div class="form-group">

<label>Nama Supplier</label>

<input
type="text"
name="nama_supplier"
required>

</div>

<div class="form-group">

<label>Telepon</label>

<input
type="text"
name="telepon">

</div>

<div class="form-group">

<label>Email</label>

<input
type="email"
name="email">

</div>

<div class="form-group">

<label>Alamat</label>

<textarea
name="alamat"
rows="4"></textarea>

</div>

<button
type="submit"
name="simpan"
class="btn-save">

Simpan

</button>

<a
href="supplier.php"
class="btn-back">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>