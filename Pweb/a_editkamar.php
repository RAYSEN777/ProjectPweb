<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['admin'])) {
    header('location: a_masuk.php'); 
    exit(); 
}

$username_admin = $_SESSION['admin']['username_admin'];
$email_admin = $_SESSION['admin']['email_admin'];

function sanitize($data){
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
        if (isset($_GET['id'])){
            $id = sanitize($_GET['id']);

            $sql = "SELECT * FROM daftar_kamar WHERE id_kamar='$id'";
            $result = mysqli_query($dbConn, $sql);

            if (mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $edit_nama_kamar = $row['nama_kamar'];
                $edit_Kesediaan_kamar = $row['Kesediaan_kamar'];
                $edit_nama_pasien = $row['nama_pasien'];
                $edit_tanggal_masuk = $row['tanggal_masuk'];
            } else {
                echo "<p>Tidak ada data User.</p>";
                exit;
            }
        } else {
            echo "<p>Invalid request.</p>";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])){
            $id = sanitize($_POST['id_kamar']);
            $nama_kamar = sanitize($_POST['nama_kamar']);
            $Kesediaan_kamar = sanitize($_POST['Kesediaan_kamar']);
            $nama_pasien = sanitize($_POST['nama_pasien']);
            $tanggal_masuk = sanitize($_POST['tanggal_masuk']);

            $sql = "UPDATE daftar_kamar SET nama_kamar='$nama_kamar', Kesediaan_kamar='$Kesediaan_kamar', nama_pasien='$nama_pasien', tanggal_masuk='$tanggal_masuk' WHERE id_kamar='$id'";

            if (mysqli_query($dbConn, $sql)){
                echo "<p>User berhasil diupdate.</p>";
                header("Location: a_daftarKamar.php");
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
                <h3>Edit Daftar Kamar</h3>
                <input type="hidden" name="id_kamar" value="<?php echo $id; ?>">
                <label>Nama Kamar</label>
                <input type="text" name="nama_kamar" value="<?php echo $edit_nama_kamar; ?>" required>
                <label>Ketersediaan Kamar</label>
                <input type="text" name="Kesediaan_kamar" value="<?php echo $edit_Kesediaan_kamar; ?>" required><br>
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien" value="<?php echo $edit_nama_pasien; ?>" required><br>
                <label>Tanggal Masuk</label>
                <input type="datetime-local" name="tanggal_masuk" value="<?php echo $edit_tanggal_masuk; ?>" required><br>
                <input type="submit" name="update" value="Update">
                <a href="a_daftarKamar.php" class="cancel-btn">Batal</a>
            </form>
        </div>
    </section>
</body>
</html>
