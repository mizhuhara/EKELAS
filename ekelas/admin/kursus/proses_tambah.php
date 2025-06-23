<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah.php");
    exit();
}

// Validasi input
$required_fields = ['judul', 'deskripsi', 'kategori'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['flash_message'] = [
            'title' => 'Error!',
            'text' => 'Semua field harus diisi',
            'icon' => 'error'
        ];
        header("Location: tambah.php");
        exit();
    }
}

$judul = trim($_POST['judul']);
$deskripsi = trim($_POST['deskripsi']);
$kategori = trim($_POST['kategori']);

// Validasi panjang judul
if (strlen($judul) > 255) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => 'Judul terlalu panjang (maks 255 karakter)',
        'icon' => 'error'
    ];
    header("Location: tambah.php");
    exit();
}

try {
    // Upload thumbnail jika ada
    $thumbnail_path = null;
    if (!empty($_FILES['thumbnail']['name'])) {
        $upload_dir = '../../assets/uploads/thumbnails/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array(strtolower($file_ext), $allowed_types)) {
            throw new Exception("Format file tidak didukung. Gunakan JPG, PNG, atau WEBP");
        }

        if ($_FILES['thumbnail']['size'] > 2 * 1024 * 1024) { // 2MB
            throw new Exception("Ukuran file terlalu besar (maks 2MB)");
        }

        $filename = 'kursus_' . time() . '.' . $file_ext;
        $destination = $upload_dir . $filename;

        if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $destination)) {
            throw new Exception("Gagal mengupload thumbnail");
        }

        $thumbnail_path = 'assets/uploads/thumbnails/' . $filename;
    }

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO kursus (judul, deskripsi, kategori, thumbnail) VALUES (?, ?, ?, ?)");
    $stmt->execute([$judul, $deskripsi, $kategori, $thumbnail_path]);

    $_SESSION['flash_message'] = [
        'title' => 'Berhasil!',
        'text' => 'Kursus baru berhasil ditambahkan',
        'icon' => 'success'
    ];
    
    header("Location: index.php");
    exit();

} catch (PDOException $e) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => 'Gagal menambahkan kursus: ' . $e->getMessage(),
        'icon' => 'error'
    ];
    header("Location: tambah.php");
    exit();
} catch (Exception $e) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => $e->getMessage(),
        'icon' => 'error'
    ];
    header("Location: tambah.php");
    exit();
}