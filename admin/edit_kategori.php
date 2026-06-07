<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama = $_POST['nama_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    mysqli_query($conn,"
        UPDATE kategori
        SET
        nama_kategori='$nama',
        deskripsi='$deskripsi',
        status='$status'
        WHERE id_kategori='$id'
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
    <title>Edit Kategori - Transistock</title>

    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container">

    <!-- Sidebar -->
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

    <!-- Main -->
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
                    <h2>Edit Kategori</h2>
                    <p>Perbarui data kategori barang.</p>
                </div>
            </div>

            <form method="POST">

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input
                        type="text"
                        name="nama_kategori"
                        value="<?= $row['nama_kategori']; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>

                    <textarea
                        name="deskripsi"
                        rows="4"><?= $row['deskripsi']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>

                    <select name="status">

                        <option value="AKTIF"
                            <?= ($row['status'] == 'AKTIF') ? 'selected' : ''; ?>>
                            AKTIF
                        </option>

                        <option value="NONAKTIF"
                            <?= ($row['status'] == 'NONAKTIF') ? 'selected' : ''; ?>>
                            NONAKTIF
                        </option>

                    </select>
                </div>

                <div class="button-group">

                <a href="kategori.php" class="btn-back">
                    Kembali
                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn-add">
                    Update Kategori
                </button>

            </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>