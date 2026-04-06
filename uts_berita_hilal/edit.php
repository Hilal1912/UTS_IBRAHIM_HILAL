<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'");
$r = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    
    // Cek apakah user ganti gambar atau tidak
    if ($_FILES['gambar']['name'] != "") {
        $foto = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/".$foto);
        mysqli_query($conn, "UPDATE berita SET judul='$judul', isi='$isi', gambar='$foto' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE berita SET judul='$judul', isi='$isi' WHERE id='$id'");
    }
    header("location:admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container card p-4 shadow" style="max-width: 500px;">
        <h3>Edit Berita</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="judul" class="form-control mb-2" value="<?php echo $r['judul']; ?>">
            <textarea name="isi" class="form-control mb-2" rows="5"><?php echo $r['isi']; ?></textarea>
            <p><small>Gambar saat ini: <?php echo $r['gambar']; ?></small></p>
            <input type="file" name="gambar" class="form-control mb-3">
            <button type="submit" name="update" class="btn btn-success w-100">Update Berita</button>
            <a href="admin.php" class="btn btn-light w-100 mt-2">Batal</a>
        </form>
    </div>
</body>
</html>