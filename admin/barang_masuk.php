<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn,
    "SELECT * FROM barang WHERE id_barang='$id'"
);

$barang = mysqli_fetch_assoc($data);

if(isset($_POST['simpan'])){

    $jumlah = $_POST['jumlah'];
    $tanggal = date('Y-m-d');

    mysqli_query($conn,"
        INSERT INTO barang_masuk
        (tanggal_masuk,id_barang,jumlah,status)
        VALUES
        (
            '$tanggal',
            '$id',
            '$jumlah',
            'SELESAI'
        )
    ");

    mysqli_query($conn,"
        UPDATE barang
        SET stok = stok + $jumlah
        WHERE id_barang='$id'
    ");

    header("Location: inventaris.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Barang Masuk</title>
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
            <a href="riwayat_barang_masuk.php">
                Riwayat Barang Masuk
            </a>
        </li>

        <li>
            <a href="kategori.php">
                Kelola Kategori
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

            <input type="text" placeholder="Cari barang...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">
                <div>
                    <h2>Barang Masuk</h2>
                    <p>Tambah stok barang ke inventaris.</p>
                </div>
            </div>

            <form method="POST">

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input
                        type="text"
                        value="<?= $barang['nama_barang']; ?>"
                        readonly>
                </div>

                <div class="form-group">
                    <label>Stok Saat Ini</label>
                    <input
                        type="text"
                        value="<?= $barang['stok']; ?>"
                        readonly>
                </div>

                <div class="form-group">
                    <label>Jumlah Barang Masuk</label>
                    <input
                        type="number"
                        name="jumlah"
                        required>
                </div>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-save">

                    Simpan Barang Masuk

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>