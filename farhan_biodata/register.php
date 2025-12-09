<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($name === '' || $email === '' || $password === '') {
        $error = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error = 'Email sudah terdaftar, silakan login.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $insert = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insert, 'sss', $name, $email, $hashed);
            if (mysqli_stmt_execute($insert)) {
                $_SESSION['message'] = 'Registrasi berhasil, silakan login.';
                header('Location: login.php');
                exit();
            } else {
                $error = 'Terjadi kesalahan saat menyimpan data.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Informasi Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="auth-illustration mb-2"><i class="fas fa-user-plus"></i></div>
                <h3 class="fw-bold mb-1">Buat Akun Baru</h3>
                <p class="text-muted">Dapatkan akses ke seluruh fitur</p>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" placeholder="Nama kamu" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="contoh@email.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-custom w-100">
                    <i class="fas fa-user-check me-2"></i>Daftar
                </button>
            </form>
            <p class="text-center text-muted mb-0">
                Sudah punya akun? <a href="login.php" class="fw-semibold">Masuk sekarang</a>
            </p>
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted"><i class="fas fa-arrow-left me-1"></i>Kembali ke beranda</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

