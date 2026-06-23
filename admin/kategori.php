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
                    <h2>Kelola Kategori</h2>
                    <p>Kelola seluruh kategori barang.</p>
                </div>

                <a href="tambah_kategori.php" class="btn-add">
                    + Tambah Kategori
                </a>
            </div>
<div class="kategori-list">

<?php while($row = mysqli_fetch_assoc($data)) : ?>
<?php

$gambar = "default.png";

if($row['nama_kategori'] == "Minuman"){
    $gambar = "minuman.png";
}
elseif($row['nama_kategori'] == "Makanan"){
    $gambar = "makanan.png";
}
elseif($row['nama_kategori'] == "Snack"){
    $gambar = "snack.png";
}
elseif($row['nama_kategori'] == "ATK"){
    $gambar = "atk.png";
}

?>

<div class="product-card">

    <div class="product-info">

       <img
    src="../uploads/<?= $gambar; ?>"
    class="kategori-image">
    <h3><?= $row['nama_kategori']; ?></h3>

        <p class="product-detail">
            <?= $row['deskripsi']; ?>
        </p>

        <div class="product-footer">

            <div class="product-action">

                <a href="edit_kategori.php?id=<?= $row['id_kategori']; ?>"
                class="action-edit">
                    Edit
                </a>

                <a href="hapus_kategori.php?id=<?= $row['id_kategori']; ?>"
                class="action-delete"
                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                    Hapus
                </a>

            </div>

            <?php if($row['status'] == 'AKTIF') : ?>

                <span class="product-status" style="color:#16a34a;">
                    🟢 Aktif
                </span>

            <?php else : ?>

                <span class="product-status" style="color:#dc2626;">
                    🔴 Nonaktif
                </span>

            <?php endif; ?>

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