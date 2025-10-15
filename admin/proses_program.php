<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit;
}

// Tambah atau Edit
if(isset($_POST['simpan'])){
    $id = $_POST['id'] ?? '';
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_program']);
    $target = $_POST['target'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    if($id){ // Edit
        mysqli_query($koneksi, "UPDATE donasi_program SET nama_program='$nama', target='$target', deskripsi='$deskripsi' WHERE id='$id'");
    } else { // Tambah
        mysqli_query($koneksi, "INSERT INTO donasi_program (nama_program,target,deskripsi) VALUES ('$nama','$target','$deskripsi')");
    }
    header("Location: program_admin.php");
    exit;
}

// Hapus
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM donasi_program WHERE id='$id'");
    header("Location: program_admin.php");
    exit;
}
?>
