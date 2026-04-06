<?php
$conn = mysqli_connect("localhost", "root", "", "db_berita");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>