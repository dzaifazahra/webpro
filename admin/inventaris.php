<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
$data = mysqli_query($conn,"
    SELECT
        barang.*,
        kategori.nama_kategori
    FROM barang
    LEFT JOIN kategori
    ON barang.id_kategori = kategori.id_kategori
    WHERE barang.status = 'aktif'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris - Transistock</title>

    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container">

    <div class="sidebar">
        <h2>Transistock</h2>

        <ul>
            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>

            <li class="active">
                <a href="inventaris.php">Inventaris</a>
            </li>

           <li>
    <a href="kategori.php">Kelola Kategori</a>
</li>

<li>
    <a href="riwayat_barang_masuk.php">Riwayat Stok</a>
</li>
            <li>
                <a href="notifikasi.php">Notifikasi</a>
            </li>
         <li>
    <a href="profil_admin.php">Profil Admin</a>
</li>

<li>
    <a href="pengaturan.php">Pengaturan</a>
</li>

            <li>
                <a href="../auth/logout.php">Logout</a>
            </li>
        </ul>
    </div>

    <div class="main">

        <div class="header">
            <input type="text" placeholder="Cari barang...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>
        </div>

        <div class="inventory-card">

            <div class="inventory-top">
                <div>
                    <h2>Manajemen Barang</h2>
                    <p>Kelola seluruh data inventaris barang.</p>
                </div>

                <a href="tambah_barang.php" class="btn-add">
                    + Tambah Barang
                </a>
            </div>

 <div class="product-list">

<?php $no = 1; ?>

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<?php

if($row['stok'] > 10){
    $status = "🟢 Aman";
    $warna = "#16a34a";
}
elseif($row['stok'] > 0){
    $status = "🟡 Menipis";
    $warna = "#d97706";
}
else{
    $status = "🔴 Habis";
    $warna = "#dc2626";
}

?>

<div class="product-card">

    <img
        src="../uploads/<?= $row['foto']; ?>"
        class="product-image">

    <div class="product-info">

        <h3><?= $row['nama_barang']; ?></h3>

        <p class="product-detail">
            <?= $row['nama_kategori']; ?> • <?= $row['sku']; ?>
        </p>
  <div class="product-price">
            Rp <?= number_format($row['harga_jual'],0,',','.'); ?>
        </div>

        <div class="product-meta">
    <span>Stok : <?= $row['stok']; ?></span>
</div>
<div class="product-footer">

    <div class="product-action">

        <a href="edit_barang.php?id=<?= $row['id_barang']; ?>"
        class="action-edit">
            Edit
        </a>

        <a href="hapus_barang.php?id=<?= $row['id_barang']; ?>"
        class="action-delete"
        onclick="return confirm('Yakin ingin menghapus barang ini?')">
            Hapus
        </a>

    </div>

    <span class="product-status"
    style="color:<?= $warna ?>;">
        <?= $status ?>
    </span>

</div>
</div>
</div>

<?php endwhile; ?>

</div>
        </div>

    </div>

</div>

</body>
</html>