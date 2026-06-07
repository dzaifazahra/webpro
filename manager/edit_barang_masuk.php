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
        FROM barang_masuk
        WHERE id_masuk='$id'
    ")
);

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
        UPDATE barang_masuk
        SET
            tanggal_masuk='$tanggal_masuk',
            id_supplier='$id_supplier',
            id_barang='$id_barang',
            jumlah='$jumlah',
            status='$status',
            catatan='$catatan'
        WHERE id_masuk='$id'
    ");

    echo "
    <script>
        alert('Data berhasil diperbarui');
        window.location='barang_masuk.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Barang Masuk</title>

<link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>

<div class="container">

<div class="main">

<div class="inventory-card">

<div class="inventory-top">

<div>
<h2>Edit Barang Masuk</h2>
<p>Perbarui data barang masuk.</p>
</div>

</div>

<form method="POST">

<div class="form-group">

<label>Tanggal Masuk</label>

<input
type="date"
name="tanggal_masuk"
value="<?= $data['tanggal_masuk']; ?>"
required>

</div>

<div class="form-group">

<label>Supplier</label>

<select name="id_supplier">

<?php while($s = mysqli_fetch_assoc($supplier)) : ?>

<option
value="<?= $s['id_supplier']; ?>"
<?= $s['id_supplier']==$data['id_supplier'] ? 'selected' : ''; ?>>

<?= $s['nama_supplier']; ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Barang</label>

<select name="id_barang">

<?php while($b = mysqli_fetch_assoc($barang)) : ?>

<option
value="<?= $b['id_barang']; ?>"
<?= $b['id_barang']==$data['id_barang'] ? 'selected' : ''; ?>>

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
value="<?= $data['jumlah']; ?>"
required>

</div>

<div class="form-group">

<label>Status</label>

<select name="status">

<option value="DRAFT"
<?= $data['status']=='DRAFT' ? 'selected' : ''; ?>>
DRAFT
</option>

<option value="SELESAI"
<?= $data['status']=='SELESAI' ? 'selected' : ''; ?>>
SELESAI
</option>

</select>

</div>

<div class="form-group">

<label>Catatan</label>

<textarea
name="catatan"
rows="4"><?= $data['catatan']; ?></textarea>

</div>

<button
type="submit"
name="simpan"
class="btn-save">

Simpan Perubahan

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