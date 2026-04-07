<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Informatika - Terkini</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-color: #2c3e50; --accent-color: #e74c3c; }
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; color: #333; }
        
        /* Navbar Styling */
        .navbar { background: white !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: 700; color: var(--primary-color) !important; letter-spacing: 1px; }
        
        /* Hero Section */
        .hero-section { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; height: 300px; border-radius: 20px; display: flex; align-items: flex-end; padding: 40px; color: white; margin-bottom: 40px; }
        
        /* Card Styling */
        .news-card { border: none; border-radius: 15px; transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; background: white; }
        .news-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .news-card img { height: 200px; object-fit: cover; }
        .badge-category { position: absolute; top: 15px; left: 15px; background: var(--accent-color); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        
        /* Sidebar Styling */
        .sidebar-title { border-left: 4px solid var(--accent-color); padding-left: 15px; font-weight: 700; margin-bottom: 20px; }
        .list-trending { border: none; background: transparent; }
        .trending-item { background: white; border-radius: 10px; margin-bottom: 10px; transition: 0.2s; border: 1px solid #eee; }
        .trending-item:hover { background: #fff5f5; }
        
        /* Footer */
        footer { background: var(--primary-color); color: white; padding: 40px 0; margin-top: 50px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-lightning-fill text-danger"></i> INFO_HILAL</a>
            <div class="d-flex align-items-center">
                <form action="index.php" method="GET" class="d-none d-md-flex me-3">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control form-control-sm border-0 bg-light" placeholder="Cari berita..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                        <button class="btn btn-light btn-sm" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <a href="login.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">Admin Panel</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="hero-section shadow">
            <div>
                <span class="badge bg-danger mb-2">Breaking News</span>
                <h2 class="fw-bold">Selamat Datang di Portal Berita Ibrahim Hilal</h2>
                <p class="mb-0">Dapatkan informasi teknologi dan berita terbaru setiap hari.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <h4 class="sidebar-title mb-4">
                    <?php 
                    // Judul Dinamis berdasarkan filter
                    if(isset($_GET['cari'])) {
                        echo "Hasil Pencarian: '" . htmlspecialchars($_GET['cari']) . "'";
                    } elseif(isset($_GET['kategori'])) {
                        $id_k = mysqli_real_escape_string($conn, $_GET['kategori']);
                        $cek_kat = mysqli_query($conn, "SELECT nama_kategori FROM kategori WHERE id_kategori = '$id_k'");
                        if($nama_k = mysqli_fetch_array($cek_kat)) {
                            echo "Berita Kategori: " . $nama_k['nama_kategori'];
                        }
                    } else {
                        echo "Berita Terbaru";
                    }
                    ?>
                </h4>
                
                <div class="row">
                    <?php
                    // Logika SQL untuk Filter Data
                    $query_str = "SELECT berita.*, kategori.nama_kategori FROM berita 
                                  LEFT JOIN kategori ON berita.id_kategori = kategori.id_kategori";
                    
                    if(isset($_GET['cari'])) {
                        $key = mysqli_real_escape_string($conn, $_GET['cari']);
                        $query_str .= " WHERE berita.judul LIKE '%$key%' OR berita.isi LIKE '%$key%'";
                    } elseif(isset($_GET['kategori'])) {
                        $id_kategori = mysqli_real_escape_string($conn, $_GET['kategori']);
                        $query_str .= " WHERE berita.id_kategori = '$id_kategori'";
                    }
                    
                    $query_str .= " ORDER BY id DESC";
                    $sql = mysqli_query($conn, $query_str);

                    // Peringatan jika data kosong
                    if(mysqli_num_rows($sql) == 0) {
                        echo "<div class='col-12'><div class='alert alert-warning shadow-sm'>Belum ada berita yang ditemukan.</div></div>";
                    }

                    // Menampilkan Data
                    while($data = mysqli_fetch_array($sql)) { ?>
                    <div class="col-md-6 mb-4">
                        <div class="card news-card h-100 shadow-sm">
                            <span class="badge-category"><?= $data['nama_kategori']; ?></span>
                            <img src="img/<?= $data['gambar']; ?>" class="card-img-top" alt="News Image">
                            <div class="card-body p-4">
                                <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($data['tanggal'])); ?></small>
                                <h5 class="card-title fw-bold mt-2"><?= $data['judul']; ?></h5>
                                <p class="card-text text-muted small"><?= substr(strip_tags($data['isi']), 0, 100); ?>...</p>
                                <a href="detail.php?id=<?= $data['id']; ?>" class="btn btn-link text-danger p-0 fw-bold text-decoration-none">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-5">
                    <h5 class="sidebar-title">Kategori</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        // Menampilkan tombol kategori dari database
                        $kat = mysqli_query($conn, "SELECT * FROM kategori");
                        while($k = mysqli_fetch_array($kat)) {
                            echo "<a href='index.php?kategori=$k[id_kategori]' class='btn btn-white shadow-sm btn-sm border rounded-pill px-3'>#$k[nama_kategori]</a>";
                        }
                        ?>
                        <a href="index.php" class="btn btn-outline-danger shadow-sm btn-sm border rounded-pill px-3">Semua Berita</a>
                    </div>
                </div>

                <div>
                    <h5 class="sidebar-title">🔥 Lagi Rame</h5>
                    <div class="list-group list-trending">
                        <?php
                        $trending = mysqli_query($conn, "SELECT id, judul, views FROM berita ORDER BY views DESC LIMIT 5");
                        while($t = mysqli_fetch_array($trending)) { ?>
                        <a href="detail.php?id=<?= $t['id']; ?>" class="list-group-item trending-item p-3 text-decoration-none text-dark d-flex align-items-center">
                            <h4 class="me-3 mb-0 text-danger opacity-50 fw-bold">#</h4>
                            <div>
                                <h6 class="mb-0 small fw-bold"><?= $t['judul']; ?></h6>
                                <small class="text-muted"><?= $t['views']; ?> pembaca</small>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <h5 class="fw-bold mb-3">INFO_HILAL</h5>
            <p class="small opacity-75">Tugas UTS Pemrograman Web - Ibrahim Hilal - Teknik Informatika</p>
            <div class="d-flex justify-content-center gap-3">
                <i class="bi bi-instagram fs-5"></i>
                <i class="bi bi-github fs-5"></i>
                <i class="bi bi-linkedin fs-5"></i>
            </div>
            <hr class="my-4 opacity-25">
            <p class="mb-0 small">&copy; 2026 Ibrahim Hilal. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
