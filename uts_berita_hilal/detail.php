<?php 
include 'koneksi.php';
$id = $_GET['id'];

// Tambah View (Logika Populer)
mysqli_query($conn, "UPDATE berita SET views = views + 1 WHERE id = '$id'");

// Ambil Data Berita
$data = mysqli_query($conn, "SELECT * FROM berita WHERE id = '$id'");
$r = mysqli_fetch_array($data);

// Logika Simpan Komentar
if (isset($_POST['kirim_komentar'])) {
    $nama = $_POST['nama'];
    $komentar = $_POST['isi_komentar'];
    mysqli_query($conn, "INSERT INTO komentar (id_berita, nama, isi_komentar) VALUES ('$id', '$nama', '$komentar')");
    header("location:detail.php?id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $r['judul']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5" style="max-width: 800px;">
        <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>
        <div class="card shadow-sm p-4">
            <h1><?php echo $r['judul']; ?></h1>
            <small class="text-muted">Diposting pada: <?php echo $r['tanggal']; ?> | Dilihat: <?php echo $r['views']; ?> kali</small>
            <hr>
            <img src="img/<?php echo $r['gambar']; ?>" class="img-fluid rounded mb-4">
            <p style="line-height: 1.8; text-align: justify;"><?php echo nl2br($r['isi']); ?></p>
        </div>

        <div class="card mt-4 p-4 shadow-sm">
            <h5>Komentar</h5>
            <form action="" method="post" class="mb-4">
                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Anda" required>
                <textarea name="isi_komentar" class="form-control mb-2" placeholder="Tulis komentar..." required></textarea>
                <button type="submit" name="kirim_komentar" class="btn btn-success btn-sm">Kirim Komentar</button>
            </form>

            <hr>
            <?php
            $list_komentar = mysqli_query($conn, "SELECT * FROM komentar WHERE id_berita = '$id' ORDER BY id DESC");
            while($k = mysqli_fetch_array($list_komentar)) {
            ?>
                <div class="mb-3 border-bottom pb-2">
                    <strong><?php echo $k['nama']; ?></strong> <small class="text-muted">(<?php echo $k['tanggal']; ?>)</small>
                    <p class="mb-0"><?php echo $k['isi_komentar']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>