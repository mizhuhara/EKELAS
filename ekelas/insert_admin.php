<?php
require_once 'config/database.php'; // Pastikan koneksi ke database sudah benar

// Data admin baru
$email = 'kazuya1@gmail.com';
$passwordPlain = 'kazuya123';

// Hash password
$hashedPassword = password_hash($passwordPlain, PASSWORD_DEFAULT);

// Siapkan dan eksekusi query insert
$stmt = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hashedPassword]);

echo "Admin baru berhasil ditambahkan dengan email: $email";
