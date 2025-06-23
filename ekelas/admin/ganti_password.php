<?php
require_once '../../includes/auth.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    
    // Validasi
    if ($new_pass !== $confirm_pass) {
        $_SESSION['flash_message'] = [
            'title' => 'Error!',
            'text' => 'Password baru tidak sama',
            'icon' => 'error'
        ];
        header("Location: ganti_password.php");
        exit();
    }
    
    // Verifikasi password lama
    $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $admin = $stmt->fetch();
    
    if (!$admin || !password_verify($current_pass, $admin['password'])) {
        $_SESSION['flash_message'] = [
            'title' => 'Error!',
            'text' => 'Password saat ini salah',
            'icon' => 'error'
        ];
        header("Location: ganti_password.php");
        exit();
    }
    
    // Update password
    $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
    $stmt->execute([$new_hash, $_SESSION['user_id']]);
    
    $_SESSION['flash_message'] = [
        'title' => 'Berhasil!',
        'text' => 'Password berhasil diubah',
        'icon' => 'success'
    ];
    header("Location: dashboard.php");
    exit();
}

include '../../includes/header.php';
?>

<!-- Form ganti password -->
<div class="container">
    <form method="POST">
        <div class="mb-3">
            <label>Password Saat Ini</label>
            <input type="password" name="current_pass" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_pass" class="form-control" required minlength="8">
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="confirm_pass" class="form-control" required minlength="8">
        </div>
        <button type="submit" class="btn btn-primary">Ganti Password</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>