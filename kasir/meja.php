<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

if(isset($_POST['tambah'])){

    $nomor = $_POST['nomor_meja'];

    mysqli_query($conn,"
        INSERT INTO meja(nomor_meja,status)
        VALUES('$nomor','KOSONG')
    ");

    header("Location: meja.php");
}

$data = mysqli_query($conn,"
    SELECT *
    FROM meja
    ORDER BY id_meja ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Meja</title>
    <link rel="stylesheet" href="../admin/dashboard.css">
    
</head>
<body>

<div class="container">

<div class="sidebar">

<h2>Transistock</h2>

<ul>

<li>
<a href="dashboard_kasir.php">Dashboard</a>
</li>

<li>
<a href="penjualan.php">Penjualan</a>
</li>

<li class="active">
Manajemen Meja
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
<a href="../auth/logout.php">Logout</a>
</li>

</ul>

</div>

<div class="main">

<div class="inventory-card">

<h2>Data Meja</h2>

<form method="POST">

<div class="form-group">
<label>Nomor Meja</label>
<input type="text" name="nomor_meja" required>
</div>

<button type="submit" name="tambah" class="btn-save">
Tambah Meja
</button>

</form>

<br>

<table width="100%" border="1" cellpadding="10">

<tr>
<th>ID</th>
<th>Nomor Meja</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php while($row=mysqli_fetch_assoc($data)): ?>

<tr>

<td><?= $row['id_meja']; ?></td>

<td><?= $row['nomor_meja']; ?></td>

<td>
<?php
$statusClass = '';

if($row['status']=='KOSONG'){
    $statusClass='kosong';
}
elseif($row['status']=='DIPESAN'){
    $statusClass='dipesan';
}
else{
    $statusClass='ditempati';
}
?>

<span class="status <?= $statusClass ?>">
    <?= $row['status'] ?>
</span>
</td>

<td>
<div class="btn-primary">

<a href="edit_meja.php?id=<?= $row['id_meja']; ?>"
class="btn-edit">
✏ Edit
</a>

<a href="hapus_meja.php?id=<?= $row['id_meja']; ?>"
class="btn-delete"
onclick="return confirm('Hapus meja?')">
🗑 Hapus
</a>

</div>
</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</div>

</body>
</html>