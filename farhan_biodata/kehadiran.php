<?php
session_start();
include 'config.php';
include 'auth_check.php';

// Pastikan kolom nama_panjang ada (abaikan error jika sudah ada)
mysqli_query($conn, "ALTER TABLE kehadiran ADD COLUMN nama_panjang VARCHAR(200) NULL");

$userName = $_SESSION['user_name'] ?? 'Pengguna';

// Proses tambah/edit kehadiran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $tanggal = $_POST['tanggal'];
            $waktu_masuk = $_POST['waktu_masuk'];
            $waktu_keluar = $_POST['waktu_keluar'];
            $status = $_POST['status'];
            $nama_panjang = mysqli_real_escape_string($conn, $_POST['nama_panjang']);
            $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

            $query = "INSERT INTO kehadiran (tanggal, waktu_masuk, waktu_keluar, status, keterangan, nama_panjang) 
                      VALUES ('$tanggal', '$waktu_masuk', '$waktu_keluar', '$status', '$keterangan', '$nama_panjang')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Data kehadiran berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        } elseif ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $tanggal = $_POST['tanggal'];
            $waktu_masuk = $_POST['waktu_masuk'];
            $waktu_keluar = $_POST['waktu_keluar'];
            $status = $_POST['status'];
            $nama_panjang = mysqli_real_escape_string($conn, $_POST['nama_panjang']);
            $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

            $query = "UPDATE kehadiran SET tanggal='$tanggal', waktu_masuk='$waktu_masuk', 
                      waktu_keluar='$waktu_keluar', status='$status', nama_panjang='$nama_panjang', keterangan='$keterangan' WHERE id=$id";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Data kehadiran berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        }
    }
    header("Location: kehadiran.php");
    exit();
}

// Ambil data kehadiran
$query = "SELECT * FROM kehadiran ORDER BY tanggal DESC, waktu_masuk DESC";
$result = mysqli_query($conn, $query);

// Hitung statistik
$query_hadir = "SELECT COUNT(*) as total FROM kehadiran WHERE status = 'Hadir'";
$result_hadir = mysqli_query($conn, $query_hadir);
$total_hadir = mysqli_fetch_assoc($result_hadir)['total'];

$query_sakit = "SELECT COUNT(*) as total FROM kehadiran WHERE status = 'Sakit'";
$result_sakit = mysqli_query($conn, $query_sakit);
$total_sakit = mysqli_fetch_assoc($result_sakit)['total'];

$query_izin = "SELECT COUNT(*) as total FROM kehadiran WHERE status = 'Izin'";
$result_izin = mysqli_query($conn, $query_izin);
$total_izin = mysqli_fetch_assoc($result_izin)['total'];

$query_alpha = "SELECT COUNT(*) as total FROM kehadiran WHERE status = 'Alpha'";
$result_alpha = mysqli_query($conn, $query_alpha);
$total_alpha = mysqli_fetch_assoc($result_alpha)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran - Sistem Informasi Personal</title>
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
                        <a class="nav-link active" href="kehadiran.php">Kehadiran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kegiatan.php">Kegiatan</a>
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
                    <i class="fas fa-calendar-check me-2"></i>Sistem Kehadiran
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
                    <h3 class="status-hadir"><?php echo $total_hadir; ?></h3>
                    <p class="text-muted mb-0">Hadir</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="status-sakit"><?php echo $total_sakit; ?></h3>
                    <p class="text-muted mb-0">Sakit</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="status-izin"><?php echo $total_izin; ?></h3>
                    <p class="text-muted mb-0">Izin</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="status-alpha"><?php echo $total_alpha; ?></h3>
                    <p class="text-muted mb-0">Alpha</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Form Kehadiran -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Tambah Kehadiran
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Masuk</label>
                                    <input type="time" class="form-control" name="waktu_masuk">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Keluar</label>
                                    <input type="time" class="form-control" name="waktu_keluar">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Panjang</label>
                                <input type="text" class="form-control" name="nama_panjang" placeholder="Masukkan nama lengkap">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Simpan Kehadiran
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Kehadiran -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Kehadiran
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Panjang</th>
                                            <th>Tanggal</th>
                                            <th>Waktu Masuk</th>
                                            <th>Waktu Keluar</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $row['nama_panjang'] ?: '-'; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                                <td><?php echo $row['waktu_masuk'] ? date('H:i', strtotime($row['waktu_masuk'])) : '-'; ?></td>
                                                <td><?php echo $row['waktu_keluar'] ? date('H:i', strtotime($row['waktu_keluar'])) : '-'; ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        echo $row['status'] == 'Hadir' ? 'success' : 
                                                            ($row['status'] == 'Sakit' ? 'warning' : 
                                                            ($row['status'] == 'Izin' ? 'info' : 'danger')); 
                                                    ?>">
                                                        <?php echo $row['status']; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $row['keterangan'] ?: '-'; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" onclick="editKehadiran(<?php echo $row['id']; ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted">
                                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                <p>Belum ada data kehadiran</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kehadiran -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kehadiran</h5>
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
        function editKehadiran(id) {
            // Load kehadiran data for editing via AJAX
            fetch('get_kehadiran.php?id=' + id)
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
                                <label class="form-label">Nama Panjang</label>
                                <input type="text" class="form-control" name="nama_panjang" value="${data.nama_panjang || ''}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Masuk</label>
                                    <input type="time" class="form-control" name="waktu_masuk" value="${data.waktu_masuk || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Keluar</label>
                                    <input type="time" class="form-control" name="waktu_keluar" value="${data.waktu_keluar || ''}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="Hadir" ${data.status == 'Hadir' ? 'selected' : ''}>Hadir</option>
                                    <option value="Sakit" ${data.status == 'Sakit' ? 'selected' : ''}>Sakit</option>
                                    <option value="Izin" ${data.status == 'Izin' ? 'selected' : ''}>Izin</option>
                                    <option value="Alpha" ${data.status == 'Alpha' ? 'selected' : ''}>Alpha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3">${data.keterangan || ''}</textarea>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Update Kehadiran
                            </button>
                        </form>
                    `;
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                });
        }
    </script>
</body>
</html> 