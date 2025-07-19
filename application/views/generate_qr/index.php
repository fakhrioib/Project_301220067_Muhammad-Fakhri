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
        <h4 class="mb-4">Generate QR Code</h4>
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3" action="<?= base_url('generate_qr/create') ?>" method="post">
                    <div class="col-md-4">
                        <label class="form-label">Judul QR Code</label>
                        <input type="text" class="form-control" name="title" placeholder="Judul QR Code" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="description" placeholder="Deskripsi singkat" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" name="location" placeholder="Lokasi presensi" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Berlaku Dari</label>
                        <input type="datetime-local" class="form-control" name="valid_from" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Berlaku Sampai</label>
                        <input type="datetime-local" class="form-control" name="valid_until" required>
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-generate w-100"><i class="fas fa-qrcode"></i> Generate QR</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3">Daftar QR Code</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Lokasi</th>
                                <th>Berlaku Dari</th>
                                <th>Berlaku Sampai</th>
                                <th>Aksi</th>
                                <th>QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($qrcodes as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row->code) ?></td>
                                    <td><?= htmlspecialchars($row->title) ?></td>
                                    <td><?= htmlspecialchars($row->description) ?></td>
                                    <td><?= htmlspecialchars($row->location) ?></td>
                                    <td><?= htmlspecialchars($row->valid_from) ?></td>
                                    <td><?= htmlspecialchars($row->valid_until) ?></td>
                                    <td><?= htmlspecialchars($row->created_by_name) ?></td>
                                    <td>
                                        <div id="qr-<?= htmlspecialchars($row->code) ?>"></div>
                                    </td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script>
        <?php foreach ($qrcodes as $row): ?>
            var qr<?= preg_replace('/[^a-zA-Z0-9]/', '', $row->code) ?> = new QRious({
                element: document.getElementById('qr-<?= htmlspecialchars($row->code) ?>'),
                value: "<?= htmlspecialchars($row->code) ?>",
                size: 64
            });
        <?php endforeach; ?>
    </script>
</body>

</html>