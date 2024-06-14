<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['admin'])) {
    header('location: a_masuk.php'); 
    exit(); 
}

$username_admin = $_SESSION['admin']['username_admin'];
$email_admin = $_SESSION['admin']['email_admin'];
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
<body>
    <header class="header">
        <a href="#" class="icon-user">
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


    <section class="edit">
        <?php
        function sanitize($data){
            return htmlspecialchars(stripslashes(trim($data)));
        }

        if (isset($_GET['id'])){
            $id = sanitize($_GET['id']);

            $sql = "SELECT * FROM user WHERE id_user='$id'";
            $result = mysqli_query($dbConn, $sql);

            if (mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $edit_username = $row['username'];
                $edit_jenis_kelamin = $row['jenis_kelamin'];
                $edit_alamat = $row['alamat'];
                $edit_email = $row['email'];
                $edit_kontak = $row['kontak'];
            } else {
                echo "<p>Tidak ada data User.</p>";
                exit;
            }
        } else {
            echo "<p>Invalid request.</p>";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])){
            $id = sanitize($_POST['id_user']);
            $username = sanitize($_POST['username']);
            $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
            $alamat = sanitize($_POST['alamat']);
            $email = sanitize($_POST['email']);
            $kontak = sanitize($_POST['kontak']);

            $sql = "UPDATE user SET username='$username',jenis_kelamin='$jenis_kelamin',alamat='$alamat', email='$email', kontak='$kontak' WHERE id_user='$id'";

            if (mysqli_query($dbConn, $sql)){
                echo "<p>User berhasil diupdate.</p>";
                header("Location: a_dataUser.php");
                exit;
            } else {
                echo "<p>Error: " . mysqli_error($dbConn) . "</p>";
            }
        }
        ?>

        <div class="row">
            <div class="image">
                <img src="image/edit.png" alt="">
            </div>

            <form class="editan" method="POST" action="">
                <h3>Edit Data User</h3>
                <input type="hidden" name="id_user" value="<?php echo $id; ?>">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $edit_username; ?>" required>
                <label>Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" value="<?php echo $edit_username; ?>" required>
                <label>Alamat</label>
                <input type="text" name="alamat" value="<?php echo $edit_username; ?>" required>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $edit_email; ?>" required><br>
                <label>Kontak</label>
                <input type="tel" name="kontak" value="<?php echo $edit_kontak; ?>" required><br>
                <input type="submit" name="update" value="Update">
                <a href="a_dataUser.php" class="cancel-btn">Batal</a>
            </form>
        </div>
    </section>
</body>
</html>
