<?php
session_start();
include 'config.php';
include 'auth_check.php';

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Pengguna';

// Proses tambah/edit biodata
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
            $pendidikan_terakhir = mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir']);
            $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);

            $query = "INSERT INTO biodata (nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, email, telepon, pendidikan_terakhir, pekerjaan) 
                      VALUES ('$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$email', '$telepon', '$pendidikan_terakhir', '$pekerjaan')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Biodata berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        } elseif ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
            $pendidikan_terakhir = mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir']);
            $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);

            $query = "UPDATE biodata SET nama='$nama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', 
                      jenis_kelamin='$jenis_kelamin', alamat='$alamat', email='$email', telepon='$telepon', 
                      pendidikan_terakhir='$pendidikan_terakhir', pekerjaan='$pekerjaan' WHERE id=$id";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Biodata berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        }
    }
    header("Location: biodata.php");
    exit();
}

// Ambil data biodata
$query = "SELECT * FROM biodata ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata - Sistem Informasi Personal</title>
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
                        <a class="nav-link active" href="biodata.php">Biodata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kehadiran.php">Kehadiran</a>
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
                    <i class="fas fa-user me-2"></i>Biodata Personal
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

        <div class="row">
            <!-- Form Biodata -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Tambah Biodata Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" class="form-control" name="telepon">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" class="form-control" name="pendidikan_terakhir">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Simpan Biodata
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Biodata -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Biodata
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>TTL</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $row['nama']; ?></td>
                                                <td><?php echo $row['tempat_lahir'] . ', ' . date('d/m/Y', strtotime($row['tanggal_lahir'])); ?></td>
                                                <td><?php echo $row['jenis_kelamin']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" onclick="viewBiodata(<?php echo $row['id']; ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning" onclick="editBiodata(<?php echo $row['id']; ?>)">
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
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Belum ada data biodata</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Biodata -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Biodata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Biodata -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Biodata</h5>
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
        function viewBiodata(id) {
            // Load biodata data via AJAX
            fetch('get_biodata.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('viewModalBody').innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> ${data.nama}</p>
                                <p><strong>Tempat Lahir:</strong> ${data.tempat_lahir}</p>
                                <p><strong>Tanggal Lahir:</strong> ${data.tanggal_lahir}</p>
                                <p><strong>Jenis Kelamin:</strong> ${data.jenis_kelamin}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> ${data.email || '-'}</p>
                                <p><strong>Telepon:</strong> ${data.telepon || '-'}</p>
                                <p><strong>Pendidikan:</strong> ${data.pendidikan_terakhir || '-'}</p>
                                <p><strong>Pekerjaan:</strong> ${data.pekerjaan || '-'}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p><strong>Alamat:</strong> ${data.alamat}</p>
                            </div>
                        </div>
                    `;
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                });
        }

        function editBiodata(id) {
            // Load biodata data for editing via AJAX
            fetch('get_biodata.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editModalBody').innerHTML = `
                        <form method="POST">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="${data.id}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="${data.nama}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" value="${data.tempat_lahir}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" value="${data.tanggal_lahir}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="Laki-laki" ${data.jenis_kelamin == 'Laki-laki' ? 'selected' : ''}>Laki-laki</option>
                                        <option value="Perempuan" ${data.jenis_kelamin == 'Perempuan' ? 'selected' : ''}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="3" required>${data.alamat}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="${data.email || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" class="form-control" name="telepon" value="${data.telepon || ''}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" class="form-control" name="pendidikan_terakhir" value="${data.pendidikan_terakhir || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan" value="${data.pekerjaan || ''}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Update Biodata
                            </button>
                        </form>
                    `;
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                });
        }
    </script>
</body>
</html> 