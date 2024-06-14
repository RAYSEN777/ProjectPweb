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
<body class="beranda">
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

    <section class="home">
            <h1 class="heading">Selamat datang di Puskesmas Konoha!</h1>
            <div class="row">
                <div class="content">
                    <p>
                        Di Puskesmas Konoha, kami berkomitmen untuk memberikan pelayanan kesehatan yang terbaik bagi masyarakat. 
                        Dengan fasilitas yang modern dan tim medis yang profesional, kami menyediakan berbagai layanan kesehatan yang berkualitas dan terjangkau untuk semua kalangan.

                    </p>
                    <h3>Visi</h3>
                    <p>
                        Menjadi pusat pelayanan kesehatan yang unggul dan terpercaya dalam mendukung kesehatan masyarakat.
                    </p>
                    <h3>Misi</h3>
                    <ol>
                        <li>
                            Pelayanan Kesehatan Berkualitas: Memberikan pelayanan kesehatan yang komprehensif dan berkualitas tinggi kepada setiap pasien.
                        </li>
                        <li>
                            Peningkatan Kesehatan Masyarakat: Mendorong perilaku hidup sehat melalui edukasi dan layanan pencegahan penyakit.
                        </li>
                        <li>
                            Inovasi dan Teknologi: Mengintegrasikan teknologi modern dalam setiap aspek pelayanan untuk meningkatkan efisiensi dan kenyamanan pasien.
                        </li>
                        <li>
                            Profesionalisme dan Empati: Menyediakan layanan dengan sikap profesional dan penuh empati terhadap setiap pasien.
                        </li>
                    </ol>
                </div>
            </div>
    </section> 

</body>
</html>
