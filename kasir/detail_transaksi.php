<?php
session_start();

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn,"
    SELECT
        detail_transaksi.*,
        barang.nama_barang,
        barang.foto
    FROM detail_transaksi
    JOIN barang
    ON detail_transaksi.id_barang = barang.id_barang
    WHERE id_transaksi='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>

<div class="container">

    <div class="main">

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Detail Transaksi</h2>
                    <p>ID Transaksi #<?= $id; ?></p>
                </div>

                <a
                    href="riwayat.php"
                    class="btn-back">

                    Kembali

                </a>

            </div>

            <table class="inventory-table">

                <thead>

                    <tr>
                        <th>    </th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($data)) : ?>

                    <tr>

                    <td>
<img
src="../uploads/<?= $row['foto']; ?>"
width="60"
height="60"
style="border-radius:10px;object-fit:cover;">
</td>

                        <td>
                            <?= $row['nama_barang']; ?>
                        </td>

                        <td>
                            <?= $row['qty']; ?>
                        </td>

                        <td>
                            Rp <?= number_format($row['harga'],0,',','.'); ?>
                        </td>

                        <td>
                            Rp <?= number_format($row['subtotal'],0,',','.'); ?>
                        </td>

                        <td>

<a
href="edit_detail_transaksi.php?id=<?= $row['id_detail']; ?>"
class="action-stock">

Edit

</a>

<a
href="hapus_detail_transaksi.php?id=<?= $row['id_detail']; ?>"
class="action-delete"
onclick="return confirm('Hapus detail transaksi?')">

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