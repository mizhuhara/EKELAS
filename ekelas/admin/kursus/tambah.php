<?php 
include '../../includes/auth.php'; 
include '../../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Kursus Baru</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="/admin/kursus/proses_tambah.php" method="POST">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Kursus</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Mobile Development">Mobile Development</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Desain Grafis">Desain Grafis</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kursus</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
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