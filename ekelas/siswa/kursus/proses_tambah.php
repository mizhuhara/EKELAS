<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO kursus (judul, deskripsi, kategori) VALUES (?, ?, ?)");
        $stmt->execute([$judul, $deskripsi, $kategori]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Kursus baru telah ditambahkan',
            'icon' => 'success'
        ];
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = [
            'title' => 'Error!',
            'text' => $e->getMessage(),
            'icon' => 'error'
        ];
        header("Location: tambah.php");
        exit();
    }
} else {
    header("Location: tambah.php");
    exit();
}