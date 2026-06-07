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
    $password = $_POST['password'];

    if(!empty($password)){

        mysqli_query($conn,"
            UPDATE users
            SET
                nama='$nama',
                email='$email',
                password='$password'
            WHERE id_user='$id_user'
        ");

    }else{

        mysqli_query($conn,"
            UPDATE users
            SET
                nama='$nama',
                email='$email'
            WHERE id_user='$id_user'
        ");

    }

    $_SESSION['nama'] = $nama;

    echo "
    <script>
        alert('Data berhasil diperbarui');
        window.location='pengaturan.php';
    </script>
    ";
}
?>

<!DOCTYPE html>

<html>
<head>

<meta charset="UTF-8">
<title>Pengaturan Admin</title>

<link rel="stylesheet" href="dashboard.css">

</head>
<body>

<div class="container">

<div class="sidebar">

<h2>Transistock</h2>

<ul>

<li><a href="dashboard.php">Dashboard</a></li>

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
<a href="notifikasi.php">
Notifikasi
</a>
</li>

<li>
<a href="profil_admin.php">
Profil Admin
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

<div class="main">

<div class="header">

<input
type="text"
placeholder="Pengaturan akun">

<div class="profile">

<h4><?= $_SESSION['nama']; ?></h4>

<p>Admin Utama</p>

</div>

</div>

<div class="inventory-card">

<div class="inventory-top">

<div>

<h2>Pengaturan Akun</h2>

<p>Kelola informasi akun administrator.</p>

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

<div class="form-group">

<label>Password Baru</label>

<input
type="password"
name="password"
placeholder="Kosongkan jika tidak ingin mengganti">

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
