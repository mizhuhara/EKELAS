<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? 0;

try {
    // Hapus materi dan soal terkait terlebih dahulu karena ada foreign key constraint
    $conn->beginTransaction();
    
    // Hapus materi
    $stmt = $conn->prepare("DELETE FROM materi WHERE kursus_id = ?");
    $stmt->execute([$id]);
    
    // Hapus soal
    $stmt = $conn->prepare("DELETE FROM soal WHERE kursus_id = ?");
    $stmt->execute([$id]);
    
    // Hapus hasil latihan
    $stmt = $conn->prepare("DELETE FROM hasil_latihan WHERE kursus_id = ?");
    $stmt->execute([$id]);
    
    // Hapus kursus
    $stmt = $conn->prepare("DELETE FROM kursus WHERE id = ?");
    $stmt->execute([$id]);
    
    $conn->commit();
    
    $_SESSION['flash_message'] = [
        'title' => 'Berhasil!',
        'text' => 'Kursus berhasil dihapus',
        'icon' => 'success'
    ];
} catch (PDOException $e) {
    $conn->rollBack();
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => $e->getMessage(),
        'icon' => 'error'
    ];
}

header("Location: index.php");
exit();