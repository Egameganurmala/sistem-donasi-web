<?php
session_start();
include "../config/koneksi.php";

// Cek user login
$user_id = $_SESSION['id'] ?? NULL;
$user = $user_id ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$user_id'")) : null;

// Ambil semua program donasi
$programs = mysqli_query($koneksi, "SELECT * FROM donasi_program ORDER BY id DESC");

// Ambil riwayat 5 donasi terakhir jika login
$riwayat = $user_id ? mysqli_query($koneksi, "
    SELECT d.*, p.nama_program 
    FROM donasi d 
    JOIN donasi_program p ON d.program_id = p.id 
    WHERE d.user_id = '$user_id'
    ORDER BY d.tgl_donasi DESC LIMIT 5
") : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DonasiYuk | Bersama Kita Berbagi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  :root {
    --hijau-utama: #2b9348;
    --hijau-gelap: #208b3a;
  }
  body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
  }
  .navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  .navbar-brand {
    font-weight: 700;
    color: var(--hijau-utama) !important;
  }
  .hero {
  background: linear-gradient(rgba(43,147,72,0.85), rgba(43,147,72,0.85)),
              url('../assets/images1.jpg') center/cover no-repeat;
  color: white;
  text-align: center;
  padding: 50px 20px;   /* 🔽 sebelumnya 100px */
  

  .hero h1 {
    font-weight: 700;
    font-size: 2.5rem;
  }
  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    transition: transform 0.3s;
  }
  .card:hover {
    transform: translateY(-5px);
  }
  .btn-success {
    background-color: var(--hijau-utama);
    border: none;
  }
  .btn-success:hover {
    background-color: var(--hijau-gelap);
  }
  footer {
    background: #ffffff;
    border-top: 2px solid #e9ecef;
  }
</style>
</head>
<body>

<!-- 🔹 NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="dashboard_user.php">💚 DonasiYuk</a>
    <div class="d-flex align-items-center">
      <?php if ($user): ?>
        <div class="dropdown">
          <a class="btn btn-outline-success dropdown-toggle" href="#" data-bs-toggle="dropdown">
            👤 <?= htmlspecialchars($user['username']); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="../login.php" class="btn btn-success">Login / Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- 🔹 HERO SECTION -->
<section class="hero">
  <div class="container">
    <h1>Selamat Datang, <?= $user ? htmlspecialchars($user['username']) : 'Donatur' ?>!</h1>
    <p class="lead mt-2">Terima kasih telah berkontribusi untuk membantu sesama 💚</p>
</section>

<!-- 🔹 PROGRAM DONASI -->
<section id="program" class="container py-5">
  <h2 class="text-center mb-4 text-success fw-bold">Program Donasi</h2>
  <div class="row justify-content-center">
    <?php
    if (mysqli_num_rows($programs) == 0) {
        echo "<p class='text-center text-muted'>Belum ada program donasi yang tersedia.</p>";
    }

    $no = 1;
    while ($p = mysqli_fetch_assoc($programs)) :
      $gambar = "../assets/gambar" . $no . ".jpeg";
      if (!file_exists($gambar)) {
          $gambar = "../assets/gambar1.jpeg";
      }
    ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="<?= $gambar ?>" class="card-img-top" alt="Program Donasi" style="height:220px; object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($p['nama_program']) ?></h5>
            <p class="text-muted small"><?= substr($p['deskripsi'], 0, 100) ?>...</p>
            <p><strong>Target:</strong> Rp <?= number_format($p['target'], 0, ',', '.') ?></p>
            <button class="btn btn-success w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#donasiModal"
                    data-id="<?= $p['id'] ?>"
                    data-nama="<?= htmlspecialchars($p['nama_program']) ?>">
              Donasi Sekarang
            </button>
          </div>
        </div>
      </div>
    <?php 
      $no++;
    endwhile; 
    ?>
  </div>
</section>

<!-- 🔹 RIWAYAT DONASI -->
<?php if($user): ?>
<section class="container mb-5">
  <div class="card p-3 shadow-sm">
    <h4 class="mb-3 text-success">Riwayat Donasi Terbaru</h4>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-success text-center">
          <tr>
            <th>Program</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php if(mysqli_num_rows($riwayat) > 0): ?>
            <?php while($r = mysqli_fetch_assoc($riwayat)): ?>
            <tr>
              <td><?= htmlspecialchars($r['nama_program']) ?></td>
              <td>Rp <?= number_format($r['jumlah'],0,',','.') ?></td>
              <td><span class="badge bg-<?= $r['status']=='terverifikasi'?'success':'warning text-dark' ?>">
                <?= ucfirst($r['status']) ?></span>
              </td>
              <td><?= date('d-m-Y H:i', strtotime($r['tgl_donasi'])) ?></td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center text-muted">Belum ada donasi</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- 🔹 FOOTER -->
<footer class="text-center py-3">
  <small>© <?= date('Y') ?> DonasiYuk — Bersama Kita Berbagi 💚</small>
</footer>

<!-- 🔹 MODAL DONASI -->
<div class="modal fade" id="donasiModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses_donasi.php" method="POST">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Form Donasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="program_id" id="program_id">
          <div class="mb-3">
            <label>Program Donasi</label>
            <input type="text" id="program_nama" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Kosongkan jika ingin anonim">
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email aktif (opsional)">
          </div>
          <div class="mb-3">
            <label>Nominal Donasi (Rp)</label>
            <input type="number" name="jumlah" class="form-control" required min="1000">
          </div>
          <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode" class="form-select" required>
              <option value="">-- Pilih E-Wallet --</option>
              <option value="ovo">OVO</option>
              <option value="dana">DANA</option>
              <option value="gopay">GoPay</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success w-100">Donasi Sekarang</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const modal = document.getElementById('donasiModal');
modal.addEventListener('show.bs.modal', event => {
  const button = event.relatedTarget;
  document.getElementById('program_id').value = button.getAttribute('data-id');
  document.getElementById('program_nama').value = button.getAttribute('data-nama');
});
</script>

</body>
</html>
