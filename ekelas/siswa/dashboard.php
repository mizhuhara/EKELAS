<?php 
include '../includes/auth.php'; 
include '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Siswa -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <img src="https://i1.sndcdn.com/artworks-0EgHrWMz1UMPzydf-WDPNsg-t500x500.jpg" class="rounded-circle" width="80" alt="Profile">
                    <h6 class="mt-2 text-white"><?php echo $_SESSION['nama']; ?></h6>
                    <small class="text-muted">Siswa</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="kursus/">
                            <i class="fas fa-book me-2"></i>Kursus Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="latihan/">
                            <i class="fas fa-question-circle me-2"></i>Latihan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="profile.php">
                            <i class="fas fa-user me-2"></i>Profil
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Siswa</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['nama']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="profile.php">Profil</a></li>
                            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="alert alert-primary">
                <h4><i class="fas fa-graduation-cap me-2"></i> Selamat datang di eKelas!</h4>
                <p class="mb-0">Mulailah belajar dengan memilih kursus yang tersedia. Jangan lupa mengerjakan latihan untuk menguji pemahaman Anda.</p>
            </div>

            <!-- Kursus Terbaru -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Kursus Tersedia</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="../assets/images/1.png" class="card-img-top" alt="HTML Dasar">
                                <div class="card-body">
                                    <h5 class="card-title">HTML Dasar</h5>
                                    <p class="card-text">Belajar HTML dari dasar untuk membangun struktur website.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">Web Development</span>
                                        <a href="kursus/detail.php?id=1" class="btn btn-sm btn-outline-primary">Mulai Belajar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="../assets/images/2.png" class="card-img-top" alt="CSS Fundamental">
                                <div class="card-body">
                                    <h5 class="card-title">CSS Fundamental</h5>
                                    <p class="card-text">Pelajari CSS untuk mempercantik tampilan website Anda.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">Web Development</span>
                                        <a href="kursus/detail.php?id=2" class="btn btn-sm btn-outline-primary">Mulai Belajar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="../assets/images/3.png" class="card-img-top" alt="PHP untuk Pemula">
                                <div class="card-body">
                                    <h5 class="card-title">PHP untuk Pemula</h5>
                                    <p class="card-text">Mulai belajar pemrograman backend dengan PHP.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">Web Development</span>
                                        <a href="kursus/detail.php?id=3" class="btn btn-sm btn-outline-primary">Mulai Belajar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Belajar -->
            <div class="card">
                <div class="card-header">
                    <h5>Progress Belajar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kursus</th>
                                    <th>Materi Selesai</th>
                                    <th>Nilai Terakhir</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>HTML Dasar</td>
                                    <td>3/5</td>
                                    <td>80</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CSS Fundamental</td>
                                    <td>1/6</td>
                                    <td>-</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 16%;" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">16%</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

