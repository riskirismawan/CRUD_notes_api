<?php
$hostname = "localhost";
$database = "notes_db";
$username = "root";
$password = "";

$connect = mysqli_connect($hostname, $username, $password, $database);

// cek koneksi
if (!$connect) {
    die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
}
?>