<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("location: login.php"); // Jika belum login, tendang ke login.php
    exit;
}
include 'koneksi.php';
// ... sisa kodingan admin kamu ...
// Logika Tambah Berita
if (isset($_POST['submit'])) {
    // Bungkus inputan dengan mysqli_real_escape_string
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi   = mysqli_real_escape_string($conn, $_POST['isi']);
    $id_kat = $_POST['id_kategori'];
    
    // Proses Gambar
    $foto = $_FILES['gambar']['name'];
    $tmp  = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "img/".$foto);

    // Query INSERT sekarang lebih aman
    $query = "INSERT INTO berita (judul, isi, gambar, id_kategori) VALUES ('$judul', '$isi', '$foto', '$id_kat')";
    
    if(mysqli_query($conn, $query)) {
        header("location:admin.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Hitung Statistik Dasar
$total_berita = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM berita"));
$total_views = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(views) AS total FROM berita"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - News Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 10px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: white; border-left: 4px solid #0d6efd; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .btn-primary { border-radius: 8px; padding: 10px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block sidebar p-0">
            <div class="p-4 text-center">
                <h5 class="fw-bold text-white"><i class="bi bi-newspaper me-2"></i>ADMIN</h5>
            </div>
            <nav class="mt-3">
                <a href="admin.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                <a href="index.php"><i class="bi bi-globe me-2"></i> Lihat Web</a>
                <hr class="mx-3 text-secondary">
                <a href="logout.php" class="text-danger" onclick="return confirm('Yakin ingin keluar?')">
    <i class="bi bi-box-arrow-left me-2"></i> Logout
</a>
            </nav>
        </div>

        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Dashboard Overview</h4>
                <span class="text-muted">Halo, Ibrahim Hilal</span>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Berita</h6>
                                <h2 class="fw-bold mb-0"><?= $total_berita; ?></h2>
                            </div>
                            <i class="bi bi-file-earmark-text fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Pembaca</h6>
                                <h2 class="fw-bold mb-0"><?= number_format($total_views); ?></h2>
                            </div>
                            <i class="bi bi-eye fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Tulis Artikel Baru</h6>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Judul Artikel</label>
                                <input type="text" name="judul" class="form-control form-control-sm" placeholder="Masukkan judul..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Kategori</label>
                                <select name="id_kategori" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $kat = mysqli_query($conn, "SELECT * FROM kategori");
                                    while($k = mysqli_fetch_array($kat)) {
                                        echo "<option value='$k[id_kategori]'>$k[nama_kategori]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Isi Berita</label>
                                <textarea name="isi" class="form-control form-control-sm" rows="5" placeholder="Tulis konten..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Gambar Cover</label>
                                <input type="file" name="gambar" class="form-control form-control-sm" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">
                                <i class="bi bi-send-fill me-2"></i>Publish Sekarang
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-list-stars me-2"></i>Manajemen Konten</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr class="small">
                                        <th>ARTIKEL</th>
                                        <th>KATEGORI</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $res = mysqli_query($conn, "SELECT berita.*, kategori.nama_kategori FROM berita 
                                                                LEFT JOIN kategori ON berita.id_kategori = kategori.id_kategori 
                                                                ORDER BY id DESC");
                                    while($row = mysqli_fetch_array($res)) { ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold small"><?= $row['judul']; ?></div>
                                            <small class="text-muted"><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($row['tanggal'])); ?></small>
                                        </td>
                                        <td><span class="badge bg-light text-primary border border-primary-subtle"><?= $row['nama_kategori']; ?></span></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus berita ini?')"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>