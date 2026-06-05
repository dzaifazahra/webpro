<?php
include '../koneksi.php';
include '../auth/cek_login.php';

$id = $_GET['id'];

$data = mysqli_query($conn,
        "SELECT * FROM barang WHERE id='$id'");

$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>

<h2>Edit Barang</h2>

<form action="proses_edit.php" method="POST">

    <input type="hidden"
           name="id"
           value="<?= $row['id']; ?>">

    <input type="text"
           name="nama_barang"
           value="<?= $row['nama_barang']; ?>">

    <br><br>

    <input type="number"
           name="harga"
           value="<?= $row['harga']; ?>">

    <br><br>

    <input type="number"
           name="jumlah"
           value="<?= $row['jumlah']; ?>">

    <br><br>

    <input type="text"
           name="kategori"
           value="<?= $row['kategori']; ?>">

    <br><br>

    <button type="submit">
        Update
    </button>

</form>

</body>
</html>