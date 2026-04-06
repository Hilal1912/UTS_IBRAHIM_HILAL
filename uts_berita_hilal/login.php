<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek ke database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['admin'] = $user; // Menyimpan session
        header("location: admin.php");
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; height: 100vh; display: flex; align-items: center; }
        .card { border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">ADMIN LOGIN</h4>
                    <p class="text-muted small">Silahkan masuk ke panel kontrol</p>
                </div>
                
                <?php if(isset($error)) : ?>
                    <div class="alert alert-danger small py-2"><?= $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="admin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="******" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 fw-bold">Masuk</button>
                    <div class="text-center mt-3">
                        <a href="index.php" class="text-decoration-none small text-muted">← Kembali ke Web</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>