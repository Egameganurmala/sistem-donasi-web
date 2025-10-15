<?php
session_start();
include "../config/koneksi.php";

// Cek login admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit;
}

// Cek apakah parameter selesai ada
if(isset($_GET['selesai'])){
    $donasi_id = $_GET['selesai'];

    // Update status donasi menjadi completed
    $update = mysqli_query($koneksi, "UPDATE donasi SET status='completed' WHERE id='$donasi_id'");

    if($update){
        $_SESSION['success'] = "Donasi berhasil diselesaikan.";
    } else {
        $_SESSION['error'] = "Gagal menyelesaikan donasi: " . mysqli_error($koneksi);
    }

    header("Location: dashboard.php");
    exit;
}

// Jika tidak ada parameter, kembali ke dashboard
header("Location: dashboard.php");
exit;
?>
