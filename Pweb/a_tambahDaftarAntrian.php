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


    <section class="add">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])){
            function sanitize($data){
                return htmlspecialchars(stripslashes(trim($data)));
            }

            $nama_user = sanitize($_POST['nama_user']);
            $waktu_kedatangan = sanitize($_POST['waktu_kedatangan']);
            $dokter_dituju = sanitize(sanitize($_POST['dokter_dituju']));
            

            $sql = "INSERT INTO daftar_antrian (nama_user,waktu_kedatangan,dokter_dituju) VALUES ('$nama_user','$waktu_kedatangan','$dokter_dituju' )";

                if (mysqli_query($dbConn, $sql)){
                    mysqli_close($dbConn);
                    header("Location: a_daftarAntrian.php");
                    exit();
                }else{
                    echo "<p>Error: " . mysqli_error($dbConn) . "</p>";
                }
            }
        ?>

    <div class="row mt-35">
        <div class="image">
            <img src="#" alt="">
        </div>
        <form class="tambah" method="POST" action="">
            <h3>Tambah Pengantri</h3>
            <label>Nama Pengantri</label>
            <input type="text" name="nama_user" required><br>
            <label>Waktu Kedatangan</label>
            <input type="datetime-local" name="waktu_kedatangan" required><br>
            <label>Dokter Yang Dituju</label>
            <input type="text" name="dokter_dituju" required><br>
            <input type="submit" name="add" value="Tambah">
            <a href="a_daftarAntrian.php" class="cancel-btn">Batal</a>
        </form>
    </section>
</body>
</html>
