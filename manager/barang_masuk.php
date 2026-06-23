<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
SELECT
barang_masuk.*,
supplier.nama_supplier,
barang.nama_barang
FROM barang_masuk
LEFT JOIN supplier
ON barang_masuk.id_supplier = supplier.id_supplier
LEFT JOIN barang
ON barang_masuk.id_barang = barang.id_barang
ORDER BY barang_masuk.id_masuk DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Barang Masuk</title>
<link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>

<div class="container">

<div class="sidebar">

<h2>Transistock</h2>

<ul>

<li>
<a href="dashboard_manager.php">Dashboard</a>
</li>

<li>
<a href="supplier.php">Supplier</a>
</li>

<li class="active">
Barang Masuk
</li>

<li>
<a href="performa_produk.php">Performa Produk</a>
</li>

<li>
<a href="performa_tim.php">Performa Tim</a>
</li>

<li>
<a href="riwayat_operasional.php">Riwayat Operasional</a>
</li>

<li>
<a href="pengaturan_manager.php">Pengaturan</a>
</li>

<li>
<a href="../auth/logout.php">Logout</a>
</li>

</ul>

</div>

<div class="main">

<div class="header">

<input type="text" placeholder="Cari barang masuk...">

<div class="profile">
<h4><?= $_SESSION['nama']; ?></h4>
<p>Manager</p>
</div>

</div>

<div class="inventory-card">

<div class="inventory-top">

<div>
<h2>Barang Masuk</h2>
<p>Kelola data barang masuk.</p>
</div>

<a href="tambah" class="btn-add">
Tambah Barang Masuk
</a>

</div>

<table class="inventory-table">

<thead>

<tr>

<th>No</th>
<th>Tanggal</th>
<th>Supplier</th>
<th>Barang</th>
<th>Jumlah</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php $no=1; ?>

<?php while($row=mysqli_fetch_assoc($data)) : ?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['tanggal_masuk']; ?></td>

<td><?= $row['nama_supplier']; ?></td>

<td><?= $row['nama_barang']; ?></td>

<td><?= $row['jumlah']; ?></td>

<td><?= $row['status']; ?></td>

<td>

<a
href="edit_barang_masuk.php?id=<?= $row['id_masuk']; ?>"
class="action-stock">

Edit

</a>

<a
href="hapus_barang_masuk.php?id=<?= $row['id_masuk']; ?>"
class="action-delete"
onclick="return confirm('Hapus data ini?')">

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