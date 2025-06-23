<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireSiswa();

// Query yang diperbaiki untuk mengambil kursus yang diikuti
$stmt = $conn->prepare("SELECT DISTINCT k.id, k.judul 
                       FROM kursus k
                       JOIN materi_selesai ms ON k.id = ms.kursus_id
                       WHERE ms.siswa_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$kursus_diikuti = $stmt->fetchAll();

// Ambil data latihan per kursus dengan query yang lebih baik
$latihan_per_kursus = [];
foreach ($kursus_diikuti as $kursus) {
    // Hitung jumlah soal per kursus
    $stmt = $conn->prepare("SELECT COUNT(*) as total_soal FROM soal WHERE kursus_id = ?");
    $stmt->execute([$kursus['id']]);
    $total_soal = $stmt->fetchColumn();
    
    // Hitung percobaan latihan
    $stmt = $conn->prepare("SELECT COUNT(*) as attempt_count 
                           FROM hasil_latihan 
                           WHERE siswa_id = ? AND kursus_id = ?");
    $stmt->execute([$_SESSION['user_id'], $kursus['id']]);
    $attempt_count = $stmt->fetchColumn();
    
    // Ambil nilai tertinggi
    $nilai_tertinggi = null;
    if ($attempt_count > 0) {
        $stmt = $conn->prepare("SELECT MAX(nilai) as max_nilai 
                               FROM hasil_latihan 
                               WHERE siswa_id = ? AND kursus_id = ?");
        $stmt->execute([$_SESSION['user_id'], $kursus['id']]);
        $nilai_tertinggi = $stmt->fetchColumn();
    }
    
    if ($total_soal > 0) {
        $latihan_per_kursus[] = [
            'kursus_id' => $kursus['id'],
            'kursus_judul' => $kursus['judul'],
            'total_soal' => $total_soal,
            'attempt_count' => $attempt_count,
            'nilai_tertinggi' => $nilai_tertinggi
        ];
    }
}

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Latihan dan Ujian</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="filterButton">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>

            <?php if (empty($latihan_per_kursus)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Anda belum memiliki latihan yang tersedia. 
                    Silakan selesaikan materi kursus terlebih dahulu.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($latihan_per_kursus as $item): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?= htmlspecialchars($item['kursus_judul']) ?></h5>
                                <span class="badge bg-light text-dark">
                                    <?= $item['attempt_count'] > 0 ? 'Sudah Mengerjakan' : 'Baru' ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <small class="text-muted">Total Soal</small>
                                        <h6 class="mb-0"><?= $item['total_soal'] ?> Pertanyaan</h6>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">Percobaan</small>
                                        <h6 class="mb-0"><?= $item['attempt_count'] ?>x</h6>
                                    </div>
                                </div>
                                
                                <?php if ($item['nilai_tertinggi'] !== null): ?>
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar bg-<?= getProgressColor($item['nilai_tertinggi']) ?>" 
                                         role="progressbar" 
                                         style="width: <?= $item['nilai_tertinggi'] ?>%;" 
                                         aria-valuenow="<?= $item['nilai_tertinggi'] ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                        <?= $item['nilai_tertinggi'] ?>%
                                    </div>
                                </div>
                                <small class="text-muted">Nilai Tertinggi</small>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-grid gap-2">
                                    <a href="mulai.php?kursus_id=<?= $item['kursus_id'] ?>" 
                                       class="btn btn-<?= $item['attempt_count'] > 0 ? 'warning' : 'primary' ?>">
                                        <i class="fas fa-<?= $item['attempt_count'] > 0 ? 'redo' : 'play' ?> me-1"></i>
                                        <?= $item['attempt_count'] > 0 ? 'Coba Lagi' : 'Mulai Latihan' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php
// Fungsi helper untuk warna progress bar
function getProgressColor($nilai) {
    if ($nilai >= 80) return 'success';
    if ($nilai >= 60) return 'info';
    if ($nilai >= 40) return 'warning';
    return 'danger';
}
?>

<script>
// Tambahkan fungsi filter sederhana
document.getElementById('filterButton').addEventListener('click', function() {
    // Implementasi filter bisa ditambahkan di sini
    alert('Fitur filter akan segera tersedia!');
});
</script>

