<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kursus_id = $_POST['kursus_id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $file_link = $_POST['file_link'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO materi (kursus_id, judul, isi, file_link) VALUES (?, ?, ?, ?)");
        $stmt->execute([$kursus_id, $judul, $isi, $file_link]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Materi baru telah ditambahkan',
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
        header("Location: tambah.php?kursus_id=$kursus_id");
        exit();
    }
} else {
    header("Location: tambah.php");
    exit();
}