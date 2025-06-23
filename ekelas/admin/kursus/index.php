<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Ambil data kursus dari database
$stmt = $conn->query("SELECT * FROM kursus ORDER BY created_at DESC");
$kursus = $stmt->fetchAll();

// Hitung jumlah materi per kursus
$materi_counts = [];
$stmt = $conn->query("SELECT kursus_id, COUNT(*) as jumlah FROM materi GROUP BY kursus_id");
foreach ($stmt->fetchAll() as $row) {
    $materi_counts[$row['kursus_id']] = $row['jumlah'];
}

include '../../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Kursus</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="tambah.php" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Kursus
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= $_SESSION['flash_message']['icon'] === 'error' ? 'danger' : 'success' ?>">
                    <strong><?= $_SESSION['flash_message']['title'] ?></strong>: <?= $_SESSION['flash_message']['text'] ?>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Judul Kursus</th>
                            <th width="20%">Kategori</th>
                            <th width="15%">Materi</th>
                            <th width="15%">Tanggal Dibuat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kursus)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-book fa-3x mb-3"></i>
                                        <h5>Belum ada kursus</h5>
                                        <a href="tambah.php" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i> Tambah Kursus Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kursus as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($row['thumbnail']): ?>
                                            <img src="../../<?= htmlspecialchars($row['thumbnail']) ?>" 
                                                 class="rounded me-3" width="40" height="40" 
                                                 style="object-fit: cover">
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= htmlspecialchars($row['judul']) ?></strong>
                                            <div class="text-muted small">
                                                <?= strlen($row['deskripsi']) > 50 ? 
                                                    substr(htmlspecialchars($row['deskripsi']), 0, 50).'...' : 
                                                    htmlspecialchars($row['deskripsi']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $row['kategori'] == 'Web Development' ? 'primary' : 
                                        ($row['kategori'] == 'Mobile Development' ? 'info' : 'success') 
                                    ?>">
                                        <?= htmlspecialchars($row['kategori']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $materi_counts[$row['id']] ?? 0 ?> Materi
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($row['created_at'])) ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="edit.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $row['id'] ?>)" 
                                                class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="../materi/?kursus_id=<?= $row['id'] ?>" 
                                           class="btn btn-info" title="Lihat Materi">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Kursus beserta semua materi dan soal terkait akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus.php?id=' + id;
        }
    })
}
</script>

<?php include '../../includes/footer.php'; ?>