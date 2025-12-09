<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Informasi Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <i class="fas fa-user-circle me-2"></i>Biodata Farhan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="biodata.php">Biodata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kehadiran.php">Kehadiran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kegiatan.php">Kegiatan</a>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item d-flex align-items-center ms-2">
                            <span class="badge bg-light text-dark fw-semibold px-3 py-2">
                                <i class="fas fa-user-circle me-2 text-primary"></i><?php echo htmlspecialchars($userName); ?>
                            </span>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link text-danger fw-semibold" href="logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-primary text-white px-3 py-2" href="register.php">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 110px;">
        <div class="hero-section">
            <p class="text-uppercase fw-bold mb-3" style="letter-spacing: 2px;">Dashboard</p>
            <h1 class="display-5 fw-bold mb-3">Sistem Informasi Personal</h1>
            <p class="lead mb-4">Kelola biodata, kehadiran, dan laporan kegiatan dalam satu tempat dengan tampilan yang lebih segar.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="login.php" class="btn btn-custom btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="register.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Register
                </a>
            </div>
            <?php if ($isLoggedIn): ?>
                <p class="mt-3 text-white-50 mb-0">Sudah login sebagai <?php echo htmlspecialchars($userName); ?>, lanjutkan ke <a class="text-white" href="index.php">beranda</a>.</p>
            <?php endif; ?>
        </div>

        <div class="row gy-4">
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h4>Biodata Lengkap</h4>
                    <p class="text-muted">Simpan dan kelola informasi personal dengan mudah dan rapi.</p>
                    <a href="biodata.php" class="btn btn-custom w-100">Masuk Biodata</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4>Kehadiran Cepat</h4>
                    <p class="text-muted">Catat status kehadiran harian dan pantau statistiknya.</p>
                    <a href="kehadiran.php" class="btn btn-custom w-100">Buka Kehadiran</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>Agenda Kegiatan</h4>
                    <p class="text-muted">Rencanakan dan dokumentasikan kegiatan lengkap dengan status.</p>
                    <a href="kegiatan.php" class="btn btn-custom w-100">Lihat Kegiatan</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-white mt-5 py-4">
        <div class="container">
            <p class="mb-0">&copy; 2024 Biodata Farhan. Dashboard entry point dengan login & register.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

