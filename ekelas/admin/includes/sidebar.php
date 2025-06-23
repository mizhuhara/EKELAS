<?php
require_once '../../includes/auth.php';
require_once(__DIR__ . '/../../config/database.php'); // menuju config/
requireAdmin();
?>
<!-- Sidebar Admin -->
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h6 class="mt-2 text-white"><?= $_SESSION['nama'] ?? 'Administrator' ?></h6>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'dashboard') ? 'active-custom' : '' ?>" aria-current="page" href="/admin/dashboard.php">
                    <i class="fas fa-fw me-2 fa-clock"></i> Dashboard
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'manajemen kursus') ? 'active-custom' : '' ?>" aria-current="page" href="/admin/kursus/index.php">
                    <i class="fas fa-fw me-2 fa-clock"></i> Manajemen kursus
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'manajemen materi') ? 'active-custom' : '' ?>" aria-current="page" href="/admin/materi/index.php">
                    <i class="fas fa-fw me-2 fa-clock"></i> Manajemen materi
                </a>
            </li>
            
              <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'manajemen soal') ? 'active-custom' : '' ?>" aria-current="page" href="/admin/soal/index.php">
                    <i class="fas fa-fw me-2 fa-clock"></i> Manajemen soal
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'nilai siswa') ? 'active-custom' : '' ?>" aria-current="page" href="/admin/nilai/index.php">
                    <i class="fas fa-fw me-2 fa-clock"></i> Nilai siswa
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <a class="nav-link text-danger" href="../../logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>