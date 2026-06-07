<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$totalMasuk = mysqli_query($conn,
    "SELECT SUM(jumlah) AS total FROM barang_masuk"
);

$masuk = mysqli_fetch_assoc($totalMasuk);

$queryBarang = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
$dataBarang = mysqli_fetch_assoc($queryBarang);

$totalBarang = $dataBarang['total'];
$queryKategori = mysqli_query(
$conn,
"SELECT COUNT(*) as total FROM kategori"
);

$dataKategori = mysqli_fetch_assoc($queryKategori);

$totalKategori = $dataKategori['total'];

$queryStokRendah = mysqli_query(
$conn,
"SELECT COUNT(*) as total
FROM barang
WHERE stok <= 10"
);

$stokRendah = mysqli_fetch_assoc($queryStokRendah);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Transistock</title>

    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Transistock</h2>

        <ul>
            <li class="active">Dashboard</li>
            <li>
                <a href="inventaris.php">Inventaris</a>
            </li>
            <li>
                <a href="kategori.php">Kelola Kategori</a>
            </li>
           <li>
                <a href="riwayat_barang_masuk.php">
                    Riwayat Barang Masuk
                </a>
            </li>
            
            <li>
                <a href="notifikasi.php">Notifikasi</a>
            </li>
            <li>
    <a href="profil_admin.php">Profil Admin</a>
</li>

<li>
    <a href="pengaturan.php">Pengaturan</a>
</li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </div>

  
   <div class="main">

    <!-- Header -->
    <div class="header">
        <input type="text" placeholder="Cari inventaris atau transaksi...">

        <div class="profile">
            <h4><?= $_SESSION['nama']; ?></h4>
            <p>Admin Utama</p>
        </div>
    </div>

    <!-- Cards Statistik -->
    <div class="cards">

        <div class="card">
            <h3>Total Item</h3>
            <h1><?= $totalBarang ?></h1>
        </div>

        <div class="card">
            <h3>Barang Masuk</h3>
            <h1><?= $masuk['total'] ?? 0; ?></h1>
        </div>

        <div class="card">
            <h3>Total Kategori</h3>
            <h1><?= $totalKategori ?></h1>
        </div>

        <div class="card">
            <h3>Stok Rendah</h3>
            <h1><?= $stokRendah['total']; ?></h1>
        </div>

    </div>

    <div class="chart">
<h2>Ringkasan Inventaris</h2>

<table class="inventory-table">

    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
        </tr>
    </thead>

    <tbody>

    <?php

    $ringkasan = mysqli_query($conn,"
        SELECT barang.*, kategori.nama_kategori
        FROM barang
        LEFT JOIN kategori
        ON barang.id_kategori = kategori.id_kategori
        ORDER BY stok DESC
        LIMIT 5
    ");

    while($row = mysqli_fetch_assoc($ringkasan)) :

    ?>

        <tr>
            <td><?= $row['nama_barang']; ?></td>
            <td><?= $row['nama_kategori']; ?></td>
            <td>
                <span class="stock-badge">
                    <?= $row['stok']; ?>
                </span>
            </td>
        </tr>

    <?php endwhile; ?>

    </tbody>

</table>

</div>


    <!-- Aktivitas -->
    <div class="activity">

        <h2>Aktivitas Terakhir</h2>

        <?php

        $aktivitas = mysqli_query($conn,"
            SELECT bm.*, b.nama_barang
            FROM barang_masuk bm
            JOIN barang b
            ON bm.id_barang = b.id_barang
            ORDER BY bm.id_masuk DESC
            LIMIT 5
        ");

        while($row = mysqli_fetch_assoc($aktivitas)) :

        ?>

            <div class="activity-item">
                Barang Masuk:
                <?= $row['nama_barang']; ?>
                (+<?= $row['jumlah']; ?>)
            </div>

        <?php endwhile; ?>

    </div>

</div>
</div> 
</script>
</body>
</html>