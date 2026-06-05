<?php
include '../auth/cek_login.php';

if ($_SESSION['role'] != 'manager') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>

    <style>

        body{
            font-family: Arial;
            background: #f4f4f4;
        }

        .box{
            width: 400px;
            background: white;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
        }

        input{
            width: 94%;
            padding: 10px;
            margin-top: 10px;
        }

        button{
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: none;
            background: green;
            color: white;
            cursor: pointer;
        }

    </style>
</head>
<body>

<div class="box">

    <h2>Tambah Barang</h2>

    <form action="proses_tambah.php" method="POST">

        <input type="text"
               name="nama_barang"
               placeholder="Nama Barang"
               required>

        <input type="number"
               name="harga"
               placeholder="Harga"
               required>

        <input type="number"
               name="jumlah"
               placeholder="Jumlah"
               required>

        <input type="text"
               name="kategori"
               placeholder="Kategori"
               required>

        <button type="submit">
            Simpan
        </button>

    </form>

</div>

</body>
</html>