<?php
include '../auth/cek_login.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>

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

        input, select{
            width: 100%;
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

        <button type="submit">
            Simpan User
        </button>

    </form>

</div>

</body>
</html>