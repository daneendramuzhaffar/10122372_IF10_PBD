<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_pegawai = $_GET['id'];
    
    $query = "DELETE FROM pegawai WHERE id_pegawai = '$id_pegawai'";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard_admin.php');
        exit();
    } else {
        echo "<script>alert('Gagal menghapus pegawai'); window.location='dashboard_admin.php';</script>";
    }
} else {
    header('Location: dashboard_admin.php');
    exit();
}
?>
