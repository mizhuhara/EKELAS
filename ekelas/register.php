<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header("Location: " . (isAdmin() ? 'admin/dashboard.php' : 'siswa/dashboard.php'));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi
    if ($password !== $confirm_password) {
        $_SESSION['flash_message'] = [
            'title' => 'Registrasi Gagal',
            'text' => 'Password dan konfirmasi password tidak sama',
            'icon' => 'error'
        ];
        header("Location: register.php");
        exit();
    }
    
    // Cek email sudah terdaftar
    $stmt = $conn->prepare("SELECT id FROM siswa WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['flash_message'] = [
            'title' => 'Registrasi Gagal',
            'text' => 'Email sudah terdaftar',
            'icon' => 'error'
        ];
        header("Location: register.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO siswa (nama, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$nama, $email, $hashed_password]);
    
    $_SESSION['flash_message'] = [
        'title' => 'Registrasi Berhasil',
        'text' => 'Silakan login dengan akun yang telah dibuat',
        'icon' => 'success'
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
                    <h3 class="card-title text-center mb-4">Daftar Siswa</h3>
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?= $_SESSION['flash_message']['icon'] === 'error' ? 'danger' : 'success' ?>">
                            <?= $_SESSION['flash_message']['text'] ?>
                        </div>
                        <?php unset($_SESSION['flash_message']); ?>
                    <?php endif; ?>
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>