<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Ambil data nilai
$stmt = $conn->query("SELECT h.*, s.nama as siswa_nama, k.judul as kursus_judul 
                      FROM hasil_latihan h
                      JOIN siswa s ON h.siswa_id = s.id
                      JOIN kursus k ON h.kursus_id = k.id
                      ORDER BY h.tanggal DESC");
$nilai = $stmt->fetchAll();

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Nilai Siswa</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Siswa</th>
                            <th>Kursus</th>
                            <th>Nilai</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nilai as $i => $row): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= htmlspecialchars($row['siswa_nama']) ?></td>
                            <td><?= htmlspecialchars($row['kursus_judul']) ?></td>
                            <td>
                                <span class="badge bg-<?= $row['nilai'] >= 70 ? 'success' : ($row['nilai'] >= 50 ? 'warning' : 'danger') ?>">
                                    <?= $row['nilai'] ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>