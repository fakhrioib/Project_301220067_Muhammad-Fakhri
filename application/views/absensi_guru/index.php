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

        .badge-tanpa {
            background: #dc2626;
            color: #fff;
        }

        .btn-edit {
            background: #38bdf8;
            color: #fff;
        }

        .btn-edit:hover {
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
        <h4 class="mb-4">Absensi Guru</h4>
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" style="max-width:200px;display:inline-block;" value="<?= $tanggal ?>">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Absen Guru</h6>
                    <button class="btn btn-success"><i class="fas fa-sync-alt"></i> REFRESH</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NUPTK</th>
                                <th>Nama Guru</th>
                                <th>Kehadiran</th>
                                <th>Jam masuk</th>
                                <th>Jam pulang</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($absen as $row): ?>
                                <tr>
                                    <td><?= $row['no'] ?></td>
                                    <td><?= $row['nuptk'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td>
                                        <span class="badge badge-tanpa">TANPA KETERANGAN</span>
                                    </td>
                                    <td><?= $row['jam_masuk'] ?></td>
                                    <td><?= $row['jam_pulang'] ?></td>
                                    <td><?= $row['keterangan'] ?></td>
                                    <td><button class="btn btn-edit btn-sm"><i class="fas fa-edit"></i> EDIT</button></td>
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