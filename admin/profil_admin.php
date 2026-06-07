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
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Admin</title>

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

<li class="active">
Profil Admin
</li>

<li>
<a href="pengaturan.php">
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
placeholder="Profil administrator">

<div class="profile">

<h4><?= $_SESSION['nama']; ?></h4>

<p>Admin Utama</p>

</div>

</div>

<div class="inventory-card">

<div class="inventory-top">

<div>

<h2>Profil Admin</h2>

<p>Informasi akun administrator.</p>

</div>

</div>

<form>

<div class="form-group">

<label>ID User</label>

<input
type="text"
value="<?= $data['id_user']; ?>"
readonly>

</div>

<div class="form-group">

<label>Nama Lengkap</label>

<input
type="text"
value="<?= $data['nama']; ?>"
readonly>

</div>

<div class="form-group">

<label>Email</label>

<input
type="email"
value="<?= $data['email']; ?>"
readonly>

</div>

<div class="form-group">

<label>Role</label>

<input
type="text"
value="<?= ucfirst($data['role']); ?>"
readonly>

</div>

<div class="form-group">

<label>Status Akun</label>

<input
type="text"
value="Aktif"
readonly>

</div>

</form>

</div>

</div>

</div>

</body>
</html>
