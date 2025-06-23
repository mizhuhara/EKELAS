<?php
// index.php
require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header("Location: " . (isAdmin() ? 'admin/dashboard.php' : 'siswa/dashboard.php'));
    exit();
}

include __DIR__ . '/includes/header.php';
?>

<style>
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --secondary: #7209b7;
    --accent: #f72585;
    --light: #f8f9fa;
    --dark: #212529;
    --gray: #6c757d;
    --light-gray: #e9ecef;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    color: var(--dark);
}

/* Modern gradient background */
.gradient-bg {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
}

/* Typography */
.display-4 {
    font-weight: 800;
    letter-spacing: -0.05rem;
}

.lead-lg {
    font-size: 1.4rem;
    font-weight: 400;
    color: var(--gray);
}

/* Cards */
.card-hover {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(67, 97, 238, 0.1);
}

/* Buttons */
.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
}

.btn-outline-primary {
    border-width: 2px;
    font-weight: 600;
    border-radius: 50px;
    padding: 0.75rem 2rem;
}

/* Section styling */
.section {
    padding: 6rem 0;
}

.section-title {
    position: relative;
    margin-bottom: 3rem;
}

.section-title:after {
    content: '';
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--accent);
    border-radius: 2px;
}

/* Feature icons */
.feature-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: rgba(67, 97, 238, 0.1);
    margin-bottom: 1.5rem;
    color: var(--primary);
    font-size: 1.75rem;
}

/* Animation classes */
[data-aos] {
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.aos-fade {
    opacity: 0;
    transform: translateY(20px);
}

.aos-fade.aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* Stats counter */
.stat-number {
    font-size: 3.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    line-height: 1;
}

/* Gradient text */
.gradient-text {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
</style>

<!-- Hero Section -->
<section class="gradient-bg">
    <div class="container">
        <div class="row align-items-center min-vh-80 py-5">
            <div class="col-lg-6 py-5" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">
                    Belajar Lebih <span class="gradient-text">Menyenangkan</span> dengan eKelas
                </h1>
                <p class="lead-lg mb-4">
                    Platform pembelajaran digital terdepan yang membantu Anda mencapai potensi maksimal dengan metode belajar interaktif dan personal.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="register.php" class="btn btn-primary">
                        Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="#features" class="btn btn-outline-primary">
                        Jelajahi Fitur
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                <div class="p-4">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary rounded-4" style="transform: rotate(3deg); opacity: 0.1;"></div>
                        <div class="position-relative bg-white rounded-4 shadow-lg p-4">
                            <div class="p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary rounded-circle p-2 me-3">
                                        <i class="fas fa-book text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Materi Pembelajaran</h5>
                                        <small class="text-muted">Update terbaru</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success rounded-circle p-2 me-3">
                                        <i class="fas fa-chart-line text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Progress Belajar</h5>
                                        <small class="text-muted">+12% minggu ini</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning rounded-circle p-2 me-3">
                                        <i class="fas fa-trophy text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Pencapaian</h5>
                                        <small class="text-muted">3 badge baru</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="section bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title display-5 fw-bold">Fitur Unggulan eKelas</h2>
            <p class="lead-lg mx-auto" style="max-width: 700px;">Desain pembelajaran yang revolusioner untuk pengalaman belajar yang lebih efektif</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card-hover h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Kurikulum Modern</h4>
                    <p class="text-muted">Materi pembelajaran terkini yang dirancang oleh pakar pendidikan dan profesional industri.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-hover h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Belajar Fleksibel</h4>
                    <p class="text-muted">Akses materi kapan saja, di mana saja dengan antarmuka yang responsif di semua perangkat.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-hover h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Mentor Ahli</h4>
                    <p class="text-muted">Dapatkan bimbingan langsung dari mentor berpengalaman di bidangnya masing-masing.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card-hover h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Proyek Nyata</h4>
                    <p class="text-muted">Praktikkan pengetahuan Anda melalui proyek-proyek dunia nyata yang relevan.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card-hover h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Analisis Kemajuan</h4>
                    <p class="text-muted">Pantau perkembangan belajar Anda dengan dashboard analitik yang komprehensif.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card-hover h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Sertifikasi</h4>
                    <p class="text-muted">Dapatkan sertifikat resmi yang diakui industri setelah menyelesaikan program.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3" data-aos="fade-up">
                <div class="p-4">
                    <div class="stat-number mb-2">10K+</div>
                    <p class="fw-bold text-muted">Siswa Aktif</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4">
                    <div class="stat-number mb-2">500+</div>
                    <p class="fw-bold text-muted">Materi Belajar</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4">
                    <div class="stat-number mb-2">98%</div>
                    <p class="fw-bold text-muted">Kepuasan Siswa</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4">
                    <div class="stat-number mb-2">24/7</div>
                    <p class="fw-bold text-muted">Dukungan Belajar</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section gradient-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="zoom-in">
                <h2 class="display-5 fw-bold mb-4">Siap Mengubah Cara Belajar Anda?</h2>
                <p class="lead-lg mb-5">Bergabunglah dengan komunitas pembelajar eKelas hari ini dan mulailah perjalanan menuju kesuksesan akademis dan profesional Anda.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="register.php" class="btn btn-primary btn-lg px-4">
                        Daftar Gratis
                    </a>
                    <a href="login.php" class="btn btn-outline-primary btn-lg px-4">
                        Masuk Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Simple scroll animation
document.addEventListener('DOMContentLoaded', function() {
    const aosElements = document.querySelectorAll('[data-aos]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    });
    
    aosElements.forEach(element => {
        element.classList.add('aos-fade');
        observer.observe(element);
    });
});
</script>
</body>
</html>