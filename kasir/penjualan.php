<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

 $cari = $_GET['cari'] ?? '';

$barang = mysqli_query($conn,"
SELECT *
FROM barang
WHERE nama_barang LIKE '%$cari%'
ORDER BY nama_barang
");

if(isset($_POST['simpan'])){

    $id_barang = $_POST['id_barang'];
    $qty = $_POST['qty'];
    $metode = $_POST['metode_pembayaran'];

    $produk = mysqli_fetch_assoc(
        mysqli_query($conn,"
            SELECT *
            FROM barang
            WHERE id_barang='$id_barang'
        ")
    );

    $harga = $produk['harga_jual'];

    $subtotal = $harga * $qty;

    mysqli_query($conn,"
        INSERT INTO transaksi
        (
            id_user,
            tanggal,
            total,
            metode_pembayaran,
            status
        )
        VALUES
        (
            '{$_SESSION['id_user']}',
            NOW(),
            '$subtotal',
            '$metode',
            'SELESAI'
        )
    ");

    $id_transaksi = mysqli_insert_id($conn);

    mysqli_query($conn,"
        INSERT INTO detail_transaksi
        (
            id_transaksi,
            id_barang,
            qty,
            harga,
            subtotal
        )
        VALUES
        (
            '$id_transaksi',
            '$id_barang',
            '$qty',
            '$harga',
            '$subtotal'
        )
    ");

    mysqli_query($conn,"
        UPDATE barang
        SET stok = stok - $qty
        WHERE id_barang='$id_barang'
    ");

    echo "
    <script>
        alert('Transaksi berhasil disimpan');
        window.location='dashboard_kasir.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Penjualan - Transistock</title>

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

            <li class="active">
                Penjualan
            </li>

            <li>
                <a href="meja.php">
                    Manajemen Meja
                </a>
            </li>

            <li>
                <a href="riwayat.php">
                    Riwayat
                </a>
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
                placeholder="Cari produk...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Kasir</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Penjualan</h2>
                    <p>Buat transaksi penjualan baru.</p>
                </div>

            </div>

           <form method="GET">

    <input
        type="text"
        name="cari"
        value="<?= $cari; ?>"
        placeholder="Cari produk...">

    <button
        type="submit"
        class="btn-save">

        Cari

    </button>

    <label>Meja</label>

    <select name="id_meja">

<?php

    $meja = mysqli_query($conn,"
    SELECT *
    FROM meja
    WHERE status != 'DITEMPATI'");

    while($m=mysqli_fetch_assoc($meja)){

?>

        <option value="<?= $m['id_meja']; ?>">
        <?= $m['nomor_meja']; ?>
        (<?= $m['status']; ?>)
    </option>

<?php } ?>

</select>

</form>

            <form method="POST">

                <div class="form-group">

                    <label>Produk</label>

                    <select name="id_barang">

                        <?php while($row = mysqli_fetch_assoc($barang)) : ?>

                            <option value="<?= $row['id_barang']; ?>">

                                <?= $row['nama_barang']; ?>
                                (Stok: <?= $row['stok']; ?>)

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="qty">
                </div>

                <div class="form-group">

                    <label>Metode Pembayaran</label>

                    <select name="metode_pembayaran">

                        <option value="TUNAI">
                            Tunai
                        </option>

                        <option value="QRIS">
                            QRIS
                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-save">

                    Simpan Transaksi

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
