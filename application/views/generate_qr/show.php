<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        .qr-container {
            text-align: center;
            margin-top: 2rem;
        }

        .qr-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .qr-detail {
            margin: 1rem 0;
        }

        .btn-download {
            margin-top: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-body qr-container">
                        <div class="qr-title mb-3">QR Code Presensi</div>
                        <canvas id="qr-canvas"></canvas>
                        <div class="qr-detail">
                            <p><b>Judul:</b> <?= htmlspecialchars($qr->title) ?></p>
                            <p><b>Deskripsi:</b> <?= htmlspecialchars($qr->description) ?></p>
                            <p><b>Lokasi:</b> <?= htmlspecialchars($qr->location) ?></p>
                            <p><b>Berlaku Dari:</b> <?= htmlspecialchars($qr->valid_from) ?></p>
                            <p><b>Berlaku Sampai:</b> <?= htmlspecialchars($qr->valid_until) ?></p>
                            <p><b>Kode QR:</b> <?= htmlspecialchars($qr->code) ?></p>
                        </div>
                        <button class="btn btn-primary btn-download" onclick="downloadPDF()"><i class="fas fa-download"></i> Download PDF</button>
                        <a href="<?= base_url('generate_qr') ?>" class="btn btn-secondary ms-2">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate QR code berisi URL scan-qr + kode
            var qrUrl = "<?= base_url('scan-qr?code=') . urlencode($qr->code) ?>";
            var qrCanvas = document.getElementById('qr-canvas');
            try {
                var qr = new QRious({
                    element: qrCanvas,
                    value: qrUrl,
                    size: 200
                });
            } catch (e) {
                qrCanvas.outerHTML = '<div class="alert alert-danger">QR code gagal dibuat: ' + e.message + '</div>';
            }
        });

        function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            var doc = new jsPDF();
            doc.setFontSize(16);
            doc.text('QR Code Presensi', 20, 20);
            doc.setFontSize(12);
            doc.text('Judul: <?= htmlspecialchars($qr->title) ?>', 20, 35);
            doc.text('Deskripsi: <?= htmlspecialchars($qr->description) ?>', 20, 43);
            doc.text('Lokasi: <?= htmlspecialchars($qr->location) ?>', 20, 51);
            doc.text('Berlaku Dari: <?= htmlspecialchars($qr->valid_from) ?>', 20, 59);
            doc.text('Berlaku Sampai: <?= htmlspecialchars($qr->valid_until) ?>', 20, 67);
            doc.text('Kode QR: <?= htmlspecialchars($qr->code) ?>', 20, 75);
            // QR code image
            var qrImg = document.getElementById('qr-canvas').toDataURL('image/png');
            doc.addImage(qrImg, 'PNG', 140, 30, 50, 50);
            doc.save('qr-presensi-<?= htmlspecialchars($qr->code) ?>.pdf');
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</body>

</html>