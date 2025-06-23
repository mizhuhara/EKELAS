<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

requireSiswa();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kursus_id = $_POST['kursus_id'];
    $siswa_id = $_SESSION['user_id'];

    // Ambil kunci jawaban
    $stmt = $conn->prepare("SELECT id, jawaban_benar FROM soal WHERE kursus_id = ?");
    $stmt->execute([$kursus_id]);
    $soal = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Hitung nilai
    $score = 0;
    $total_questions = count($soal);

    foreach ($_POST as $key => $user_answer) {
        if (strpos($key, 'soal') !== false) {
            $question_id = str_replace('soal', '', $key);
            if (isset($soal[$question_id])) { // ✅ Kurung diperbaiki di sini
                if ($user_answer == $soal[$question_id]) {
                    $score += (100 / $total_questions);
                }
            }
        }
    }

    // Simpan hasil
    $score = round($score);
    $stmt = $conn->prepare("INSERT INTO hasil_latihan (siswa_id, kursus_id, nilai) VALUES (?, ?, ?)");
    $stmt->execute([$siswa_id, $kursus_id, $score]);

    // Tandai materi sebagai selesai jika belum
    $stmt = $conn->prepare("INSERT IGNORE INTO materi_selesai (siswa_id, kursus_id) VALUES (?, ?)");
    $stmt->execute([$siswa_id, $kursus_id]);

    header("Location: hasil.php");
    exit();
} else {
    header("Location: ../kursus/");
    exit();
}
