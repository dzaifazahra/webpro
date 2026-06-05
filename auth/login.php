<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login TransiStok</title>

    <style>
        body{
            font-family: Arial;
            background: #f4f4f4;
        }

        .login-box{
            width: 350px;
            background: white;
            padding: 30px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        input{
            width: 93%;
            padding: 10px;
            margin-top: 10px;
        }

        button{
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: royalblue;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        h2{
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>LOGIN TRANSISTOK</h2>

    <form action="proses_login.php" method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">LOGIN</button>

    </form>
</div>
<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>
</body>
</html>