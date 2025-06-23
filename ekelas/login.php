<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header("Location: " . (isAdmin() ? 'admin/dashboard.php' : 'siswa/dashboard.php'));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['email'] = $admin['email'];
        $_SESSION['nama'] = 'Administrator';
        $_SESSION['role'] = 'admin';
        header("Location: admin/dashboard.php");
        exit();
    }
    
    // Cek di tabel siswa
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE email = ?");
    $stmt->execute([$email]);
    $siswa = $stmt->fetch();
    
    if ($siswa && password_verify($password, $siswa['password'])) {
        $_SESSION['user_id'] = $siswa['id'];
        $_SESSION['email'] = $siswa['email'];
        $_SESSION['nama'] = $siswa['nama'];
        $_SESSION['role'] = 'siswa';
        header("Location: siswa/dashboard.php");
        exit();
    }
    
    $_SESSION['flash_message'] = [
        'title' => 'Login Gagal',
        'text' => 'Email atau password salah',
        'icon' => 'error'
    ];
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login eKelas</h3>
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['flash_message']['text'] ?>
                        </div>
                        <?php unset($_SESSION['flash_message']); ?>
                    <?php endif; ?>
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                   placeholder="Masukkan password">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

