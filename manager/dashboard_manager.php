<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$totalSupplier = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM supplier
    ")
);

$totalBarangMasuk = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM barang_masuk
    ")
);

$totalBarang = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM barang
    ")
);

$stokMenipis = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM barang
        WHERE stok <= 10
    ")
);

$aktivitas = mysqli_query($conn,"
    SELECT
        barang_masuk.*,
        supplier.nama_supplier,
        barang.nama_barang
    FROM barang_masuk
    LEFT JOIN supplier
    ON barang_masuk.id_supplier = supplier.id_supplier
    LEFT JOIN barang
    ON barang_masuk.id_barang = barang.id_barang
    ORDER BY tanggal_masuk DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Dashboard Manager</title>

<link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

<div class="sidebar">

<h2>Transistock</h2>

<ul>

<li class="active">
Dashboard
</li>

<li>
<a href="supplier.php">
Supplier
</a>
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
placeholder="Cari laporan...">

<div class="profile">

<h4><?= $_SESSION['nama']; ?></h4>

<p>Manager</p>

</div>

</div>

<div class="cards">

<div class="card">

<h3>Total Supplier</h3>

<h1>
<?= $totalSupplier['total']; ?>
</h1>

</div>

<div class="card">

<h3>Barang Masuk</h3>

<h1>
<?= $totalBarangMasuk['total']; ?>
</h1>

</div>

<div class="card">

<h3>Total Barang</h3>

<h1>
<?= $totalBarang['total']; ?>
</h1>

</div>

<div class="card">

<h3>Stok Menipis</h3>

<h1>
<?= $stokMenipis['total']; ?>
</h1>

</div>

</div>

<div class="inventory-card">

<div class="inventory-top">

<div>

<h2>Aktivitas Barang Masuk</h2>

<p>5 aktivitas terbaru.</p>

</div>

</div>

<table class="inventory-table">

<thead>

<tr>

<th>ID</th>
<th>Tanggal</th>
<th>Supplier</th>
<th>Barang</th>
<th>Jumlah</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($aktivitas)) : ?>

<tr>

<td><?= $row['id_masuk']; ?></td>

<td><?= $row['tanggal_masuk']; ?></td>

<td><?= $row['nama_supplier']; ?></td>

<td><?= $row['nama_barang']; ?></td>

<td><?= $row['jumlah']; ?></td>

<td><?= $row['status']; ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>