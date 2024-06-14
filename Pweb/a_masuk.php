<?php
session_start();
include "koneksi.php";

if (isset($_POST['username_admin'])) {
    $username_admin = $_POST['username_admin'];
    $password_admin = md5($_POST['password_admin']);

    $query = mysqli_query($dbConn, "SELECT * FROM admin WHERE username_admin = '$username_admin' AND password_admin = '$password_admin'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['admin'] = $data;
        echo '<script>alert("Selamat datang, '.$data['username_admin'].'"); location.href="a_beranda.php";</script>';
    } else {
        echo '<script>alert("Username/password tidak sesuai.");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin</title>
    <link rel="stylesheet" href="style_web.css">
</head>
<body class="sign_in">
    <div class="container">
        <div class="login">
            <header class="keterangan">Form Masuk Admin</header>
            <form action="" method="POST">
                <input type="text" placeholder="Username" name="username_admin" required>
                <input type="password" placeholder="Password" name="password_admin" required>
                <a href="#">Lupa password?</a><br>
                <button type="submit">Masuk</button><br><br>
            </form>
        </div>
    </div>
</body>
</html>
