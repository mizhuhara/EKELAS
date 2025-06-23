<?php
require_once '../../../config/database.php';
require_once '../../../includes/auth.php';
requireSiswa();

$kursus_id = $_GET['kursus_id'] ?? null;

if (!$kursus_id) {
    header("Location: index.php");
    exit();
}

// Ambil info kursus
$stmt = $conn->prepare("SELECT judul FROM kursus WHERE id = ?");
$stmt->execute([$kursus_id]);
$kursus = $stmt->fetch();

if (!$kursus) {
    header("Location: index.php");
    exit();
}

// Ambil riwayat latihan
$stmt = $conn->prepare("SELECT *, DATE_FORMAT(tanggal, '%d/%m/%Y %H:%i') as tanggal_format 
                       FROM hasil_latihan
                       WHERE siswa_id = ? AND kursus_id = ?
                       ORDER BY tanggal DESC");
$stmt->execute([$_SESSION['user_id'], $kursus_id]);
$riwayat = $stmt->fetchAll();

include '../../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Detail Nilai: <?= htmlspecialchars($kursus['judul']) ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Tanggal</th>
                                    <th width="15%">Nilai</th>
                                    <th width="15%">Benar</th>
                                    <th width="15%">Salah</th>
                                    <th width="30%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($riwayat)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-info-circle me-2"></i> Belum ada riwayat latihan
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($riwayat as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $row['tanggal_format'] ?></td>
                                        <td>
                                            <span class="badge bg-<?= getNilaiColor($row['nilai']) ?>">
                                                <?= $row['nilai'] ?>
                                            </span>
                                        </td>
                                        <td><?= round($row['nilai'] / 10) ?> soal</td>
                                        <td><?= 10 - round($row['nilai'] / 10) ?> soal</td>
                                        <td>
                                            <?php if ($row['nilai'] >= 75): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i> Kompeten
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-exclamation me-1"></i> Belum Kompeten
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
// Fungsi helper untuk warna nilai
function getNilaiColor($nilai) {
    if ($nilai >= 80) return 'success';
    if ($nilai >= 60) return 'info';
    if ($nilai >= 40) return 'warning';
    return 'danger';
}

include '../../../includes/footer.php';
?>