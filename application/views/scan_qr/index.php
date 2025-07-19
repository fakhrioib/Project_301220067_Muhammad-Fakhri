<?php
// Ambil nama user dari session
$nama_user = $user['name'] ?? ($user['nama'] ?? '-');
$inisial = strtoupper(substr($nama_user, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body {
            background: #f6f8fc;
        }

        .scan-box,
        .riwayat-box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0001;
            padding: 2rem;
            margin-top: 2rem;
        }

        .header-user {
            width: 100%;
            background: #fff;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 2px 8px #0001;
            padding: 1rem 2rem 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: bold;
            margin-right: 10px;
            box-shadow: 0 2px 8px #0002;
        }

        .user-name {
            font-weight: 600;
            margin-right: 10px;
            color: #333;
        }

        .dropdown-menu-user {
            display: none;
            position: absolute;
            right: 0;
            top: 48px;
            background: #fff;
            min-width: 160px;
            box-shadow: 0 2px 8px #0002;
            border-radius: 10px;
            z-index: 200;
            padding: 0.5rem 0;
        }

        .dropdown-menu-user.show {
            display: block;
        }

        .dropdown-menu-user a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            transition: background 0.2s;
        }

        .dropdown-menu-user a:hover {
            background: #f6f8fc;
        }

        #reader {
            margin: 1rem 0;
        }

        @media (max-width: 600px) {

            .scan-box,
            .riwayat-box {
                padding: 1rem;
            }

            .header-user {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="header-user">
        <div class="user-dropdown">
            <span class="user-avatar"><?php echo $inisial; ?></span>
            <span class="user-name"><?php echo htmlspecialchars($nama_user); ?></span>
            <a href="#" id="dropdownUserBtn"><i class="fas fa-chevron-down"></i></a>
            <div class="dropdown-menu-user" id="dropdownUserMenu">
                <a href="<?php echo site_url('profile'); ?>"><i class="fas fa-user me-2"></i> Profile</a>
                <a href="<?php echo site_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="scan-box">
            <h3 class="mb-4">Scan QR Code Presensi</h3>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
            <?php endif; ?>
            <?php if (!empty($redirect_report)): ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "<?= base_url('generate_laporan') ?>";
                    }, 2000);
                </script>
            <?php endif; ?>
            <div class="mb-3">
                <button class="btn btn-success" id="btnScanQr">Scan QR dengan Kamera</button>
            </div>
            <div id="reader" style="width:320px; display:none;"></div>
            <div id="qr-result" class="mt-2"></div>
            <form class="form-inline mb-3">
                <input type="text" class="form-control mr-2" placeholder="Masukkan kode QR manual">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <small class="text-muted">*Fitur scan QR menggunakan kamera akan aktif jika tombol di atas diklik.</small>
        </div>
        <div class="riwayat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4>Riwayat Presensi Saya</h4>
                <a href="<?= base_url('generate_laporan') ?>" class="btn btn-info">Lihat Laporan Kehadiran</a>
            </div>
            <table class="table table-bordered mt-3 bg-white">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada presensi.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['tanggal']); ?></td>
                                <td><?php echo htmlspecialchars($r['waktu_masuk']); ?></td>
                                <td><?php echo htmlspecialchars($r['waktu_pulang']); ?></td>
                                <td><?php echo htmlspecialchars($r['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Dropdown user
        document.getElementById('dropdownUserBtn').onclick = function(e) {
            e.preventDefault();
            document.getElementById('dropdownUserMenu').classList.toggle('show');
        };
        document.addEventListener('click', function(e) {
            var menu = document.getElementById('dropdownUserMenu');
            var btn = document.getElementById('dropdownUserBtn');
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        // QR SCANNER
        let scannerActive = false;
        let html5QrcodeScanner;
        document.getElementById('btnScanQr').onclick = function() {
            var reader = document.getElementById('reader');
            var result = document.getElementById('qr-result');
            if (!scannerActive) {
                reader.style.display = 'block';
                result.innerHTML = '';
                html5QrcodeScanner = new Html5Qrcode("reader");
                html5QrcodeScanner.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {
                        result.innerHTML = '<div class="alert alert-success">QR Terdeteksi: ' + qrCodeMessage + '</div>';
                        html5QrcodeScanner.stop().then(() => {
                            reader.style.display = 'none';
                            scannerActive = false;
                        });
                    },
                    errorMessage => {
                        // ignore scan errors
                    }
                );
                scannerActive = true;
                this.textContent = 'Stop Scan';
                this.classList.remove('btn-success');
                this.classList.add('btn-danger');
            } else {
                html5QrcodeScanner.stop().then(() => {
                    reader.style.display = 'none';
                    scannerActive = false;
                    document.getElementById('btnScanQr').textContent = 'Scan QR dengan Kamera';
                    document.getElementById('btnScanQr').classList.remove('btn-danger');
                    document.getElementById('btnScanQr').classList.add('btn-success');
                });
            }
        };
    </script>
</body>

</html>