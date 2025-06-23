<?php
require_once '../../../config/database.php';
require_once '../../../includes/auth.php';
requireSiswa();

// Ambil daftar kursus yang sudah dikerjakan
$stmt = $conn->prepare("SELECT DISTINCT k.id, k.judul 
                       FROM kursus k
                       JOIN hasil_latihan hl ON k.id = hl.kursus_id
                       WHERE hl.siswa_id = ?
                       ORDER BY k.judul");
$stmt->execute([$_SESSION['user_id']]);
$kursus_diikuti = $stmt->fetchAll();

// Hitung statistik umum
$stmt = $conn->prepare("SELECT 
                       COUNT(DISTINCT kursus_id) as total_kursus,
                       COUNT(*) as total_attempt,
                       AVG(nilai) as rata_rata,
                       MAX(nilai) as nilai_tertinggi
                       FROM hasil_latihan
                       WHERE siswa_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$statistik = $stmt->fetch();

include '../../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Riwayat Nilai Latihan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="printBtn">
                            <i class="fas fa-print me-1"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Kursus</h6>
                                    <h2 class="mb-0"><?= $statistik['total_kursus'] ?></h2>
                                </div>
                                <i class="fas fa-book fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Rata-Rata Nilai</h6>
                                    <h2 class="mb-0"><?= round($statistik['rata_rata'], 1) ?></h2>
                                </div>
                                <i class="fas fa-chart-line fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Percobaan</h6>
                                    <h2 class="mb-0"><?= $statistik['total_attempt'] ?></h2>
                                </div>
                                <i class="fas fa-redo fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Nilai Tertinggi</h6>
                                    <h2 class="mb-0"><?= $statistik['nilai_tertinggi'] ?></h2>
                                </div>
                                <i class="fas fa-trophy fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Perkembangan Nilai -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Perkembangan Nilai</h5>
                </div>
                <div class="card-body">
                    <canvas id="nilaiChart" height="100"></canvas>
                </div>
            </div>

            <!-- Daftar Nilai per Kursus -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Nilai per Kursus</h5>
                    <input type="text" class="form-control form-control-sm w-25" id="searchInput" placeholder="Cari kursus...">
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="nilaiTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Kursus</th>
                                    <th width="15%">Percobaan</th>
                                    <th width="15%">Nilai Tertinggi</th>
                                    <th width="15%">Nilai Terakhir</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($kursus_diikuti)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-info-circle me-2"></i> Belum ada riwayat nilai
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($kursus_diikuti as $index => $kursus): 
                                        // Ambil data nilai per kursus
                                        $stmt = $conn->prepare("SELECT 
                                                             COUNT(*) as attempt_count,
                                                             MAX(nilai) as max_nilai,
                                                             (SELECT nilai FROM hasil_latihan 
                                                              WHERE siswa_id = ? AND kursus_id = ? 
                                                              ORDER BY tanggal DESC LIMIT 1) as last_nilai
                                                             FROM hasil_latihan
                                                             WHERE siswa_id = ? AND kursus_id = ?");
                                        $stmt->execute([
                                            $_SESSION['user_id'],
                                            $kursus['id'],
                                            $_SESSION['user_id'],
                                            $kursus['id']
                                        ]);
                                        $nilai_kursus = $stmt->fetch();
                                    ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($kursus['judul']) ?></td>
                                        <td><?= $nilai_kursus['attempt_count'] ?>x</td>
                                        <td>
                                            <span class="badge bg-<?= getNilaiColor($nilai_kursus['max_nilai']) ?>">
                                                <?= $nilai_kursus['max_nilai'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= getNilaiColor($nilai_kursus['last_nilai']) ?>">
                                                <?= $nilai_kursus['last_nilai'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="detail.php?kursus_id=<?= $kursus['id'] ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-list"></i> Detail
                                            </a>
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
?>

<!-- JavaScript untuk Chart dan Fungsi Tambahan -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Perkembangan Nilai
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    fetch('chart.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('nilaiChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Perkembangan Nilai',
                        data: data.nilai,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        });

    // Fungsi pencarian
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#nilaiTable tbody tr');
        
        rows.forEach(row => {
            const kursusName = row.cells[1].textContent.toLowerCase();
            row.style.display = kursusName.includes(searchValue) ? '' : 'none';
        });
    });

    // Fungsi cetak
    document.getElementById('printBtn').addEventListener('click', function() {
        window.print();
    });
});
</script>

<style>
@media print {
    .sidebar, .btn-toolbar, .card-header {
        display: none !important;
    }
    main {
        width: 100% !important;
        margin-left: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<?php include '../../../includes/footer.php'; ?>