<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? 0;

try {
    // Ambil kursus_id sebelum menghapus untuk redirect
    $stmt = $conn->prepare("SELECT kursus_id FROM soal WHERE id = ?");
    $stmt->execute([$id]);
    $soal = $stmt->fetch();
    
    if ($soal) {
        $stmt = $conn->prepare("DELETE FROM soal WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Soal berhasil dihapus',
            'icon' => 'success'
        ];
        header("Location: index.php?kursus_id=".$soal['kursus_id']);
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => $e->getMessage(),
        'icon' => 'error'
    ];
    header("Location: index.php");
    exit();
}