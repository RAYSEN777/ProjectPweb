<?php
$dbServer = "localhost";
$database = "db_puskesmas";
$dbUser = "root";
$dbPass = "";

$dbConn = mysqli_connect($dbServer, $dbUser, $dbPass, $database);

if (!$dbConn){
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>