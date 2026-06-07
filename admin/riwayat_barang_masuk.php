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
    <title>Riwayat Barang Masuk</title>

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
                    Riwayat Barang Masuk
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
                placeholder="Cari riwayat barang masuk...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Riwayat Barang Masuk</h2>
                    <p>Daftar seluruh transaksi barang masuk.</p>
                </div>

            </div>

            <table class="inventory-table">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                         <th>    </th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php $no = 1; ?>

                <?php while($row = mysqli_fetch_assoc($data)) : ?>

                 <tr>

    <td><?= $no++; ?></td>

    <td>
        <?= $row['tanggal_masuk']; ?>
    </td>

    <td>
        <img
            src="../uploads/<?= $row['foto']; ?>"
            width="60"
            height="60"
            style="object-fit:cover; border-radius:10px;">
    </td>

    <td>
        <?= $row['nama_barang']; ?>
    </td>

    <td>
        <span class="stock-badge">
            +<?= $row['jumlah']; ?>
        </span>
    </td>

    <td>
        <span class="stock-badge">
            <?= $row['status']; ?>
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