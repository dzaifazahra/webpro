<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT *
        FROM supplier
        WHERE id_supplier='$id'
    ")
);

if(isset($_POST['simpan'])){

    $nama_supplier = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];

    mysqli_query($conn,"
        UPDATE supplier
        SET
            nama_supplier='$nama_supplier',
            telepon='$telepon',
            email='$email',
            alamat='$alamat'
        WHERE id_supplier='$id'
    ");

    echo "
    <script>
        alert('Supplier berhasil diperbarui');
        window.location='supplier.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Edit Supplier</title>

<link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

<div class="main">

<div class="inventory-card">

<div class="inventory-top">

<div>

<h2>Edit Supplier</h2>

<p>Perbarui data supplier.</p>

</div>

</div>

<form method="POST">

<div class="form-group">

<label>Nama Supplier</label>

<input
type="text"
name="nama_supplier"
value="<?= $data['nama_supplier']; ?>"
required>

</div>

<div class="form-group">

<label>Telepon</label>

<input
type="text"
name="telepon"
value="<?= $data['telepon']; ?>">

</div>

<div class="form-group">

<label>Email</label>

<input
type="email"
name="email"
value="<?= $data['email']; ?>">

</div>

<div class="form-group">

<label>Alamat</label>

<textarea
name="alamat"
rows="4"><?= $data['alamat']; ?></textarea>

</div>

<button
type="submit"
name="simpan"
class="btn-save">

Simpan Perubahan

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