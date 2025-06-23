<?php
require_once '../../includes/auth.php';
requireAdmin();

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM soal WHERE id = ?");
$stmt->execute([$id]);
$soal = $stmt->fetch();

if (!$soal) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => 'Soal tidak ditemukan',
        'icon' => 'error'
    ];
    header("Location: index.php");
    exit();
}

// Ambil daftar kursus untuk dropdown
$stmt = $conn->query("SELECT * FROM kursus ORDER BY judul");
$kursus = $stmt->fetchAll();

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Soal</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php?kursus_id=<?= $soal['kursus_id'] ?>" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="proses_edit.php" method="POST">
                        <input type="hidden" name="id" value="<?= $soal['id'] ?>">
                        <div class="mb-3">
                            <label for="kursus_id" class="form-label">Kursus</label>
                            <select class="form-select" id="kursus_id" name="kursus_id" required>
                                <option value="">Pilih Kursus</option>
                                <?php foreach ($kursus as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= $soal['kursus_id'] == $row['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['judul']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pertanyaan" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required><?= htmlspecialchars($soal['pertanyaan']) ?></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="opsi_a" class="form-label">Opsi A</label>
                                <input type="text" class="form-control" id="opsi_a" name="opsi_a" 
                                       value="<?= htmlspecialchars($soal['opsi_a']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="opsi_b" class="form-label">Opsi B</label>
                                <input type="text" class="form-control" id="opsi_b" name="opsi_b" 
                                       value="<?= htmlspecialchars($soal['opsi_b']) ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="opsi_c" class="form-label">Opsi C</label>
                                <input type="text" class="form-control" id="opsi_c" name="opsi_c" 
                                       value="<?= htmlspecialchars($soal['opsi_c']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="opsi_d" class="form-label">Opsi D</label>
                                <input type="text" class="form-control" id="opsi_d" name="opsi_d" 
                                       value="<?= htmlspecialchars($soal['opsi_d']) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
                            <select class="form-select" id="jawaban_benar" name="jawaban_benar" required>
                                <option value="">Pilih Jawaban Benar</option>
                                <option value="A" <?= $soal['jawaban_benar'] == 'A' ? 'selected' : '' ?>>Opsi A</option>
                                <option value="B" <?= $soal['jawaban_benar'] == 'B' ? 'selected' : '' ?>>Opsi B</option>
                                <option value="C" <?= $soal['jawaban_benar'] == 'C' ? 'selected' : '' ?>>Opsi C</option>
                                <option value="D" <?= $soal['jawaban_benar'] == 'D' ? 'selected' : '' ?>>Opsi D</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>