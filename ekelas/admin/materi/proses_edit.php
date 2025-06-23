<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $kursus_id = $_POST['kursus_id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $file_link = $_POST['file_link'];
    
    try {
        $stmt = $conn->prepare("UPDATE materi SET kursus_id = ?, judul = ?, isi = ?, file_link = ? WHERE id = ?");
        $stmt->execute([$kursus_id, $judul, $isi, $file_link, $id]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Materi berhasil diperbarui',
            'icon' => 'success'
        ];
        header("Location: index.php?kursus_id=$kursus_id");
        exit();
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = [
            'title' => 'Error!',
            'text' => $e->getMessage(),
            'icon' => 'error'
        ];
        header("Location: edit.php?id=$id");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}