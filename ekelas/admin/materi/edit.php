<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM materi WHERE id = ?");
$stmt->execute([$id]);
$materi = $stmt->fetch();

if (!$materi) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => 'Materi tidak ditemukan',
        'icon' => 'error'
    ];
    header("Location: index.php");
    exit();
}

// Ambil daftar kursus untuk dropdown
$stmt = $conn->query("SELECT * FROM kursus ORDER BY judul");
$kursus = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kursus_id = $_POST['kursus_id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $file_link = $_POST['file_link'];
    
    try {
        $stmt = $conn->prepare("UPDATE materi SET kursus_id = ?, judul = ?, isi = ?, file_link = ? WHERE id = ?");
        $stmt->execute([$kursus_id, $judul, $isi, $file_link, $id]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Materi berhasil diperbarui',
            'icon' => 'success'
        ];
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = [
            'title' => 'Error!',
            'text' => $e->getMessage(),
            'icon' => 'error'
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
                <h1 class="h2">Edit Materi</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="kursus_id" class="form-label">Kursus</label>
                            <select class="form-select" id="kursus_id" name="kursus_id" required>
                                <option value="">Pilih Kursus</option>
                                <?php foreach ($kursus as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= $materi['kursus_id'] == $row['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['judul']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="<?= htmlspecialchars($materi['judul']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Materi</label>
                            <textarea class="form-control" id="isi" name="isi" rows="10" required><?= htmlspecialchars($materi['isi']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file_link" class="form-label">Link File/Video</label>
                            <input type="text" class="form-control" id="file_link" name="file_link" 
                                   value="<?= htmlspecialchars($materi['file_link']) ?>">
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