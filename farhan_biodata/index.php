<?php
session_start();
include 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Farhan - Sistem Informasi Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
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
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
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

    <!-- Main Content -->
    <div class="container" style="margin-top: 100px;">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="display-4 fw-bold mb-4">Selamat Datang di Sistem Informasi Personal</h1>
            <p class="lead mb-4">Kelola biodata, kehadiran, dan laporan kegiatan dengan tampilan baru yang lebih cerah.</p>
            <?php if ($isLoggedIn): ?>
                <a href="biodata.php" class="btn btn-custom btn-lg me-3">
                    <i class="fas fa-user me-2"></i>Lihat Biodata
                </a>
                <a href="kehadiran.php" class="btn btn-custom btn-lg me-3">
                    <i class="fas fa-calendar-check me-2"></i>Kehadiran
                </a>
                <a href="kegiatan.php" class="btn btn-custom btn-lg">
                    <i class="fas fa-tasks me-2"></i>Kegiatan
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-custom btn-lg me-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </a>
                <a href="register.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Daftar Akun
                </a>
            <?php endif; ?>
        </div>

        <!-- Features Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Biodata Lengkap</h4>
                    <p>Informasi personal yang lengkap dan terstruktur dengan baik</p>
                    <a href="biodata.php" class="btn btn-custom">Lihat Biodata</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4>Sistem Kehadiran</h4>
                    <p>Catatan kehadiran harian dengan status dan keterangan</p>
                    <a href="kehadiran.php" class="btn btn-custom">Kelola Kehadiran</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h4>Laporan Kegiatan</h4>
                    <p>Dokumentasi dan laporan kegiatan yang terorganisir</p>
                    <a href="kegiatan.php" class="btn btn-custom">Lihat Kegiatan</a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">
                            <i class="fas fa-chart-bar me-2"></i>Statistik Singkat
                        </h5>
                        <div class="row text-center">
                            <?php
                            // Hitung total kehadiran
                            $query_kehadiran = "SELECT COUNT(*) as total FROM kehadiran WHERE status = 'Hadir'";
                            $result_kehadiran = mysqli_query($conn, $query_kehadiran);
                            $total_hadir = mysqli_fetch_assoc($result_kehadiran)['total'];

                            // Hitung total kegiatan
                            $query_kegiatan = "SELECT COUNT(*) as total FROM kegiatan";
                            $result_kegiatan = mysqli_query($conn, $query_kegiatan);
                            $total_kegiatan = mysqli_fetch_assoc($result_kegiatan)['total'];

                            // Hitung kegiatan selesai
                            $query_selesai = "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Selesai'";
                            $result_selesai = mysqli_query($conn, $query_selesai);
                            $total_selesai = mysqli_fetch_assoc($result_selesai)['total'];
                            ?>
                            <div class="col-md-4">
                                <div class="border-end">
                                    <h3 class="text-primary"><?php echo $total_hadir; ?></h3>
                                    <p class="text-muted">Total Kehadiran</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-end">
                                    <h3 class="text-success"><?php echo $total_kegiatan; ?></h3>
                                    <p class="text-muted">Total Kegiatan</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-info"><?php echo $total_selesai; ?></h3>
                                <p class="text-muted">Kegiatan Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white mt-5 py-4">
        <div class="container">
            <p>&copy; 2024 Biodata Farhan. Dibuat dengan PHP dan Bootstrap.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 