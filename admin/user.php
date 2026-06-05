<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$users = mysqli_query($conn,
         "SELECT * FROM users
          ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>

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

        .btn{
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
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

        .logout{
            background: crimson !important;
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
            margin: 80px auto;
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

        select{
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

    </style>
</head>
<body>

<div class="container">

    <h2>Data User</h2>

    <button class="btn tambah"
        onclick="openTambahModal()">
    Tambah User
    
    </button>

    <a class="btn logout" 
    href="../auth/logout.php">
        Logout
    </a>

    <br><br>

    <table>

        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Last Login</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while($row = mysqli_fetch_assoc($users)){
        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td><?= $row['nama']; ?></td>

            <td><?= $row['username']; ?></td>

            <td><?= ucfirst($row['role']); ?></td>

            <td>

                <?= $row['last_login']
                ? $row['last_login']
                : 'Belum Pernah Login'; ?>

            </td>

            <td>

                <button class="btn edit"

                    onclick="openModal(
                        '<?= $row['id']; ?>',
                        '<?= $row['nama']; ?>',
                        '<?= $row['username']; ?>',
                        '<?= $row['role']; ?>'
                    )">

                    Edit

                </button>

                <a class="btn hapus"
                   href="hapus_user.php?id=<?= $row['id']; ?>"
                   onclick="return confirm('Yakin hapus user?')">

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

        <span class="close"
              onclick="closeModal()">

              &times;

        </span>

        <h2>Edit User</h2>

        <form action="proses_edit.php"
              method="POST">

            <input type="hidden"
                   name="id"
                   id="id">

            <input type="text"
                   name="nama"
                   id="nama"
                   placeholder="Nama"
                   required>

            <input type="text"
                   name="username"
                   id="username"
                   placeholder="Username"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Kosongkan jika tidak diubah">

            <select name="role"
                    id="role"
                    required>

                <option value="admin">
                    Admin
                </option>

                <option value="manager">
                    Manager
                </option>

                <option value="kasir">
                    Kasir
                </option>

            </select>

            <button class="btn tambah"
                    type="submit"
                    style="width:100%;margin-top:15px;">

                Update User

            </button>

        </form>

    </div>

</div>

<script>

function openModal(id,nama,username,role){

    document.getElementById('editModal')
    .style.display = 'block';

    document.getElementById('id').value = id;
    document.getElementById('nama').value = nama;
    document.getElementById('username').value = username;
    document.getElementById('role').value = role;
}

function closeModal(){

    document.getElementById('editModal')
    .style.display = 'none';
}

window.onclick = function(event){

let editModal =
document.getElementById('editModal');

let tambahModal =
document.getElementById('tambahModal');

if(event.target == editModal){

    editModal.style.display = "none";
}

if(event.target == tambahModal){

    tambahModal.style.display = "none";
}
}

function openTambahModal(){

document.getElementById('tambahModal')
.style.display = 'block';
}

function closeTambahModal(){

document.getElementById('tambahModal')
.style.display = 'none';
}

history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};

</script>

<!-- MODAL TAMBAH USER -->

<div class="modal" id="tambahModal">

    <div class="modal-content">

        <span class="close"
              onclick="closeTambahModal()">

              &times;

        </span>

        <h2>Tambah User</h2>

        <form action="proses_tambah.php"
              method="POST">

            <input type="text"
                   name="nama"
                   placeholder="Nama"
                   required>

            <input type="text"
                   name="username"
                   placeholder="Username"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   required>

            <select name="role" required>

                <option value="">
                    -- Pilih Role --
                </option>

                <option value="admin">
                    Admin
                </option>

                <option value="manager">
                    Manager
                </option>

                <option value="kasir">
                    Kasir
                </option>

            </select>

            <button class="btn tambah"
                    type="submit"
                    style="width:100%;margin-top:15px;">

                Simpan User

            </button>

        </form>

    </div>

</div>

</body>
</html>