<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $kursus_id = $_POST['kursus_id'];
    $pertanyaan = $_POST['pertanyaan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];
    
    try {
        $stmt = $conn->prepare("UPDATE soal SET 
                              kursus_id = ?, 
                              pertanyaan = ?, 
                              opsi_a = ?, 
                              opsi_b = ?, 
                              opsi_c = ?, 
                              opsi_d = ?, 
                              jawaban_benar = ? 
                              WHERE id = ?");
        $stmt->execute([$kursus_id, $pertanyaan, $opsi_a, $opsi_b, $opsi_c, $opsi_d, $jawaban_benar, $id]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Soal berhasil diperbarui',
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