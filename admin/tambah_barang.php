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

if(isset($_POST['simpan'])){

    $nama_barang = $_POST['nama_barang'];
    $sku = $_POST['sku'];
    $stok = $_POST['stok'];
    $harga_jual = $_POST['harga_jual'];
    $id_kategori = $_POST['id_kategori'];

    $foto = '';

if($_FILES['foto']['name'] != ''){

    $foto = $_FILES['foto']['name'];

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        "../uploads/" . $foto
    );
}

    $query = mysqli_query($conn, "
    INSERT INTO barang
    (nama_barang, sku, stok, harga_jual, id_kategori, foto)
    VALUES
    (
        '$nama_barang',
        '$sku',
        '$stok',
        '$harga_jual',
        '$id_kategori',
        '$foto'
    )
");

    if($query){

    $id_barang = mysqli_insert_id($conn);

    mysqli_query($conn,"
        INSERT INTO barang_masuk
        (
            tanggal_masuk,
            id_supplier,
            status,
            catatan,
            id_barang,
            jumlah
        )
        VALUES
        (
            CURDATE(),
            1,
            'SELESAI',
            'Tambah Barang Baru',
            '$id_barang',
            '$stok'
        )
    ");

    header("Location: inventaris.php");
    exit;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

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
    <a href="riwayat_barang_masuk.php">Riwayat Stok</a>
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

            <input type="text" placeholder="Cari barang...">

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Admin Utama</p>
            </div>

        </div>

        <div class="inventory-card">

            <div class="inventory-top">
                <div>
                    <h2>Tambah Barang</h2>
                    <p>Tambahkan barang baru ke inventaris.</p>
                </div>
            </div>

           <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" required>
                </div>

                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>

                    <select name="id_kategori" required>

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <?php while($kategori = mysqli_fetch_assoc($dataKategori)) : ?>

                            <option value="<?= $kategori['id_kategori']; ?>">
                                <?= $kategori['nama_kategori']; ?>
                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" required>
                </div>

                <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" required>
                </div>

                <div class="form-group">
                    <label>Foto Barang</label>
                    <input type="file" name="foto">
                </div>

                <button type="submit" name="simpan" class="btn-save">
                    Simpan Barang
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>