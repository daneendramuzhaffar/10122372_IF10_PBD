<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ada

// Cek apakah user sudah login dan memiliki peran pegawai
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pegawai') {
    header('Location: login.php');
    exit();
}

$id_pegawai = $_SESSION['user']['id_pegawai'];

// Ambil data pegawai dari database
$query = "SELECT pegawai.nama, pegawai.email, pegawai.gaji, jabatan.nama_jabatan 
          FROM pegawai 
          JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan 
          WHERE pegawai.id_pegawai = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pegawai);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pegawai = mysqli_fetch_assoc($result);

// Proses perubahan password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    
    // Ambil password pegawai saat ini
    $query_password = "SELECT password FROM pegawai WHERE id_pegawai = ?";
    $stmt_password = mysqli_prepare($conn, $query_password);
    mysqli_stmt_bind_param($stmt_password, "i", $id_pegawai);
    mysqli_stmt_execute($stmt_password);
    $result_password = mysqli_stmt_get_result($stmt_password);
    $data_password = mysqli_fetch_assoc($result_password);

    // Cek apakah password lama sesuai
    if ($password_lama === $data_password['password']) {
        // Update password baru
        $query_update = "UPDATE pegawai SET password = ? WHERE id_pegawai = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "si", $password_baru, $id_pegawai);
        mysqli_stmt_execute($stmt_update);
        
        $message = "Password berhasil diperbarui!";
    } else {
        $error = "Password lama salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-lg mx-auto bg-white p-6 mt-10 rounded-lg shadow-md">
    <h2 class="text-center text-2xl font-semibold mb-4">Dashboard Pegawai</h2>
    <p class="text-center mb-4">Selamat datang, <strong><?= htmlspecialchars($pegawai['nama']) ?></strong></p>

    <!-- Tampilkan Data Pegawai -->
    <div class="mb-6">
        <p><strong>Email:</strong> <?= htmlspecialchars($pegawai['email']) ?></p>
        <p><strong>Jabatan:</strong> <?= htmlspecialchars($pegawai['nama_jabatan']) ?></p>
        <p><strong>Gaji:</strong> Rp<?= number_format($pegawai['gaji'], 0, ',', '.') ?></p>
    </div>

    <div class="flex justify-between">
            <a href="ganti_password.php" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ganti Password</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
        </div>

    </form>
</div>

</body>
</html>
