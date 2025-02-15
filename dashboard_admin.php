<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto bg-white p-8 mt-10 rounded-lg shadow-lg">
    <h2 class="text-center text-3xl font-bold text-gray-700 mb-6">Dashboard Admin</h2>
    <p class="text-center mb-6 text-lg text-gray-600">Selamat datang, <strong><?= $_SESSION['user']['email']; ?></strong></p>

    <div class="flex justify-between mb-6">
        <a href="tambah_pegawai.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Tambah Pegawai</a>
        <a href="log.php" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Lihat Log</a>
        <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Logout</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-3 text-left">ID</th>
                    <th class="border border-gray-300 px-4 py-3 text-left">Nama</th>
                    <th class="border border-gray-300 px-4 py-3 text-left">Email</th>
                    <th class="border border-gray-300 px-4 py-3 text-left">Jabatan</th>
                    <th class="border border-gray-300 px-4 py-3 text-left">Gaji</th>
                    <th class="border border-gray-300 px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                $query = "SELECT pegawai.id_pegawai, pegawai.nama, pegawai.email, jabatan.nama_jabatan, pegawai.gaji
                          FROM pegawai 
                          JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='border border-gray-300 hover:bg-gray-100 transition'>";
                    echo "<td class='border border-gray-300 px-4 py-3'>" . $row['id_pegawai'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-3'>" . $row['nama'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-3'>" . $row['email'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-3'>" . $row['nama_jabatan'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-3'>" . number_format($row['gaji'], 0, ',', '.') . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-3 text-center'>
                            <a href='edit_pegawai.php?id=" . $row['id_pegawai'] . "' class='bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition'>Edit</a>
                            <a href='hapus_pegawai.php?id=" . $row['id_pegawai'] . "' 
                            class='bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition' 
                            onclick='return confirm(\"Apakah Anda yakin ingin menghapus pegawai ini? Data yang dihapus tidak dapat dikembalikan.\")'>
                            Hapus</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
