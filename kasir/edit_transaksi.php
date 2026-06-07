<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT *
        FROM transaksi
        WHERE id_transaksi='$id'
    ")
);

if(isset($_POST['simpan'])){

    $status = $_POST['status'];

    mysqli_query($conn,"
        UPDATE transaksi
        SET status='$status'
        WHERE id_transaksi='$id'
    ");

    header("Location: riwayat.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Transaksi</title>

    <link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>

<div class="container">

    <div class="main">

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Edit Transaksi</h2>
                    <p>Perbarui status transaksi.</p>
                </div>

                <a href="riwayat.php" class="btn-add">
                    Kembali
                </a>

            </div>

            <form method="POST">

                <div class="form-group">

                    <label>Status Transaksi</label>

                    <select name="status">

                        <option value="DIPROSES"
                        <?= ($data['status']=='DIPROSES') ? 'selected' : ''; ?>>
                            DIPROSES
                        </option>

                        <option value="SELESAI"
                        <?= ($data['status']=='SELESAI') ? 'selected' : ''; ?>>
                            SELESAI
                        </option>

                        <option value="REFUND"
                        <?= ($data['status']=='REFUND') ? 'selected' : ''; ?>>
                            REFUND
                        </option>

                    </select>

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