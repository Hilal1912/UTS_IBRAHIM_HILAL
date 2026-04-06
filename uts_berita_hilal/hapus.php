<?php
include 'koneksi.php';

$id = $_GET['id'];

// Ambil nama file gambar agar bisa dihapus dari folder 'img'
$data = mysqli_query($conn, "SELECT gambar FROM berita WHERE id='$id'");
$r = mysqli_fetch_array($data);
unlink("img/".$r['gambar']); // Menghapus file di folder

mysqli_query($conn, "DELETE FROM berita WHERE id='$id'");
header("location:admin.php");
?>