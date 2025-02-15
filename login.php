<?php
session_start();
include 'koneksi.php'; // Koneksi database

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Cek di tabel admin
    $query_admin = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result_admin = mysqli_query($conn, $query_admin);
    
    if (mysqli_num_rows($result_admin) > 0) {
        $admin = mysqli_fetch_assoc($result_admin);
        $_SESSION['user'] = [
            'id' => $admin['id_admin'],
            'email' => $admin['email'],
            'role' => 'admin'
        ];
        header('Location: dashboard_admin.php');
        exit();
    }
    
    // Cek di tabel pegawai
    $query_pegawai = "SELECT * FROM pegawai WHERE email = '$email' AND password = '$password'";
    $result_pegawai = mysqli_query($conn, $query_pegawai);
    
    if (mysqli_num_rows($result_pegawai) > 0) {
        $pegawai = mysqli_fetch_assoc($result_pegawai);
        $_SESSION['user'] = [
            'id_pegawai' => $pegawai['id_pegawai'], // Pastikan ada
            'nama' => $pegawai['nama'],
            'email' => $pegawai['email'],
            'role' => 'pegawai'
        ];        
        header('Location: dashboard_pegawai.php');
        exit();
    }
    
    $error = "Email atau password salah";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"> <?= $error ?> </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>