<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] != 'kasir') {
    header("Location: ../auth/login.php");
    exit;
}

$transaksi = mysqli_query($conn,
             "SELECT * FROM transaksi
              ORDER BY id DESC");

$totalPemasukan = mysqli_query($conn,
                  "SELECT SUM(total_harga)
                   AS total FROM transaksi");

$total = mysqli_fetch_assoc($totalPemasukan);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>

    <style>

        body{
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        .container{
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td{
            border: 1px solid #ddd;
        }

        th, td{
            padding: 10px;
            text-align: center;
        }

        th{
            background: royalblue;
            color: white;
        }

        .total{
            background: green;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .nav{
    margin-bottom: 20px;
}

.nav a{
    text-decoration: none;
    padding: 10px 15px;
    background: royalblue;
    color: white;
    border-radius: 5px;
    margin-right: 10px;
}

.logout{
    background: crimson !important;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Riwayat Transaksi</h2>
<div class="nav">

    <a href="transaksi.php">
        Transaksi
    </a>

    <a class="logout"
       href="../auth/logout.php">
        Logout
    </a>

</div>

    

    <div class="total">

        Total Pemasukan :
        <b>
            Rp <?= number_format($total['total']); ?>
        </b>

    </div>

    

    <table>

        <tr>
            <th>Kode</th>
            <th>Kasir</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($transaksi)){ ?>

        <tr>

            <td><?= $row['kode_transaksi']; ?></td>

            <td><?= $row['kasir']; ?></td>

            <td>
                Rp <?= number_format($row['total_harga']); ?>
            </td>

            <td><?= $row['created_at']; ?></td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>