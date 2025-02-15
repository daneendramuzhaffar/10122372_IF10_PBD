<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $id_jabatan = $_POST['id_jabatan'];
    $gaji = $_POST['gaji'];
    $password = $_POST['password'];
    $tanggal_lahir= $_POST['tanggal_lahir'];

    $query = "INSERT INTO pegawai (nama, email, id_jabatan, gaji, tanggal_lahir, password) VALUES ('$nama', '$email', '$id_jabatan', '$gaji', '$tanggal_lahir', '$password')";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard_admin.php');
        exit();
    } else {
        $error = "Gagal menambahkan pegawai: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-lg mx-auto bg-white p-6 mt-10 rounded-lg shadow-md">
    <h2 class="text-center text-2xl font-semibold mb-4">Tambah Pegawai</h2>
    <?php if (isset($error)) { echo "<p class='text-red-500'>$error</p>"; } ?>
    <form method="POST" action="">
        <div class="mb-4">
            <label class="block text-gray-700">Nama</label>
            <input type="text" name="nama" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="text" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">tanggal lahir</label>
            <input type="date" name="tanggal_lahir" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Gaji</label>
        <input type="text" name="gaji" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Jabatan</label>
            <select name="id_jabatan" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php
                $jabatan_query = "SELECT * FROM jabatan";
                $jabatan_result = mysqli_query($conn, $jabatan_query);
                while ($jabatan = mysqli_fetch_assoc($jabatan_result)) {
                    echo "<option value='" . $jabatan['id_jabatan'] . "'>" . $jabatan['nama_jabatan'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="flex justify-between">
            <a href="dashboard_admin.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </div>
    </form>
</div>
</body>
</html>
