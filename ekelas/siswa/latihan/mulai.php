<?php 
include '../../includes/auth.php'; 
include '../../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Latihan HTML Dasar</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-clock me-1"></i> 30:00
                        </button>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle me-2"></i> Petunjuk Pengerjaan</h5>
                <ul class="mb-0">
                    <li>Latihan ini terdiri dari 10 soal pilihan ganda</li>
                    <li>Waktu pengerjaan: 30 menit</li>
                    <li>Setiap soal hanya memiliki satu jawaban benar</li>
                    <li>Anda tidak bisa kembali ke soal sebelumnya setelah menjawab</li>
                </ul>
            </div>

            <form action="hasil.php" method="POST">
                <input type="hidden" name="kursus_id" value="1">
                
                <!-- Soal 1 -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Soal 1</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Apa kepanjangan dari HTML?</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="soal1" id="soal1a" value="A">
                            <label class="form-check-label" for="soal1a">
                                Hyperlinks and Text Markup Language
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="soal1" id="soal1b" value="B">
                            <label class="form-check-label" for="soal1b">
                                Hyper Text Markup Language
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="soal1" id="soal1c" value="C">
                            <label class="form-check-label" for="soal1c">
                                Home Tool Markup Language
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="soal1" id="soal1d" value="D">
                            <label class="form-check-label" for="soal1d">
                                Hyper Text Making Language
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Soal 2 -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Soal 2</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Tag HTML untuk membuat paragraf adalah:</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="soal2" id="soal2a" value="A">
                            <label class="form-check-label" for="soal2a">
                                &lt;para&gt;
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="soal2" id="soal2b" value="B">
                            <label class="form-check-label" for="soal2b">
                                &lt;p&gt;
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="soal2" id="soal2c" value="C">
                            <label class="form-check-label" for="soal2c">
                                &lt;paragraph&gt;
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="soal2" id="soal2d" value="D">
                            <label class="form-check-label" for="soal2d">
                                &lt;pg&gt;
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Submit -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Jawaban
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>