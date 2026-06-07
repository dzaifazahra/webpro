<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
    SELECT
        barang.nama_barang,
        barang.stok,
        SUM(detail_transaksi.qty) as total_terjual
    FROM barang
    LEFT JOIN detail_transaksi
    ON barang.id_barang = detail_transaksi.id_barang
    GROUP BY barang.id_barang
    ORDER BY total_terjual DESC
");
?>

<!DOCTYPE html>

<html>
<head>

<meta charset="UTF-8">
<title>Performa Produk</title>

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

        <li class="active">
            Performa Produk
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
            placeholder="Cari data produk...">

        <div class="profile">

            <h4><?= $_SESSION['nama']; ?></h4>

            <p>Manager</p>

        </div>

    </div>

    <div class="inventory-card">

        <div class="inventory-top">

            <div>

                <h2>Performa Produk</h2>

                <p>
                    Analisis produk berdasarkan jumlah penjualan.
                </p>

            </div>

        </div>

        <table class="inventory-table">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Total Terjual</th>
                    <th>Stok Saat Ini</th>

                </tr>

            </thead>

            <tbody>

            <?php $no = 1; ?>

            <?php while($row = mysqli_fetch_assoc($data)) : ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <?= $row['nama_barang']; ?>
                    </td>

                    <td>
                        <?= $row['total_terjual'] ?? 0; ?>
                    </td>

                    <td>
                        <?= $row['stok']; ?>
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
