<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
    SELECT barang_masuk.*,
           barang.nama_barang,
           barang.foto
    FROM barang_masuk
    LEFT JOIN barang
    ON barang_masuk.id_barang = barang.id_barang
    ORDER BY tanggal_masuk DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok</title>

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

            <li>
                <a href="inventaris.php">Inventaris</a>
            </li>

            <li>
                <a href="kategori.php">
                    Kelola Kategori
                </a>
            </li>


           <li class="active">
    <a href="riwayat_barang_masuk.php">
        Riwayat Stok
    </a>
</li>
            
         <li>
    <a href="notifikasi.php">
        Notifikasi
    </a>
</li>
           <li>
    <a href="profil_admin.php">Profil Admin</a>
</li>

<li>
    <a href="pengaturan.php">Pengaturan</a>
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
                placeholder="Cari riwayat stok...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Riwayat Stok</h2>
                    <p>Daftar seluruh aktivitas keluar masuk barang.</p>
                </div>

            </div>

            <table class="inventory-table">

                <thead>

                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Aktivitas</th>
                        <th>Jumlah</th>
                    </tr>

                </thead>

                <tbody>

                <?php $no = 1; ?>

                <?php while($row = mysqli_fetch_assoc($data)) : ?>

                 <tr>
<td><?= $row['tanggal_masuk']; ?></td>

<td>
    <div class="barang-info">

        <img
            src="../uploads/<?= $row['foto']; ?>"
            class="table-photo">

        <span>
            <?= $row['nama_barang']; ?>
        </span>

    </div>
</td>

<td>
    <span class="status-active">
        🟢 Barang Masuk
    </span>
</td>

<td>
    <span class="stock-badge">
        +<?= $row['jumlah']; ?>
    </span>
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