<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$queryAktif = mysqli_query($conn,"
    SELECT COUNT(*) as total
    FROM transaksi
    WHERE status='DIPROSES'
");

$pesananAktif = mysqli_fetch_assoc($queryAktif);

$queryTransaksi = mysqli_query($conn,"
    SELECT COUNT(*) as total
    FROM transaksi
");

$dataTransaksi = mysqli_fetch_assoc($queryTransaksi);

$totalTransaksi = $dataTransaksi['total'];

$queryPendapatan = mysqli_query($conn,"
    SELECT SUM(total) as pendapatan
    FROM transaksi
");

$pendapatan = mysqli_fetch_assoc($queryPendapatan);

$queryBarangTerjual = mysqli_query($conn,"
    SELECT SUM(qty) as total
    FROM detail_transaksi
");

$barangTerjual = mysqli_fetch_assoc($queryBarangTerjual);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - Transistock</title>

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
            <a href="penjualan.php">
                Penjualan
            </a>
        </li>

        <li>
            <a href="riwayat.php">
                Riwayat
            </a>
        </li>

        <li>
            <a href="pengaturan.php">
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
        placeholder="Cari transaksi atau produk...">

    <div class="profile">
        <h4><?= $_SESSION['nama']; ?></h4>
        <p>Kasir</p>
    </div>

</div>

<div class="cards">

    <div class="card">
        <h3>Total Transaksi</h3>
        <h1><?= $totalTransaksi; ?></h1>
    </div>

    <div class="card">
        <h3>Pendapatan</h3>
        <h1>
            Rp <?= number_format($pendapatan['pendapatan'] ?? 0,0,',','.'); ?>
        </h1>
    </div>

    <div class="card">
        <h3>Barang Terjual</h3>
        <h1><?= $barangTerjual['total'] ?? 0; ?></h1>
    </div>

    <div class="card">
        <h3>Pesanan Aktif</h3>
        <h1><?= $pesananAktif['total']; ?></h1>
    </div>

</div>

<div class="activity">

    <h2>Transaksi Terbaru</h2>

    <?php

    $riwayat = mysqli_query($conn,"
        SELECT *
        FROM transaksi
        ORDER BY tanggal DESC
        LIMIT 5
    ");

    while($row = mysqli_fetch_assoc($riwayat)) :

    ?>

        <div class="activity-item">

            Transaksi #
            <?= $row['id_transaksi']; ?>

            -
            Rp <?= number_format($row['total'],0,',','.'); ?>

            (<?= $row['status']; ?>)

        </div>

    <?php endwhile; ?>

</div>
</div>
</div>
</body>
</html>