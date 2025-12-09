<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
        $error = 'Email dan password wajib diisi.';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, name, password FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['message'] = 'Selamat datang kembali, ' . $user['name'] . '!';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Email atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="auth-illustration mb-2"><i class="fas fa-lock"></i></div>
                <h3 class="fw-bold mb-1">Masuk</h3>
                <p class="text-muted">Akses dashboard biodata, kehadiran, dan kegiatan</p>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <form method="POST" class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="contoh@email.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-custom w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </form>
            <p class="text-center text-muted mb-0">
                Belum punya akun? <a href="register.php" class="fw-semibold">buat di sini</a>
            </p>
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted"><i class="fas fa-arrow-left me-1"></i>Kembali ke beranda</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

