<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$supplier = mysqli_query($conn,"
    SELECT *
    FROM supplier
    ORDER BY nama_supplier
");

$barang = mysqli_query($conn,"
    SELECT *
    FROM barang
    ORDER BY nama_barang
");

if(isset($_POST['simpan'])){

    $tanggal_masuk = $_POST['tanggal_masuk'];
    $id_supplier = $_POST['id_supplier'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];
    $catatan = $_POST['catatan'];

    mysqli_query($conn,"
        INSERT INTO barang_masuk
        (
            tanggal_masuk,
            id_supplier,
            status,
            catatan,
            id_barang,
            jumlah
        )
        VALUES
        (
            '$tanggal_masuk',
            '$id_supplier',
            '$status',
            '$catatan',
            '$id_barang',
            '$jumlah'
        )
    ");

    if($status == 'SELESAI'){

        mysqli_query($conn,"
            UPDATE barang
            SET stok = stok + $jumlah
            WHERE id_barang='$id_barang'
        ");

    }

    echo "
    <script>
        alert('Barang masuk berhasil ditambahkan');
        window.location='barang_masuk.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Tambah Barang Masuk</title>

<link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

<div class="main">

<div class="inventory-card">

<div class="inventory-top">

<div>
<h2>Tambah Barang Masuk</h2>
<p>Input data barang masuk.</p>
</div>

</div>

<form method="POST">

<div class="form-group">

<label>Tanggal Masuk</label>

<input
type="date"
name="tanggal_masuk"
required>

</div>

<div class="form-group">

<label>Supplier</label>

<select name="id_supplier">

<?php while($s = mysqli_fetch_assoc($supplier)) : ?>

<option value="<?= $s['id_supplier']; ?>">

<?= $s['nama_supplier']; ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Barang</label>

<select name="id_barang">

<?php while($b = mysqli_fetch_assoc($barang)) : ?>

<option value="<?= $b['id_barang']; ?>">

<?= $b['nama_barang']; ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Jumlah</label>

<input
type="number"
name="jumlah"
required>

</div>

<div class="form-group">

<label>Status</label>

<select name="status">

<option value="DRAFT">
DRAFT
</option>

<option value="SELESAI">
SELESAI
</option>

</select>

</div>

<div class="form-group">

<label>Catatan</label>

<textarea
name="catatan"
rows="4"></textarea>

</div>

<button
type="submit"
name="simpan"
class="btn-save">

Simpan

</button>

<a
href="barang_masuk.php"
class="btn-back">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>