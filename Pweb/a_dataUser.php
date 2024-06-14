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


    <section class="events">
        <h1 class="heading">Data User</h1>
        <div class="table-container">
            <a href="a_tambahUser.php" class="add-contact-btn">Tambah User</a>
                <?php
                    function sanitize($data){
                        return htmlspecialchars(stripslashes(trim($data)));
                    }
                    if (isset($_GET['delete'])){
                        $id = $_GET['delete'];

                        $sql = "DELETE FROM user WHERE id_user='$id'";

                        if (mysqli_query($dbConn, $sql)){
                        }else{
                            echo "<p>Error: " . mysqli_error($dbConn) . "</p>";
                        }
                    }
                    $sql = "SELECT * FROM user";
                    $result = mysqli_query($dbConn, $sql);

                    if (mysqli_num_rows($result) > 0){
                        echo "<table>";
                        echo "<tr><th>ID User</th><th>Nama</th><th>Jenis Kelamin</th><th>Alamat</th><th>Email</th><th>Kontak</th><th>Aksi</th></tr>";
                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>" . $row['id_user'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['jenis_kelamin'] . "</td>";
                            echo "<td>" . $row['alamat'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['kontak'] . "</td>";
                            echo "<td>";
                            echo "<a href='a_editUser.php?id=" . $row['id_user'] . "' class='edit-btn'>Edit</a> ";
                            echo "<a href='?delete=" . $row['id_user'] . "' class='delete-btn'>Hapus</a>";
                            echo "</td>";
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
