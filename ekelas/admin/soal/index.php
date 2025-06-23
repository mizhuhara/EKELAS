<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Ambil data soal berdasarkan kursus_id jika ada
$kursus_id = $_GET['kursus_id'] ?? null;
$where = $kursus_id ? "WHERE kursus_id = $kursus_id" : "";

$stmt = $conn->prepare("SELECT s.*, k.judul as kursus_judul FROM soal s 
                        JOIN kursus k ON s.kursus_id = k.id $where 
                        ORDER BY s.id DESC");
$stmt->execute();
$soal = $stmt->fetchAll();

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Soal</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="tambah.php<?= $kursus_id ? '?kursus_id='.$kursus_id : '' ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Soal
                    </a>
                </div>
            </div>

            <?php if ($kursus_id): ?>
                <div class="alert alert-info">
                    Menampilkan soal untuk kursus: <strong><?= $soal[0]['kursus_judul'] ?? '' ?></strong>
                    <a href="index.php" class="float-end">Lihat semua soal</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pertanyaan</th>
                            <th>Kursus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($soal as $i => $row): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= substr(htmlspecialchars($row['pertanyaan']), 0, 50) ?>...</td>
                            <td><?= htmlspecialchars($row['kursus_judul']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete(<?= $row['id'] ?>, 'soal')" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>