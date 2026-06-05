<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] != 'manager') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>

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
            padding: 12px;
            text-align: center;
        }

        th{
            background: royalblue;
            color: white;
        }

        a{
            text-decoration: none;
        }

        .btn{
            padding: 8px 12px;
            width: 90px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .tambah{
            background: green;
        }

        .edit{
            background: orange;
        }

        .hapus{
            background: crimson;
        }

        .modal{
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content{
            background: white;
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }

        .close{
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 22px;
            cursor: pointer;
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
            background: royalblue;
            color: white;
            cursor: pointer;
        }

        .logout{
        background: crimson !important;
        }

    </style>
</head>
<body>

<div class="container">

    <h2>Data Barang</h2>

    <a class="btn tambah" href="tambah_barang.php">
        Tambah Barang
    </a>
    
    <a class="btn logout"
       href="../auth/logout.php">
        Logout
    </a>
         
    <br><br>
        
    <table>

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while($row = mysqli_fetch_assoc($data)){
        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td><?= $row['nama_barang']; ?></td>

            <td>Rp <?= number_format($row['harga']); ?></td>

            <td><?= $row['jumlah']; ?></td>

            <td><?= $row['kategori']; ?></td>

            <td>

                <button
                    class="btn edit"
                    onclick="openModal(
                        '<?= $row['id']; ?>',
                        '<?= $row['nama_barang']; ?>',
                        '<?= $row['harga']; ?>',
                        '<?= $row['jumlah']; ?>',
                        '<?= $row['kategori']; ?>'
                    )">
                    Edit
                </button>

                <a class="btn hapus"
                   href="hapus_barang.php?id=<?= $row['id']; ?>"
                   onclick="return confirm('Yakin hapus data?')">
                    Hapus
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<!-- MODAL EDIT -->

<div class="modal" id="editModal">

    <div class="modal-content">

        <span class="close" onclick="closeModal()">
            &times;
        </span>

        <h2>Edit Barang</h2>

        <form action="proses_edit.php" method="POST">

            <input type="hidden" name="id" id="id">

            <input type="text"
                   name="nama_barang"
                   id="nama_barang"
                   placeholder="Nama Barang"
                   required>

            <input type="number"
                   name="harga"
                   id="harga"
                   placeholder="Harga"
                   required>

            <input type="number"
                   name="jumlah"
                   id="jumlah"
                   placeholder="Jumlah"
                   required>

            <input type="text"
                   name="kategori"
                   id="kategori"
                   placeholder="Kategori"
                   required>

            <button type="submit">
                Update Barang
            </button>

        </form>

    </div>

</div>

<script>

function openModal(id, nama, harga, jumlah, kategori){

    document.getElementById('editModal').style.display = 'block';

    document.getElementById('id').value = id;
    document.getElementById('nama_barang').value = nama;
    document.getElementById('harga').value = harga;
    document.getElementById('jumlah').value = jumlah;
    document.getElementById('kategori').value = kategori;
}

function closeModal(){
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event){

    let modal = document.getElementById('editModal');

    if(event.target == modal){
        modal.style.display = "none";
    }
}

history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};

</script>

</body>
</html>