<?php
session_start();

// Redirect ke dashboard sesuai peran jika sudah login
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: dashboard_admin.php');
        exit();
    } elseif ($_SESSION['user']['role'] === 'pegawai') {
        header('Location: dashboard_pegawai.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-md max-w-md text-center">
    <h1 class="text-2xl font-semibold mb-4">Sistem Manajemen Pegawai</h1>
    <p class="text-gray-700 mb-6">Silakan login untuk mengakses dashboard</p>
    
    <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
</div>

</body>
</html>
