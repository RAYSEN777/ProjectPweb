<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['admin'])) {
    header('location: a_masuk.php');
    exit();
}

$username_admin = $_SESSION['admin']['username_admin'];
$email_admin = $_SESSION['admin']['email_admin'];

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style_web.css">
    <link rel="stylesheet" href="style_coba.css">
</head>
<body class="beranda">
    <header class="header">
        <a href="a_profil" class="icon-user">
            <i class="fa-solid fa-user"></i> <?php echo $username_admin; ?>
        </a>
    </header>
    <div class="sidebar">
        <h3>MyPuskes</h3>
        <ul>
            <li><a href="a_beranda.php"><i class="fa-solid fa-house"></i>Beranda</a></li>
            <li><a href="a_dataUser.php"><i class="fa-solid fa-users"></i>User</a></li>
            <li><a href="a_daftarantrian.php"><i class="fa-solid fa-user-group"></i>Daftar Antrian</a></li>
            <li><a href="a_daftarKamar.php"><i class="fa-solid fa-bed"></i>Kamar Inap</a></li>
            <li><a href="a_diagnosa.php"><i class="fa-solid fa-pills"></i>Diagnosa</a></li>
            <li><a href="a_daftarDokter.php"><i class="fa-solid fa-user-group"></i>Data Dokter</a></li>
            <li><a href="a_penilaian.php"><i class="fa-solid fa-comments"></i>Penilaian Layanan</a></li>
            <li><a href="a_keluar.php"><i class="fa-solid fa-right-from-bracket"></i>Keluar</a></li>
        </ul>
    </div>

    <section class="add">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
            $username_dokter = sanitize($_POST['username_dokter']);
            $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
            $alamat = sanitize($_POST['alamat']);
            $no_telp = sanitize($_POST['no_telp']);
            $email = sanitize($_POST['email']);
            $spesialis = sanitize($_POST['spesialis']);
            $password = md5(sanitize($_POST['password']));

            $foto_name = '';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $foto = $_FILES['foto'];
                $foto_name = basename($foto['name']);
                $foto_tmp = $foto['tmp_name'];
                $foto_folder = "dokter/" . $foto_name;
                if (!move_uploaded_file($foto_tmp, $foto_folder)) {
                    echo "<p>Failed to upload image.</p>";
                    $foto_folder = '';
                }
            }

            $sql = "INSERT INTO dokter (username_dokter, jenis_kelamin, alamat, no_telp, email, spesialis, foto, password) VALUES ('$username_dokter', '$jenis_kelamin', '$alamat', '$no_telp', '$email', '$spesialis', '$foto_folder', '$password')";
            if (mysqli_query($dbConn, $sql)) {
                mysqli_close($dbConn);
                header("Location: a_daftarDokter.php");
                exit();
            } else {
                echo "<p>Error: " . mysqli_error($dbConn) . "</p>";
            }
        }
        ?>

        <div class="row mt-35">
            <div class="image">
                <img src="#" alt="">
            </div>
            <form class="tambah" method="POST" action="" enctype="multipart/form-data">
                <h3>Tambah User</h3>
                <label>Nama Dokter</label>
                <input type="text" name="username_dokter" required><br>
                <label>Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" required><br>
                <label>Alamat</label>
                <input type="text" name="alamat" required><br>
                <label>No.telp</label>
                <input type="tel" name="no_telp" required><br>
                <label>Email</label>
                <input type="email" name="email" placeholder="@gmail.com" required><br>
                <label>Spesialis</label>
                <input type="text" name="spesialis" required><br>
                <label>Foto</label>
                <input type="file" name="foto"><br>
                <label>Password</label>
                <input type="password" name="password" required><br>
                <input type="submit" name="add" value="Tambah">
                <a href="a_daftarDokter.php" class="cancel-btn">Batal</a>
            </form>
        </div>
    </section>
</body>
</html>
