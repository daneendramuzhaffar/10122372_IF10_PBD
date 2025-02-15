<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-4xl mx-auto bg-white p-6 mt-10 rounded-lg shadow-md">
    <h2 class="text-center text-2xl font-semibold mb-4">Log Aktivitas Pegawai</h2>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID Log</th>
                    <th class="border border-gray-300 px-4 py-2">ID Pegawai</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    <th class="border border-gray-300 px-4 py-2">User Admin</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM log_pegawai ORDER BY tanggal DESC";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='border border-gray-300'>";
                    echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . $row['id_log'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . $row['id_pegawai'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . $row['aksi'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . $row['user_admin'] . "</td>";
                    echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . $row['tanggal'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <a href="dashboard_admin.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
    </div>
</div>

</body>
</html>
