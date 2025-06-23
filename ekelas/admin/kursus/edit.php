<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM kursus WHERE id = ?");
$stmt->execute([$id]);
$kursus = $stmt->fetch();

if (!$kursus) {
    $_SESSION['flash_message'] = [
        'title' => 'Error!',
        'text' => 'Kursus tidak ditemukan',
        'icon' => 'error'
    ];
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    
    try {
        $stmt = $conn->prepare("UPDATE kursus SET judul = ?, deskripsi = ?, kategori = ? WHERE id = ?");
        $stmt->execute([$judul, $deskripsi, $kategori, $id]);
        
        $_SESSION['flash_message'] = [
            'title' => 'Berhasil!',
            'text' => 'Kursus berhasil diperbarui',
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
                <h1 class="h2">Edit Kursus</h1>
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
                            <label for="judul" class="form-label">Judul Kursus</label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="<?= htmlspecialchars($kursus['judul']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Web Development" <?= $kursus['kategori'] == 'Web Development' ? 'selected' : '' ?>>Web Development</option>
                                <option value="Mobile Development" <?= $kursus['kategori'] == 'Mobile Development' ? 'selected' : '' ?>>Mobile Development</option>
                                <option value="Data Science" <?= $kursus['kategori'] == 'Data Science' ? 'selected' : '' ?>>Data Science</option>
                                <option value="Desain Grafis" <?= $kursus['kategori'] == 'Desain Grafis' ? 'selected' : '' ?>>Desain Grafis</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kursus</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?= htmlspecialchars($kursus['deskripsi']) ?></textarea>
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