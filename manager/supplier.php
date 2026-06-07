<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
    SELECT *
    FROM supplier
    ORDER BY id_supplier DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Data Supplier</title>

<link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

<div class="sidebar">

<h2>Transistock</h2>

<ul>

<li>
<a href="dashboard_manager.php">
Dashboard
</a>
</li>

<li class="active">
Supplier
</li>

<li>
<a href="barang_masuk.php">
Barang Masuk
</a>
</li>

<li>
<a href="performa_produk.php">
Performa Produk
</a>
</li>

<li>
<a href="performa_tim.php">
Performa Tim
</a>
</li>

<li>
<a href="riwayat_operasional.php">
Riwayat Operasional
</a>
</li>

<li>
<a href="pengaturan_manager.php">
Pengaturan
</a>
</li>

<li>
<a href="../auth/logout.php">
Logout
</a>
</li>

</ul>

</div>

<div class="main">

<div class="header">

<input
type="text"
placeholder="Cari supplier...">

<div class="profile">

<h4><?= $_SESSION['nama']; ?></h4>
<p>Manager</p>

</div>

</div>

<div class="inventory-card">

<div class="inventory-top">

<div>

<h2>Data Supplier</h2>

<p>Kelola data supplier.</p>

</div>

<a
href="tambah_supplier.php"
class="btn-add">

Tambah Supplier

</a>

</div>

<table class="inventory-table">

<thead>

<tr>

<th>No</th>
<th>Nama Supplier</th>
<th>Telepon</th>
<th>Email</th>
<th>Alamat</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php $no = 1; ?>

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_supplier']; ?></td>

<td><?= $row['telepon']; ?></td>
<td><?= $row['email']; ?></td>
<td><?= $row['alamat']; ?></td>

<td>

<a
href="edit_supplier.php?id=<?= $row['id_supplier']; ?>"
class="action-stock">

Edit

</a>

<a
href="hapus_supplier.php?id=<?= $row['id_supplier']; ?>"
class="action-delete"
onclick="return confirm('Hapus supplier ini?')">

Hapus

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>