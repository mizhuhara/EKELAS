<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Ambil daftar kursus untuk dropdown
$stmt = $conn->query("SELECT * FROM kursus ORDER BY judul");
$kursus = $stmt->fetchAll();

$kursus_id = $_GET['kursus_id'] ?? null;

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Materi Baru</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php<?= $kursus_id ? '?kursus_id='.$kursus_id : '' ?>" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="kursus_id" class="form-label">Kursus</label>
                            <select class="form-select" id="kursus_id" name="kursus_id" required>
                                <option value="">Pilih Kursus</option>
                                <?php foreach ($kursus as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= $kursus_id == $row['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['judul']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Materi</label>
                            <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file_link" class="form-label">Link File/Video (opsional)</label>
                            <input type="text" class="form-control" id="file_link" name="file_link" placeholder="Contoh: https://youtu.be/...">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>