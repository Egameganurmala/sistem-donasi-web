<?php
session_start();
include "config/koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "
    SELECT d.*, p.nama_program 
    FROM donasi d
    JOIN donasi_program p ON d.program_id = p.id
    WHERE d.id = '$id'
");

if (mysqli_num_rows($query) === 0) {
    echo "<h3 style='text-align:center;margin-top:50px;'>Data donasi tidak ditemukan.</h3>";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bukti Donasi - <?= htmlspecialchars($data['nama_program']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">
  <div class="card shadow-lg mx-auto" style="max-width: 500px; border-radius: 15px;">
    <div class="card-body text-center">
      <h3 class="text-success mb-3">Terima Kasih atas Donasimu! 💚</h3>
      <h5><?= htmlspecialchars($data['nama_program']) ?></h5>
      <hr>

      <p><strong>Nama Donatur:</strong> <?= htmlspecialchars($data['nama_lengkap'] ?: 'Anonim') ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($data['email'] ?: '-') ?></p>
      <p><strong>Jumlah Donasi:</strong> Rp <?= number_format($data['jumlah'], 0, ',', '.') ?></p>
      <p><strong>Metode Pembayaran:</strong> <?= strtoupper($data['metode']) ?></p>
      <p><strong>No. Virtual Account:</strong> 
         <span id="va"><?= htmlspecialchars($data['no_va']) ?></span> 
         <button class="btn btn-sm btn-outline-secondary" onclick="copyVA()">Salin</button>
      </p>
      <p><strong>Tanggal Donasi:</strong> <?= date('d-m-Y H:i', strtotime($data['tgl_donasi'])) ?></p>
      <p><span class="badge bg-warning text-dark"><?= ucfirst($data['status']) ?></span></p>

      <div class="alert alert-info mt-3">
        Silakan transfer sesuai metode pembayaran yang kamu pilih<br>
        
      </div>

      <a href="index.php" class="btn btn-outline-success w-100 mt-3">Kembali ke Beranda</a>
    </div>
  </div>
</div>

<script>
function copyVA() {
  const va = document.getElementById('va').innerText;
  navigator.clipboard.writeText(va);
  alert("Nomor VA disalin: " + va);
}
</script>

</body>
</html>
