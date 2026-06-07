<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
    SELECT
        barang_masuk.*,
        supplier.nama_supplier,
        barang.nama_barang
    FROM barang_masuk
    LEFT JOIN supplier
    ON barang_masuk.id_supplier = supplier.id_supplier
    LEFT JOIN barang
    ON barang_masuk.id_barang = barang.id_barang
    ORDER BY barang_masuk.tanggal_masuk DESC
");
?>

<!DOCTYPE html>

<html>
<head>

<meta charset="UTF-8">
<title>Riwayat Operasional</title>

<link rel="stylesheet" href="../admin/dashboard.css">


</head>
<body>

<div class="container">

<div class="sidebar">

    <h2>Transistock</h2>

    <ul>

        <li>
            <a href="dashboard_manager.php">
                Dashboard
            </a>
        </li>

        <li>
            <a href="supplier.php">
                Supplier
            </a>
        </li>

        <li>
            <a href="barang_masuk.php">
                Barang Masuk
            </a>
        </li>

        <li>
            <a href="performa_produk.php">
                Performa Produk
            </a>
        </li>

        <li>
            <a href="performa_tim.php">
                Performa Tim
            </a>
        </li>

        <li class="active">
            Riwayat Operasional
        </li>

        <li>
            <a href="pengaturan_manager.php">
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
            placeholder="Cari aktivitas operasional...">

        <div class="profile">

            <h4><?= $_SESSION['nama']; ?></h4>

            <p>Manager</p>

        </div>

    </div>

    <div class="inventory-card">

        <div class="inventory-top">

            <div>

                <h2>Riwayat Operasional</h2>

                <p>
                    Riwayat aktivitas barang masuk dari supplier.
                </p>

            </div>

        </div>

        <table class="inventory-table">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Catatan</th>

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
                        <?= $row['nama_supplier']; ?>
                    </td>

                    <td>
                        <?= $row['nama_barang']; ?>
                    </td>

                    <td>
                        <?= $row['jumlah']; ?>
                    </td>

                    <td>

                        <?php

                        if($row['status'] == 'SELESAI'){
                            $warna = '#dcfce7';
                            $text = '#16a34a';
                        }
                        else{
                            $warna = '#fef3c7';
                            $text = '#ca8a04';
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
                        <?= $row['catatan']; ?>
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
