<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container">

    <div class="sidebar">
        <h2>Transistock</h2>

        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="inventaris.php">Inventaris</a></li>
             <li class="active">
                <a href="kategori.php">Kelola Kategori</a>
            </li>
           <li>
    <a href="riwayat_barang_masuk.php">Riwayat Barang Masuk</a>
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
                <a href="../auth/logout.php">Logout</a>
            </li>
        </ul>
    </div>

    <div class="main">

        <div class="header">
            <input type="text" placeholder="Cari kategori...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>
        </div>

        <div class="inventory-card">

            <div class="inventory-top">
                <div>
                    <h2>Kelola Kategori</h2>
                    <p>Kelola seluruh kategori barang.</p>
                </div>

                <a href="tambah_kategori.php" class="btn-add">
                    + Tambah Kategori
                </a>
            </div>

            <table class="inventory-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php $no = 1; ?>

                <?php while($row = mysqli_fetch_assoc($data)) : ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['nama_kategori']; ?></td>

                        <td><?= $row['deskripsi']; ?></td>

                        <td>

                        <?php if($row['status'] == 'AKTIF') : ?>

                            <span class="status-active">
                                AKTIF
                            </span>

                        <?php else : ?>

                            <span class="status-inactive">
                                NONAKTIF
                            </span>

                        <?php endif; ?>

                        </td>

                        <td>

                            <a href="edit_kategori.php?id=<?= $row['id_kategori']; ?>"
                            class="action-edit">
                            Edit
                            </a>

                        <a href="hapus_kategori.php?id=<?= $row['id_kategori']; ?>"
                        class="action-delete"
                        onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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