<?php

include '../koneksi.php';
session_start();

if (!isset($_POST['barang_id'])) {

    echo "
    <script>
        alert('Cart masih kosong!');
        window.location='transaksi.php';
    </script>
    ";

    exit;
}

$barangDipilih = $_POST['barang_id'];

$total = $_POST['total_harga'];
$bayar = $_POST['uang_bayar'];

if ($bayar < $total) {

    echo "
    <script>
        alert('Uang pembayaran kurang!');
        window.location='transaksi.php';
    </script>
    ";

    exit;
}

/*
|--------------------------------------------------------------------------
| VALIDASI STOK
|--------------------------------------------------------------------------
*/

foreach($barangDipilih as $id_barang){

    $jumlah_beli = $_POST['jumlah'][$id_barang];

    $barang = mysqli_query($conn,
             "SELECT * FROM barang
              WHERE id='$id_barang'");

    $data = mysqli_fetch_assoc($barang);

    if($jumlah_beli > $data['jumlah']){

        echo "
        <script>

            alert(
                'Stok ".$data['nama_barang']." tidak mencukupi!\\n' +
                'Sisa stok : ".$data['jumlah']."'
            );

            window.location='transaksi.php';

        </script>
        ";

        exit;
    }
}

/*
|--------------------------------------------------------------------------
| SIMPAN TRANSAKSI
|--------------------------------------------------------------------------
*/

$kode = "TRX" . time();

$kasir = $_SESSION['nama'];

mysqli_query($conn,
"INSERT INTO transaksi
VALUES(
    NULL,
    '$kode',
    '$kasir',
    '$total',
    NOW()
)");

$transaksi_id = mysqli_insert_id($conn);

/*
|--------------------------------------------------------------------------
| DETAIL TRANSAKSI
|--------------------------------------------------------------------------
*/

foreach($barangDipilih as $id_barang){

    $jumlah_beli = $_POST['jumlah'][$id_barang];

    $barang = mysqli_query($conn,
             "SELECT * FROM barang
              WHERE id='$id_barang'");

    $data = mysqli_fetch_assoc($barang);

    $subtotal = $data['harga'] * $jumlah_beli;

    mysqli_query($conn,
    "INSERT INTO detail_transaksi
    VALUES(
        NULL,
        '$transaksi_id',
        '$id_barang',
        '".$data['nama_barang']."',
        '".$data['harga']."',
        '$jumlah_beli',
        '$subtotal'
    )");

    /*
    |--------------------------------------------------------------------------
    | UPDATE STOK
    |--------------------------------------------------------------------------
    */

    $stokBaru = $data['jumlah'] - $jumlah_beli;

    mysqli_query($conn,
    "UPDATE barang
    SET jumlah='$stokBaru'
    WHERE id='$id_barang'");
}

echo "
<script>
    alert('Pembayaran berhasil!');
    window.location='riwayat.php';
</script>
";
?>