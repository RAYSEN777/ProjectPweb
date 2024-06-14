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
        <h1 class="heading">Daftar Antrian</h1>
        <div class="table-container">
            <a href="a_tambahDaftarAntrian.php" class="add-contact-btn">Tambah Antrian</a>

            <?php
                if (isset($_GET['Terima'])){
                    $id = sanitize($_GET['Terima']);
                    mysqli_begin_transaction($dbConn);

                    try {
                        $sql_select = "SELECT * FROM daftar_antrian WHERE id_antrian='$id'";
                        $result_select = mysqli_query($dbConn, $sql_select);

                        if ($result_select && mysqli_num_rows($result_select) > 0) {
                            $data = mysqli_fetch_assoc($result_select);

                            $sql_insert = "INSERT INTO daftar_antrian_terima (id_antrian, nama_user, waktu_kedatangan, dokter_dituju)
                                        VALUES ('" . $data['id_antrian'] . "', '" . $data['nama_user'] . "', '" . $data['waktu_kedatangan'] . "', '" . $data['dokter_dituju'] . "')";
                            mysqli_query($dbConn, $sql_insert);

                            $sql_delete = "DELETE FROM daftar_antrian WHERE id_antrian='$id'";
                            mysqli_query($dbConn, $sql_delete);

                            mysqli_commit($dbConn);
                        }
                    } catch (Exception $e) {
                        mysqli_rollback($dbConn);
                        echo "<p>Error: " . $e->getMessage() . "</p>";
                    }
                }

                if (isset($_GET['delete'])){
                    $id = $_GET['delete'];

                    $sql = "DELETE FROM daftar_antrian WHERE id_antrian='$id'";

                    if (mysqli_query($dbConn, $sql)){
                    }else{
                        echo "<p>Error: " . mysqli_error($dbConn) . "</p>";
                    }
                }

                $sql = "SELECT * FROM daftar_antrian";
                $result = mysqli_query($dbConn, $sql);

                if (mysqli_num_rows($result) > 0){
                    echo "<table>";
                    echo "<tr>
                    <th>Nama Pengantri</th>
                    <th>Waktu Kedatangan</th>
                    <th>Nomor Antrian</th>
                    <th>Dokter Yang Dituju</th>
                    <th>Tindakan</th>
                    </tr>";
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>" . $row['nama_user'] . "</td>";
                        echo "<td>" . $row['waktu_kedatangan'] . "</td>";
                        echo "<td>" . $row['id_antrian'] . "</td>";
                        echo "<td>" . $row['dokter_dituju'] . "</td>";
                        echo "<td>";
                        echo "<a href='?Terima=" . $row['id_antrian'] . "' class='edit-btn'>Terima</a> ";
                        echo "<a href='?delete=" . $row['id_antrian'] . "' class='delete-btn'>Hapus</a>";
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
    
        <section class="events">
            <h1 class="heading">Daftar Antrian Diterima</h1>
            <div class="table-container">
                <?php
                    $sql = "SELECT * FROM daftar_antrian_terima";
                    $result = mysqli_query($dbConn, $sql);

                    if (mysqli_num_rows($result) > 0){
                        echo "<table>";
                        echo "<tr>
                        <th>Nama Pengantri</th>
                        <th>Waktu Kedatangan</th>
                        <th>Nomor Antrian</th>
                        <th>Dokter Yang Dituju</th>
                        </tr>";
                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>" . $row['nama_user'] . "</td>";
                            echo "<td>" . $row['waktu_kedatangan'] . "</td>";
                            echo "<td>" . $row['id_antrian'] . "</td>";
                            echo "<td>" . $row['dokter_dituju'] . "</td>";
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
