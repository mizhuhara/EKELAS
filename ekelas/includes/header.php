<?php
// includes/header.php

require_once __DIR__ . '/auth.php';

// BASE_URL dinamis, otomatis mendeteksi protokol dan host
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// Jika proyek berada di subfolder (contoh: http://localhost/ekelas), sesuaikan
$subDir = ''; // ← GANTI jika kamu pakai folder lain atau di root

$baseUrl = $protocol . '://' . $host . $subDir;

// Buat konstanta agar bisa digunakan di file lain
define('BASE_URL', $baseUrl);
define('ASSETS_URL', BASE_URL . '/assets');
define('ADMIN_URL', BASE_URL . '/admin');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKelas - Sistem Manajemen Kursus Online</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Style -->
    <link href="<?= ASSETS_URL ?>/css/style.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="<?= ASSETS_URL ?>/images/favicon.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">
                <i class="fas fa-graduation-cap me-2"></i>eKelas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= isAdmin() ? ADMIN_URL . '/dashboard.php' : BASE_URL . '/siswa/dashboard.php' ?>">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i><?= $_SESSION['nama'] ?? 'User' ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>/logout.php">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/login.php">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/register.php">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
