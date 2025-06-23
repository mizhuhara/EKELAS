<?php
require_once(__DIR__ . '/../../config/database.php'); // menuju config/
require_once(__DIR__ . '/../../includes/auth.php');


requireSiswa();

// Dapatkan jumlah materi yang sudah diselesaikan
$completed_courses = 0;
try {
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT kursus_id) as total FROM materi_selesai WHERE siswa_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $completed_courses = $stmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Error counting completed courses: " . $e->getMessage());
}
?>
<!-- Sidebar Siswa -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #2c3e50;">
    <div class="position-sticky pt-3 sidebar-sticky">
        <div class="d-flex flex-column align-items-center mb-4 mt-2" style="padding: 0 0.5rem;"> <img src="https://i1.sndcdn.com/artworks-0EgHrWMz1UMPzydf-WDPNsg-t500x500.jpg" alt="Profile" class="img-fluid rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
            <p class="mb-0 fw-bold text-white"><?= htmlspecialchars($_SESSION['user_name'] ?? 'gungde') ?></p>
            <small class="text-muted">Siswa</small>
        </div>
        <ul class="nav flex-column">
            <?php $current_page = basename($_SERVER['PHP_SELF'], '.php'); ?>

            <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'dashboard') ? 'active-custom' : '' ?>" aria-current="page" href="/siswa/dashboard.php">
                    <i class="fas fa-fw me-2 fa-clock"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'kursus' || $current_page == 'materi' || $current_page == 'detail_kursus') ? 'active-custom' : '' ?>" href="/ekelas/siswa/kursus/">
                    <i class="fas fa-fw me-2 fa-clipboard-list"></i> Kursus Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'latihan' || $current_page == 'kuis') ? 'active-custom' : '' ?>" href="/siswa/latihan/">
                    <i class="fas fa-fw me-2 fa-question-circle"></i> Latihan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'profil') ? 'active-custom' : '' ?>" href="/siswa/profil.php">
                    <i class="fas fa-fw me-2 fa-user"></i> Profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($current_page == 'detail' && strpos($_SERVER['REQUEST_URI'], '/nilai/') !== false) ? 'active-custom' : '' ?>" href="/ekelas/siswa/latihan/nilai/detail.php">
                    <i class="fas fa-fw me-2 fa-chart-line"></i> Nilai & Progress
                </a>
            </li>
        </ul>
    </div>
</nav>
       
<style>
    /* Custom CSS untuk Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding-top: 48px; /* Padding atas tetap */
        padding-bottom: 0;
        /* box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); (opsional, bisa dihilangkan jika tidak terlihat di gambar) */
        
        /* Tambahan padding di sisi kiri sidebar secara keseluruhan */
        padding-left: 0.8rem; /* Sesuaikan nilai ini untuk "space" di kiri */
        padding-right: 0.8rem; /* Untuk keseimbangan, atau sesuaikan */
    }

    .sidebar-sticky {
        height: calc(100vh - 48px);
        overflow-x: hidden;
        overflow-y: auto;
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #fff;
        padding: 0.75rem 1rem; /* Padding internal item menu */
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        border-radius: 0; /* Menghilangkan border-radius */
        
        /* Menghilangkan margin-left/right di sini karena sudah diatur di .sidebar */
        margin-left: 0; 
        margin-right: 0;
        
        /* Transisi untuk efek hover/active yang halus */
        transition: background-color 0.3s ease, border-left 0.3s ease;
    }

    .sidebar .nav-link .fas {
        margin-right: 0.75rem;
        font-size: 1.2rem;
    }

    /* Warna background default item menu saat tidak aktif */
    .sidebar .nav-item .nav-link {
        background-color: #3b5266; /* Abu-abu gelap */
    }

    /* Styling untuk item menu yang aktif */
    .sidebar .nav-link.active-custom {
        color: #fff;
        background-color: #49637c; /* Warna background sedikit lebih terang saat aktif */
        font-weight: bold;
        border-left: 4px solid #ff8c00; /* Garis oranye di kiri */
        padding-left: calc(1rem - 4px); /* Sesuaikan padding kiri agar total padding tetap sama */
    }

    /* Efek hover untuk item NON-AKTIF */
    .sidebar .nav-link:hover:not(.active-custom) {
        background-color: #49637c; /* Warna background sedikit lebih terang saat hover */
        color: #fff;
    }
    
    /* Efek hover untuk item AKTIF */
    .sidebar .nav-link.active-custom:hover {
        background-color: #49637c; /* Tetap warna yang sama saat hover jika aktif */
        color: #fff;
    }

    /* Styling untuk bagian profil */
    .profile-text {
        color: white;
        text-align: center;
        margin-bottom: 10px;
    }
</style>
<?php
// Helper function untuk menghitung kursus yang diambil
function countEnrolledCourses()
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM materi_selesai WHERE siswa_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Error counting enrolled courses: " . $e->getMessage());
        return 0;
    }
}

// Helper function untuk menghitung tugas yang belum selesai
function countPendingAssignments()
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tugas 
                               WHERE kursus_id IN (SELECT kursus_id FROM materi_selesai WHERE siswa_id = ?)
                               AND id NOT IN (SELECT tugas_id FROM tugas_submit WHERE siswa_id = ?)");
        $stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Error counting pending assignments: " . $e->getMessage());
        return 0;
    }
}
?>