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


    <section class="events">
        <h1 class="heading">Daftar Diagnosa</h1>

        <div class="table-container">
            <?php
                $sql = "SELECT * FROM daftar_diagnosa";
                $result = mysqli_query($dbConn, $sql);

                if (mysqli_num_rows($result) > 0){
                    echo "<table>";
                    echo "<tr>
                    <th>Nama Pasien</th>
                    <th>Dokter Pemberi Diagnosa</th>
                    <th>Diagnosa</th>
                    <th>Tanggal Diberikan</th>
                    </tr>";
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>" . $row['nama_pasien'] . "</td>";
                        echo "<td>" . $row['dokter_pemberi'] . "</td>";
                        echo "<td>" . $row['diagnosa'] . "</td>";
                        echo "<td>" . $row['tanggal_diberikan'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }else{
                    echo "<p>Tidak ada data ditemukan.</p>";
                }
            ?>
        </div>    
    </section>
</body>
</html>
