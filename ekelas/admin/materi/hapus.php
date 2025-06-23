<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? 0;

try {
    // Ambil kursus_id sebelum menghapus untuk redirect
    $stmt = $conn->prepare("SELECT kursus_id FROM materi WHERE id = ?");
    $stmt->execute([$id]);
    $materi = $stmt->fetch();
    
    if ($materi) {
        $stmt = $conn->prepare("DELETE FROM materi WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Materi berhasil dihapus',
            'icon' => 'success'
        ];
        header("Location: index.php?kursus_id=".$materi['kursus_id']);
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