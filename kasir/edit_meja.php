<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT *
        FROM meja
        WHERE id_meja='$id'
    ")
);

if(isset($_POST['update'])){

    $nomor = $_POST['nomor_meja'];
    $status = $_POST['status'];

    mysqli_query($conn,"
        UPDATE meja
        SET
            nomor_meja='$nomor',
            status='$status'
        WHERE id_meja='$id'
    ");

    header("Location: meja.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Meja</title>
<link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>

<div class="inventory-card">

<h2>Edit Meja</h2>

<form method="POST">

<div class="form-group">
<label>Nomor Meja</label>
<input
type="text"
name="nomor_meja"
value="<?= $data['nomor_meja']; ?>"
required>
</div>

<div class="form-group">

<label>Status</label>

<select name="status">

<option value="KOSONG"
<?= $data['status']=='KOSONG'?'selected':'' ?>>
KOSONG
</option>

<option value="DIPESAN"
<?= $data['status']=='DIPESAN'?'selected':'' ?>>
DIPESAN
</option>

<option value="DITEMPATI"
<?= $data['status']=='DITEMPATI'?'selected':'' ?>>
DITEMPATI
</option>

</select>

</div>

<button
type="submit"
name="update"
class="btn-save">

Update

</button>

</form>

</div>

</body>
</html>