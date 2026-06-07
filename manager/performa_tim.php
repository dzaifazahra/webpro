<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query($conn,"
    SELECT *
    FROM users
    ORDER BY role ASC, nama ASC
");
?>

<!DOCTYPE html>

<html>
<head>

<meta charset="UTF-8">
<title>Performa Tim</title>

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

        <li class="active">
            Performa Tim
        </li>

        <li>
            <a href="riwayat_operasional.php">
                Riwayat Operasional
            </a>
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
            placeholder="Cari staff atau aktivitas...">

        <div class="profile">

            <h4><?= $_SESSION['nama']; ?></h4>

            <p>Manager</p>

        </div>

    </div>

    <div class="inventory-card">

        <div class="inventory-top">

            <div>

                <h2>Performa Tim</h2>

                <p>
                    Monitoring pengguna dan role dalam sistem.
                </p>

            </div>

        </div>

        <table class="inventory-table">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>

                </tr>

            </thead>

            <tbody>

            <?php $no = 1; ?>

            <?php while($row = mysqli_fetch_assoc($data)) : ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <?= $row['nama']; ?>
                    </td>

                    <td>
                        <?= $row['email']; ?>
                    </td>

                    <td>

                        <?php

                        if($row['role'] == 'admin'){
                            $warna = '#dbeafe';
                            $text = '#2563eb';
                        }
                        elseif($row['role'] == 'manager'){
                            $warna = '#f3e8ff';
                            $text = '#9333ea';
                        }
                        else{
                            $warna = '#dcfce7';
                            $text = '#16a34a';
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

                        <?= ucfirst($row['role']); ?>

                        </span>

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
