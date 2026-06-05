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
    <title>Dashboard Manager</title>

    <style>
        body{
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        .box{
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        a{
            text-decoration: none;
            padding: 10px 15px;
            background: royalblue;
            color: white;
            border-radius: 5px;
        }

        .logout{
        background: crimson !important;
        }
    </style>
</head>
<body>

<div class="box">

    <h1>Dashboard Manager</h1>

    <p>
        Selamat datang,
        <b><?php echo $_SESSION['nama']; ?></b>
    </p>

    <br>

    <a href="barang.php">Kelola Barang</a>
    <a class="logout" 
    href="../auth/logout.php">
        Logout
    </a>

</div>
<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>
</body>
</html>