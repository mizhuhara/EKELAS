<?php
// includes/auth.php

// PENTING: Memulai sesi PHP di awal.
// Ini harus ada dan dipanggil hanya sekali di setiap request.
// Karena Anda punya ini di auth.php, pastikan auth.php di-include/require_once di setiap halaman yang membutuhkan sesi.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Cek apakah user sudah login
function isLoggedIn() {
    // Memeriksa keberadaan user_id DAN email di session untuk memastikan login
    return isset($_SESSION['user_id']) && isset($_SESSION['email']);
}

// Cek role admin
function isAdmin() {
    // Memeriksa apakah user login dan role-nya 'admin'
    return isLoggedIn() && (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

// Cek role siswa
function isSiswa() {
    // Memeriksa apakah user login dan role-nya 'siswa'
    return isLoggedIn() && (isset($_SESSION['role']) && $_SESSION['role'] === 'siswa');
}

// Redirect jika belum login (fungsi ini TIDAK akan digunakan di index.php)
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Simpan URL yang ingin diakses
        header("Location: ../login.php"); // Arahkan ke halaman login
        exit();
    }
}

// Redirect admin (fungsi ini TIDAK akan digunakan di index.php)
function requireAdmin() {
    requireLogin(); // Pastikan sudah login dulu
    if (!isAdmin()) {
        header("Location: ../siswa/dashboard.php"); // Arahkan ke dashboard siswa jika bukan admin
        exit();
    }
}

// Redirect siswa (fungsi ini TIDAK akan digunakan di index.php)
function requireSiswa() {
    requireLogin(); // Pastikan sudah login dulu
    if (!isSiswa()) {
        header("Location: ../admin/dashboard.php"); // Arahkan ke dashboard admin jika bukan siswa
        exit();
    }
}
?>