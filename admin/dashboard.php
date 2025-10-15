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

// Statistik
$total_users = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT COUNT(DISTINCT COALESCE(user_id, email)) AS total FROM donasi
"))['total'];
$total_programs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM donasi_program"))['total'];
$total_donasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM donasi"))['total'];

// Filter
$filter = "WHERE 1";
if(isset($_GET['status']) && $_GET['status'] != ''){
    $status = $_GET['status'];
    $filter .= " AND d.status='$status'";
}
if(isset($_GET['tgl_awal']) && $_GET['tgl_awal'] != ''){
    $filter .= " AND d.tgl_donasi >= '".$_GET['tgl_awal']." 00:00:00'";
}
if(isset($_GET['tgl_akhir']) && $_GET['tgl_akhir'] != ''){
    $filter .= " AND d.tgl_donasi <= '".$_GET['tgl_akhir']." 23:59:59'";
}

// Data donasi
$donasi = mysqli_query($koneksi, "
    SELECT d.*, COALESCE(u.username, d.nama_lengkap) AS donatur, p.nama_program 
    FROM donasi d
    LEFT JOIN users u ON d.user_id=u.id
    JOIN donasi_program p ON d.program_id=p.id
    $filter
    ORDER BY d.tgl_donasi DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - DonasiYuk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
  font-family: 'Poppins', sans-serif;
  background-color: #f4f6f8;
  margin: 0;
  padding: 0;
}
.sidebar {
  width: 240px;
  height: 100vh;
  position: fixed;
  background: linear-gradient(180deg, #2b9348, #208b3a);
  color: #fff;
  padding: 20px 0;
  top: 0;
  left: 0;
}
.sidebar h4 {
  font-weight: 700;
  text-align: center;
  margin-bottom: 30px;
}
.sidebar a {
  display: block;
  padding: 12px 25px;
  color: #fff;
  text-decoration: none;
  transition: 0.3s;
}
.sidebar a:hover, .sidebar a.active {
  background-color: rgba(255, 255, 255, 0.15);
  border-left: 4px solid #fff;
}
.main-content {
  margin-left: 240px;
  padding: 30px;
}
.topbar {
  background-color: white;
  padding: 15px 25px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  border-radius: 10px;
}
.card-stat {
  border: none;
  border-radius: 15px;
  background: white;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}
.card-stat:hover {
  transform: translateY(-5px);
}
.table thead {
  background: #2b9348;
  color: white;
}
.footer {
  text-align: center;
  padding: 15px 0;
  margin-top: 40px;
  color: #555;
}
</style>
</head>
<body>

<!-- 🔹 Sidebar -->
<div class="sidebar">
  <h4><i class="bi bi-heart-fill me-2"></i>DonasiYuk</h4>
  <a href="dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
  <a href="program_admin.php"><i class="bi bi-journal-text me-2"></i>Kelola Program</a>
  <a href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
</div>

<!-- 🔹 Main Content -->
<div class="main-content">
  <div class="topbar d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Dashboard Admin</h4>
    <span><i class="bi bi-person-circle me-1 text-success"></i><?= htmlspecialchars($admin['username']); ?></span>
  </div>

  <!-- 🔸 Statistik -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card-stat p-4 text-center">
        <i class="bi bi-people fs-1 text-success mb-2"></i>
        <h6>Total Donatur</h6>
        <h3><?= $total_users ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-stat p-4 text-center">
        <i class="bi bi-box2-heart fs-1 text-success mb-2"></i>
        <h6>Program Donasi</h6>
        <h3><?= $total_programs ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-stat p-4 text-center">
        <i class="bi bi-cash-stack fs-1 text-success mb-2"></i>
        <h6>Total Donasi (Rp)</h6>
        <h3><?= number_format($total_donasi,0,',','.') ?></h3>
      </div>
    </div>
  </div>

  <!-- 🔸 Filter -->
  <div class="card p-4 shadow-sm mb-4">
    <h5 class="fw-bold mb-3"><i class="bi bi-funnel me-2"></i>Filter Donasi</h5>
    <form method="GET" class="row g-3">
      <div class="col-md-3">
        <select name="status" class="form-select">
          <option value="">-- Semua Status --</option>
          <option value="pending" <?= (isset($_GET['status']) && $_GET['status']=='pending')?'selected':'' ?>>Pending</option>
          <option value="completed" <?= (isset($_GET['status']) && $_GET['status']=='completed')?'selected':'' ?>>Completed</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" name="tgl_awal" class="form-control" value="<?= $_GET['tgl_awal'] ?? '' ?>">
      </div>
      <div class="col-md-3">
        <input type="date" name="tgl_akhir" class="form-control" value="<?= $_GET['tgl_akhir'] ?? '' ?>">
      </div>
      <div class="col-md-3">
        <button class="btn btn-success w-100"><i class="bi bi-search me-1"></i>Filter</button>
      </div>
    </form>
  </div>

  <!-- 🔸 Tabel Donasi -->
  <div class="card p-4 shadow-sm">
    <h5 class="fw-bold mb-3"><i class="bi bi-table me-2"></i>Data Donasi</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="text-center">
          <tr>
            <th>Donatur</th>
            <th>Program</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($d = mysqli_fetch_assoc($donasi)): ?>
          <tr class="text-center">
            <td><?= htmlspecialchars($d['donatur']) ?></td>
            <td><?= htmlspecialchars($d['nama_program']) ?></td>
            <td>Rp <?= number_format($d['jumlah'],0,',','.') ?></td>
            <td>
              <?php if($d['status'] == 'completed'): ?>
                <span class="badge bg-success">Completed</span>
              <?php else: ?>
                <span class="badge bg-warning text-dark">Pending</span>
              <?php endif; ?>
            </td>
            <td><?= date('d-m-Y H:i', strtotime($d['tgl_donasi'])) ?> WIB</td>
            <td>
              <?php if($d['status'] == 'pending'): ?>
                <a href="proses_donasi_admin.php?selesai=<?= $d['id'] ?>" class="btn btn-success btn-sm">
                  <i class="bi bi-check-circle me-1"></i>Selesaikan
                </a>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="text-center py-3 bg-white border-top">
  <small>© <?= date('Y') ?> DonasiYuk — Bersama Kita Berbagi 💚</small>
</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
