<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
$dataKategori = mysqli_query(
    $conn,
    "SELECT * FROM kategori WHERE status='AKTIF'"
);

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id'");
$barang = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama_barang = $_POST['nama_barang'];
    $sku = $_POST['sku'];
    $stok = $_POST['stok'];
    $harga_jual = $_POST['harga_jual'];
    $id_kategori = $_POST['id_kategori'];

    $query = mysqli_query($conn,"
       UPDATE barang
    SET
        nama_barang='$nama_barang',
        sku='$sku',
        stok='$stok',
        harga_jual='$harga_jual',
        id_kategori='$id_kategori'
    WHERE id_barang='$id'
    ");

    if($query){
        header("Location: inventaris.php");
        exit;
    }else{
        echo "Gagal mengupdate data";
    }
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>

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
        <h2>Edit Barang</h2>

        <div class="profile">
            <h4><?= $_SESSION['nama']; ?></h4>
            <p>Admin Utama</p>
        </div>
    </div>

    <div class="inventory-card">

        <form method="POST">

            <div class="form-group">
                <label>Nama Barang</label>
                <input
                    type="text"
                    name="nama_barang"
                    value="<?= $barang['nama_barang']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label>SKU</label>
                <input
                    type="text"
                    name="sku"
                    value="<?= $barang['sku']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Kategori</label>

                <select name="id_kategori" required>

                    <?php while($kategori = mysqli_fetch_assoc($dataKategori)) : ?>

                        <option
                            value="<?= $kategori['id_kategori']; ?>"
                            <?= ($barang['id_kategori'] == $kategori['id_kategori']) ? 'selected' : ''; ?>>

                            <?= $kategori['nama_kategori']; ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="form-group">
                <label>Stok</label>
                <input
                    type="number"
                    name="stok"
                    value="<?= $barang['stok']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Harga Jual</label>
                <input
                    type="number"
                    name="harga_jual"
                    value="<?= $barang['harga_jual']; ?>"
                    required>
            </div>

            <button type="submit" name="update" class="btn-save">
                Update Barang
            </button>

        </form>

    </div>

</div>

</div>

</body>
</html>
