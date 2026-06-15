<?php
include '../config/koneksi.php';

$data = mysqli_query(
    $conn,
    "SELECT * FROM barang WHERE status='nonaktif'"
);
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Aksi</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $row['id_barang']; ?></td>
        <td><?= $row['nama_barang']; ?></td>
        <td>
            <a href="restore_barang.php?id=<?= $row['id_barang']; ?>">
                Restore
            </a>
        </td>
    </tr>
    <?php } ?>

</table>