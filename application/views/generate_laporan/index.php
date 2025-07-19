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

        .table thead {
            background: #f3f4f6;
        }

        .btn-generate {
            background: #a21caf;
            color: #fff;
        }

        .btn-generate:hover {
            background: #7c3aed;
            color: #fff;
        }

        .btn-export {
            background: #38bdf8;
            color: #fff;
        }

        .btn-export:hover {
            background: #0ea5e9;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="sidebar-fixed">
        <?php $this->load->view('templates/sidebar', ['user' => $user]); ?>
    </div>
    <div class="main-content">
        <h4 class="mb-4">Generate Laporan</h4>
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Jenis Laporan</label>
                        <select class="form-select">
                            <option value="">Pilih Jenis</option>
                            <option value="siswa">Laporan Siswa</option>
                            <option value="guru">Laporan Guru</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select">
                            <option value="">Semua Kelas</option>
                            <option>XII AKL</option>
                            <option>XII BDP</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-generate w-100"><i class="fas fa-search"></i> Generate</button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-export w-100"><i class="fas fa-file-export"></i> Export</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3">Hasil Laporan</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Hadir</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Alfa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($laporan as $row): ?>
                                <tr>
                                    <td><?= $row['no'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['kelas'] ?></td>
                                    <td><?= $row['hadir'] ?></td>
                                    <td><?= $row['izin'] ?></td>
                                    <td><?= $row['sakit'] ?></td>
                                    <td><?= $row['alfa'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>