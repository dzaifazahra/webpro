<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
    SELECT *
    FROM transaksi
    ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>

    <link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>

<div class="container">

    <div class="sidebar">

        <h2>Transistock</h2>

        <ul>

            <li>
                <a href="dashboard_kasir.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="penjualan.php">
                    Penjualan
                </a>
            </li>

             <li>
                <a href="meja.php">
                    Manajemen Meja
                </a>
            </li>

            <li class="active">
                Riwayat
            </li>

            <li>
                <a href="pengaturan_kasir.php">
                    Pengaturan
                </a>
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
                placeholder="Cari transaksi...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Kasir</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Riwayat Transaksi</h2>
                    <p>Daftar seluruh transaksi penjualan.</p>
                </div>

            </div>

            <table class="inventory-table">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php $no = 1; ?>

                <?php while($row = mysqli_fetch_assoc($data)) : ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <?= $row['tanggal']; ?>
                    </td>

                    <td>
                        Rp <?= number_format($row['total'],0,',','.'); ?>
                    </td>

                    <td>
                        <?= $row['metode_pembayaran']; ?>
                    </td>

                    <td>

                       <?php

if($row['status'] == 'SELESAI'){
    $warna = '#d4f5df';
    $text = '#16a34a';
}
elseif($row['status'] == 'DIPROSES'){
    $warna = '#fff4cc';
    $text = '#ca8a04';
}
else{
    $warna = '#ffe0e0';
    $text = '#dc2626';
}

?>

<span
style="
background:<?= $warna ?>;
color:<?= $text ?>;
padding:8px 14px;
border-radius:20px;
font-weight:600;
">

<?= $row['status']; ?>

</span>

                    </td>

         <td>

    <a
        href="detail_transaksi.php?id=<?= $row['id_transaksi']; ?>"
        class="action-edit">
        Detail
    </a>

    <a
        href="edit_transaksi.php?id=<?= $row['id_transaksi']; ?>"
        class="action-stock">
        Edit
    </a>

    <a
        href="hapus_transaksi.php?id=<?= $row['id_transaksi']; ?>"
        class="action-delete"
        onclick="return confirm('Hapus transaksi ini?')">
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
