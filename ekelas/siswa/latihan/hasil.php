<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireSiswa();

// Ambil data hasil latihan terakhir
$stmt = $conn->prepare("SELECT h.*, k.judul as kursus_judul 
                        FROM hasil_latihan h
                        JOIN kursus k ON h.kursus_id = k.id
                        WHERE h.siswa_id = ?
                        ORDER BY h.tanggal DESC
                        LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$hasil = $stmt->fetch();

if (!$hasil) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => 'Tidak ada hasil latihan',
        'icon' => 'error'
    ];
    header("Location: ../kursus/");
    exit();
}

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Hasil Latihan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="../kursus/" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Kursus
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <h3 class="card-title">Nilai Anda</h3>
                            <div class="display-1 text-<?= $hasil['nilai'] >= 70 ? 'success' : ($hasil['nilai'] >= 50 ? 'warning' : 'danger') ?> fw-bold">
                                <?= $hasil['nilai'] ?>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-<?= $hasil['nilai'] >= 70 ? 'success' : ($hasil['nilai'] >= 50 ? 'warning' : 'danger') ?>">
                                    <?= $hasil['nilai'] >= 70 ? 'Lulus' : 'Belum Lulus' ?>
                                </span>
                            </div>
                            <p class="card-text">Anda telah menyelesaikan latihan untuk kursus <strong><?= htmlspecialchars($hasil['kursus_judul']) ?></strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">Statistik Jawaban</h5>
                            <canvas id="hasilChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($hasil['nilai'] >= 80): ?>
            <div class="text-center mt-3">
                <a href="#" class="btn btn-success btn-lg">
                    <i class="fas fa-certificate me-2"></i> Download Sertifikat
                </a>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script>
// Chart untuk statistik jawaban
const ctx = document.getElementById('hasilChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Benar', 'Salah'],
        datasets: [{
            data: [<?= $hasil['nilai']/10 ?>, <?= 10 - ($hasil['nilai']/10) ?>],
            backgroundColor: [
                '#28a745',
                '#dc3545'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.raw + ' soal';
                    }
                }
            }
        }
    }
});
</script>

<?php include '../../includes/footer.php'; ?>