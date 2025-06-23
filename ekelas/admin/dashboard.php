<?php 
include '../includes/auth.php'; 
include '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./kursus/">
                            <i class="fas fa-book me-2"></i>Kursus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./materi/">
                            <i class="fas fa-file-alt me-2"></i>Materi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./soal/">
                            <i class="fas fa-question-circle me-2"></i>Soal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./nilai/">
                            <i class="fas fa-chart-bar me-2"></i>Nilai Siswa
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Admin</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> Admin
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Kursus</h5>
                                    <h2 class="mb-0">12</h2>
                                </div>
                                <i class="fas fa-book fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Siswa</h5>
                                    <h2 class="mb-0">85</h2>
                                </div>
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Materi</h5>
                                    <h2 class="mb-0">56</h2>
                                </div>
                                <i class="fas fa-file-alt fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card">
                <div class="card-header">
                    <h5>Aktivitas Terkini</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Siswa baru mendaftar</h6>
                                <small>5 menit lalu</small>
                            </div>
                            <p class="mb-1">Rika telah mendaftar sebagai siswa baru</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Kursus baru ditambahkan</h6>
                                <small>2 jam lalu</small>
                            </div>
                            <p class="mb-1">Kursus "JavaScript Lanjutan" telah ditambahkan</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Latihan dikerjakan</h6>
                                <small>1 hari lalu</small>
                            </div>
                            <p class="mb-1">Andi menyelesaikan latihan HTML Dasar dengan nilai 80</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>