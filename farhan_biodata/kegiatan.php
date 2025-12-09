<?php
session_start();
include 'config.php';
include 'auth_check.php';

$userName = $_SESSION['user_name'] ?? 'Pengguna';

// Proses tambah/edit kegiatan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $tanggal = $_POST['tanggal'];
            $nama_kegiatan = mysqli_real_escape_string($conn, $_POST['nama_kegiatan']);
            $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
            $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
            $waktu_mulai = $_POST['waktu_mulai'];
            $waktu_selesai = $_POST['waktu_selesai'];
            $status = $_POST['status'];

            $query = "INSERT INTO kegiatan (tanggal, nama_kegiatan, deskripsi, lokasi, waktu_mulai, waktu_selesai, status) 
                      VALUES ('$tanggal', '$nama_kegiatan', '$deskripsi', '$lokasi', '$waktu_mulai', '$waktu_selesai', '$status')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Kegiatan berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        } elseif ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $tanggal = $_POST['tanggal'];
            $nama_kegiatan = mysqli_real_escape_string($conn, $_POST['nama_kegiatan']);
            $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
            $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
            $waktu_mulai = $_POST['waktu_mulai'];
            $waktu_selesai = $_POST['waktu_selesai'];
            $status = $_POST['status'];

            $query = "UPDATE kegiatan SET tanggal='$tanggal', nama_kegiatan='$nama_kegiatan', 
                      deskripsi='$deskripsi', lokasi='$lokasi', waktu_mulai='$waktu_mulai', 
                      waktu_selesai='$waktu_selesai', status='$status' WHERE id=$id";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Kegiatan berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        }
    }
    header("Location: kegiatan.php");
    exit();
}

// Ambil data kegiatan
$query = "SELECT * FROM kegiatan ORDER BY tanggal DESC, waktu_mulai DESC";
$result = mysqli_query($conn, $query);

// Hitung statistik
$query_total = "SELECT COUNT(*) as total FROM kegiatan";
$result_total = mysqli_query($conn, $query_total);
$total_kegiatan = mysqli_fetch_assoc($result_total)['total'];

$query_selesai = "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Selesai'";
$result_selesai = mysqli_query($conn, $query_selesai);
$total_selesai = mysqli_fetch_assoc($result_selesai)['total'];

$query_berlangsung = "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Sedang Berlangsung'";
$result_berlangsung = mysqli_query($conn, $query_berlangsung);
$total_berlangsung = mysqli_fetch_assoc($result_berlangsung)['total'];

$query_dibatalkan = "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Dibatalkan'";
$result_dibatalkan = mysqli_query($conn, $query_dibatalkan);
$total_dibatalkan = mysqli_fetch_assoc($result_dibatalkan)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan - Sistem Informasi Personal</title>
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
                        <a class="nav-link active" href="kegiatan.php">Kegiatan</a>
                    </li>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title mb-4">
                    <i class="fas fa-tasks me-2"></i>Laporan Kegiatan
                </h2>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="text-primary"><?php echo $total_kegiatan; ?></h3>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="status-selesai"><?php echo $total_selesai; ?></h3>
                    <p class="text-muted mb-0">Selesai</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="status-berlangsung"><?php echo $total_berlangsung; ?></h3>
                    <p class="text-muted mb-0">Sedang Berlangsung</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="status-dibatalkan"><?php echo $total_dibatalkan; ?></h3>
                    <p class="text-muted mb-0">Dibatalkan</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Form Kegiatan -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Tambah Kegiatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Kegiatan</label>
                                <input type="text" class="form-control" name="nama_kegiatan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Mulai</label>
                                    <input type="time" class="form-control" name="waktu_mulai">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control" name="waktu_selesai">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="Sedang Berlangsung">Sedang Berlangsung</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Simpan Kegiatan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Kegiatan -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Kegiatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <div class="kegiatan-card">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="fw-bold mb-2"><?php echo $row['nama_kegiatan']; ?></h6>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?php echo date('d/m/Y', strtotime($row['tanggal'])); ?>
                                                <?php if ($row['waktu_mulai']): ?>
                                                    <i class="fas fa-clock ms-3 me-1"></i>
                                                    <?php echo date('H:i', strtotime($row['waktu_mulai'])); ?>
                                                    <?php if ($row['waktu_selesai']): ?>
                                                        - <?php echo date('H:i', strtotime($row['waktu_selesai'])); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </p>
                                            <?php if ($row['lokasi']): ?>
                                                <p class="text-muted mb-2">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    <?php echo $row['lokasi']; ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($row['deskripsi']): ?>
                                                <p class="mb-2"><?php echo $row['deskripsi']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-<?php 
                                                echo $row['status'] == 'Selesai' ? 'success' : 
                                                    ($row['status'] == 'Sedang Berlangsung' ? 'info' : 'danger'); 
                                            ?> mb-2">
                                                <?php echo $row['status']; ?>
                                            </span>
                                            <br>
                                            <button class="btn btn-sm btn-warning" onclick="editKegiatan(<?php echo $row['id']; ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center text-muted">
                                <i class="fas fa-tasks fa-3x mb-3"></i>
                                <p>Belum ada data kegiatan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kegiatan -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editKegiatan(id) {
            // Load kegiatan data for editing via AJAX
            fetch('get_kegiatan.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editModalBody').innerHTML = `
                        <form method="POST">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="${data.id}">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="${data.tanggal}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Kegiatan</label>
                                <input type="text" class="form-control" name="nama_kegiatan" value="${data.nama_kegiatan}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3">${data.deskripsi || ''}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" value="${data.lokasi || ''}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Mulai</label>
                                    <input type="time" class="form-control" name="waktu_mulai" value="${data.waktu_mulai || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control" name="waktu_selesai" value="${data.waktu_selesai || ''}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="Sedang Berlangsung" ${data.status == 'Sedang Berlangsung' ? 'selected' : ''}>Sedang Berlangsung</option>
                                    <option value="Selesai" ${data.status == 'Selesai' ? 'selected' : ''}>Selesai</option>
                                    <option value="Dibatalkan" ${data.status == 'Dibatalkan' ? 'selected' : ''}>Dibatalkan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Update Kegiatan
                            </button>
                        </form>
                    `;
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                });
        }
    </script>
</body>
</html> 