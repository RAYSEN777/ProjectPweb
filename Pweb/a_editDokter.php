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
        if (isset($_GET['id'])) {
            $id = sanitize($_GET['id']);

            $sql = "SELECT * FROM dokter WHERE id_dokter='$id'";
            $result = mysqli_query($dbConn, $sql);

            if (!$result) {
                echo "<p>Error: " . mysqli_error($dbConn) . "</p>";
                exit;
            }

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $edit_username_dokter = $row['username_dokter'];
                $edit_jenis_kelamin = $row['jenis_kelamin'];
                $edit_alamat = $row['alamat'];
                $edit_no_telp = $row['no_telp'];
                $edit_email = $row['email'];
                $edit_spesialis = $row['spesialis'];
                $edit_foto = $row['foto'];
            } else {
                echo "<p>Tidak ada data User.</p>";
                exit;
            }
        } else {
            echo "<p>Invalid request.</p>";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $id_dokter = sanitize($_POST['id_dokter']);
            $username_dokter = sanitize($_POST['username_dokter']);
            $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
            $alamat = sanitize($_POST['alamat']);
            $no_telp = sanitize($_POST['no_telp']);
            $email = sanitize($_POST['email']);
            $spesialis = sanitize($_POST['spesialis']);

            $update_foto = false;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $foto = $_FILES['foto'];
                $foto_name = basename($foto['name']);
                $foto_tmp = $foto['tmp_name'];
                $foto_folder = "dokter/" . $foto_name;

                if (move_uploaded_file($foto_tmp, $foto_folder)) {
                    $update_foto = true;
                } else {
                    echo "<p>Failed to upload image.</p>";
                }
            }

            if ($update_foto) {
                $sql = "UPDATE dokter SET username_dokter='$username_dokter', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_telp='$no_telp', email='$email', spesialis='$spesialis', foto='$foto_folder' WHERE id_dokter='$id_dokter'";
            } else {
                $sql = "UPDATE dokter SET username_dokter='$username_dokter', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_telp='$no_telp', email='$email', spesialis='$spesialis' WHERE id_dokter='$id_dokter'";
            }

            if (mysqli_query($dbConn, $sql)) {
                echo "<p>User berhasil diupdate.</p>";
                header("Location: a_daftarDokter.php");
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

            <form class="editan" method="POST" action="" enctype="multipart/form-data">
                <h3>Edit Data User</h3>
                <input type="hidden" name="id_dokter" value="<?php echo $id; ?>">
                <label>Nama Dokter</label>
                <input type="text" name="username_dokter" value="<?php echo $edit_username_dokter; ?>" required>
                <label>Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" value="<?php echo $edit_jenis_kelamin; ?>" required>
                <label>Alamat</label>
                <input type="text" name="alamat" value="<?php echo $edit_alamat; ?>" required>
                <label>No.telp</label>
                <input type="tel" name="no_telp" value="<?php echo $edit_no_telp; ?>" required>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $edit_email; ?>" required><br>
                <label>Spesialis</label>
                <input type="text" name="spesialis" value="<?php echo $edit_spesialis; ?>" required><br>
                <label>Foto</label>
                <input type="file" name="foto"><br>
                <input type="submit" name="update" value="Update">
                <a href="a_daftarDokter.php" class="cancel-btn">Batal</a>
            </form>
        </div>
    </section>
</body>
</html>
