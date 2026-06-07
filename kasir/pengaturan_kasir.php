<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT *
        FROM users
        WHERE id_user='$id_user'
    ")
);

if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $email = $_POST['email'];

    mysqli_query($conn,"
        UPDATE users
        SET
            nama='$nama',
            email='$email'
        WHERE id_user='$id_user'
    ");

    $_SESSION['nama'] = $nama;

    echo "
    <script>
        alert('Data berhasil diperbarui');
        window.location='pengaturan_kasir.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengaturan Kasir - Transistock</title>

    <link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

    <!-- Sidebar -->
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
                <a href="riwayat.php">
                    Riwayat
                </a>
            </li>

            <li class="active">
                Pengaturan
            </li>

            <li>
                <a href="../auth/logout.php">
                    Logout
                </a>
            </li>

        </ul>

    </div>

    <!-- Main -->
    <div class="main">

        <!-- Header -->
        <div class="header">

            <input
                type="text"
                placeholder="Pengaturan akun..."
                disabled>

            <div class="profile">
                <h4><?= $_SESSION['nama']; ?></h4>
                <p>Kasir</p>
            </div>

        </div>

        <!-- Form -->
        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Pengaturan Akun</h2>
                    <p>Kelola informasi akun kasir.</p>
                </div>

            </div>

            <form method="POST">

                <div class="form-group">

                    <label>Nama</label>

                    <input
                        type="text"
                        name="nama"
                        value="<?= $data['nama']; ?>"
                        required>

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        value="<?= $data['email']; ?>"
                        required>

                </div>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-save">

                    Simpan Perubahan

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>