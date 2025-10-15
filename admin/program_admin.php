<?php
session_start();
include "../config/koneksi.php";

// Cek login admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit;
}

// Data admin
$admin_id = $_SESSION['id'];
$admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$admin_id'"));

// Data semua program donasi
$programs = mysqli_query($koneksi, "SELECT * FROM donasi_program");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Program Donasi - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8fff6; /* Warna lembut seperti dashboard admin */
    min-height: 100vh;
}

/* === NAVBAR === */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: linear-gradient(90deg, #198754, #157347); /* Hijau khas dashboard admin */
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.navbar-brand {
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* === CARD === */
.card {
    border: none;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: 0.3s ease-in-out;
}
.card:hover {
    transform: translateY(-4px);
}

/* === TABLE === */
.table thead {
    background: #198754;
    color: white;
}
.table tbody tr:hover {
    background: #f0fff4;
}

/* === BUTTONS === */
.btn {
    border: none;
    border-radius: 10px;
    transition: 0.3s;
}
.btn-success {
    background: linear-gradient(90deg, #198754, #28a745);
}
.btn-success:hover {
    background: linear-gradient(90deg, #157347, #198754);
    transform: scale(1.03);
}
.btn-primary:hover, .btn-danger:hover, .btn-secondary:hover {
    transform: scale(1.03);
}

/* === MODAL === */
.modal-content {
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.modal-header {
    background: linear-gradient(90deg, #198754, #157347);
    color: white;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

h3.section-title {
    font-weight: 600;
    color: #198754;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">
      <i class="bi bi-heart-fill me-1"></i>DonasiYuk Admin
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <span class="nav-link"><i class="bi bi-person-circle me-1"></i><?= $admin['username'] ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container py-5">
  <div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="section-title"><i class="bi bi-journal-text me-2"></i>Manajemen Program Donasi</h3>
      <div>
        <a href="dashboard.php" class="btn btn-secondary me-2">
          <i class="bi bi-arrow-left-circle me-1"></i>Kembali
        </a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalProgram">
          <i class="bi bi-plus-circle me-1"></i>Tambah Program
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead>
          <tr>
            <th>Nama Program</th>
            <th>Target (Rp)</th>
            <th>Deskripsi</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = mysqli_fetch_assoc($programs)): ?>
          <tr>
            <td><?= htmlspecialchars($p['nama_program']) ?></td>
            <td><?= number_format($p['target'],0,',','.') ?></td>
            <td class="text-start"><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></td>
            <td>
              <button class="btn btn-primary btn-sm editProgram"
                data-id="<?= $p['id'] ?>"
                data-nama="<?= htmlspecialchars($p['nama_program']) ?>"
                data-target="<?= $p['target'] ?>"
                data-deskripsi="<?= htmlspecialchars($p['deskripsi']) ?>">
                <i class="bi bi-pencil-square"></i> Edit
              </button>
              <a href="proses_program.php?hapus=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin hapus program ini?')" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i> Hapus
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProgram" tabindex="-1" aria-labelledby="modalProgramLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses_program.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProgramLabel">Tambah Program</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="program_id">
          <div class="mb-3">
            <label class="form-label">Nama Program</label>
            <input type="text" name="nama_program" id="nama_program" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Target (Rp)</label>
            <input type="number" name="target" id="target" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="simpan" class="btn btn-success w-100">
            <i class="bi bi-check-circle me-1"></i> Simpan Program
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(".editProgram").click(function(){
    $("#program_id").val($(this).data("id"));
    $("#nama_program").val($(this).data("nama"));
    $("#target").val($(this).data("target"));
    $("#deskripsi").val($(this).data("deskripsi"));
    $("#modalProgramLabel").text("Edit Program Donasi");
    new bootstrap.Modal(document.getElementById('modalProgram')).show();
});
</script>

</body>
</html>
