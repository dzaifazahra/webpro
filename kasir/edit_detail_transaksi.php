<?php
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT *
        FROM detail_transaksi
        WHERE id_detail='$id'
    ")
);

if(isset($_POST['simpan'])){

    $qty = $_POST['qty'];

    mysqli_query($conn,"
        UPDATE detail_transaksi
        SET qty='$qty'
        WHERE id_detail='$id'
    ");

    header("Location: riwayat.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Edit Detail Transaksi</title>

<link rel="stylesheet" href="../admin/dashboard.css">

</head>
<body>

<div class="container">

    <div class="main">

        <div class="inventory-card">

            <div class="inventory-top">

                <div>
                    <h2>Edit Detail Transaksi</h2>
                    <p>Perbarui jumlah produk pada transaksi.</p>
                </div>

                <a href="riwayat.php" class="btn-add">
                    Kembali
                </a>

            </div>

            <form method="POST">

                <div class="form-group">

                    <label>Jumlah Produk</label>

                    <input
                        type="number"
                        name="qty"
                        value="<?= $data['qty']; ?>"
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