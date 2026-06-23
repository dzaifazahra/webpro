<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    mysqli_query($conn,"
        INSERT INTO kategori
        (nama_kategori, deskripsi, status)
        VALUES
        ('$nama','$deskripsi','$status')
    ");

    header("Location: kategori.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Transistock</title>

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
          <a href="kategori.php">Kelola Kategori</a>
</li>

<li>
    <a href="riwayat_barang_masuk.php">Riwayat Stok</a>
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
                    <h2>Tambah Kategori</h2>
                    <p>Tambahkan kategori baru.</p>
                </div>
            </div>

            <form method="POST">

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text"
                           name="nama_kategori"
                           required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>

                    <select name="status">
                        <option value="AKTIF">AKTIF</option>
                        <option value="NONAKTIF">NONAKTIF</option>
                    </select>
                </div>

                <div class="button-group">

                    <a href="kategori.php" class="btn-back">
                        Kembali
                    </a>

                    <button type="submit"
                            name="simpan"
                            class="btn-add">
                        Simpan Kategori
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>