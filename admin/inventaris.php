<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
$data = mysqli_query($conn,"
    SELECT
        barang.*,
        kategori.nama_kategori
    FROM barang
    LEFT JOIN kategori
    ON barang.id_kategori = kategori.id_kategori
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris - Transistock</title>

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
                <a href="notifikasi.php">Notifikasi</a>
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
            <input type="text" placeholder="Cari barang...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>
        </div>

        <div class="inventory-card">

            <div class="inventory-top">
                <div>
                    <h2>Manajemen Barang</h2>
                    <p>Kelola seluruh data inventaris barang.</p>
                </div>

                <a href="tambah_barang.php" class="btn-add">
                    + Tambah Barang
                </a>
            </div>

            <table class="inventory-table">

                <thead>
                   <tr>
    <th>No</th>
    <th>   </th>
    <th>Nama Barang</th>
    <th>Kategori</th>
    <th>SKU</th>
    <th>Stok</th>
    <th>Status</th>
    <th>Harga</th>
    <th>Aksi</th>
</tr>
                </thead>

                <tbody>

                <?php $no = 1; ?>

             <?php while($row = mysqli_fetch_assoc($data)) : ?>

<?php

if($row['stok'] > 10){
    $status = "AMAN";
    $warna = "#dcfce7";
    $text = "#16a34a";
}
elseif($row['stok'] > 0){
    $status = "MENIPIS";
    $warna = "#fef3c7";
    $text = "#d97706";
}
else{
    $status = "HABIS";
    $warna = "#fee2e2";
    $text = "#dc2626";
}

?>

<tr>

<td><?= $no++; ?></td>

    <td>
        <img
            src="../uploads/<?= $row['foto']; ?>"
            width="60"
            height="60"
            style="object-fit:cover; border-radius:10px;">
    </td>

   <td><?= $row['nama_barang']; ?></td>

<td><?= $row['nama_kategori']; ?></td>

<td><?= $row['sku']; ?></td>

<td><?= $row['stok']; ?></td>

<td>

<span
style="
background:<?= $warna ?>;
color:<?= $text ?>;
padding:10px 14px;
border-radius:10px;
font-size:14px;
font-weight:500;
">
<?= $status ?>
</span>

</td>

<td>
Rp <?= number_format($row['harga_jual'],0,',','.'); ?>
</td>
    <td>

        <a href="edit_barang.php?id=<?= $row['id_barang']; ?>" class="action-edit">
            Edit
        </a>

        <a href="hapus_barang.php?id=<?= $row['id_barang']; ?>"
        class="action-delete"
        onclick="return confirm('Yakin ingin menghapus barang ini?')">
            Hapus
        </a>

        <a href="barang_masuk.php?id=<?= $row['id_barang']; ?>"
        class="action-stock">
            Barang Masuk
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