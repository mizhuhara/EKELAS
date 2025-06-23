<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireSiswa();

$kursus_id = $_GET['kursus_id'] ?? null;

if (!$kursus_id) {
    header("Location: ../kursus/");
    exit();
}

// Ambil info kursus
$stmt = $conn->prepare("SELECT judul FROM kursus WHERE id = ?");
$stmt->execute([$kursus_id]);
$kursus = $stmt->fetch();

if (!$kursus) {
    header("Location: ../kursus/");
    exit();
}

// Ambil materi kursus
$stmt = $conn->prepare("SELECT m.*, 
                       (SELECT COUNT(*) FROM materi_selesai 
                        WHERE siswa_id = ? AND materi_id = m.id) as sudah_dibaca
                       FROM materi m 
                       WHERE m.kursus_id = ?
                       ORDER BY m.id");
$stmt->execute([$_SESSION['user_id'], $kursus_id]);
$materi = $stmt->fetchAll();

// Hitung progress
$total_materi = count($materi);
$materi_selesai = 0;
foreach ($materi as $m) {
    if ($m['sudah_dibaca']) $materi_selesai++;
}
$progress = $total_materi > 0 ? round(($materi_selesai / $total_materi) * 100) : 0;

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Materi: <?= htmlspecialchars($kursus['judul']) ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="../kursus/" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="alert alert-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Progress Belajar:</strong> 
                        <?= $materi_selesai ?> dari <?= $total_materi ?> materi selesai
                    </div>
                    <div class="progress" style="width: 200px; height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: <?= $progress ?>%;" 
                             aria-valuenow="<?= $progress ?>" 
                             aria-valuemin="0" aria-valuemax="100">
                            <?= $progress ?>%
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if (empty($materi)): ?>
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle me-2"></i> Belum ada materi untuk kursus ini.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($materi as $index => $row): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-<?= $row['sudah_dibaca'] ? 'success' : 'primary' ?>">
                            <div class="card-header bg-<?= $row['sudah_dibaca'] ? 'success' : 'primary' ?> text-white">
                                <h5 class="mb-0">Materi <?= $index + 1 ?></h5>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                                <p class="card-text">
                                    <?= strlen($row['isi']) > 100 ? 
                                        substr(strip_tags($row['isi']), 0, 100).'...' : 
                                        strip_tags($row['isi']) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-grid gap-2">
                                    <a href="detail.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-<?= $row['sudah_dibaca'] ? 'outline-success' : 'primary' ?>">
                                        <i class="fas fa-<?= $row['sudah_dibaca'] ? 'check' : 'book-open' ?> me-1"></i>
                                        <?= $row['sudah_dibaca'] ? 'Sudah Dibaca' : 'Pelajari Sekarang' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>