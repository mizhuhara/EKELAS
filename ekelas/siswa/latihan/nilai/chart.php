<?php
require_once '../../../config/database.php';
require_once '../../../includes/auth.php';
requireSiswa();

// Ambil 10 latihan terakhir untuk chart
$stmt = $conn->prepare("SELECT nilai, DATE_FORMAT(tanggal, '%d/%m') as tanggal 
                       FROM hasil_latihan
                       WHERE siswa_id = ?
                       ORDER BY tanggal DESC
                       LIMIT 10");
$stmt->execute([$_SESSION['user_id']]);
$data = $stmt->fetchAll();

// Format data untuk chart
$labels = [];
$nilai = [];

foreach (array_reverse($data) as $row) {
    $labels[] = $row['tanggal'];
    $nilai[] = $row['nilai'];
}

header('Content-Type: application/json');
echo json_encode([
    'labels' => $labels,
    'nilai' => $nilai
]);
?>