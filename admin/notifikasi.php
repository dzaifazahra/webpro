<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$stokRendah = mysqli_query($conn,"
    SELECT *
    FROM barang
    WHERE stok <= 10
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notifikasi</title>

<link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container">

    <div class="sidebar">

        <h2>Transistock</h2>

        <ul>

            <li><a href="dashboard.php">Dashboard</a></li>

            <li><a href="inventaris.php">Inventaris</a></li>
             <li>
                <a href="kategori.php">
                    Kelola Kategori
                </a>
            </li>
            <li>
                <a href="riwayat_barang_masuk.php">
                    Riwayat Barang Masuk
                </a>
            </li>


            <li class="active">
                <a href="notifikasi.php">
                    Notifikasi
                </a>
            </li>

            <li>
                <a href="profil_admin.php">
                    Profil Admin
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
                placeholder="Cari notifikasi...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Notifikasi</h2>
                    <p>Peringatan stok dan aktivitas sistem.</p>
                </div>

            </div>

            <?php while($row = mysqli_fetch_assoc($stokRendah)) : ?>

                <div class="activity-item">

                    ⚠️ Stok barang
                    <b><?= $row['nama_barang']; ?></b>
                    tersisa
                    <b><?= $row['stok']; ?></b>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

</div>

</body>
</html>