<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Transistock</title>

    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-card">

    <div class="logo">
        <h1>Transistock</h1>
        <p>Sistem Manajemen Inventaris</p>
    </div>

    <form action="proses_login.php" method="POST">

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                required>
        </div>

        <div class="form-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required>
        </div>

        <button
            type="submit"
            class="btn-login">

            Masuk

        </button>

    </form>

    <div class="footer">
        © 2026 Transistock
    </div>

</div>

</body>
</html>