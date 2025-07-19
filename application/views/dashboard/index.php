<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6fb;
        }

        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem 2rem 0 2rem;
        }

        .card-stat {
            min-width: 180px;
        }

        .card-absensi {
            min-height: 120px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-value {
            font-size: 2rem;
            font-weight: bold;
        }

        .chart-container {
            min-height: 250px;
        }
    </style>
</head>

<body>
    <div class="sidebar-fixed">
        <?php $user = isset($user) ? $user : $this->session->userdata();
        $this->load->view('templates/sidebar', ['user' => $user]); ?>
    </div>
    <div class="main-content">
        <h3 class="mb-4">Dashboard</h3>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-0 text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x me-3"></i>
                            <div>
                                <div class="card-title">Jumlah Siswa</div>
                                <div class="card-value"><?= $jumlah_siswa ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-0 text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tie fa-2x me-3"></i>
                            <div>
                                <div class="card-title">Jumlah Guru</div>
                                <div class="card-value"><?= $jumlah_guru ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-0 text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chalkboard fa-2x me-3"></i>
                            <div>
                                <div class="card-title">Jumlah Kelas</div>
                                <div class="card-value"><?= $jumlah_kelas ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-0 text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-cog fa-2x me-3"></i>
                            <div>
                                <div class="card-title">Jumlah Petugas</div>
                                <div class="card-value"><?= $jumlah_petugas ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card card-absensi shadow-sm border-0">
                    <div class="card-header bg-purple text-white" style="background: #7c3aed;">
                        Absensi Siswa Hari Ini
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col">
                                <span class="badge bg-success">Hadir</span><br><?= $absensi_siswa['present'] ?>
                            </div>
                            <div class="col">
                                <span class="badge bg-warning text-dark">Terlambat</span><br><?= $absensi_siswa['late'] ?>
                            </div>
                            <div class="col">
                                <span class="badge bg-danger">Alfa</span><br><?= $absensi_siswa['absent'] ?>
                            </div>
                            <div class="col">
                                <span class="badge bg-info text-dark">Setengah Hari</span><br><?= $absensi_siswa['half_day'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-absensi shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        Absensi Guru Hari Ini
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col">
                                <span class="badge bg-success">Hadir</span><br><?= $absensi_guru['present'] ?>
                            </div>
                            <div class="col">
                                <span class="badge bg-warning text-dark">Terlambat</span><br><?= $absensi_guru['late'] ?>
                            </div>
                            <div class="col">
                                <span class="badge bg-danger">Alfa</span><br><?= $absensi_guru['absent'] ?>
                            </div>
                            <div class="col">
                                <span class="badge bg-info text-dark">Setengah Hari</span><br><?= $absensi_guru['half_day'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-purple text-white" style="background: #7c3aed;">
                        Tingkat Kehadiran Siswa (7 Hari Terakhir)
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="chartSiswa"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        Tingkat Kehadiran Guru (7 Hari Terakhir)
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="chartGuru"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 mb-2">
            <small class="text-muted">&copy; <?= date('Y') ?> Sifa Barqilah - Sistem Presensi QR Code</small>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Siswa
        var ctxSiswa = document.getElementById('chartSiswa').getContext('2d');
        var chartSiswa = new Chart(ctxSiswa, {
            type: 'line',
            data: {
                labels: ['1 Aug', '2 Aug', '3 Aug', '4 Aug', '5 Aug', '6 Aug', 'Hari ini'],
                datasets: [{
                    label: 'Kehadiran',
                    data: [55, 60, 58, 62, 59, 61, 64],
                    borderColor: '#7c3aed',
                    backgroundColor: 'rgba(124,58,237,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        // Chart Guru
        var ctxGuru = document.getElementById('chartGuru').getContext('2d');
        var chartGuru = new Chart(ctxGuru, {
            type: 'line',
            data: {
                labels: ['1 Aug', '2 Aug', '3 Aug', '4 Aug', '5 Aug', '6 Aug', 'Hari ini'],
                datasets: [{
                    label: 'Kehadiran',
                    data: [30, 32, 31, 35, 33, 36, 34],
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>