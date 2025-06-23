<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireSiswa();

$materi_id = $_GET['id'] ?? null;

if (!$materi_id) {
    header("Location: ../kursus/");
    exit();
}

// Ambil detail materi
$stmt = $conn->prepare("SELECT m.*, k.judul as kursus_judul 
                       FROM materi m
                       JOIN kursus k ON m.kursus_id = k.id
                       WHERE m.id = ?");
$stmt->execute([$materi_id]);
$materi = $stmt->fetch();

if (!$materi) {
    header("Location: ../kursus/");
    exit();
}

// Tandai materi sebagai dibaca
try {
    $stmt = $conn->prepare("INSERT IGNORE INTO materi_selesai (siswa_id, kursus_id, materi_id) 
                           VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $materi['kursus_id'], $materi_id]);
} catch (PDOException $e) {
    error_log("Error marking material as read: " . $e->getMessage());
}

// Ambil materi sebelumnya dan berikutnya
$stmt = $conn->prepare("SELECT id, judul FROM materi 
                       WHERE kursus_id = ? AND id < ? 
                       ORDER BY id DESC LIMIT 1");
$stmt->execute([$materi['kursus_id'], $materi_id]);
$prev_materi = $stmt->fetch();

$stmt = $conn->prepare("SELECT id, judul FROM materi 
                       WHERE kursus_id = ? AND id > ? 
                       ORDER BY id ASC LIMIT 1");
$stmt->execute([$materi['kursus_id'], $materi_id]);
$next_materi = $stmt->fetch();

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?= htmlspecialchars($materi['judul']) ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php?kursus_id=<?= $materi['kursus_id'] ?>" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Materi
                    </a>
                </div>
            </div>

            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../kursus/">Kursus</a></li>
                    <li class="breadcrumb-item"><a href="index.php?kursus_id=<?= $materi['kursus_id'] ?>">
                        <?= htmlspecialchars($materi['kursus_judul']) ?>
                    </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($materi['judul']) ?></li>
                </ol>
            </nav>

            <div class="card mb-4">
                <div class="card-body">
                    <?php if ($materi['file_link'] && isVideoLink($materi['file_link'])): ?>
                        <div class="ratio ratio-16x9 mb-4">
                            <iframe src="<?= embedYouTubeUrl($materi['file_link']) ?>" 
                                    allowfullscreen></iframe>
                        </div>
                    <?php elseif ($materi['file_link']): ?>
                        <div class="text-center mb-4">
                            <a href="<?= htmlspecialchars($materi['file_link']) ?>" 
                               class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i> Buka Dokumen Materi
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="content">
                        <?= nl2br(htmlspecialchars($materi['isi'])) ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <?php if ($prev_materi): ?>
                            <a href="detail.php?id=<?= $prev_materi['id'] ?>" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i> Sebelumnya: <?= htmlspecialchars($prev_materi['judul']) ?>
                            </a>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                        
                        <?php if ($next_materi): ?>
                            <a href="detail.php?id=<?= $next_materi['id'] ?>" class="btn btn-primary">
                                Selanjutnya: <?= htmlspecialchars($next_materi['judul']) ?> <i class="fas fa-arrow-right me-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
// Fungsi helper untuk deteksi link video
function isVideoLink($url) {
    $video_domains = ['youtube.com', 'youtu.be', 'vimeo.com'];
    foreach ($video_domains as $domain) {
        if (strpos($url, $domain) !== false) return true;
    }
    return false;
}

// Fungsi untuk embed YouTube URL
function embedYouTubeUrl($url) {
    if (strpos($url, 'youtube.com') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return isset($params['v']) ? "https://www.youtube.com/embed/{$params['v']}" : $url;
    } elseif (strpos($url, 'youtu.be') !== false) {
        $path = parse_url($url, PHP_URL_PATH);
        $video_id = ltrim($path, '/');
        return "https://www.youtube.com/embed/{$video_id}";
    }
    return $url;
}

include '../../includes/footer.php';
?>