<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireSiswa();

// Ambil data kursus
$stmt = $conn->query("SELECT * FROM kursus ORDER BY judul");
$kursus = $stmt->fetchAll();

// Ambil progress belajar siswa
$progress_data = []; // Ubah nama variabel agar tidak bentrok dengan $progress di loop
try {
    $stmt = $conn->prepare("SELECT kursus_id, COUNT(*) as selesai FROM materi_selesai 
                            WHERE siswa_id = ? GROUP BY kursus_id");
    $stmt->execute([$_SESSION['user_id']]);
    $progress_data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Ubah ini
} catch (PDOException $e) {
    $progress_data = []; // Jika tabel belum ada, anggap tidak ada materi selesai
    error_log("Error accessing materi_selesai: " . $e->getMessage());
}

// Hitung total materi per kursus
$total_materi = [];
$stmt = $conn->query("SELECT kursus_id, COUNT(*) as total FROM materi GROUP BY kursus_id");
foreach ($stmt->fetchAll() as $row) {
    $total_materi[$row['kursus_id']] = $row['total'];
}

// Ambil nilai siswa
$nilai_siswa = [];
try {
    $stmt = $conn->prepare("SELECT kursus_id, nilai FROM hasil_latihan 
                            WHERE siswa_id = ? ORDER BY tanggal DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $nilai_siswa = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    error_log("Error accessing hasil_latihan: " . $e->getMessage());
}

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kursus Saya</h1>
            </div>

            <div class="row">
                <?php if (empty($kursus)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Belum ada kursus yang tersedia.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($kursus as $row): 
                        $total = $total_materi[$row['id']] ?? 0;
                        $selesai = $progress_data[$row['id']] ?? 0; // Menggunakan $progress_data
                        $progress = $total > 0 ? round(($selesai / $total) * 100) : 0;
                        $nilai = $nilai_siswa[$row['id']] ?? null;
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars(substr($row['deskripsi'], 0, 100)) ?>...</p>
                                
                                <div class="mb-3">
                                    <small>Progress Belajar</small>
                                    <div class="progress" style="height: 10px;"> <div class="progress-bar" role="progressbar" 
                                             style="width: <?= $progress ?>%;" 
                                             aria-valuenow="<?= $progress ?>" 
                                             aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block"> <?= $selesai ?> dari <?= $total ?> materi selesai
                                    </small>
                                </div>
                                
                                <?php /*
                                <?php if ($nilai !== null): ?>
                                    <div class="alert alert-sm alert-<?= $nilai >= 70 ? 'success' : 'warning' ?> mb-3">
                                        Nilai terakhir: <strong><?= $nilai ?></strong>
                                    </div>
                                <?php endif; ?>
                                */ ?>
                                
                                <a href="../materi/?kursus_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm mt-3"> <i class="fas fa-book-open me-1"></i> Lanjut Belajar
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

