<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Cek apakah user sudah login sebagai pegawai
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pegawai') {
    header('Location: login.php');
    exit();
}

$id_pegawai = $_SESSION['user']['id_pegawai'];

// Proses perubahan password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Ambil password pegawai saat ini dari database
    $query_password = "SELECT password FROM pegawai WHERE id_pegawai = ?";
    $stmt_password = mysqli_prepare($conn, $query_password);
    mysqli_stmt_bind_param($stmt_password, "i", $id_pegawai);
    mysqli_stmt_execute($stmt_password);
    $result_password = mysqli_stmt_get_result($stmt_password);
    $data_password = mysqli_fetch_assoc($result_password);

    // Cek apakah password lama sesuai (tanpa hashing)
    if ($password_lama === $data_password['password']) {
        // Cek apakah password baru dan konfirmasi password cocok
        if ($password_baru === $konfirmasi_password) {
            // Update password baru tanpa hashing
            $query_update = "UPDATE pegawai SET password = ? WHERE id_pegawai = ?";
            $stmt_update = mysqli_prepare($conn, $query_update);
            mysqli_stmt_bind_param($stmt_update, "si", $password_baru, $id_pegawai);
            mysqli_stmt_execute($stmt_update);
            
            $message = "Password berhasil diperbarui!";
        } else {
            $error = "Konfirmasi password tidak cocok!";
        }
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
    <title>Ganti Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-lg mx-auto bg-white p-6 mt-10 rounded-lg shadow-md">
    <h2 class="text-center text-2xl font-semibold mb-4">Ganti Password</h2>

    <!-- Notifikasi -->
    <?php if (isset($message)) echo "<p class='text-green-500'>$message</p>"; ?>
    <?php if (isset($error)) echo "<p class='text-red-500'>$error</p>"; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="block text-gray-700">Password Lama</label>
            <input type="password" name="password_lama" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Password Baru</label>
            <input type="password" name="password_baru" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi_password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-between">
            <a href="dashboard_pegawai.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Password</button>
        </div>
    </form>
</div>

</body>
</html>
